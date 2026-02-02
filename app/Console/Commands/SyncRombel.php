<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\RombonganBelajar;


class SyncRombel extends Command
{
    protected $signature = 'sync:rombel';
    protected $description = 'Ambil data kelas/rombel dari API';

    public function handle()
    {
        $this->info('Sabar ya, lagi narik data kelas...');
        
        // Sesuaikan URL API kelas jika ada, atau pakai URL yang sama jika datanya gabung
        $response = Http::get('https://zieapi.zielabs.id/api/getsiswa?tahun=2025');

        if ($response->successful()) {
            $dataApi = $response->json();
            
            // Kita ambil nama-nama rombel yang unik saja
            $rombels = collect($dataApi)->pluck('rombel')->unique();

            foreach ($rombels as $namaRombel) {
                if($namaRombel) {
                    RombonganBelajar::updateOrCreate(
                        ['nama_rombel' => $namaRombel],
                        [
                            'tahun_ajar_id' => 1, // Anggap saja ID Tahun Ajar 2025 itu 1
                            'teacher_id' => null,  // Wali kelas set null dulu
                            'tingkat' => 10,       // Default tingkat 10
                        ]
                    );
                }
            }
            $this->info('MANTAP! Semua kelas sudah masuk.');
        } else {
            $this->error('Gagal konek ke API.');
        }
    }
}