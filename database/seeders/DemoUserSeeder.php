<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'user@local.id';

        if (DB::table('users')->where('email', $email)->exists()) {
            DB::table('users')->where('email', $email)->update([
                'password_hash' => Hash::make('user123'),
                'nama_lengkap' => 'User Demo',
                'role' => 'user',
            ]);

            return;
        }

        DB::table('users')->insert([
            'id' => (string) Str::uuid(),
            'email' => $email,
            'password_hash' => Hash::make('user123'),
            'nama_lengkap' => 'User Demo',
            'role' => 'user',
            'created_at' => now(),
        ]);
    }
}
