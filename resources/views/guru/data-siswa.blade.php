<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-black text-gray-800 tracking-tight">Data Siswa</h2>
                    <p class="text-gray-500 font-medium">Total Terdaftar: <span class="text-blue-600 font-bold">{{ $dataSiswa->count() }} Siswa</span></p>
                </div>
                <a href="{{ route('guru.dashboard') }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-2xl font-bold text-sm shadow-sm hover:bg-gray-50 transition">
                    ← Kembali
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-5 text-xs font-black text-gray-400 uppercase tracking-widest">No</th>
                                <th class="p-5 text-xs font-black text-gray-400 uppercase tracking-widest">Siswa</th>
                                <th class="p-5 text-xs font-black text-gray-400 uppercase tracking-widest">Username / NIS</th>
                                <th class="p-5 text-xs font-black text-gray-400 uppercase tracking-widest">Role</th>
                                <th class="p-5 text-xs font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($dataSiswa as $key => $siswa)
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="p-5 text-sm font-bold text-gray-400">{{ $key + 1 }}</td>
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-black text-xs shadow-md">
                                            {{ strtoupper(substr($siswa->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-gray-800 uppercase tracking-tight">{{ $siswa->name }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase italic">Kelas Belum Diatur</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-black">
                                        {{ $siswa->username }}
                                    </span>
                                </td>
                                <td class="p-5">
                                    <span class="text-xs font-bold text-blue-500 uppercase">Siswa</span>
                                </td>
                                <td class="p-5 text-center">
                                    <button class="p-2 text-gray-400 hover:text-blue-600 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>