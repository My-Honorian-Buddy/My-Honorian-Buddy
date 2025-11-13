<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Student;
use App\Models\Tutor;
use App\Http\Resources\ApiResponse;
use App\Traits\ErrorHandling;
use Illuminate\Support\Facades\Auth;
use App\Models\bookedSession;
use App\View\Components\authLayout;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    use ErrorHandling;

    public function store(Request $request)
    {
        try {
            $this->logOperationStart('Store Review', [
                'user_id' => Auth::id(),
            ]);

            $validated = $request->validate([
                'tutor_id' => 'required|exists:tutors,user_id',
                'rating' => 'nullable|integer|min:1|max:5',
                'comment' => 'nullable|string|max:255',
            ]);

            $bookedSession = bookedSession::where('student_id', Auth::user()->id)
                ->where('tutor_id', $validated['tutor_id'])
                ->whereNull('deleted_at')
                ->first();

            if (!$bookedSession) {
                $this->logOperationFailure('Store Review', 'No booked session found', [
                    'user_id' => Auth::id(),
                    'tutor_id' => $validated['tutor_id'],
                ]);

                return redirect()->back()->with('notBooked', 'You have not booked a session with this tutor.');
            }

            $validated['student_id'] = $bookedSession->student_id;

            if ($bookedSession->reviewed === true) {
                $this->logOperationFailure('Store Review', 'Already reviewed', [
                    'user_id' => Auth::id(),
                ]);

                return redirect()->back()->with('reviewedAlready', 'You have already reviewed this tutor.');
            }

            // Create review
            $review = $this->executeDbOperation(
                fn() => Review::create($validated),
                'Create Review',
                'Failed to submit your review'
            );

            if (!$review) {
                return redirect()->back()->with('notCreated', 'An error occurred while submitting the review.');
            }

            // Get tutor
            $tutor = Tutor::where('user_id', $validated['tutor_id'])->first();

            if (!$tutor) {
                Log::error('Tutor not found after review creation', [
                    'tutor_id' => $validated['tutor_id'],
                ]);

                return redirect()->back()->with('noTutor', 'Tutor not found.');
            }

            // Calculate average rating
            $avgRating = Review::where('tutor_id', $validated['tutor_id'])->avg('rating');

            if (is_null($avgRating)) {
                Log::error('Failed to calculate average rating', [
                    'tutor_id' => $validated['tutor_id'],
                ]);

                return redirect()->back()->with('noAvg', 'An error occurred while calculating the average rating.');
            }

            // Update tutor and session
            $tutor->rating = round($avgRating, 1);
            $bookedSession->reviewed = true;
            $tutor->NoOfReviews += 1;

            $this->executeDbOperation(
                fn() => [
                    'session_saved' => $bookedSession->save(),
                    'tutor_saved' => $tutor->save(),
                ],
                'Update Review Data',
                'Failed to update review data'
            );

            $this->logOperationSuccess('Store Review', [
                'review_id' => $review->id,
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('reviews.show')->with('success', 'Review submitted successfully.');

        } catch (\App\Exceptions\DatabaseOperationException $e) {
            $this->logOperationFailure('Store Review', $e->getMessage());
            return redirect()->back()->with('errorOccur', $e->getUserMessage());

        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->logOperationFailure('Store Review', 'Validation failed', [
                'errors' => $e->errors(),
            ]);

            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            $this->logOperationFailure('Store Review', $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('errorOccur', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function index()
    {
        try {
            $this->logOperationStart('Fetch Reviews', [
                'user_id' => Auth::id(),
            ]);

            $reviews = $this->executeDbOperation(
                fn() => Review::where('student_id', Auth::id())
                    ->with('tutor')
                    ->get(),
                'Fetch Reviews',
                'Failed to fetch reviews'
            );

            $this->logOperationSuccess('Fetch Reviews', [
                'count' => $reviews->count(),
            ]);

            return view('view', compact('reviews'));

        } catch (\App\Exceptions\DatabaseOperationException $e) {
            Log::error('Error fetching reviews: ' . $e->getMessage());
            return view('view', ['reviews' => collect()])->with('error', 'Failed to load reviews');

        } catch (\Exception $e) {
            $this->logOperationFailure('Fetch Reviews', $e->getMessage(), [
                'user_id' => Auth::id(),
            ]);

            return view('view', ['reviews' => collect()])->with('error', 'An error occurred');
        }
    }
}
