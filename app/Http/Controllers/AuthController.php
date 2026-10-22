<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('pages.auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Welcome to Ghat Administration Panel.');
            }

            return redirect()->intended(route('my-bookings'))
                ->with('success', 'Jai Shri Krishna! Welcome back.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function quickLogin(string $role): RedirectResponse
    {
        $email = ($role === 'admin') ? 'admin@bookmyaarti.com' : 'devotee@example.com';
        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = User::create([
                'name' => ($role === 'admin') ? 'Ghat Prabandhak (Admin)' : 'Devotee Aarav',
                'email' => $email,
                'role' => ($role === 'admin') ? 'admin' : 'devotee',
                'password' => Hash::make('password'),
            ]);
        }

        Auth::login($user);
        request()->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Logged in as Administrator (Full Control).');
        }

        return redirect()->route('my-bookings')
            ->with('success', 'Logged in as Devotee.');
    }

    public function register(): View
    {
        return view('pages.auth.register');
    }

    public function storeRegistration(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'devotee',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('my-bookings')
            ->with('success', 'Account created successfully! Welcome to BookMyAarti.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('info', 'You have been logged out.');
    }
}
