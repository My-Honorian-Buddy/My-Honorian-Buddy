<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TermsAgreementController extends Controller
{
    /**
     * Display the terms agreement page.
     */
    public function show(): View
    {
        return view('auth.terms-agreement');
    }

    /**
     * Handle the terms acceptance.
     */
    public function accept(Request $request): RedirectResponse
    {
        $request->validate([
            'agree' => ['required', 'accepted'],
        ], [
            'agree.required' => 'You must agree to the Terms and Conditions to continue.',
            'agree.accepted' => 'You must agree to the Terms and Conditions to continue.',
        ]);

        // Mark that user has accepted terms in session or database
        $user = $request->user();
        $user->update(['terms_accepted_at' => now()]);

        return redirect()->route('role.select');
    }
}
