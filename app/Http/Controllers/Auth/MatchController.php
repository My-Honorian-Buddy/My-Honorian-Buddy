<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\studentSubject;
use App\Models\tutorSubject;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class MatchController extends \App\Http\Controllers\Controller
{
    public function view()
    {
        $user = Auth::user();
        return view('find-buddy.ai-matching-explore', compact('user'));
    }
    public function showMatches()
    {

        if (Auth::check()) {
            $auth_id = Auth::user()->id;
        } else {
            return redirect()->route('login');
        }

        // ilalagay dito ano kung sino naka login na student ganun
        $users = User::all();
        $tutors = Tutor::paginate(1);
        $students = Student::all();
        Log::info("Tutor: " . $tutors);
        // Log::info("Student: " . $students);
        $tutorSubjects = tutorSubject::paginate(1);
        $studentSubjects = studentSubject::all();

        // Path to the Python script
        $pythonScriptPath = base_path('/python/main.py');
        Log::info($pythonScriptPath);

        // Run the Python script, passing the subjects as an argument
        $pythonPath = env('PYTHON_PATH', 'python');
        $command = $pythonPath . " " . escapeshellarg($pythonScriptPath) . " " . escapeshellarg($auth_id) . " 2>&1";

        Log::info($command);
        $output = shell_exec($command);
        $output = trim($output);

        $startPos = strpos($output, '[{');

        if ($startPos !== false) {
            $output = substr($output, $startPos);
        }

        $matches = json_decode($output, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('JSON Decode Error: ' . json_last_error_msg());
            return response()->json(['error' => 'Invalid JSON output from Python script.'], 500);
        }


        return view('find-buddy.ai-matching-result', compact('matches', 'tutors', 'auth_id', 'students', 'tutorSubjects', 'studentSubjects', 'users'));

        // Log::info('Output: ' . $output);
        // dd($output);
        // if (!$output) {
        //     return response()->json(['error' => 'No output from Python script.'], 500);
        // }

        // // Decode the JSON output from the Python script (assumes the script returns JSON)
        // $matches = json_decode($output, true);
        // if (json_last_error() !== JSON_ERROR_NONE) {
        //     Log::error('JSON decode error: ' . json_last_error_msg());
        //     return response()->json(['error' => 'Invalid JSON output from Python script.'], 500);
        // }


        // return view('find-buddy.ai-matching-result', compact('matches', 'tutors', 'auth_id', 'students', 'tutorSubjects', 'studentSubjects','users'));
    }
}
