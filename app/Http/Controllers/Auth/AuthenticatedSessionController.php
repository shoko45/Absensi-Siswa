<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

/**
 * Handle an incoming authentication request.
 */
public function store(Request $request): RedirectResponse
{
    // 1. Validasi ganti dari 'email' ke 'username'
    $request->validate([
        'username' => ['required', 'string'], 
        'password' => ['required', 'string'],
    ]);

    // 2. Proses Login pakai 'username'
    if (! Auth::attempt($request->only('username', 'password'), $request->boolean('remember'))) {
        throw ValidationException::withMessages([
            'username' => __('auth.failed'),
        ]);
    }

    $request->session()->regenerate();

    $user = Auth::user();

    if ($user->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role == 'wali_kelas') {
        return redirect()->route('guru.dashboard');
    } else {
        return redirect()->route('siswa.dashboard');
    }
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
