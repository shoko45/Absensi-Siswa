<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-3xl p-8 text-center border border-gray-100">
                
                <h2 class="text-2xl font-black text-gray-800 mb-2">QR Code Dinamis</h2>
                <p class="text-gray-500 text-sm mb-4">Berubah otomatis dalam <span id="timer" class="text-blue-600 font-bold">30</span> detik</p>

                <div id="qr-container" class="bg-blue-50 p-6 rounded-3xl inline-block mb-8 border-4 border-blue-100 shadow-inner">
                    {!! QrCode::size(250)->gradient(37, 99, 235, 124, 58, 237, 'diagonal')->margin(1)->generate($kodePayload) !!}
                </div>

                <div class="space-y-4 text-left">
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Status Keamanan</p>
                        <p class="text-sm font-black text-emerald-600 flex items-center gap-2">
                            <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
                            Terenkripsi & Aktif
                        </p>
                    </div>

                    <a href="{{ route('guru.dashboard') }}" class="block w-full py-4 bg-gray-800 text-white rounded-2xl font-bold text-sm text-center shadow-lg">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        let timeLeft = 30;
        const timerElement = document.getElementById('timer');
        const qrContainer = document.getElementById('qr-container');

        // Fungsi ambil QR baru dari server
        async function refreshQR() {
            try {
                const response = await fetch("{{ route('get.new.qr') }}");
                const qrSvg = await response.text();
                qrContainer.innerHTML = qrSvg;
                timeLeft = 30; // Reset waktu
            } catch (error) {
                console.error("Gagal update QR", error);
            }
        }

        // Jalankan hitung mundur
        setInterval(() => {
            timeLeft--;
            timerElement.innerText = timeLeft;

            if (timeLeft <= 0) {
                refreshQR();
            }
        }, 1000);
    </script>
</x-app-layout>