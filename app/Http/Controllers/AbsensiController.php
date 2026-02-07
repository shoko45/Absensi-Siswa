<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\RombonganBelajar;
use Carbon\Carbon; 

class AbsensiController extends Controller
{
    // 1. Fungsi Scan QR untuk Siswa
    public function scanQr(Request $request) 
    {
        $user = Auth::user();
        // Cari rombel tempat siswa bernaung
        $rombel = RombonganBelajar::where('id', $request->rombel_id)->first();

        // LOGIKA GPS: Hitung jarak antara posisi HP Siswa & Sekolah
        $jarak = $this->calculateDistance(
            $request->lat_siswa, $request->long_siswa,
            $rombel->latitude_sekolah, $rombel->longitude_sekolah
        );

        if ($jarak > $rombel->radius_meter) {
            return response()->json(['status' => 'error', 'message' => 'Anda di luar radius sekolah! Jarak: ' . round($jarak) . 'm'], 403);
        }

        // Cek apakah sudah absen hari ini
        $sudahAbsen = Absensi::where('user_id', $user->id)->where('tanggal', now()->toDateString())->exists();
        if ($sudahAbsen) {
            return response()->json(['status' => 'error', 'message' => 'Anda sudah absen hari ini!'], 422);
        }

        Absensi::create([
            'user_id' => $user->id,
            'rombongan_belajar_id' => $rombel->id,
            'tanggal' => now()->toDateString(),
            'jam_absen' => now()->toTimeString(),
            'lat_siswa' => $request->lat_siswa,
            'long_siswa' => $request->long_siswa,
            'status' => 'H',
            'metode' => 'qr'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Absensi Berhasil!']);
    }

    // 2. Fungsi Absen Manual untuk Wali Kelas
    public function absenManual(Request $request)
    {
        // Validasi hanya Walas yang bisa
        if (Auth::user()->role !== 'wali_kelas') return abort(403);

        Absensi::updateOrCreate(
            ['user_id' => $request->siswa_id, 'tanggal' => now()->toDateString()],
            [
                'rombongan_belajar_id' => $request->rombel_id,
                'status' => $request->status, // S, I, atau A
                'keterangan' => $request->keterangan,
                'metode' => 'manual',
                'jam_absen' => now()->toTimeString()
            ]
        );

        return back()->with('success', 'Status siswa berhasil diperbarui.');
    }

    // Rumus Haversine untuk hitung jarak GPS (Hasil dalam Meter)
    private function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthRadius * $c;
    }
}
