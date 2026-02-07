<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class GuruController extends Controller
{
    public function generateQr()
{
    // Logika: Ambil waktu sekarang, bagi 30, lalu bulatkan. 
    // Jadi dalam rentang 30 detik, hasilnya akan tetap sama.
    $tandaWaktu = floor(time() / 30);
    $kodePayload = "PPLG1-" . $tandaWaktu;
    
    return view('guru.generate-qr', compact('kodePayload'));
}

// Tambahkan fungsi baru untuk dipanggil AJAX
public function getNewQr()
{
    $tandaWaktu = floor(time() / 30);
    $kodePayload = "PPLG1-" . $tandaWaktu;
    
    // Kirim gambar QR dalam bentuk string HTML
    return QrCode::size(250)
        ->gradient(37, 99, 235, 124, 58, 237, 'diagonal')
        ->margin(1)
        ->generate($kodePayload);
}
public function prosesIzin(Request $request, $id_siswa, $status)
{
    // 1. Cari data siswa dulu untuk dapetin rombongan_belajar_id-nya
    $siswa = \App\Models\User::find($id_siswa);

    if (!$siswa) {
        return redirect()->back()->with('error', 'Siswa tidak ditemukan!');
    }

    // 2. Proses update atau insert ke tabel absensi
    DB::table('absensi')->updateOrInsert(
        [
            'user_id' => $id_siswa,
            'tanggal' => now()->format('Y-m-d'),
        ],
        [
            // Tambahkan baris ini supaya database nggak marah lagi!
            'rombongan_belajar_id' => $siswa->rombongan_belajar_id ?? 1, 
            'status' => $status,
            'jam_absen' => now()->format('H:i:s'),
            'metode' => 'manual',
            'created_at' => now(),
            'updated_at' => now(),
        ]
    );

    return redirect()->route('guru.dashboard')->with('success', 'Status absensi berhasil diperbarui!');
}
public function dataSiswa()
{
    // Ambil data siswa yang terdaftar di database
    $dataSiswa = \App\Models\User::where('role', 'siswa')
                ->orderBy('name', 'asc')
                ->get();

    return view('guru.data-siswa', compact('dataSiswa'));
}
}