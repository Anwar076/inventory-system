<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Stancl\Tenancy\Database\Models\Domain;
use Stancl\Tenancy\Tenancy;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class CompanyRegistrationController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/CompanyRegister');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        // Maak alleen een user aan
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);
        $user->assignRole('admin');
        // NIET automatisch inloggen, maar redirect naar login
        return redirect('/login')->with('success', 'Registratie gelukt! Je kunt nu inloggen.');
    }
}
