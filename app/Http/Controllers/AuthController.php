<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationSuccessMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        return view('auth.login', [
            'error' => $request->query('error') ?? session('error'),
            'registered' => $request->query('registered'),
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = strtolower(trim($request->input('email')));

        try {
            $user = DB::table('users')->where('email', $email)->first();
        } catch (\Throwable $e) {
            return redirect('/login')->with('error', 'Server/database bermasalah, coba lagi');
        }

        if (! $user) {
            return redirect('/login')->with('error', 'Email atau password salah');
        }

        // Support both Laravel Bcrypt and Next.js bcryptjs hashes
        $passwordValid = verify_password_hash($request->input('password'), $user->password_hash);

        if (! $passwordValid) {
            return redirect('/login')->with('error', 'Email atau password salah');
        }

        try {
            session([
                'auth' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'role' => $user->role,
                    'nama_lengkap' => $user->nama_lengkap,
                ],
            ]);
        } catch (\Throwable $e) {
            return redirect('/login')->with('error', 'Gagal membuat sesi login, coba lagi');
        }

        return redirect($user->role === 'admin' ? '/admin/dashboard' : '/user/dashboard');
    }

    public function showRegister(Request $request)
    {
        return view('auth.register', [
            'error' => $request->query('error') ?? session('error'),
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:1',
            'nama_lengkap' => 'required|string|max:255',
        ]);

        $email = strtolower(trim($request->input('email')));

        try {
            $exists = DB::table('users')->where('email', $email)->exists();
        } catch (\Throwable $e) {
            return redirect('/register')->with('error', 'Server/database bermasalah, coba lagi');
        }

        if ($exists) {
            return redirect('/register')->with('error', 'Email sudah terdaftar');
        }

        $userId = (string) Str::uuid();
        $password = $request->input('password');
        $namaLengkap = trim($request->input('nama_lengkap'));

        try {
            DB::table('users')->insert([
                'id' => $userId,
                'email' => $email,
                'password_hash' => Hash::make($password),
                'nama_lengkap' => $namaLengkap,
                'role' => 'user',
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            return redirect('/register')->with('error', 'Gagal mendaftar, coba lagi');
        }

        $emailSent = false;
        try {
            Mail::to($email)->send(new RegistrationSuccessMail($namaLengkap, $email, $password));
            $emailSent = true;
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim email pendaftaran', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);
        }

        try {
            session([
                'auth' => [
                    'id' => $userId,
                    'email' => $email,
                    'role' => 'user',
                    'nama_lengkap' => $namaLengkap,
                ],
            ]);
        } catch (\Throwable $e) {
            return redirect('/login')->with('error', 'Akun berhasil dibuat, silakan masuk');
        }

        $message = $emailSent
            ? 'Pendaftaran berhasil! Detail akun telah dikirim ke email Anda.'
            : 'Pendaftaran berhasil! Email konfirmasi gagal dikirim, namun Anda sudah masuk.';

        return redirect('/user/dashboard')->with('success', $message);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('auth');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
