@php
    use Illuminate\Support\Facades\DB;
    use App\Models\User;

    $hariIni = now()->format('Y-m-d');
    
    // 1. Ambil Total Siswa (Misal Wali Kelas ini memegang kelas tertentu)
    // Untuk UKK sederhana, kita ambil semua user ber-role siswa dulu
    $totalSiswa = User::where('role', 'siswa')->count(); 

    // 2. Hitung Hadir (Status 'H')
    $hadir = DB::table('absensi')
                ->where('tanggal', $hariIni)
                ->where('status', 'H')
                ->count();

    // 3. Hitung Izin & Sakit (Status 'I' & 'S')
    $izinSakit = DB::table('absensi')
                    ->where('tanggal', $hariIni)
                    ->whereIn('status', ['I', 'S'])
                    ->count();

    // 4. Logika Perhitungan
    $belumAbsen = $totalSiswa - ($hadir + $izinSakit);
    $persentase = ($totalSiswa > 0) ? round(($hadir / $totalSiswa) * 100) : 0;

    // 5. Warna Persentase
    $warnaPersen = 'bg-orange-500'; 
    if($persentase >= 90) $warnaPersen = 'bg-emerald-600'; 
    elseif($persentase < 50) $warnaPersen = 'bg-red-600';
@endphp

<x-app-layout>
    <div class="py-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-3xl shadow-sm mb-6 flex flex-col md:flex-row justify-between items-start md:items-center border border-gray-100">
                <div>
                    <h2 class="text-2xl font-black text-gray-800 tracking-tight">Halo, Wali Kelas! 👋</h2>
                    <p class="text-gray-500 font-medium">Siap mengelola absen hari ini.</p>
                </div>
                <div class="mt-4 md:mt-0 text-right">
                    <div class="text-blue-600 font-black text-2xl flex items-center justify-end gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span id="clock">{{ now()->format('H:i:s') }}</span>
                    </div>
                    <p class="text-gray-400 text-sm font-bold">{{ now()->format('l, d F Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8 text-white">
                <div class="bg-blue-600 p-4 rounded-2xl shadow-lg">
                    <p class="text-[10px] font-bold uppercase opacity-80 tracking-widest">Total Siswa</p>
                    <p class="text-3xl font-black mt-1">{{ $totalSiswa }}</p>
                </div>
                <div class="bg-emerald-600 p-4 rounded-2xl shadow-lg">
                    <p class="text-[10px] font-bold uppercase opacity-80 tracking-widest">Hadir</p>
                    <p class="text-3xl font-black mt-1">{{ $hadir }}</p>
                </div>
                <div class="bg-emerald-700 p-4 rounded-2xl shadow-lg">
                    <p class="text-[10px] font-bold uppercase opacity-80 tracking-widest">Izin/Sakit</p>
                    <p class="text-3xl font-black mt-1">{{ $izinSakit }}</p>
                </div>
                <div class="bg-red-500 p-4 rounded-2xl shadow-lg">
                    <p class="text-[10px] font-bold uppercase opacity-80 tracking-widest">Belum Absen</p>
                    <p class="text-3xl font-black mt-1">{{ $belumAbsen }}</p>
                </div>
                <div class="{{ $warnaPersen }} p-4 rounded-2xl shadow-lg transition-colors duration-500">
                    <p class="text-[10px] font-bold uppercase opacity-80 tracking-widest">Persentase</p>
                    <p class="text-3xl font-black mt-1">{{ $persentase }}%</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <div class="lg:col-span-3 bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex flex-col">
                    <h3 class="font-black text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-2 h-5 bg-blue-600 rounded-full"></span>
                        Siswa Belum Absen
                    </h3>
                    <div class="space-y-3 overflow-y-auto pr-2 mb-4" style="max-height: 320px;">
                        @for ($i = 1; $i <= 5; $i++)
                        <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50 border border-gray-50 hover:border-blue-100 transition">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600 text-xs">AG</div>
                            <div>
                                <p class="text-xs font-bold text-gray-800 uppercase">Siswa Ke-{{ $i }}</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase">12 TKJ 1</p>
                            </div>
                        </div>
                        @endfor
                    </div>
                    <button class="w-full mt-auto py-3 bg-blue-600 text-white rounded-2xl font-bold text-sm shadow-md hover:bg-blue-700 transition">Lihat Semua</button>
                </div>

                <div class="lg:col-span-5 bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="font-black text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-2 h-5 bg-orange-500 rounded-full"></span>
                        Pengajuan Sekretaris
                    </h3>
                    <div class="space-y-4">
                        <div class="p-4 rounded-2xl border-2 border-orange-50 bg-orange-50/30">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-orange-500 flex items-center justify-center text-white shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-gray-800 tracking-tight tracking-widest uppercase">Siti Aminah</p>
                                        <p class="text-[10px] font-bold text-orange-600 uppercase">Laporan: SAKIT</p>
                                    </div>
                                </div>
                                <span class="text-[10px] bg-white px-2 py-1 rounded-full font-bold shadow-sm border text-gray-400">Baru Saja</span>
                            </div>
                           <div class="mt-4">
    @php
    // Cek apakah Siti Aminah (ID: 2) sudah ada di tabel absensi hari ini
    $cekAbsen = DB::table('absensi')
                ->where('user_id', 2)
                ->where('tanggal', now()->format('Y-m-d'))
                ->first();
@endphp

<div class="mt-4">
    @if(!$cekAbsen)
        <div class="flex gap-2">
            <a href="{{ route('admin.proses-izin', ['id' => 2, 'status' => 'S']) }}" 
               class="flex-1 py-2.5 bg-emerald-500 text-white rounded-xl font-bold text-xs text-center shadow-sm hover:bg-emerald-600 transition">
               Terima
            </a>
            <a href="{{ route('admin.proses-izin', ['id' => 2, 'status' => 'A']) }}" 
               class="flex-1 py-2.5 bg-white text-red-500 border border-red-100 rounded-xl font-bold text-xs text-center hover:bg-red-50 transition">
               Tolak
            </a>
        </div>
    @else
        <div class="py-2.5 px-4 rounded-xl text-center font-bold text-xs border">
            @if($cekAbsen->status == 'S' || $cekAbsen->status == 'I')
                <span class="text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">
                    ✅ PENGAUJAN DITERIMA
                </span>
            @elseif($cekAbsen->status == 'A')
                <span class="text-red-600 bg-red-50 px-3 py-1 rounded-full border border-red-100">
                    ❌ PENGAJUAN DITOLAK
                </span>
            @endif
        </div>
    @endif
</div>
</div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 bg-white p-5 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="font-black text-gray-800 mb-6 flex items-center gap-2">
                        <span class="w-2 h-5 bg-purple-600 rounded-full"></span>
                        Menu Utama
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('guru.generate-qr') }}" class="p-4 rounded-3xl border border-gray-50 flex flex-col items-center gap-3 hover:bg-blue-50 transition group bg-gray-50/50">
                            <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 group-hover:scale-110 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <p class="text-[10px] font-black text-gray-700 uppercase">Generate QR</p>
                        </a>
                        <a href="{{ route('guru.data-siswa') }}" class="p-4 rounded-3xl border border-gray-50 flex flex-col items-center gap-3 hover:bg-emerald-50 transition group bg-gray-50/50">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <p class="text-[10px] font-black text-gray-700 uppercase tracking-tighter">Data Siswa</p>
                        </a>
                        <a href="#" class="p-4 rounded-3xl border border-gray-50 flex flex-col items-center gap-3 hover:bg-orange-50 transition group bg-gray-50/50">
                            <div class="w-12 h-12 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-600 group-hover:scale-110 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <p class="text-[10px] font-black text-gray-700 uppercase">Laporan</p>
                        </a>
                        <a href="#" class="p-4 rounded-3xl border border-gray-50 flex flex-col items-center gap-3 hover:bg-purple-50 transition group bg-gray-50/50">
                            <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 group-hover:scale-110 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-[10px] font-black text-gray-700 uppercase">Rekap</p>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        setInterval(() => {
            const now = new Date();
            const clock = document.getElementById('clock');
            if(clock) clock.innerText = now.toLocaleTimeString('id-ID');
        }, 1000);
    </script>
</x-app-layout>