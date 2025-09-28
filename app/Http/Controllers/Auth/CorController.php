<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Student;      
use App\Models\Tutor;

class CorController extends Controller
{

    public function view()
    {
        return view('auth.verify-cor');
    }
    
    public function upload(Request $request)
    {
        $request->validate([
            'cor_pdf' => 'required|mimes:pdf|max:5120', // max 5MB lang para di sayang space
        ]);
    
        // Store temporarily then deletes after ma check. ref to line 26
        $uploadedFile = $request->file('cor_pdf');
        $filename = time() . '_' . $uploadedFile->getClientOriginalName();

        $path = $uploadedFile->storeAs('cor_uploads', $filename, 'public');
        $fullPath = storage_path('app/public/cor_uploads/' . $filename);
        // sleep(1);
        // dd([
        //     'fullPath' => $fullPath,
        //     'file_exists' => file_exists($fullPath),
        // ]);

        // tempo
        // dd($request->file('cor_pdf'));
        // dd($fullPath);
        // Run Python verification
        // $output = shell_exec("python3 python/cor_verify/cor_verification.py");

        $user = Auth::user();
        $fname = '';
        $lname = '';

        if ($user -> role === 'Student' && $user->student) {
            
                $fname = $user->student->fname;
                $lname = $user->student->lname;
            
        } elseif ($user -> role === 'Tutor' && $user->tutor) {
            
                $fname = $user->tutor->fname;
                $lname = $user->tutor->lname;
            
        }

        // Run Python verification
        // naka hard code, lipat sa .env pag uupload na sa hosting service
        $pythonPath = env('PYTHON_PATH', 'python');
        $pythonScriptPath = base_path('python/cor_verify/cor_verification.py');

        // check if same name and same cor :)
        // dd([
        // 'role' => $user->role,
        // 'fname' => $fname,
        // 'lname' => $lname,
        // auth::user()
        // ]);

        $command = $pythonPath . " "
        . escapeshellarg($pythonScriptPath) . " " 
        . escapeshellarg($fullPath) . " "
        . escapeshellarg($fname) . " "
        . escapeshellarg($lname) . " 2>&1"; // capture errors

        // $command = trim($command);
        $output = shell_exec($command);
        // dd($output);
        // dd($command, $output);
        // \Log::info('COR command', ['command' => $command]);
        // \Log::info('COR output', ['output' => $output]);
    
        // Delete file after checking (to be revised na dedelete kasi agad)
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    
        // Handle Python output
        // Much better if toast message
        if (stripos($output, 'invalid') !== false) {
            return back()->with('status', '❌ COR is invalid!');
        } elseif (stripos($output, 'valid') !== false) {
            $user = Auth::user();
            $user->cor_status = 'verified';
            $user->save();
            return back()->with('status', '✅ COR is valid!');
        } else {
            return back()->with('status', '⚠️ Error during COR verification.');
        }
    }
}