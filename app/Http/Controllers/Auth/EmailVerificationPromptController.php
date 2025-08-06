<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Inertia\Inertia;

class EmailVerificationPromptController
{
    public function __invoke(Request $request)
    {
        return Inertia::render('Auth/VerifyEmail', [
            'status' => session('status'),
        ]);
    }
} 