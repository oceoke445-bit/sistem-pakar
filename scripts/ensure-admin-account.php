<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$email = strtolower(env('ADMIN_EMAIL', 'admin@local.id'));
$password = env('ADMIN_PASSWORD', 'admin123');

$user = DB::table('users')->where('email', $email)->first();

if ($user) {
    DB::table('users')->where('id', $user->id)->update([
        'password_hash' => Hash::make($password),
        'role' => 'admin',
        'nama_lengkap' => $user->nama_lengkap ?: 'Administrator',
    ]);
    echo "UPDATED existing admin: {$email}\n";
} else {
    DB::table('users')->insert([
        'id' => (string) Str::uuid(),
        'email' => $email,
        'password_hash' => Hash::make($password),
        'nama_lengkap' => 'Administrator',
        'role' => 'admin',
        'created_at' => now(),
    ]);
    echo "CREATED new admin: {$email}\n";
}

$fresh = DB::table('users')->where('email', $email)->first();
$ok = verify_password_hash($password, $fresh->password_hash);

echo 'Role: '.$fresh->role."\n";
echo 'Password verify: '.($ok ? 'OK' : 'FAIL')."\n";
echo "Login with email={$email} password={$password}\n";

exit($ok ? 0 : 1);
