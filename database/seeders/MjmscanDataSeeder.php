<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MjmscanDataSeeder extends Seeder
{
    public function run(): void
    {
        $n = (int) DB::table('gejala')->count();
        if ($n === 0) {
            $gejala = [
                ['GK001', 'Mobil Kehilangan Tenaga'],
                ['GK002', 'Mobil Sulit Dinyalakan / Distarter'],
                ['GK003', 'Mesin Mati Sesaat'],
                ['GK004', 'Terjadi Gejala Surging Dada Mesin'],
                ['GK005', 'Akselerasi Mobil Tidak Optimal'],
                ['GK006', 'Suara Mesin Kasar Dan Terasa Getaran'],
                ['GK007', 'Mesin Mobil Mati Mendadak'],
                ['GK008', 'Konsumsi Bahan Bakar Boros'],
                ['GK009', 'Asap Hitam Keluar Dari Knalpot'],
                ['GK010', 'Terdengar Letupan (Nembak-Nembak) Dari Knalpot'],
                ['GK011', 'Mesin Mbrebet Saat Akselerasi'],
                ['GK012', 'Asap Putih Keluar Dari Knalpot'],
                ['GK013', 'Oli Mesin Cepat Berkurang'],
            ];
            foreach ($gejala as [$k, $nama]) {
                DB::table('gejala')->insertOrIgnore(['kode_gejala' => $k, 'nama_gejala' => $nama]);
            }

            $penyakit = [
                ['JK01', 'Busi Bermasalah', 'ringan', 'Busi bermasalah dapat menyebabkan kinerja mesin menjadi tidak optimal, seperti sulitnya mesin menyala, mesin tersendat-sendat, atau konsumsi bahan bakar yang boros.', 'Mengecek jalur pengapian dan lihatlah apakah ada kabel yang terbakar atau terlihat krosleting, pastikan posisi busi pas, setting ulang setelan bahan bakar.', 'Pemeriksaan rutin, Penggantian busi secara berkala, Menggunakan bahan bakar berkualitas, Menghindari penggunaan mesin yang berlebihan'],
                ['JK02', 'Masalah Pada Sistem Transmisi (CVT)', 'sedang', 'Masalah pada sistem transmisi CVT dapat menyebabkan kinerja mobil menjadi tidak optimal.', 'Ganti komponen CVT yang rusak dengan suku cadang berkualitas baik.', 'Perawatan rutin, Pemeriksaan sistem transmisi, Menggunakan oli transmisi yang sesuai'],
                ['JK03', 'Filter Udara Tersumbat', 'ringan', 'Filter udara tersumbat dapat menyebabkan kinerja mesin menjadi tidak optimal.', 'Bersihkan filter udara dan karburator agar aliran udara kembali lancar.', 'Perawatan rutin, Pemeriksaan filter udara, Menggunakan filter udara berkualitas'],
                ['JK04', 'Pengaturan Knalpot Tidak Tepat', 'ringan', 'Pengaturan knalpot yang tidak tepat dapat menyebabkan kinerja mesin menjadi tidak optimal.', 'Ganti knalpot jika diperlukan dan lakukan penyetelan ulang sistem bahan bakar atau ECU.', 'Pemasangan knalpot yang benar, Perawatan rutin'],
                ['JK05', 'Pengaturan Jarum Skep Tidak Sesuai', 'ringan', 'Pengaturan jarum skep yang tidak sesuai dapat menyebabkan kinerja karburator menjadi tidak optimal.', 'Pastikan jarum skep terpasang dengan lurus dan presisi. Lakukan penyetelan ulang karburator.', 'Pengaturan jarum skep yang benar, Perawatan rutin'],
                ['JK06', 'Piston Haus atau Tergores', 'berat', 'Piston haus atau tergores dapat menyebabkan kinerja mesin menjadi tidak optimal.', 'Lakukan penggantian piston dan perawatan berkala.', 'Perawatan rutin, Menggunakan oli berkualitas'],
                ['JK07', 'Aki Soak atau Lemah', 'sedang', 'Aki soak atau lemah dapat menyebabkan kinerja mobil menjadi tidak optimal.', 'Lakukan pengisian ulang daya (cas aki), periksa voltase. Jika perlu, ganti aki dengan yang baru.', 'Perawatan rutin, Menggunakan aki yang sesuai'],
            ];
            foreach ($penyakit as $row) {
                DB::table('penyakit')->insertOrIgnore([
                    'kode_penyakit' => $row[0],
                    'nama_penyakit' => $row[1],
                    'tingkat' => $row[2],
                    'deskripsi' => $row[3],
                    'solusi' => $row[4],
                    'pencegahan' => $row[5],
                ]);
            }

            $relasi = [
                ['JK01', 'GK001'], ['JK01', 'GK002'], ['JK01', 'GK003'], ['JK01', 'GK004'], ['JK01', 'GK005'], ['JK01', 'GK006'],
                ['JK02', 'GK001'], ['JK02', 'GK005'], ['JK02', 'GK006'], ['JK02', 'GK007'],
                ['JK03', 'GK001'], ['JK03', 'GK002'], ['JK03', 'GK006'], ['JK03', 'GK008'], ['JK03', 'GK009'],
                ['JK04', 'GK001'], ['JK04', 'GK010'],
                ['JK05', 'GK001'], ['JK05', 'GK011'],
                ['JK06', 'GK001'], ['JK06', 'GK002'], ['JK06', 'GK006'], ['JK06', 'GK012'], ['JK06', 'GK013'],
                ['JK07', 'GK001'], ['JK07', 'GK002'],
            ];
            foreach ($relasi as [$pk, $gk]) {
                DB::table('relasi')->insertOrIgnore(['kode_penyakit' => $pk, 'kode_gejala' => $gk]);
            }
        }

        $adminEmail = env('ADMIN_EMAIL', 'admin@local.id');
        if (! DB::table('users')->where('email', $adminEmail)->exists()) {
            DB::table('users')->insert([
                'id' => (string) Str::uuid(),
                'email' => $adminEmail,
                'password_hash' => Hash::make(env('ADMIN_PASSWORD', 'admin123')),
                'nama_lengkap' => 'Administrator',
                'role' => 'admin',
                'created_at' => now(),
            ]);
        }
    }
}
