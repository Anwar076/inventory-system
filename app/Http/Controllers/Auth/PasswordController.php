<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if (!Hash::check($request->current_password, $request->user()->password)) {
            return back()->withErrors([
                'current_password' => __('auth.password'),
            ]);
        }

        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }
} 