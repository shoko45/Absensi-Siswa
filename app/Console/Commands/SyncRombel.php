<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\RombonganBelajar;


class SyncRombel extends Command
{
    protected $signature = 'sync:rombel';
    protected $description = 'Ambil data kelas/rombel dari API';

    // File: app/Console/Commands/SyncRombel.php

public function handle()
{
    $this->info('Sedang menarik data kelas dari API...');

    // Ambil Tahun Ajar yang is_aktif = true
    $tahunAktif = \App\Models\TahunAjar::where('is_aktif', true)->first();

    if (!$tahunAktif) {
        $this->error('Waduh! Belum ada Tahun Ajaran yang aktif. Jalankan Seeder dulu!');
        return;
    }

    $response = \Illuminate\Support\Facades\Http::get('https://zieapi.zielabs.id/api/getsiswa?tahun=2025');

    if ($response->successful()) {
        $dataApi = $response->json();
        $rombels = collect($dataApi)->pluck('rombel')->unique();

        foreach ($rombels as $namaRombel) {
            if ($namaRombel) {
                \App\Models\RombonganBelajar::updateOrCreate(
                    ['nama_rombel' => $namaRombel],
                    [
                        'tahun_ajar_id' => $tahunAktif->id, // Otomatis pake yang aktif
                        'teacher_id'    => null, // Nanti diplot manual oleh Admin
                        'sekertaris_id' => null,
                        'latitude_sekolah' => -6.816667, // Default koordinat
                        'longitude_sekolah' => 107.133333,
                        'radius_meter' => 50
                    ]
                );
            }
        }
        $this->info('MANTAP! Semua kelas sudah masuk ke Tahun Ajar ' . $tahunAktif->tahun_akademik);
    }
}
}