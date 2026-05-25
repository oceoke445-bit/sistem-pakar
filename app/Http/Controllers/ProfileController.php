<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $auth = $request->session()->get('auth');

        return view('profile.show', [
            'user' => DB::table('users')->where('id', $auth['id'])->first(),
            'success' => $request->query('success'),
            'error' => $request->query('error'),
        ]);
    }

    public function update(Request $request)
    {
        $auth = $request->session()->get('auth');
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|string',
            'current_password' => 'nullable|string',
        ]);

        $user = DB::table('users')->where('id', $auth['id'])->first();
        if (! $user) {
            return redirect('/login');
        }

        $newPassword = trim((string) $request->input('password', ''));
        $update = [
            'nama_lengkap' => trim($request->input('nama_lengkap')),
            'email' => strtolower(trim($request->input('email'))),
        ];

        if ($newPassword !== '') {
            if (! $request->filled('current_password')) {
                return redirect('/profile')->with('error', 'Password saat ini wajib diisi untuk mengubah password.');
            }
            if (! verify_password_hash($request->input('current_password'), $user->password_hash)) {
                return redirect('/profile')->with('error', 'Password lama salah.');
            }
            $update['password_hash'] = Hash::make($newPassword);
        }

        DB::table('users')->where('id', $auth['id'])->update($update);

        $request->session()->put('auth.nama_lengkap', $update['nama_lengkap']);
        $request->session()->put('auth.email', $update['email']);

        return redirect('/profile?success=1');
    }
}
