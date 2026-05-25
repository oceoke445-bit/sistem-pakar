# 🚀 Panduan Deploy Laravel SPK (MJMScan) ke Fly.io

Dokumen ini berisi panduan lengkap untuk melakukan deploy aplikasi SPK MJMScan (Laravel) Anda ke platform **Fly.io**, lengkap dengan panduan pengisian **Environment Variables** dan konfigurasi database PostgreSQL.

---

## 📋 Daftar Environment Variables yang Wajib Diisi

Berdasarkan pengaturan sistem dan screenshot dashboard Fly.io Anda, berikut adalah variabel lingkungan (environment variables) yang perlu Anda tambahkan di Fly.io:

### 1. Variabel Inti Laravel (Core)

| Key | Value (Rekomendasi) | Deskripsi |
| :--- | :--- | :--- |
| **`APP_KEY`** | `base64:j3u3RnwYJBmDZwzQF63qx0ao3kJetBGf4brif5vueaI=` | Kunci enkripsi aplikasi. Anda bisa menyalin dari file `.env` lokal Anda. |
| **`APP_ENV`** | `production` | Menandakan bahwa aplikasi berjalan di server produksi. |
| **`APP_DEBUG`** | `false` | **Wajib `false`** untuk keamanan produksi agar pesan error mentah database tidak bocor ke publik. |
| **`APP_URL`** | `https://nama-aplikasi-anda.fly.dev` | Ganti dengan URL aplikasi Fly.io yang Anda daftarkan. |
| **`APP_LOCALE`** | `id` | Mengeset bahasa utama aplikasi menjadi Bahasa Indonesia. |
| **`APP_TIMEZONE`** | `Asia/Jakarta` | Mengatur zona waktu default server ke WIB. |

---

### 2. Variabel Database (PostgreSQL)

Anda memiliki **dua pilihan** untuk database PostgreSQL Anda:

#### OPSI A: Menggunakan Database Neon PostgreSQL yang Sudah Ada (Sangat Direkomendasikan & Praktis)
Jika Anda ingin tetap menggunakan database Neon PostgreSQL yang sedang digunakan saat ini, **JANGAN centang** kotak "Managed Postgres" di Fly.io. Cukup masukkan variabel berikut di kolom Environment Variables Fly.io:

| Key | Value |
| :--- | :--- |
| **`DB_CONNECTION`** | `pgsql` |
| **`DATABASE_URL`** | `postgresql://neondb_owner:npg_CD4hgoOMB6NI@ep-crimson-tree-ap0uklxp-pooler.c-7.us-east-1.aws.neon.tech/neondb?sslmode=require&channel_binding=require` |

#### OPSI B: Menggunakan Database Bawaan Fly.io (Managed Postgres)
Jika Anda ingin menggunakan database baru yang dikelola langsung di Fly.io:
1. **Centang** kotak **`[✓] Managed Postgres`** pada halaman dashboard Fly.io (seperti di screenshot Anda).
2. Fly.io akan **secara otomatis membuat database** dan menyuntikkan (inject) variabel `DATABASE_URL` ke aplikasi Anda secara otomatis tanpa perlu Anda ketik manual.
3. Anda hanya perlu menambahkan variabel berikut di kolom Environment Variables:

| Key | Value |
| :--- | :--- |
| **`DB_CONNECTION`** | `pgsql` |

---

### 3. Variabel Akun Administrator Awal

Aplikasi Anda menggunakan seeder untuk membuat akun administrator saat database pertama kali diisi. Pastikan Anda menambahkan variabel ini agar Anda bisa masuk (login) sebagai admin pertama kali di Fly.io:

| Key | Value (Contoh) | Deskripsi |
| :--- | :--- | :--- |
| **`ADMIN_EMAIL`** | `admin@local.id` | Alamat email yang digunakan untuk login sebagai admin di Fly.io. |
| **`ADMIN_PASSWORD`** | `admin123` | Password yang digunakan untuk login admin. |

---

## 🛠️ Langkah-Langkah Deploy ke Fly.io

### Langkah 1: Install Flyctl (Command Line Tool Fly.io)
Jika Anda belum menginstalnya di komputer lokal, buka PowerShell (sebagai Administrator) dan jalankan:
```powershell
iwr https://fly.io/install.ps1 -useb | iex
```
*Setelah selesai install, tutup dan buka kembali terminal Anda.*

### Langkah 2: Login ke Akun Fly.io Anda
Jalankan perintah berikut di folder proyek Anda `c:\Users\VICTUS\Downloads\spkfc\mjmscan-laravel`:
```bash
fly auth login
```

### Langkah 3: Inisialisasi Proyek Fly.io
Jalankan perintah berikut untuk membuat file konfigurasi otomatis:
```bash
fly launch
```
*   Fly.io akan mendeteksi bahwa aplikasi Anda adalah **Laravel**.
*   Ikuti petunjuk di layar (pilih region server terdekat seperti Singapore `sin` atau Jakarta `cgk`).
*   Jika ditanya `"Would you like to set up a PostgreSQL database?"`, pilih **Yes** jika Anda memilih **OPSI B**, atau **No** jika memilih **OPSI A** (menggunakan Neon DB).

### Langkah 4: Tambahkan Environment Variables
Isi kolom **Environment Variables** di dashboard Fly.io Anda seperti pada screenshot sesuai dengan tabel di atas, lalu klik tombol **Deploy**.

---

## 🗄️ Menjalankan Migrasi Database & Seeding di Server Fly.io

Setelah aplikasi berhasil ter-deploy, database Anda masih kosong. Anda harus menjalankan migrasi tabel dan seeder agar data gejala, printer, kerusakan, rule, dan akun admin terbuat.

Jalankan perintah berikut langsung dari terminal komputer lokal Anda:

1. **Jalankan Migrasi Tabel**:
   ```bash
   fly ssh console -c "php artisan migrate --force"
   ```

2. **Jalankan Seeder (Mengisi Data Gejala, Printer, Rule, dan Admin)**:
   ```bash
   fly ssh console -c "php artisan db:seed --force"
   ```

Setelah kedua perintah di atas sukses dijalankan, aplikasi SPK MJMScan Anda telah aktif sepenuhnya di Fly.io dan siap digunakan! 🎉
