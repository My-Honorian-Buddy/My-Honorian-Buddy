<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    public function chatty(Request $request)
    {
        Log::info('Received chatty request with message: '. $request->message);
        $request->validate([
            'message' => 'required|string',
        ]);

        $apiKey = env('OPENAI_API_KEY');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post('https://chatgpt-api.shn.hk/v1/', [
            'prompt' => $request->input('message'),
            'user' => $request->user()->id, // Track user-specific data
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            // Log the failed response for debugging
            return response()->json([
                'error' => 'AI request failed.',
                'status' => $response->status(),
                'response' => $response->body()
            ], 500);
            
        }
        
    }
}

