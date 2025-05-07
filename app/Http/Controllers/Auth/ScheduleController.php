<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Student;
use App\Models\User;
use App\Models\Tutor;

class ScheduleController extends Controller
{
    public function create(){

        $users = User::all();
        $students = Student::all();
        $tutor = Tutor::all();

        return view('settingup-profile.date-availability');
        
    }

    public function store(Request $request){
        Log::info('Incoming request data', $request->all());



        $request->validate([
            'days_week' => 'required|array', //JSON
            'start_time' => 'required | date_format:H:i',
            'end_time' => 'required | date_format:H:i|after:start_time',
        ]);

        Log::info('Validation scheds', $request->all());
        $userID = Auth::id();

        Schedule::create([
            'user_id' => $userID,
            'days_week' => $request->days_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,

        ]);

        Log::info('Schedule created successfully.', [
            'user_id' => $userID,
            'schedule_data' => [
                'days_week' => $request->days_week,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ],
        ]);

    
        return redirect()->route('workspace.start');
    }

}
