<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TahunAjar;
use App\Models\RombonganBelajar;
use App\Models\PesertaDidik;
use App\Models\AnggotaRombel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Tahun Ajaran Aktif
        $tahunAjar = TahunAjar::create([
            'tahun_akademik' => '2025/2026',
            'semester' => 'Ganjil',
            'is_aktif' => true,
        ]);

        // 2. Buat User Wali Kelas (Username pake NIP)
        $walas = User::create([
            'username' => '19800101202401',
            'name' => 'Bapak Guru, S.Kom',
            'password' => Hash::make('password123'),
            'role' => 'wali_kelas',
        ]);

        // 3. Buat User Sekertaris (Username pake NISN)
        $sekertaris = User::create([
            'username' => '2223001',
            'name' => 'Siti Sekertaris',
            'password' => Hash::make('password123'),
            'role' => 'sekertaris',
        ]);

        // 4. Buat Rombongan Belajar (Rombel)
        // Set koordinat sekolah kamu di sini (Contoh: Area sekitar sekolah)
        $rombel = RombonganBelajar::create([
            'nama_rombel' => 'XII PPLG 1',
            'teacher_id' => $walas->id,
            'sekertaris_id' => $sekertaris->id,
            'tahun_ajar_id' => $tahunAjar->id,
            'latitude_sekolah' => -6.816667, // Ganti dengan Lat sekolahmu
            'longitude_sekolah' => 107.133333, // Ganti dengan Long sekolahmu
            'radius_meter' => 50,
        ]);

        // 5. Buat Data Siswa Contoh (Looping biar banyak)
        $daftarSiswa = [
            ['username' => '2223002', 'name' => 'Azmi User'],
            ['username' => '2223003', 'name' => 'Budi Siswa'],
            ['username' => '2223004', 'name' => 'Ani Siswi'],
        ];

        // Masukkan Sekertaris juga ke daftar Peserta Didik
        $daftarSiswa[] = ['username' => '2223001', 'name' => 'Siti Sekertaris'];

        foreach ($daftarSiswa as $s) {
            $userSiswa = User::updateOrCreate(
                ['username' => $s['username']],
                [
                    'name' => $s['name'],
                    'password' => Hash::make('password123'),
                    'role' => $s['username'] == '2223001' ? 'sekertaris' : 'siswa',
                ]
            );

            $pd = PesertaDidik::create([
                'user_id' => $userSiswa->id,
                'nis' => $s['username'],
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Kenangan No. 1',
            ]);

            // Masukkan ke Anggota Rombel
            AnggotaRombel::create([
                'peserta_didik_id' => $pd->id,
                'rombongan_belajar_id' => $rombel->id,
            ]);
        }
    }
}
