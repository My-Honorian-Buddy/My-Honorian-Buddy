<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResponse;
use App\Traits\ErrorHandling;
use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\RewardRedemption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class RewardRedemptionController extends Controller
{
    use ErrorHandling;

    public function index()
    {
        try {
            $this->logOperationStart('Fetch Rewards', [
                'user_id' => Auth::id(),
            ]);

            $rewards = $this->executeDbOperation(
                fn() => Reward::all(),
                'Fetch Rewards',
                'Failed to load rewards'
            );

            $this->logOperationSuccess('Fetch Rewards', [
                'count' => $rewards->count(),
            ]);

            return view('rewards', compact('rewards'));

        } catch (\App\Exceptions\DatabaseOperationException $e) {
            Log::error('Error fetching rewards: ' . $e->getMessage());
            return view('rewards', ['rewards' => collect()])->with('error', $e->getUserMessage());

        } catch (\Exception $e) {
            $this->logOperationFailure('Fetch Rewards', $e->getMessage());
            return view('rewards', ['rewards' => collect()])->with('error', 'An error occurred while loading rewards');
        }
    }

    public function redeem(Request $request, $rewardID)
    {
        try {
            $this->logOperationStart('Redeem Reward', [
                'user_id' => Auth::id(),
                'reward_id' => $rewardID,
            ]);

            $tutor = Auth::user()->tutor;

            if (!$tutor) {
                Log::warning('Tutor not found for user', [
                    'user_id' => Auth::id(),
                ]);

                return redirect()->back()->with('error', 'Your tutor profile not found.');
            }

            $reward = $this->executeDbOperation(
                fn() => Reward::findOrFail($rewardID),
                'Fetch Reward',
                'Reward not found'
            );

            // Check points
            if ($tutor->points < $reward->pointsReq) {
                $this->logOperationFailure('Redeem Reward', 'Insufficient points', [
                    'user_id' => Auth::id(),
                    'points_available' => $tutor->points,
                    'points_required' => $reward->pointsReq,
                ]);

                return redirect()->back()->with('error', 'You do not have enough points to redeem this reward.');
            }

            // Check existing pending redemption
            $existingRedemption = RewardRedemption::where('tutor_id', $tutor->id)
                ->where('reward_id', $reward->id)
                ->where('status', 'pending')
                ->first();

            if ($existingRedemption) {
                Log::info('Duplicate redemption attempt prevented', [
                    'user_id' => Auth::id(),
                    'reward_id' => $reward->id,
                ]);

                return redirect()->back()->with('error', 'You already have a pending redemption for this reward.');
            }

            // Create redemption and deduct points
            $this->executeDbOperation(
                function () use ($tutor, $reward) {
                    RewardRedemption::create([
                        'tutor_id' => $tutor->id,
                        'reward_id' => $reward->id,
                        'status' => 'pending',
                    ]);

                    $tutor->points -= $reward->pointsReq;
                    $tutor->save();
                },
                'Create Reward Redemption',
                'Failed to redeem reward'
            );

            $this->logOperationSuccess('Redeem Reward', [
                'user_id' => Auth::id(),
                'reward_id' => $reward->id,
                'points_deducted' => $reward->pointsReq,
            ]);

            return redirect()->back()->with('success', 'Reward redeemed successfully. Please wait for approval.');

        } catch (\App\Exceptions\DatabaseOperationException $e) {
            $this->logOperationFailure('Redeem Reward', $e->getMessage());
            return redirect()->back()->with('error', $e->getUserMessage());

        } catch (\Exception $e) {
            $this->logOperationFailure('Redeem Reward', $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);

            return redirect()->back()->with('error', 'An error occurred while redeeming the reward.');
        }
    }

    public function myRedemptions()
    {
        try {
            $this->logOperationStart('Fetch My Redemptions', [
                'user_id' => Auth::id(),
            ]);

            $tutor = Auth::user()->tutor;

            if (!$tutor) {
                return view('redeemed-rewards', ['redemptions' => collect()])
                    ->with('error', 'Your tutor profile not found.');
            }

            $redemptions = $this->executeDbOperation(
                fn() => $tutor->rewardRedemptions()
                    ->with('reward')
                    ->latest()
                    ->get(),
                'Fetch Redemptions',
                'Failed to load redemptions'
            );

            $this->logOperationSuccess('Fetch My Redemptions', [
                'count' => $redemptions->count(),
            ]);

            return view('redeemed-rewards', compact('redemptions'));

        } catch (\App\Exceptions\DatabaseOperationException $e) {
            Log::error('Error fetching redemptions: ' . $e->getMessage());
            return view('redeemed-rewards', ['redemptions' => collect()])
                ->with('error', $e->getUserMessage());

        } catch (\Exception $e) {
            $this->logOperationFailure('Fetch My Redemptions', $e->getMessage());
            return view('redeemed-rewards', ['redemptions' => collect()])
                ->with('error', 'An error occurred while loading redemptions');
        }
    }

    public function claimReward($claimID)
    {
        try {
            $this->logOperationStart('Claim Reward', [
                'user_id' => Auth::id(),
                'claim_id' => $claimID,
            ]);

            $claim = $this->executeDbOperation(
                fn() => RewardRedemption::findOrFail($claimID),
                'Fetch Claim',
                'Reward claim not found'
            );

            // Verify authorization
            if ($claim->tutor_id !== Auth::user()->tutor->id) {
                Log::warning('Unauthorized claim attempt', [
                    'user_id' => Auth::id(),
                    'claim_id' => $claimID,
                    'tutor_id' => $claim->tutor_id,
                ]);

                abort(403, 'You are not authorized to claim this reward.');
            }

            // Handle claim based on status
            $message = '';
            $statusCode = 'error';

            if ($claim->status === 'accepted') {
                $claim->status = 'claimed';
                $this->executeDbOperation(
                    fn() => $claim->save(),
                    'Update Claim Status',
                    'Failed to claim reward'
                );

                $message = 'Reward claimed successfully.';
                $statusCode = 'success';

                $this->logOperationSuccess('Claim Reward', [
                    'claim_id' => $claimID,
                ]);

            } elseif ($claim->status === 'rejected') {
                Log::info('Attempt to claim rejected reward', [
                    'user_id' => Auth::id(),
                    'claim_id' => $claimID,
                ]);

                $message = 'Reward has been rejected.';

            } elseif ($claim->status === 'pending') {
                $message = 'Reward is still pending.';

            } elseif ($claim->status === 'claimed') {
                $message = 'Reward has already been claimed.';
                $statusCode = 'info';
            } else {
                $message = 'Unknown reward status.';
            }

            return redirect()->back()->with($statusCode, $message);

        } catch (\App\Exceptions\DatabaseOperationException $e) {
            $this->logOperationFailure('Claim Reward', $e->getMessage());
            return redirect()->back()->with('error', $e->getUserMessage());

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Reward claim not found', [
                'user_id' => Auth::id(),
                'claim_id' => $claimID,
            ]);

            return redirect()->back()->with('error', 'Reward claim not found.');

        } catch (\Exception $e) {
            $this->logOperationFailure('Claim Reward', $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
