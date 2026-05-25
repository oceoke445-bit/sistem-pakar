<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

$email = $argv[1] ?? 'user@local.id';
$testPass = $argv[2] ?? 'TestPass123!';

$user = DB::table('users')->where('email', strtolower($email))->first();
if (! $user) {
    echo "User not found: {$email}\n";
    exit(1);
}

echo "Before: {$user->email} hash=".substr($user->password_hash, 0, 7)."\n";

DB::table('users')->where('id', $user->id)->update([
    'password_hash' => Hash::make($testPass),
]);

$fresh = DB::table('users')->where('id', $user->id)->first();
$okHash = Hash::check($testPass, $fresh->password_hash);
$okVerify = verify_password_hash($testPass, $fresh->password_hash);

echo "After update Hash::check: ".($okHash ? 'OK' : 'FAIL')."\n";
echo "After update verify_password_hash: ".($okVerify ? 'OK' : 'FAIL')."\n";