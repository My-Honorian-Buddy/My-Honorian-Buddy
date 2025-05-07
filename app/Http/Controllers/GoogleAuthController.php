<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle(){
        
        try{
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id', $google_user->getId())->first();
    
            if(!$user){
                
                $existing_user = User::where('email', $google_user->getEmail())->first();
    
                if ($existing_user) {
                    
                    $existing_user->update([
                        'google_id' => $google_user->getId(),
                        'provider' => 'google',
                    ]);
    
                    Auth::login($existing_user);
                } else {

                    $new_user = User::create([
                        'name' => $google_user->getName(),
                        'email' => $google_user->getEmail(),
                        'profile_pic' => $google_user->getAvatar(),
                        'google_id' => $google_user->getId(),
                        'provider' => 'google',
                        
                    ]);
                    Log::info("Updated existing user with Google login", $new_user->toArray());
    
                    Auth::login($new_user);
                    $user = $new_user;
                }
            } else {
                Auth::login($user);
            } 
            
            return $user->role 
            ? redirect()->route('workspace.start') 
            : redirect()->route('role.select');

        } catch (\Throwable $th){
            Log::error("Google Authentication Error: " . $th->getMessage());
            return redirect()->route('login')->withErrors('An error occurred during Google sign-in. Please try again' );
            
        }
    }
}
