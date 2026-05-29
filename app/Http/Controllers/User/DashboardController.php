<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $auth = $request->session()->get('auth');
        $dbError = false;
        $firstName = trim(explode(' ', trim($auth['nama_lengkap'] ?? 'Pengguna'))[0] ?: 'Pengguna');

        try {
            DB::table('diagnosa')->where('id_user', $auth['id'])->limit(1)->exists();
        } catch (\Throwable $e) {
            $dbError = true;
        }

        return view('user.dashboard', compact('firstName', 'dbError'));
    }
}
