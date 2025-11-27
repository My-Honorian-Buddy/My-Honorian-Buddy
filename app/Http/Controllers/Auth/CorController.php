<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use App\Models\Student;      
use App\Models\Tutor;
use App\Models\CorSetting;

class CorController extends Controller
{
    /**
     * Get active COR verification keywords for Python script
     * API endpoint for dynamic keyword loading
     */
    public function getActiveKeywords(): JsonResponse
    {
        $activeSetting = CorSetting::getActive();

        if (!$activeSetting) {
            return response()->json([
                'success' => false,
                'message' => 'No active COR verification settings found. Please configure COR settings in admin panel.',
                'keywords' => []
            ], 404);
        }

        if (!$activeSetting->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'COR verification settings have expired. Please update the settings.',
                'keywords' => []
            ], 410);
        }

        return response()->json([
            'success' => true,
            'keywords' => $activeSetting->getRequiredKeywords(),
            'academic_year' => $activeSetting->academic_year,
            'valid_until' => $activeSetting->valid_until->format('Y-m-d'),
        ]);
    }

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

        // Get active COR settings to pass to Python script
        $activeSetting = CorSetting::getActive();
        
        if (!$activeSetting) {
            return back()->with('status', '⚠️ No active COR verification settings found. Please contact admin.');
        }
        
        if (!$activeSetting->isValid()) {
            return back()->with('status', '⚠️ COR verification settings have expired. Please contact admin.');
        }
        
        $keywords = $activeSetting->getRequiredKeywords();
        
        // Write keywords to temporary file for Python script to read
        $keywordsFile = storage_path('app/cor_keywords_temp.json');
        file_put_contents($keywordsFile, json_encode($keywords, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        
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

        // Pass keywords file path to avoid API call and JSON escaping issues
        $command = $pythonPath . " "
        . escapeshellarg($pythonScriptPath) . " " 
        . escapeshellarg($fullPath) . " "
        . escapeshellarg($fname) . " "
        . escapeshellarg($lname) . " "
        . escapeshellarg($keywordsFile) . " 2>&1"; // capture errors

        // $command = trim($command);
        $output = shell_exec($command);
        
        // Clean up temporary keywords file
        if (file_exists($keywordsFile)) {
            unlink($keywordsFile);
        }
        
        // Debug logging - check storage/logs/laravel.log for details
        \Log::info('COR Verification Debug', [
            'command' => $command,
            'output' => $output,
            'output_length' => strlen($output ?? ''),
            'output_contains_valid' => stripos($output, 'valid'),
            'output_contains_invalid' => stripos($output, 'invalid'),
            'fname' => $fname,
            'lname' => $lname,
            'pdf_path' => $fullPath,
            'file_exists' => file_exists($fullPath)
        ]);
    
        // Delete file after checking (to be revised na dedelete kasi agad)
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    
        // Handle Python output
        // Check if output is empty or null first
        if (empty($output)) {
            \Log::error('COR Verification Error: Python script produced no output');
            return back()->with('status', '⚠️ Error: No response from verification script.');
        }
        
        // Much better if toast message
        if (stripos($output, 'invalid') !== false) {
            return back()->with('status', '❌ COR is invalid!');
        } elseif (stripos($output, 'valid') !== false) {
            $user = Auth::user();
            $user->cor_status = 'verified';
            $user->save();
            return back()->with('status', '✅ COR is valid!');
        } else {
            \Log::error('COR Verification Error: Could not parse output', ['output' => $output]);
            return back()->with('status', '⚠️ Error during COR verification. Check logs for details.');
        }
    }
}