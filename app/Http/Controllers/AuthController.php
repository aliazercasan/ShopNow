<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:customer,seller',
            'shop_name' => 'required_if:role,seller|nullable|string|max:255',
            'tin_number' => 'required_if:role,seller|nullable|string|max:255',
            'business_permit' => 'required_if:role,seller|nullable|image|max:2048',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ];

        // Handle seller-specific data
        if ($validated['role'] === 'seller') {
            $userData['shop_name'] = $validated['shop_name'];
            $userData['tin_number'] = $validated['tin_number'];
            $userData['verification_status'] = 'pending';
            
            if ($request->hasFile('business_permit')) {
                $userData['business_permit'] = $request->file('business_permit')->store('business_permits', 'public');
            }
        } else {
            $userData['verification_status'] = 'approved'; // Customers are auto-approved
        }

        $user = User::create($userData);

        Auth::login($user);

        // Redirect based on role
        if ($user->isSeller()) {
            if ($user->isPending()) {
                return redirect()->route('seller.dashboard')->with('info', 'Your seller account is pending verification. You can add products, but they won\'t be visible until approved.');
            }
            return redirect()->route('seller.dashboard')->with('success', 'Welcome to your seller dashboard!');
        }

        return redirect()->route('products.index')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.products.index');
            }

            if (Auth::user()->isSeller()) {
                return redirect()->route('seller.dashboard');
            }

            return redirect()->intended(route('products.index'));
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
