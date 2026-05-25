<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($auth['id'], 'id'),
            ],
            'password' => 'nullable|string|min:6|confirmed',
            'current_password' => 'nullable|required_with:password|string',
        ], [
            'current_password.required_with' => 'Password saat ini wajib diisi untuk mengubah password.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'email.unique' => 'Email sudah digunakan akun lain.',
        ]);

        $user = DB::table('users')->where('id', $auth['id'])->first();
        if (! $user) {
            return redirect('/login');
        }

        $newPassword = (string) $request->input('password', '');
        $passwordChanged = false;

        $update = [
            'nama_lengkap' => trim($request->input('nama_lengkap')),
            'email' => strtolower(trim($request->input('email'))),
        ];

        if ($newPassword !== '') {
            if (! verify_password_hash((string) $request->input('current_password'), $user->password_hash)) {
                return redirect('/profile')->with('error', 'Password saat ini salah.');
            }

            $update['password_hash'] = Hash::make($newPassword);
            $passwordChanged = true;
        }

        DB::table('users')->where('id', $auth['id'])->update($update);

        if ($passwordChanged) {
            $fresh = DB::table('users')->where('id', $auth['id'])->first();
            if (! $fresh || ! Hash::check($newPassword, $fresh->password_hash)) {
                return redirect('/profile')->with('error', 'Password gagal disimpan. Silakan coba lagi.');
            }
        }

        $request->session()->put('auth.nama_lengkap', $update['nama_lengkap']);
        $request->session()->put('auth.email', $update['email']);

        return redirect('/profile?success='.($passwordChanged ? 'password' : 'profile'));
    }
}
