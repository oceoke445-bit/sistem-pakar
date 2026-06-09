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
        // 1. Clean existing records
        DB::table('diagnosa_detail')->delete();
        DB::table('diagnosa')->delete();
        DB::table('relasi')->delete();
        DB::table('gejala')->delete();
        DB::table('penyakit')->delete();

        // 2. Seed Gejala Printer (G01–G12, sesuai UI pilih gejala)
        $gejala = [
            ['G01', 'Printer tidak menyala'],
            ['G02', 'Lampu indikator mati'],
            ['G03', 'Printer tidak merespon perintah'],
            ['G04', 'Hasil cetak kosong'],
            ['G05', 'Hasil cetak bergaris'],
            ['G06', 'Tinta tidak keluar'],
            ['G07', 'Kertas tidak tertarik'],
            ['G08', 'Kertas Macet (Paper Jam)'],
            ['G09', 'Hasil cetak buram'],
            ['G10', 'Printer mengeluarkan suara kasar'],
            ['G11', 'Cartridge tidak terdeteksi'],
            ['G12', 'Muncul pesan error di komputer'],
        ];
        foreach ($gejala as [$k, $nama]) {
            DB::table('gejala')->insert(['kode_gejala' => $k, 'nama_gejala' => $nama]);
        }

        // 3. Seed Penyakit/Kerusakan Printer (matches the results card in the user's screenshot exactly!)
        $penyakit = [
            [
                'K001', 
                'Printer tidak menyala (Mati Total)', 
                'Berat', 
                'Printer mati total dan tidak merespon saat dihidupkan, biasanya disebabkan karena kabel power rusak, saklar bermasalah, atau kerusakan pada board power supply internal.', 
                "Periksa sambungan kabel power ke saklar listrik.\nCoba ganti kabel power dengan yang baru.\nPeriksa dan ganti adaptor / power supply internal printer.\nBawa ke pusat servis jika mainboard mengalami kerusakan berat.", 
                'Gunakan stabilizer listrik atau UPS berkualitas untuk menghindari lonjakan voltase mendadak.'
            ],
            [
                'K002', 
                'Lampu indikator berkedip (Blinking)', 
                'Ringan', 
                'Lampu indikator berkedip terus menerus, menandakan printer mengalami status error seperti sensor kotor, paper jam, atau waste ink absorber penuh.', 
                "Matikan printer selama beberapa menit lalu nyalakan kembali.\nPeriksa bagian dalam printer apakah ada kertas kecil atau benda asing yang menyangkut.\nLakukan reset counter printer dengan software adjustment tool.\nBersihkan encoder strip transparan di belakang cartridge.", 
                'Bersihkan debu bagian dalam printer secara berkala dan hindari memaksakan penarikan cartridge.'
            ],
            [
                'K003', 
                'Hasil cetak bergaris / belang', 
                'Berat', 
                'Kerusakan terjadi karena komponen pada bagian drum unit atau kotoran pada kaca scanner yang menyebabkan garis pada hasil cetakan.', 
                "Bersihkan kaca scanner dan automatic document feeder (ADF).\nPeriksa kondisi drum unit. Jika kotor bersihkan menggunakan kain lembut.\nJika drum unit sudah aus atau rusak, lakukan penggantian.\nGunakan kertas yang sesuai dan tidak lembab.", 
                'Gunakan tinta original yang direkomendasikan dan lakukan cleaning nozzle berkala.'
            ],
            [
                'K004', 
                'Kertas macet (Paper Jam)', 
                'Ringan', 
                'Kertas tersangkut di dalam printer, disebabkan karena karet roller penarik kertas (ASF Roller) yang sudah licin/kotor atau ada serpihan kertas di dalamnya.', 
                "Tarik kertas yang tersangkut secara perlahan searah dengan jalurnya.\nBersihkan karet roller penarik kertas menggunakan kain bersih yang sedikit lembab.\nHindari menaruh kertas terlalu tebal atau lecek di tray.\nGanti karet roller ASF jika sudah aus/licin.", 
                'Gunakan kertas dengan ketebalan standar dan hindari memasukkan kertas yang terlalu berdebu.'
            ],
            [
                'K005', 
                'Tinta tidak keluar / Cartridge tidak terbaca', 
                'Ringan', 
                'Cartridge printer tidak terdeteksi atau tinta tidak keluar sama sekali, biasanya karena pin chip kuningan kotor, tinta habis, atau cartridge kering.', 
                "Lepaskan cartridge lalu bersihkan chip kuningan menggunakan penghapus pensil lembut.\nLakukan proses Head Cleaning lewat komputer.\nIsi kembali tinta jika tingkat tinta di tabung/cartridge habis.\nGanti cartridge baru jika chip terbukti mati/rusak.", 
                'Lakukan pencetakan minimal 1-2 kali seminggu agar tinta tidak mengering di nozzle cartridge.'
            ],
        ];
        foreach ($penyakit as $row) {
            DB::table('penyakit')->insert([
                'kode_penyakit' => $row[0],
                'nama_penyakit' => $row[1],
                'tingkat' => $row[2],
                'deskripsi' => $row[3],
                'solusi' => $row[4],
                'pencegahan' => $row[5],
            ]);
        }

        // 4. Seed Relasi Printer (Rules)
        $relasi = [
            ['K001', 'G01'], ['K001', 'G02'],
            ['K002', 'G02'], ['K002', 'G10'],
            ['K003', 'G05'], ['K003', 'G09'],
            ['K004', 'G08'], ['K004', 'G07'],
            ['K005', 'G06'], ['K005', 'G11'],
        ];
        foreach ($relasi as [$pk, $gk]) {
            DB::table('relasi')->insert(['kode_penyakit' => $pk, 'kode_gejala' => $gk]);
        }

        // 5. Create Admin Account
        $adminEmail = env('ADMIN_EMAIL', 'admin@local.id');
        if (! DB::table('users')->where('email', $adminEmail)->exists()) {
            DB::table('users')->insert([
                'id' => (string) Str::uuid(),
                'email' => $adminEmail,
                'password_hash' => Hash::make(env('ADMIN_PASSWORD', 'admin123')),
                'nama_lengkap' => 'Gemma Galgani Ajum',
                'role' => 'admin',
                'created_at' => now(),
            ]);
        }
    }
}
