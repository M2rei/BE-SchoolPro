<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        $Login = User::all();
        return response()->json($Login);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();



        
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::WithMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken('user login')->plainTextToken;
    }

    public function postuser(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($validatedData['password']),
            'role' => $request->role,
        ]);

        if ($user) {
            return response()->json([
                'message' => 'User created successfully.',
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'Failed to create user.',
                'error' => 'Unknown error occurred.'
            ], 500);
        }
    }
}
