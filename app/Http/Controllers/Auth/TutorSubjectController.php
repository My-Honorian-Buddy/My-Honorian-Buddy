<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tutorSubject;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class TutorSubjectController extends Controller
{
    public function create(){
        return view('settingup-profile.subject-expertise');
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
