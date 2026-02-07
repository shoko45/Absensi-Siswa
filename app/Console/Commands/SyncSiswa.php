<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\PesertaDidik;
use App\Models\RombonganBelajar;
use App\Models\AnggotaRombel;
use Illuminate\Support\Facades\Hash;

// class SyncSiswa extends Command
// {
//     protected $signature = 'sync:siswa';
//     protected $description = 'Sinkronisasi data siswa dari API';

//     public function handle()
//     {
//         ini_set('memory_limit', '512M');
//         set_time_limit(0); 

//         $this->info('Sedang menarik data dari API...');

//         $response = Http::timeout(120)->retry(3, 100)->get('https://zieapi.zielabs.id/api/getsiswa?tahun=2025');

//         if ($response->successful()) {
//             $students = $response->json();

//             if (!is_array($students)) {
//                 $this->error('Data API bukan format list!');
//                 return;
//             }

//             $this->output->progressStart(count($students));

//             foreach ($students as $data) {
//                 if (!is_array($data)) {
//                     $this->output->progressAdvance();
//                     continue;
//                 }

//                 $nis = $data['nomor_induk'] ?? $data['nisn'] ?? $data['username'];
//                 if (!$nis) {
//                     $this->output->progressAdvance();
//                     continue;
//                 }

//                 $user = User::updateOrCreate(
//                     ['username' => $nis],
//                     [
//                         'name'     => $data['nama'] ?? 'Tanpa Nama',
//                         'password' => Hash::make('password123'),
//                         'role'     => 'siswa'
//                     ]
//                 );

//                 $peserta = PesertaDidik::updateOrCreate(
//                     ['nis' => $nis],
//                     [
//                         'user_id'       => $user->id,
//                         'jenis_kelamin' => ($data['jk'] ?? 'L') == 'Laki-laki' ? 'L' : 'P',
//                         'alamat'        => $data['alamat'] ?? '-',
//                     ]
//                 );

//                 if (isset($data['rombel'])) {
//                     $rombel = RombonganBelajar::where('nama_rombel', $data['rombel'])->first();
//                     if ($rombel) {
//                         AnggotaRombel::updateOrCreate(
//                             [
//                                 'peserta_didik_id'     => $peserta->id,
//                                 'rombongan_belajar_id' => $rombel->id
//                             ]
//                         );
//                     }
//                 }
//                 $this->output->progressAdvance();
//             }
//             $this->output->progressFinish();
//             $this->info('MANTAP! Semua data siswa sudah masuk.');

//         } else {
//             $this->error('Gagal koneksi ke server API.');
//         }
    // } // Penutup handle
// } // Penutup class