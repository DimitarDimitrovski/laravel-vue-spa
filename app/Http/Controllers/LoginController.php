<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $userRole = User::where('email', $request->email)->first()->role;

        if($userRole === 'regular') {
            return redirect('/')
            ->with(
                [
                    'error' => 'error',
                    'message' => 'Access denied. You do not have permission to view this data.',
                    'email' => $request->email
                ]
            );
        }

        if (Auth::attempt($credentials, true)) {
            // Authentication passed...
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->back()->with(['error' => 'error', 'message' => 'Invalid login details. Please try again.', 'email' => $request->email]);
    }

    public function logout()
    {
        session()->flush();
        auth()->logout();

        return redirect()->route('admin.login')
            ->with(['status' => 'success', 'message' => 'You have successfully logged out']);
    }
}
