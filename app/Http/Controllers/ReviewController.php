<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Support\Facades\Auth;
use App\Models\bookedSession;
use App\View\Components\authLayout;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{   
    public function store(Request $request){

    try{
        $validated = $request->validate([
            'tutor_id' => 'required|exists:tutors,user_id',
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string|max:255',
        ]);

        $bookedSession = bookedSession::where('student_id', Auth::user()->id)
        ->where('tutor_id', $validated['tutor_id'])
        ->first();

        if (!$bookedSession) {
            return redirect()->back()->with('notBooked', 'You have not booked a session with this tutor.');
        }

        $validated['student_id'] = $bookedSession->student_id;

        if($bookedSession->reviewed === true){
            return redirect()->back()->with('reviewedAlready', 'You have already reviewed this tutor.'); 
        }

        $review = Review::create($validated);
        if (!$review){
            return redirect()->back()->with('notCreated', 'An error occurred while submitting the review.');
        }
        $tutor = Tutor::where('user_id', $validated['tutor_id'])->first();

        if(!$tutor) {
            return redirect()->back()->with('noTutor', 'Tutor not found.');
        }
           
        $avgRating = Review::where('tutor_id', $validated['tutor_id'])->avg('rating');
        if(is_null($avgRating)){
            return redirect()->back()->with('noAvg', 'An error occurred while calculating the average rating.');
        }
        $tutor->rating = round($avgRating, 1);

    
        $bookedSession->reviewed = true;
        $bookedSession->save();
        $tutor->save();

        if(!$bookedSession->save() || !$tutor->save()){
            return redirect()->back()->with('notSaved', 'Failed to update the tutor or session data.');
        }

        return redirect()->route('reviews.show')->with('success', 'Review submitted successfully.');
    } catch (ValidationException $e) {
            return redirect()->back()->with('errorOccur', 'An unexpected error occurred. Please try again later.');
        }
    }  

    public function index(){
        $reviews = Review::where('student_id', Auth::id())->with('tutor')->get();
        
        
        return view('view', compact('reviews'));
    }   
}
