<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\ToDoLists;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use App\Models\bookedSession;

class TaskController extends Controller
{
    public function index()
    {
        $todolists = Auth::user()->to_do_lists;

        $user = Auth::user();
        $student = Student::All();
        $tutor = Tutor::All();
        $subjects = collect();
        $pickedSubjects = collect();
        $allUsers = User::all();
        $bookedSession = collect();

        if ($user->role ==='Student' && $user->student){
            $student = $user->student;
            if($student){
                $pickedSubjects = $student->subject_student;
            }else{
                Log::info("No Sessions Found");
            }
            
        } elseif ($user->role === 'Tutor' && $user->tutor) {
            $tutor = $user->tutor;
            if($tutor){
                $pickedSubjects = $tutor->subject_tutor;
            }else{
                Log::info("No Sessions Found");
            } 
        }

        if ($user->role ==='Student' && $user->student){
            $student = $user->student->bookedsessions;
            if($student){
                $subjects = $student->tutoring_subject;
            }else{
                Log::info("No Sessions Found");
            }
            
        } elseif ($user->role === 'Tutor' && $user->tutor) {
            $tutor = $user->tutor->bookedsessions;
            if($tutor){
                $subjects = $tutor->tutoring_subject;
            }else{
                Log::info("No Sessions Found");
            } 
        }

        return view('workspace', compact('todolists', 'subjects', 'user', 'student', 'allUsers', 'tutor', 'pickedSubjects', ));
    }
    
    public function store(Request $request)
    {
        Log::info("Store request: ", $request->all()); 
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            ]);
        Log::info("Task validation passed: ", $validated); 
        $userId = Auth::user()->id;

        $task = ToDoLists::create([
            'user_id' => $userId,
            'title' => $request->title,
            'is_completed' => false,
        ]);

        Log::info('Task created:', $task->toArray());
        return response()->json(['status' => 'success', 'task' => $task]);
    }

    public function update(ToDoLists $task)
    {
        if (Auth::id() !== $task->user_id) {
            abort('Unauthorized action');
        }

        $task->update([
            'is_completed' => !$task->is_completed
        ]);

        return response()->json(['status' => 'success']);
    }

    public function delete(ToDoLists $task)
    {
        if (Auth::id() !== $task->user_id) {
            abort('Unauthorized action.');
        }
        
        $task->delete();
        
        return response()->json(['status' => 'success']);
        
    }

    public function connectTutor(){

        $user = Auth::user();
        $student = Student::All();
        $tutor = Tutor::All();
        $subjects = collect();
        $pickedSubjects = collect();
        $allUsers = User::all();
        $bookedSession = collect();

        if ($user->role ==='Student' && $user->student){
            $student = $user->student;
            if($student){
                $pickedSubjects = $student->subject_student;
            }else{
                Log::info("No Sessions Found");
            }
            
        } elseif ($user->role === 'Tutor' && $user->tutor) {
            $tutor = $user->tutor;
            if($tutor){
                $pickedSubjects = $tutor->subject_tutor;
            }else{
                Log::info("No Sessions Found");
            } 
        }

        return view ('workspace.tutor-profile', compact('user', 'student', 'tutor', 'subjects', 'pickedSubjects', 'allUsers', 'bookedSession'));
    }

    public function connectStudent(){
        $user = Auth::user();
        $student = Student::All();
        $tutor = Tutor::All();
        $subjects = collect();
        $pickedSubjects = collect();
        $allUsers = User::all();
        $bookedSession = collect();

        if ($user->role ==='Student' && $user->student){
            $student = $user->student;
            if($student){
                $pickedSubjects = $student->subject_student;
            }else{
                Log::info("No Sessions Found");
            }
            
        } elseif ($user->role === 'Tutor' && $user->tutor) {
            $tutor = $user->tutor;
            if($tutor){
                $pickedSubjects = $tutor->subject_tutor;
            }else{
                Log::info("No Sessions Found");
            } 
        }
        return view ('workspace.student-profile', compact('user', 'student', 'tutor', 'subjects', 'pickedSubjects', 'allUsers', 'bookedSession'));
    }

}


