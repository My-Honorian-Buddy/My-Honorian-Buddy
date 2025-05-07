<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    public function roleSelect(){
        return view('settingup-profile.choose-role');
    }

    public function storeRole(Request $request){
        $userHasRole = Auth::user();
        
            $request->validate([
                'role' => ['required', 'in:Student,Tutor'],
            ]);

            $user = Auth::id();
            
            $updatedUser = DB::table('users')->where('id',$user)->update(['role'=>$request->role]);

            return $request->role === 'Student'
            ? redirect()->route('profile.student')
            : redirect()->route('profile.tutor');
    }
}
