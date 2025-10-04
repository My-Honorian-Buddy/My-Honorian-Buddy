<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.tutor.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
       $validated = $request->validate([
           'fname' => ['nullable', 'string', 'max:255'],
           'lname' => ['nullable', 'string', 'max:255'],
           'email' => ['nullable', 'email', 'max:255'],
           'bio' => ['nullable', 'string', 'max:255'],
       ]);

        $user = $request->user();

        if($user->role === 'Student') {
            $student = $user->student;
            $student->fname = $validated['fname'];
            $student->lname = $validated['lname'];
            $student->bio = $validated['bio'];
            $student->save();
        } else if($user->role === 'Tutor') {
            $tutor = $user->tutor;
            $tutor->fname = $validated['fname'];
            $tutor->lname = $validated['lname'];
            $tutor->bio = $validated['bio'];
            $tutor->save();
        }

        $user->email = $validated['email'];

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

       $user->save();

        return redirect()->route('profile.edit')->with('success', 'User profile updated successfully!');
    }

    

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        Log::info('User trying to delete account, provider: ' . $user->provider);

        if($user->provider == 'google'){
            $user->delete();                                                                                                                
            Auth::logout();
            return Redirect::to('/')->with('success', 'Account deleted Successfully!');
        }else{
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);
            Auth::logout(); 
            $user->delete();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function uploadProfilePicture(User $user, Request $request)
    {
        Log::info("Starting profile picture upload...");
    
        $data = $request->validate([
            'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        Log::info("Profile picture validation passed.");
        
        $user = $request->user();
        Log::info("Fetched user data", ['user_id' => $user->id]);
    
        if ($request->hasFile('profile_pic')) {
            Log::info("New profile picture uploaded", ['filename' => $request->file('profile_pic')->getClientOriginalName()]);
        
            $path = $request->file('profile_pic')->store('profile_pictures', 'public');
            Log::info("path to new profile picture:", ['path' => $url = Storage::url($path)]);
            Log::info("New profile picture stored", ['path' => $path]);
            
            $user->profile_pic ='/' . 'storage/' . $path;
            $user->save();
            Log::info("User profile picture updated in database", ['user_id' => $user->id, 'new_profile_pic' => 'storage/' . $path]);

            Log::info("The profile pic:" . $user->profile_pic);
            return Redirect::to('/profile/edit-profile')->with('success', 'Profile picture uploaded successfully!');
        }
    
        Log::error("Profile picture upload failed - no file detected.");
        return redirect()->back()->with('error', 'Something went wrong!');
    }

    public function changeSubjects(Request $request){
        $user = $request->user();
        
        try {
            $request->session()->put('changing_subjects', true);
            
            if ($user->role === 'Student') {

                //delete existing subjects for student
                if ($user->student && $user->student->subject_student()->exists()) {
                    $user->student->subject_student()->delete();
                    Log::info('Student subjects reset', ['user_id' => $user->id]);
                }

                return redirect()->route('subjects.create')->with('success', 'Your subjects have been reset. Please select your subjects again.');

            } elseif ($user->role === 'Tutor') {

                //delete existing subjects for tutor
                if ($user->tutor && $user->tutor->subject_tutor()->exists()) {
                    $user->tutor->subject_tutor()->delete();
                    Log::info('Tutor subjects reset', ['user_id' => $user->id]);
                }
                
                return redirect()->route('tutor.create')->with('success', 'Your subject expertise has been reset. Please select your subjects again.');
            }
            
            return redirect()->back()->with('error', 'Unable to determine user role.');
            
        } catch (\Exception $e) {
            Log::error('Error resetting subjects', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'An error occurred while resetting your subjects. Please try again.');
        }
    }

}
