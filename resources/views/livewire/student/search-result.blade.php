<div class="mx-auto max-w-3xl px-6 py-12 relative z-10">
    @if ($step === 'search')
        {{-- Search Form Section --}}
        <div class="text-center mb-10">
            <div
                class="inline-flex items-center gap-3 rounded-full bg-blue-900/30 px-4 py-2 mb-6 border border-blue-500/20 shadow-[0_0_15px_rgba(26,75,153,0.3)]">
                <div class="h-2 w-2 rounded-full bg-blue-400 animate-pulse"></div>
                <span class="text-xs font-bold uppercase tracking-widest text-blue-300">Portal Akses Resmi</span>
            </div>
            <h2 class="text-3xl font-serif-academic font-bold text-white sm:text-5xl mb-4 tracking-tight">Cek Status
                Kelulusan</h2>
            <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto">Silakan masukkan Nomor Induk Siswa Nasional
                (NISN) dan Tanggal Lahir untuk memverifikasi data Anda.</p>
        </div>

        <div class="p-[1px] rounded-3xl bg-gradient-to-b from-white/10 to-transparent shadow-2xl">
            <div class="bg-[#112240]/80 backdrop-blur-xl rounded-3xl p-8 sm:p-10 border border-white/5">
                @if (!$isAnnouncementTime && $announcementDate)
                    {{-- Countdown Locked State --}}
                    <div class="text-center py-6">
                        <div
                            class="mb-6 inline-flex h-20 w-20 items-center justify-center rounded-full bg-[#0A192F] border border-blue-500/20 shadow-inner">
                            <svg class="h-10 w-10 text-smaza-gold" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2 font-serif-academic">Akses Belum Dibuka</h3>
                        <p class="text-slate-400 mb-8 text-sm">Pengumuman resmi kelulusan akan dapat diakses pada:</p>

                        {{-- Countdown (Logic tidak dirubah, hanya UI) --}}
                        <div class="mb-8" x-data="countdown('{{ $announcementDate }}')" x-init="start()">
                            <div class="flex justify-center gap-3 sm:gap-6">
                                <template
                                    x-for="(val, label) in {Hari: days, Jam: hours, Menit: minutes, Detik: seconds}"
                                    :key="label">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-2xl bg-[#0A192F] text-2xl sm:text-3xl font-black text-white border border-white/10 shadow-inner">
                                            <span x-text="val">00</span>
                                        </div>
                                        <span
                                            class="mt-3 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]"
                                            x-text="label"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="inline-block bg-white/5 rounded-xl px-6 py-3 border border-white/5">
                            <p class="text-sm font-medium text-smaza-gold">
                                <span x-data="{ formatted: '' }" x-init="const d = new Date('{{ $announcementDate }}');
                                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Jakarta', hour12: false };
                                formatted = d.toLocaleDateString('id-ID', options) + ' WIB';" x-text="formatted">
                                </span>
                            </p>
                        </div>
                    </div>
                @else
                    {{-- Search Form --}}
                    <form wire:submit="search" class="space-y-6">
                        @if ($errorMessage)
                            <div class="rounded-xl bg-red-900/30 border border-red-500/30 p-4 animate-pulse">
                                <div class="flex items-start gap-3">
                                    <svg class="h-5 w-5 mt-0.5 shrink-0 text-red-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm font-medium text-red-300">{{ $errorMessage }}</span>
                                </div>
                            </div>
                        @endif

                        @if ($isLocked)
                            <div class="text-center py-6 bg-yellow-900/20 rounded-xl border border-yellow-500/20">
                                <svg class="mx-auto h-10 w-10 text-yellow-500 mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-yellow-400 font-bold mb-1">Akses Sementara Terkunci</p>
                                <p class="text-slate-400 text-sm">Terlalu banyak percobaan. Tunggu <span
                                        class="text-white font-mono font-bold">{{ $lockoutSeconds }}</span> detik.</p>
                            </div>
                        @else
                            <div class="space-y-5">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nomor
                                        Induk Siswa Nasional</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                            </svg>
                                        </div>
                                        <input type="text" wire:model="nisn"
                                            class="w-full rounded-xl border border-white/10 bg-[#0A192F] pl-11 pr-4 py-3.5 text-white placeholder-slate-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-mono tracking-wider"
                                            placeholder="Contoh: 0051234567" autocomplete="off" />
                                    </div>
                                    @error('nisn')
                                        <p class="mt-2 text-xs font-medium text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal
                                        Lahir</label>
                                    <div class="relative">
                                        <input type="date" wire:model="birth_date"
                                            class="w-full rounded-xl border border-white/10 bg-[#0A192F] px-4 py-3.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all [color-scheme:dark]" />
                                    </div>
                                    @error('birth_date')
                                        <p class="mt-2 text-xs font-medium text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit"
                                class="relative w-full overflow-hidden rounded-xl bg-gradient-to-r from-blue-700 to-blue-600 px-6 py-4 font-bold text-white transition-all hover:from-blue-600 hover:to-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-[#0A192F] active:scale-[0.98] mt-4 shadow-[0_0_20px_rgba(37,99,235,0.2)]"
                                wire:loading.attr="disabled" wire:loading.class="opacity-70 cursor-wait">
                                <span wire:loading.remove wire:target="search"
                                    class="flex items-center justify-center gap-2">
                                    LIHAT HASIL KELULUSAN
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </span>
                                <span wire:loading wire:target="search"
                                    class="flex items-center justify-center gap-3 tracking-widest">
                                    <svg class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    MEMPROSES DATA...
                                </span>
                            </button>
                        @endif
                    </form>
                @endif
            </div>
        </div>
    @elseif($step === 'result' && $studentData)
        {{-- Result Display Section --}}

        @if ($studentData['status'] === 'lulus')
            {{-- STATE: LULUS (CERTIFICATE VIBE) --}}
            <div x-data x-init="import('https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js').then(() => {
                const duration = 4000;
                const end = Date.now() + duration;
                /* Warna confetti disesuaikan dengan warna SMAZA */
                const colors = ['#FFD700', '#1A4B99', '#ffffff', '#4ade80'];
                (function frame() {
                    confetti({ particleCount: 4, angle: 60, spread: 55, origin: { x: 0 }, colors: colors });
                    confetti({ particleCount: 4, angle: 120, spread: 55, origin: { x: 1 }, colors: colors });
                    if (Date.now() < end) requestAnimationFrame(frame);
                })();
            })"></div>

            <div class="relative bg-white rounded-3xl p-1 md:p-2 shadow-2xl overflow-hidden mt-4">
                {{-- Border Emas ala Sertifikat --}}
                <div
                    class="absolute inset-0 bg-gradient-to-br from-yellow-300 via-yellow-600 to-yellow-800 opacity-20">
                </div>

                <div class="relative bg-[#F8FAFC] border border-yellow-600/30 rounded-2xl p-6 sm:p-12 h-full">
                    {{-- Watermark Logo SMAZA (opsional, asumsikan ada path logo) --}}
                    <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none">
                        <img src="{{ asset('img/logo-smaza.png') }}" alt="Watermark" class="w-2/3 grayscale">
                    </div>

                    <div class="relative z-10">
                        <div class="text-center border-b border-slate-300 pb-8 mb-8">
                            <h3 class="text-slate-500 font-bold tracking-[0.3em] text-xs uppercase mb-4">Pengumuman
                                Kelulusan Resmi</h3>
                            <h2 class="text-4xl sm:text-5xl font-serif-academic font-black text-slate-800 mb-4">
                                SELAMAT!</h2>
                            <div
                                class="inline-flex items-center justify-center px-8 py-2 rounded-full bg-green-100 border border-green-300 text-green-700 font-bold tracking-widest uppercase text-sm shadow-sm">
                                LULUS
                            </div>
                        </div>

                        {{-- Student Info Grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6 mb-10">
                            <div class="space-y-1">
                                <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Nama Lengkap
                                </p>
                                <p class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-2">
                                    {{ $studentData['name'] }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">NISN</p>
                                <p class="text-lg font-mono font-bold text-slate-800 border-b border-slate-200 pb-2">
                                    {{ $studentData['nisn'] }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Kelas</p>
                                <p class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-2">
                                    {{ $studentData['class_name'] }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Nilai Akhir
                                    Rata-rata</p>
                                <p class="text-lg font-bold text-blue-700 border-b border-slate-200 pb-2">
                                    {{ $studentData['final_score'] ?? '-' }}</p>
                            </div>
                        </div>

                        {{-- Grades Table --}}
                        @if (!empty($studentData['grades']))
                            <div class="mb-10">
                                <p
                                    class="text-[10px] text-slate-500 uppercase tracking-widest font-bold mb-3 text-center">
                                    Transkrip Nilai Sementara</p>
                                <div class="rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm">
                                    <table class="w-full">
                                        <thead class="bg-slate-50 border-b border-slate-200">
                                            <tr>
                                                <th
                                                    class="px-5 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                                    Mata Pelajaran</th>
                                                <th
                                                    class="px-5 py-3 text-right text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                                    Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach ($studentData['grades'] as $grade)
                                                <tr class="hover:bg-slate-50 transition-colors">
                                                    <td class="px-5 py-3 text-sm font-medium text-slate-700">
                                                        {{ $grade['subject'] }}</td>
                                                    <td
                                                        class="px-5 py-3 text-sm text-right font-mono font-bold text-slate-800">
                                                        {{ number_format($grade['score'], 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        {{-- Final Message & Actions --}}
                        <div class="bg-blue-50 rounded-xl p-5 mb-8 border border-blue-100 text-center">
                            <p class="text-blue-800 text-sm font-medium italic">"{{ $studentData['message'] }}"</p>
                        </div>

                        <div
                            class="flex flex-col sm:flex-row gap-4 items-center justify-center pt-6 border-t border-slate-200">
                            <a href="{{ route('graduation.download', $studentData['download_hash']) }}"
                                class="w-full sm:w-auto flex-1 flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-8 py-4 font-bold text-white shadow-lg shadow-blue-700/30 transition-all hover:bg-blue-800 hover:-translate-y-1">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                UNDUH SKL (PDF)
                            </a>
                            <button wire:click="resetSearch"
                                class="w-full sm:w-auto px-8 py-4 font-bold text-slate-500 hover:text-slate-800 transition-colors uppercase tracking-widest text-sm">
                                Kembali
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- STATE: TIDAK LULUS (RESPECTFUL & FORMAL) --}}
            <div
                class="bg-[#112240]/80 backdrop-blur-xl rounded-3xl border border-white/5 overflow-hidden shadow-2xl mt-4">
                <div class="h-2 w-full bg-red-500/80"></div>
                <div class="p-8 sm:p-12">
                    <div class="text-center mb-10">
                        <div
                            class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-red-900/30 text-red-400 mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-serif-academic font-bold text-white mb-2">Informasi Kelulusan</h2>
                        <p class="text-slate-400">Berdasarkan keputusan rapat pleno dewan guru.</p>
                    </div>

                    {{-- Student Info Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <div class="rounded-xl bg-[#0A192F] p-5 border border-white/5">
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold mb-1">Nama</p>
                            <p class="text-base font-bold text-white">{{ $studentData['name'] }}</p>
                        </div>
                        <div class="rounded-xl bg-[#0A192F] p-5 border border-white/5">
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold mb-1">NISN</p>
                            <p class="text-base font-mono font-bold text-white">{{ $studentData['nisn'] }}</p>
                        </div>
                        <div class="rounded-xl bg-[#0A192F] p-5 border border-white/5">
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold mb-1">Kelas</p>
                            <p class="text-base font-bold text-white">{{ $studentData['class_name'] }}</p>
                        </div>
                        <div class="rounded-xl bg-red-900/10 p-5 border border-red-500/20">
                            <p class="text-[10px] text-red-400/70 uppercase tracking-widest font-bold mb-1">Status
                                Akhir</p>
                            <p class="text-base font-bold text-red-400">TIDAK LULUS</p>
                        </div>
                    </div>

                    {{-- Message --}}
                    <div class="rounded-xl bg-[#0A192F] border border-white/5 p-6 mb-10">
                        <p class="text-slate-300 leading-relaxed text-center italic">"{{ $studentData['message'] }}"
                        </p>
                    </div>

                    <div class="flex justify-center">
                        <button wire:click="resetSearch"
                            class="flex items-center gap-2 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 px-8 py-3.5 font-bold text-white transition-all">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            KEMBALI KE PENCARIAN
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>

{{-- Script countdown tidak diubah, tetap di bawah --}}
<script>
    function countdown(targetDate) {
        return {
            days: '00',
            hours: '00',
            minutes: '00',
            seconds: '00',
            interval: null,
            start() {
                this.update();
                this.interval = setInterval(() => this.update(), 1000);
            },
            update() {
                const target = new Date(targetDate).getTime();
                const now = new Date();
                const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
                const wibTime = utcTime + (7 * 60 * 60 * 1000);
                const diff = target - wibTime;

                if (diff <= 0) {
                    this.days = '00';
                    this.hours = '00';
                    this.minutes = '00';
                    this.seconds = '00';
                    clearInterval(this.interval);
                    setTimeout(() => window.location.reload(), 1000);
                    return;
                }
                this.days = String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, '0');
                this.hours = String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                this.minutes = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                this.seconds = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');
            }
        }
    }
</script>
