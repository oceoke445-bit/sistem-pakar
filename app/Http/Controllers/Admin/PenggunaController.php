<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $users = DB::table('users')->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.pengguna.index', [
            'users' => $users,
            'success' => $request->query('success'),
            'notice' => $request->query('notice'),
            'error' => $request->query('error'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:1',
            'nama_lengkap' => 'required|string|max:255',
            'role' => 'required|in:admin,user',
        ]);

        $email = strtolower(trim($request->input('email')));
        if (DB::table('users')->where('email', $email)->exists()) {
            return redirect('/admin/pengguna?error='.urlencode('Email sudah digunakan'));
        }

        try {
            DB::table('users')->insert([
                'id' => (string) Str::uuid(),
                'email' => $email,
                'password_hash' => Hash::make($request->input('password')),
                'nama_lengkap' => trim($request->input('nama_lengkap')),
                'role' => $request->input('role'),
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            return redirect('/admin/pengguna?error='.urlencode($e->getMessage()));
        }

        return redirect('/admin/pengguna?success=1');
    }

    public function update(Request $request)
    {
        $auth = $request->session()->get('auth');
        $request->validate([
            'id' => 'required|string',
            'email' => 'required|email',
            'nama_lengkap' => 'required|string|max:255',
            'role' => 'required|in:admin,user',
            'password' => 'nullable|string',
        ]);

        $id = $request->input('id');
        if ($id === $auth['id'] && $request->input('role') !== 'admin') {
            return redirect('/admin/pengguna?error='.urlencode('Tidak bisa menghapus role admin pada diri sendiri'));
        }

        if ($request->filled('password')) {
            DB::table('users')->where('id', $id)->update([
                'nama_lengkap' => trim($request->input('nama_lengkap')),
                'email' => strtolower(trim($request->input('email'))),
                'role' => $request->input('role'),
                'password_hash' => Hash::make($request->input('password')),
            ]);
        } else {
            DB::table('users')->where('id', $id)->update([
                'nama_lengkap' => trim($request->input('nama_lengkap')),
                'email' => strtolower(trim($request->input('email'))),
                'role' => $request->input('role'),
            ]);
        }

        return redirect('/admin/pengguna?success=1');
    }

    public function destroy(Request $request)
    {
        $auth = $request->session()->get('auth');
        $id = (string) $request->input('id');

        if ($id === $auth['id']) {
            return redirect('/admin/pengguna?error='.urlencode('Tidak bisa menghapus akun sendiri'));
        }

        $row = DB::table('users')->where('id', $id)->select('nama_lengkap', 'email')->first();
        $label = $row ? "{$row->nama_lengkap} ({$row->email})" : $id;

        DB::table('users')->where('id', $id)->delete();

        return redirect('/admin/pengguna?notice='.urlencode("Pengguna {$label} berhasil dihapus dari sistem."));
    }
}
