<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function storeUser(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:user_infos,username',
            'password' => 'required|string|min:8',
        ], [
            "username.unique" => "Username sudah terdaftar.",
            "email.unique" => "Email sudah terdaftar.",
            "email.email" => "Format email tidak valid.",
            "password.min" => "Password harus memiliki minimal 8 karakter.",
            "username.required" => "Username harus diisi.",
            "email.required" => "Email harus diisi.",
            "password.required" => "Password harus diisi.",
            "name.required" => "Nama harus diisi.",
        ]);

        try {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);
            UserInfo::create([
                'user_id' => $user->id,
                'username' => $validatedData['username'],
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User creation failed', 'error' => $e->getMessage()], 500);
        }

        // Return a response
        return response()->json(['message' => 'User created successfully'], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            "remember" => 'required',
        ], [
            "email.required" => "Email harus diisi.",
            "password.required" => "Password harus diisi.",
            "email.email" => "Format email tidak valid.",
            "remember.required" => "Remember me harus diisi.",
        ]);

        $user = User::where('email', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $credentials['remember']);
            return response()->json(['message' => 'Login successful'], 200);
        }
        return response()->json(['message' => 'The provided credentials do not match our records.'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect("/login");
    }
}
