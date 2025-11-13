<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Exceptions\CorVerificationException;
use App\Exceptions\FileOperationException;
use App\Traits\ErrorHandling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Student;      
use App\Models\Tutor;

class CorController extends Controller
{
    use ErrorHandling;

    public function view()
    {
        return view('auth.verify-cor');
    }
    
    public function upload(Request $request)
    {
        try {
            // Validate file upload
            $request->validate([
                'cor_pdf' => 'required|mimes:pdf|max:5120', // max 5MB
            ]);

            $this->logOperationStart('COR Upload', [
                'user_id' => Auth::id(),
                'file_size' => $request->file('cor_pdf')->getSize(),
            ]);

            // Store file temporarily
            $uploadedFile = $request->file('cor_pdf');
            $filename = time() . '_' . $uploadedFile->getClientOriginalName();

            $path = $uploadedFile->storeAs('cor_uploads', $filename, 'public');
            $fullPath = storage_path('app/public/cor_uploads/' . $filename);

            if (!file_exists($fullPath)) {
                throw new FileOperationException('File Storage', 'Uploaded file was not saved properly', 'Failed to save your COR. Please try again.');
            }

            $this->logOperationStart('COR Verification', [
                'user_id' => Auth::id(),
                'file_path' => $fullPath,
            ]);

            // Get user info
            $user = Auth::user();
            $fname = '';
            $lname = '';

            if ($user->role === 'Student' && $user->student) {
                $fname = $user->student->fname;
                $lname = $user->student->lname;
            } elseif ($user->role === 'Tutor' && $user->tutor) {
                $fname = $user->tutor->fname;
                $lname = $user->tutor->lname;
            }

            if (empty($fname) || empty($lname)) {
                throw new CorVerificationException(
                    'Invalid user profile',
                    'Your profile information is incomplete. Please complete your profile first.'
                );
            }

            // Run Python verification with error handling
            $output = $this->runPythonVerification($fullPath, $fname, $lname);

            // Parse Python output safely
            $verificationResult = $this->parsePythonOutput($output);

            if ($verificationResult['success']) {
                $user->cor_status = 'verified';
                $user->save();
                
                $this->logOperationSuccess('COR Verification', [
                    'user_id' => $user->id,
                ]);

                return back()->with('status', '✅ COR is valid!');
            } else {
                $this->logOperationFailure('COR Verification', $verificationResult['message'], [
                    'user_id' => $user->id,
                ]);

                return back()->with('status', '❌ ' . $verificationResult['message']);
            }

        } catch (CorVerificationException $e) {
            $this->logOperationFailure('COR Upload', $e->getMessage());
            return back()->with('status', $e->render());
        } catch (FileOperationException $e) {
            $this->logOperationFailure('COR Upload', $e->getMessage());
            return back()->with('status', '❌ ' . $e->getUserMessage());
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        } catch (\Exception $e) {
            $this->logOperationFailure('COR Upload', $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('status', '⚠️ An unexpected error occurred. Please try again.');
        } finally {
            // Always clean up uploaded file
            $this->cleanupFile($fullPath ?? null);
        }
    }

    /**
     * Run Python verification script with error handling
     *
     * @param string $fullPath
     * @param string $fname
     * @param string $lname
     * @return string
     * @throws CorVerificationException
     */
    private function runPythonVerification($fullPath, $fname, $lname)
    {
        $pythonPath = env('PYTHON_PATH', 'python3');
        $pythonScriptPath = base_path('python/cor_verify/cor_verification.py');

        if (!file_exists($pythonScriptPath)) {
            throw new CorVerificationException(
                'Verification script not found',
                'The verification service is temporarily unavailable. Please try again later.'
            );
        }

        $command = $pythonPath . " " .
            escapeshellarg($pythonScriptPath) . " " .
            escapeshellarg($fullPath) . " " .
            escapeshellarg($fname) . " " .
            escapeshellarg($lname) . " 2>&1";

        $output = shell_exec($command);

        if ($output === null) {
            throw new CorVerificationException(
                'Python execution failed',
                'The verification service encountered an error. Please try again.'
            );
        }

        return $output;
    }

    /**
     * Parse Python output safely
     *
     * @param string $output
     * @return array
     */
    private function parsePythonOutput($output)
    {
        $output = trim($output);

        // Log raw output for debugging
        Log::debug('Python verification output', ['output' => $output]);

        // Check for valid COR
        if (stripos($output, 'valid') !== false && stripos($output, 'invalid') === false) {
            return [
                'success' => true,
                'message' => 'COR is valid',
            ];
        }

        // Check for invalid COR
        if (stripos($output, 'invalid') !== false) {
            // Try to extract missing keywords from output
            if (preg_match('/Missing:\s*(.+)/', $output, $matches)) {
                $missing = $matches[1];
                return [
                    'success' => false,
                    'message' => "COR is invalid. Missing or incorrect: {$missing}",
                ];
            }

            return [
                'success' => false,
                'message' => 'COR is invalid. Please check your Certificate of Registration.',
            ];
        }

        // Check for errors in output
        if (stripos($output, 'error') !== false) {
            if (preg_match('/Error[:\s]*(.+?)[\n$]/', $output, $matches)) {
                $errorMsg = trim($matches[1]);
                return [
                    'success' => false,
                    'message' => "Verification error: {$errorMsg}",
                ];
            }

            return [
                'success' => false,
                'message' => 'An error occurred during verification.',
            ];
        }

        // Unknown response
        return [
            'success' => false,
            'message' => 'Could not verify COR. Please ensure the file is a valid PDF.',
        ];
    }

    /**
     * Clean up uploaded file
     *
     * @param string|null $fullPath
     * @return void
     */
    private function cleanupFile($fullPath)
    {
        if (!$fullPath) {
            return;
        }

        try {
            if (file_exists($fullPath)) {
                if (!unlink($fullPath)) {
                    Log::warning('Failed to delete temporary file', ['path' => $fullPath]);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Error cleaning up file', [
                'path' => $fullPath,
                'error' => $e->getMessage(),
            ]);
        }
    }
}