<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\studentSubject;
use Illuminate\Http\Request;
use App\Models\tutorSubject;
use App\Models\Subject;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


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

        foreach ($request->subjects as $subjectData){
            studentSubject::create([
                'student_id' => $studentID ,
                'subj_code' => $subjectData['subj_code'],
                'subj_name' => $subjectData['subj_name'],
            ]);
    
        Log::info('Stored subjects', $subjectData);
        }

        Log::info('Session data before checking', $request->session()->all());

        if ($request->session()->has('changing_subjects')) {

            $request->session()->forget('changing_subjects');
            
            // redirect to workspace if sched exists
            return response()->json([
                'status' => 'success',
                'redirect' => route('workspace.start')
            ]);
        } else {
            // redirect to schedule if no sched exists
            return response()->json([
                'status' => 'success',
                'redirect' => route('user.schedule')
            ]);
        }
    }

}
