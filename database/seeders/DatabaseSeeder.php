<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Kategori Keperluan
        $kategori = [
            'Konsultasi Program Belajar',
            'Pendaftaran Siswa Baru',
            'Pembayaran Administrasi',
            'Konsultasi Akademik',
            'Pengambilan Dokumen',
            'Pertemuan dengan Pengajar',
            'Pertemuan dengan Manajemen',
            'Kerja Sama / Kemitraan',
            'Lamaran Kerja / Magang',
            'Keperluan Lainnya'
        ];

        foreach ($kategori as $kat) {
            DB::table('kategori_keperluans')->insert([
                'nama_kategori' => $kat,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Seed Admin Default
        DB::table('admins')->insert([
            'name' => 'Admin Meteor',
            'username' => 'admin',
            'email' => 'admin@meteor.com',
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Seed Mock Guests (for testing/verification)
        $tamuMock = [
            // Today (0 days ago)
            ['nama' => 'Chusnul Bariya', 'nomor_hp' => '08123456789', 'alamat' => 'Jl. Raya Meteor No. 12, Malang', 'kategori_id' => 1, 'days_ago' => 0],
            ['nama' => 'Ahmad Fauzi', 'nomor_hp' => '08234567890', 'alamat' => 'Jl. Bintang Timur No. 4, Surabaya', 'kategori_id' => 2, 'days_ago' => 0],
            ['nama' => 'Siti Aminah', 'nomor_hp' => '08345678901', 'alamat' => 'Perum Graha Indah Blok C-5, Sidoarjo', 'kategori_id' => 3, 'days_ago' => 0],
            ['nama' => 'Budi Santoso', 'nomor_hp' => '08456789012', 'alamat' => 'Jl. Kebon Jeruk No. 88, Jakarta', 'kategori_id' => 4, 'days_ago' => 0],
            ['nama' => 'Dewi Lestari', 'nomor_hp' => '08567890123', 'alamat' => 'Jl. Cempaka Wangi No. 15, Bandung', 'kategori_id' => 1, 'days_ago' => 0],
            
            // Yesterday (1 day ago)
            ['nama' => 'Eko Prasetyo', 'nomor_hp' => '08789012345', 'alamat' => 'Jl. Diponegoro No. 45, Semarang', 'kategori_id' => 5, 'days_ago' => 1],
            ['nama' => 'Fitriani', 'nomor_hp' => '08901234567', 'alamat' => 'Jl. Sudirman No. 102, Yogyakarta', 'kategori_id' => 6, 'days_ago' => 1],
            ['nama' => 'Guntur Prabowo', 'nomor_hp' => '08129087456', 'alamat' => 'Jl. Gajah Mada No. 12, Malang', 'kategori_id' => 2, 'days_ago' => 1],
            ['nama' => 'Hendra Wijaya', 'nomor_hp' => '08564738291', 'alamat' => 'Jl. Pahlawan No. 9, Surabaya', 'kategori_id' => 7, 'days_ago' => 1],
            
            // 2 Days ago (2 days ago)
            ['nama' => 'Indah Permatasari', 'nomor_hp' => '08134567890', 'alamat' => 'Jl. Melati No. 34, Pasuruan', 'kategori_id' => 3, 'days_ago' => 2],
            ['nama' => 'Joko Widodo', 'nomor_hp' => '08245678901', 'alamat' => 'Jl. Merdeka No. 1, Solo', 'kategori_id' => 8, 'days_ago' => 2],
            ['nama' => 'Kartika Sari', 'nomor_hp' => '08356789012', 'alamat' => 'Jl. Kenanga No. 7, Surabaya', 'kategori_id' => 9, 'days_ago' => 2],

            // 3 Days ago (3 days ago)
            ['nama' => 'Lukman Hakim', 'nomor_hp' => '08467890123', 'alamat' => 'Jl. Flamboyan No. 22, Malang', 'kategori_id' => 10, 'days_ago' => 3],
            ['nama' => 'Mega Utami', 'nomor_hp' => '08578901234', 'alamat' => 'Jl. Dahlia No. 11, Gresik', 'kategori_id' => 1, 'days_ago' => 3],
            ['nama' => 'Novianto', 'nomor_hp' => '08689012345', 'alamat' => 'Jl. Wijaya Kusuma No. 56, Batu', 'kategori_id' => 2, 'days_ago' => 3],
            ['nama' => 'Oki Setiana', 'nomor_hp' => '08790123456', 'alamat' => 'Jl. Anggrek No. 8, Kediri', 'kategori_id' => 3, 'days_ago' => 3],

            // 4 Days ago (4 days ago)
            ['nama' => 'Pratiwi', 'nomor_hp' => '08801234567', 'alamat' => 'Jl. Tulip No. 19, Blitar', 'kategori_id' => 4, 'days_ago' => 4],
            ['nama' => 'Rian Hidayat', 'nomor_hp' => '08912345678', 'alamat' => 'Jl. Teratai No. 30, Malang', 'kategori_id' => 5, 'days_ago' => 4],

            // 6 Days ago (6 days ago)
            ['nama' => 'Syarifuddin', 'nomor_hp' => '08123450987', 'alamat' => 'Jl. Veteran No. 8, Malang', 'kategori_id' => 6, 'days_ago' => 6],
            ['nama' => 'Taufik Hidayat', 'nomor_hp' => '08234561098', 'alamat' => 'Jl. Panjaitan No. 17, Pasuruan', 'kategori_id' => 7, 'days_ago' => 6],
        ];

        foreach ($tamuMock as $t) {
            DB::table('tamus')->insert([
                'nama' => $t['nama'],
                'nomor_hp' => $t['nomor_hp'],
                'alamat' => $t['alamat'],
                'kategori_id' => $t['kategori_id'],
                'created_at' => now()->subDays($t['days_ago']),
                'updated_at' => now()->subDays($t['days_ago']),
            ]);
        }
    }
}
