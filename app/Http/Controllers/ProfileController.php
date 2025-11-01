<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Menampilkan profil
    public function show()
    {
        $user = Auth::user()->load('userInfo', 'activities');
        return view('profile', compact('user'));
    }

    // Menampilkan halaman edit
    public function edit()
    {
        $user = Auth::user()->load('userInfo');
        return view('profile-edit', compact('user'));
    }

    // Menyimpan hasil edit
    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'collage_year' => 'nullable|integer',
            'major' => 'nullable|string|max:255',
            'semester' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $userInfo = $user->userInfo;

        if ($userInfo) {
            $userInfo->update($request->only('username', 'collage_year', 'major', 'semester'));
        }

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
