<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\studentSubject;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;


class StudentSubjectController extends Controller
{

    public function create(){

        $subjects = Subject::pluck('subj_name', 'subj_code');
        return view('settingup-profile.subject-improvement', compact('subjects'));
    }

    public function store(Request $request){
        Log::info('Incoming request data', $request->all());

        $request->validate([
            'subjects' => 'required|array',
            'subjects.*.subj_code' => ['required', 'string', 'max:255'],
            'subjects.*.subj_name' => ['required', 'string', 'max:255'],
            
        ]);

        Log::info('Received subjects', $request->all());

        $studentID = Auth::id();


        try{
        foreach ($request->subjects as $subjectData){
            studentSubject::create([
                'student_id' => $studentID,
                'subj_code' => $subjectData['subj_code'],
                'subj_name' => $subjectData['subj_name'],
            ]);

        Log::info('Stored subjects', $subjectData);
        }
        }catch(\Exception $e){
            Log::error('Error storing subjects', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error storing subjects'], 500);
        }
        
        // return redirect()->route('user.schedule');
    }
}
