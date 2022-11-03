<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Show Regiter/Create form

    public function create()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ["required", 'min:3'],
            'email' => ["required", "email", Rule::unique('users', 'email')],
            'password' => "required|confirmed|min:6"
        ]);

        $formFields["password"] = bcrypt($formFields["password"]);

        $user = User::create($formFields);

        auth()->login($user);
        return redirect('/')->with("success", "User created and logged in");
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with("message", "You have been logged out");
    }
}
