<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tutorSubject;
use App\Models\Subject;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class TutorSubjectController extends Controller
{
   
    public function create(){
        $subjects = Subject::pluck('subj_name', 'subj_code');
        return view('settingup-profile.subject-expertise', compact('subjects'));
    }

    public function store(Request $request){
        Log::info('Incoming request data', $request->all());
        
        $request->validate([
            'subjects' => 'required|array',
            'subjects.*.subj_code' => ['required', 'string', 'max:255'],
            'subjects.*.subj_name' => ['required', 'string', 'max:255'],
            
        ]);

        Log::info('Received subjects', $request->all());

        $tutorID = Auth::id();

        foreach ($request->subjects as $subjectData){
            tutorSubject::create([
                'tutor_id' => $tutorID ,
                'subj_code' => $subjectData['subj_code'],
                'subj_name' => $subjectData['subj_name'],
            ]);
    
        Log::info('Stored subjects', $subjectData);
        }
    }

}
