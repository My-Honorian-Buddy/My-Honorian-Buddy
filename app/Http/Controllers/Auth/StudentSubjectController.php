<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\studentSubject;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class StudentSubjectController extends Controller
{

    public function create(){
        
        return view('settingup-profile.subject-improvement');
        Log::info('successfully created student subject');
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
