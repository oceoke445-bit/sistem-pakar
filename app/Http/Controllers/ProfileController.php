<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $auth = $request->session()->get('auth');
        $user = DB::table('users')->where('id', $auth['id'])->first();

        if (! $user) {
            return redirect('/login');
        }

        $shared = [
            'user' => $user,
            'success' => $request->query('success'),
            'error' => $request->query('error') ?? session('error'),
        ];

        if ($user->role === 'user') {
            $firstName = trim(explode(' ', trim($user->nama_lengkap ?? 'Pengguna'))[0] ?: 'Pengguna');
            $username = strstr($user->email, '@', true) ?: $user->email;

            return view('profile.show-user', array_merge($shared, [
                'firstName' => $firstName,
                'username' => $username,
                'editMode' => $request->boolean('edit'),
            ]));
        }

        return view('profile.show', $shared);
    }

    public function update(Request $request)
    {
        $auth = $request->session()->get('auth');

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($auth['id'], 'id'),
            ],
            'password' => 'nullable|string|min:6|confirmed',
            'current_password' => 'nullable|required_with:password|string',
        ];

        $user = DB::table('users')->where('id', $auth['id'])->first();
        if (! $user) {
            return redirect('/login');
        }

        if ($user->role === 'user') {
            $rules['no_wa'] = 'nullable|string|max:30';
        }

        $request->validate($rules, [
            'current_password.required_with' => 'Password saat ini wajib diisi untuk mengubah password.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'email.unique' => 'Email sudah digunakan akun lain.',
        ]);

        $newPassword = (string) $request->input('password', '');
        $passwordChanged = false;

        $update = [
            'nama_lengkap' => trim($request->input('nama_lengkap')),
            'email' => strtolower(trim($request->input('email'))),
        ];

        if ($user->role === 'user') {
            $rawWa = trim((string) $request->input('no_wa', ''));
            if ($rawWa !== '') {
                $digits = preg_replace('/\D+/', '', $rawWa);
                if ($digits === '' || ! no_wa_has_allowed_prefix($digits)) {
                    return redirect('/profile?edit=1')
                        ->withInput()
                        ->with('error', 'Nomor WhatsApp harus diawali 0, 62, atau 8 (contoh: 0812…, 628…, 812…).');
                }
                $noWa = normalize_no_wa($rawWa);
                if ($noWa === null || ! preg_match('/^62[0-9]{9,14}$/', $noWa)) {
                    return redirect('/profile?edit=1')
                        ->withInput()
                        ->with('error', 'Nomor WhatsApp tidak valid. Periksa jumlah digit (contoh: 081234567890).');
                }
                $update['no_wa'] = $noWa;
            } else {
                $update['no_wa'] = null;
            }
        }

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

    public function uploadPhoto(Request $request)
    {
        $auth = $request->session()->get('auth');
        $user = DB::table('users')->where('id', $auth['id'])->first();

        if (! $user || $user->role !== 'user') {
            abort(403);
        }

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
        ], [
            'foto.required' => 'Pilih foto terlebih dahulu.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto: JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 5 MB.',
        ]);

        $file = $request->file('foto');
        $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            $ext = 'jpg';
        }
        if ($ext === 'jpeg') {
            $ext = 'jpg';
        }

        $dir = public_path('uploads/profiles');
        if (! is_dir($dir)) {
            File::ensureDirectoryExists($dir);
        }

        foreach (['jpg', 'jpeg', 'png', 'webp'] as $oldExt) {
            $old = $dir.DIRECTORY_SEPARATOR.$auth['id'].'.'.$oldExt;
            if (is_file($old)) {
                @unlink($old);
            }
        }

        $relative = 'uploads/profiles/'.$auth['id'].'.'.$ext;
        $file->move($dir, $auth['id'].'.'.$ext);

        DB::table('users')->where('id', $auth['id'])->update(['foto_profil' => $relative]);

        return redirect('/profile?success=photo');
    }
}
