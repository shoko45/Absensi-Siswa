<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\PesertaDidik;

class SyncSiswa extends Command
{
    protected $signature = 'sync:siswa';
    protected $description = 'Ambil data siswa dari API';

    public function handle()
    {
        $this->info('Sabar ya, lagi narik data dari API...');

        $response = Http::get('https://zieapi.zielabs.id/api/getsiswa?tahun=2025');

        if ($response->successful()) {
            $students = $response->json();

            foreach ($students as $data) {
                PesertaDidik::updateOrCreate(
                    ['nis' => $data['nisn'] ?? $data['nis'] ?? '000'], 
                    [
                        'user_id' => null, 
                        'jenis_kelamin' => ($data['jk'] ?? 'L') == 'Laki-laki' ? 'L' : 'P',
                        'alamat' => $data['alamat'] ?? '-',
                    ]
                );
            }
            $this->info('MANTAP! Data sudah masuk semua.');
        } else {
            $this->error('Gagal konek ke API.');
        }
    }
}