<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reward;
use App\Models\RewardRedemption;
use Illuminate\Support\Facades\Auth;


class RewardRedemptionController extends Controller
{
    public function index(){

        $rewards = Reward::all();
        

        return view('rewards', compact('rewards'));
    }

    public function redeem(Request $request, $rewardID) // redeeming logic
    {
        $tutor = Auth::user()->tutor;
        $reward = Reward::findorFail($rewardID);

        if ($tutor->points < $reward->pointsReq) {
            return redirect()->back()->with('error', 'You do not have enough points to redeem this reward.');
        }

        $existingRedemption = RewardRedemption::where('tutor_id', $tutor->id)
        ->where('reward_id', $reward->id)
        ->where('status', 'pending')
        ->first();

        if ($existingRedemption) {
            return redirect()->back()->with('error', 'You already have a pending redemption for this reward.');
        }

        RewardRedemption::create([
            'tutor_id' => $tutor->id,
            'reward_id' => $reward->id,
            'status' => 'pending',
        ]);

        $tutor->points -= $reward->pointsReq;
        $tutor->save();

        return redirect()->back()->with('success', 'Reward redeemed successfully. Please wait for approval.');
    }

    public function myRedemptions(){
        $tutor = Auth::user()->tutor;
        $redemptions = $tutor->rewardRedemptions()->with('reward')->latest()->get();

        return view('redeemed-rewards', compact('redemptions'));
        
    }

    public function claimReward($claimID){
        $claim = RewardRedemption::findorFail($claimID);

        if($claim->tutor_id !== Auth::user()->tutor->id){
            abort(403, 'You are not authorized to claim this reward.');
        }

        if($claim->status === 'accepted'){
            $claim->status = 'claimed';
            $claim->save();
            return redirect()->back()->with('success', 'Reward claimed successfully.');
        } elseif ($claim->status === 'rejected') {
            return redirect()->back()->with('error', 'Reward has been rejected.');
        } elseif ($claim->status === 'pending'){
            return redirect()->back()->with('error', 'Reward is still pending.');
        } elseif ($claim->status === 'claimed'){
            return redirect()->back()->with('info', 'Reward has already been claimed.');
        }

        return redirect()->back()->with('error', 'Something went wrong.');
    }
}
