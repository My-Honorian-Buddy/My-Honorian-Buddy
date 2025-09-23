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
use Illuminate\Support\Facades\Log;

class RoleSwitchController extends Controller
{
    public function switchRole (Request $request){
        $mode = $request->input('mode');

        if (!in_array($mode, ['student', 'tutor'])) {
            return redirect()->back()->with('error', 'Invalid mode selected.');
        }

        $user = Auth::user();
        $userID = $user->id;
        $student = $user->student;
        $tutor = $user->tutor;

        $role = ucfirst($mode);

        DB::table('users')
            ->where('id',$user->id)
            ->update([
                'mode'=>$mode,
                'role'=>$role
            ]);

            //if no student account
        if ($mode === 'student' && !$user->student) {
            Student::create([
                'user_id' => $user->id,
                'fname' => $tutor->fname,
                'lname' => $tutor->lname,
                'gender' => $tutor->gender,
                'address' => $tutor->address,
                'year_level' => $tutor->year_level,
                'department' => $tutor->department,
                'bio' => $tutor->bio,
            ]);
            Log::info('Switch role', ['mode'], $mode);

            return redirect()->route('subjects.create')->with('success', 'Please fill out your student profile.');
        }
            //if no tutor account
        if ($mode === 'tutor' && !$user->tutor) {
            Tutor::create([
                'user_id' => $userID,
                'fname' => $student->fname,
                'lname' => $student->lname,
                'gender' => $student->gender,
                'address' => $student->address,
                'year_level' => $student->year_level,
                'department' => $student->department,
                'bio' => $student->bio,
            ]);
            Log::info('Switch role', ['mode'], $mode);

            return redirect()->route('tutor.create')->with('success', 'Please fill out your tutor profile.');
        }

        return redirect()->back()->with('success', 'Swtiched to ' . ucfirst($mode). " mode");

    }
}
