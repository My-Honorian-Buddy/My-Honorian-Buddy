<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{

    public function store(Request $request)
    {

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gend' => ['required', 'string', 'max:255'],
            'add' => ['required', 'string', 'max:255'],
            'bio_student' => ['nullable', 'string', 'max:255'],
            'birthday' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('d-m-Y'),
            ],
        ], [
            'birthday.before_or_equal' => '*You must be at least 18 years old to register.',
        ]);

        Session::put('first_name', $request->first_name);
        Session::put('last_name', $request->last_name);
        Session::put('gend', $request->gend);
        Session::put('add', $request->add);
        Session::put('bio_student', $request->bio_student);
        Session::put('birthday', $request->birthday);

        return redirect()->route('department.student');
    }

    public function store_dept(Request $request)
    {

        $request->validate([
            'year_level' => ['required', 'string', 'max:255'],
            'college' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],

        ]);

        $userID = Auth::id();

        $student = Student::create([
            'user_id' => $userID,
            'fname' => Session::get('first_name'),
            'lname' => Session::get('last_name'),
            'gender' => Session::get('gend'),
            'address' => Session::get('add'),
            'year_level' => $request->year_level,
            'department' => $request->department,
            'college' => $request->college,
            'bio' => Session::get('bio_student'),
        ]);

        Session::forget(['first_name', 'last_name', 'gend', 'add', 'bio_student']);

        return redirect()->route('subjects.create');
    }
}
