<div class="mx-auto max-w-2xl px-4 py-12">
    @if ($step === 'search')
        {{-- Search Form --}}
        <div class="text-center mb-10">
            <div
                class="inline-flex items-center gap-2 rounded-full bg-indigo-500/10 px-4 py-2 mb-6 border border-indigo-500/20">
                <div class="h-2 w-2 rounded-full bg-indigo-400 animate-pulse"></div>
                <span class="text-sm font-medium text-indigo-300">Pengumuman Kelulusan</span>
            </div>
            <h2 class="text-3xl font-bold text-white sm:text-4xl mb-3">Cek Kelulusan</h2>
            <p class="text-white/60">Masukkan NISN dan Tanggal Lahir Anda untuk mengecek status kelulusan</p>
        </div>

        <div class="glass-card rounded-2xl p-8">
            @if (!$isAnnouncementTime && $announcementDate)
                <div class="text-center py-8">
                    <div class="mb-6">
                        <svg class="mx-auto h-16 w-16 text-amber-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Pengumuman Belum Dibuka</h3>
                    <p class="text-white/60 mb-6">Pengumuman akan dibuka pada:</p>

                    {{-- Countdown --}}
                    <div class="mb-8" x-data="countdown('{{ $announcementDate }}')" x-init="start()">
                        <div class="flex justify-center gap-4">
                            <div class="flex flex-col items-center">
                                <div
                                    class="flex h-20 w-20 items-center justify-center rounded-xl bg-white/10 text-3xl font-bold text-white border border-white/10">
                                    <span x-text="days">00</span>
                                </div>
                                <span class="mt-2 text-xs text-white/40 uppercase tracking-wider">Hari</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div
                                    class="flex h-20 w-20 items-center justify-center rounded-xl bg-white/10 text-3xl font-bold text-white border border-white/10">
                                    <span x-text="hours">00</span>
                                </div>
                                <span class="mt-2 text-xs text-white/40 uppercase tracking-wider">Jam</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div
                                    class="flex h-20 w-20 items-center justify-center rounded-xl bg-white/10 text-3xl font-bold text-white border border-white/10">
                                    <span x-text="minutes">00</span>
                                </div>
                                <span class="mt-2 text-xs text-white/40 uppercase tracking-wider">Menit</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div
                                    class="flex h-20 w-20 items-center justify-center rounded-xl bg-white/10 text-3xl font-bold text-indigo-400 border border-indigo-500/20">
                                    <span x-text="seconds">00</span>
                                </div>
                                <span class="mt-2 text-xs text-white/40 uppercase tracking-wider">Detik</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-sm text-white/40">
                        {{ \Carbon\Carbon::parse($announcementDate)->translatedFormat('l, d F Y - H:i') }} WIB
                    </p>
                </div>
            @else
                <form wire:submit="search" class="space-y-6">
                    @if ($errorMessage)
                        <div class="rounded-xl bg-red-500/10 border border-red-500/20 p-4 text-red-300 text-sm">
                            <div class="flex items-start gap-3">
                                <svg class="h-5 w-5 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $errorMessage }}</span>
                            </div>
                        </div>
                    @endif

                    @if ($isLocked)
                        <div class="text-center py-4">
                            <svg class="mx-auto h-12 w-12 text-amber-400 mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <p class="text-amber-300 font-medium mb-1">Akses Terkunci</p>
                            <p class="text-white/60 text-sm">Tunggu {{ $lockoutSeconds }} detik sebelum mencoba lagi</p>
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-medium text-white/80 mb-2">NISN (Nomor Induk Siswa
                                Nasional)</label>
                            <input type="text" wire:model="nisn"
                                class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder-white/30 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all"
                                placeholder="Masukkan NISN Anda" autocomplete="off" />
                            @error('nisn')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-white/80 mb-2">Tanggal Lahir</label>
                            <input type="date" wire:model="birth_date"
                                class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all scheme-dark" />
                            @error('birth_date')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full rounded-xl bg-indigo-600 px-6 py-3.5 font-semibold text-white transition-all hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:ring-offset-2 focus:ring-offset-transparent active:scale-[0.98] animate-glow"
                            wire:loading.attr="disabled" wire:loading.class="opacity-70 cursor-wait">
                            <span wire:loading.remove wire:target="search"
                                class="flex items-center justify-center gap-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Cek Kelulusan
                            </span>
                            <span wire:loading wire:target="search" class="flex items-center justify-center gap-2">
                                <svg class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Mencari...
                            </span>
                        </button>
                    @endif
                </form>
            @endif
        </div>
    @elseif($step === 'result' && $studentData)
        {{-- Result Display --}}
        @if ($studentData['status'] === 'lulus')
            {{-- LULUS --}}
            <div class="text-center mb-8" x-data x-init="import('https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js').then(() => {
                const duration = 4000;
                const end = Date.now() + duration;
                const colors = ['#6366f1', '#818cf8', '#a5b4fc', '#22c55e', '#86efac', '#fbbf24'];
                (function frame() {
                    confetti({ particleCount: 3, angle: 60, spread: 55, origin: { x: 0 }, colors: colors });
                    confetti({ particleCount: 3, angle: 120, spread: 55, origin: { x: 1 }, colors: colors });
                    if (Date.now() < end) requestAnimationFrame(frame);
                })();
            })">
                <div
                    class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-4 py-2 mb-6 border border-emerald-500/20">
                    <div class="h-2 w-2 rounded-full bg-emerald-400"></div>
                    <span class="text-sm font-medium text-emerald-300">Status Kelulusan</span>
                </div>
                <h2 class="text-4xl font-bold text-white sm:text-5xl mb-2">🎓 SELAMAT!</h2>
                <p class="text-xl text-emerald-400 font-semibold">Anda Dinyatakan LULUS</p>
            </div>

            <div class="glass-card rounded-2xl p-8 space-y-6">
                {{-- Student Info --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-xl bg-white/5 p-4">
                        <p class="text-xs text-white/40 uppercase tracking-wider mb-1">Nama</p>
                        <p class="text-lg font-semibold text-white">{{ $studentData['name'] }}</p>
                    </div>
                    <div class="rounded-xl bg-white/5 p-4">
                        <p class="text-xs text-white/40 uppercase tracking-wider mb-1">NISN</p>
                        <p class="text-lg font-semibold text-white font-mono">{{ $studentData['nisn'] }}</p>
                    </div>
                    <div class="rounded-xl bg-white/5 p-4">
                        <p class="text-xs text-white/40 uppercase tracking-wider mb-1">Kelas</p>
                        <p class="text-lg font-semibold text-white">{{ $studentData['class_name'] }}</p>
                    </div>
                    <div class="rounded-xl bg-white/5 p-4">
                        <p class="text-xs text-white/40 uppercase tracking-wider mb-1">Nilai</p>
                        <p class="text-lg font-semibold text-white">{{ $studentData['gpa'] ?? '-' }}</p>
                    </div>
                </div>

                {{-- Message --}}
                <div class="rounded-xl bg-emerald-500/10 border border-emerald-500/20 p-5">
                    <p class="text-emerald-200 leading-relaxed">{{ $studentData['message'] }}</p>
                </div>

                {{-- Token --}}
                <div class="text-center rounded-xl bg-white/5 p-4">
                    <p class="text-xs text-white/40 uppercase tracking-wider mb-2">Token Verifikasi Dokumen</p>
                    <p class="text-2xl font-bold font-mono text-indigo-400 tracking-widest">
                        {{ $studentData['token'] }}</p>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('graduation.download', $studentData['download_hash']) }}"
                        class="flex-1 flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3.5 font-semibold text-white transition-all hover:bg-indigo-500 active:scale-[0.98]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Unduh Surat Keterangan Lulus (PDF)
                    </a>
                    <button wire:click="resetSearch"
                        class="flex items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/5 px-6 py-3.5 font-semibold text-white transition-all hover:bg-white/10 active:scale-[0.98]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Selesai
                    </button>
                </div>
            </div>
        @else
            {{-- TIDAK LULUS --}}
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center gap-2 rounded-full bg-amber-500/10 px-4 py-2 mb-6 border border-amber-500/20">
                    <div class="h-2 w-2 rounded-full bg-amber-400"></div>
                    <span class="text-sm font-medium text-amber-300">Status Kelulusan</span>
                </div>
                <h2 class="text-3xl font-bold text-white sm:text-4xl mb-3">Informasi Kelulusan</h2>
            </div>

            <div class="glass-card rounded-2xl p-8 space-y-6">
                {{-- Student Info --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-xl bg-white/5 p-4">
                        <p class="text-xs text-white/40 uppercase tracking-wider mb-1">Nama</p>
                        <p class="text-lg font-semibold text-white">{{ $studentData['name'] }}</p>
                    </div>
                    <div class="rounded-xl bg-white/5 p-4">
                        <p class="text-xs text-white/40 uppercase tracking-wider mb-1">NISN</p>
                        <p class="text-lg font-semibold text-white font-mono">{{ $studentData['nisn'] }}</p>
                    </div>
                    <div class="rounded-xl bg-white/5 p-4">
                        <p class="text-xs text-white/40 uppercase tracking-wider mb-1">Kelas</p>
                        <p class="text-lg font-semibold text-white">{{ $studentData['class_name'] }}</p>
                    </div>
                    <div class="rounded-xl bg-white/5 p-4">
                        <p class="text-xs text-white/40 uppercase tracking-wider mb-1">Status</p>
                        <p class="text-lg font-semibold text-red-400">Tidak Lulus</p>
                    </div>
                </div>

                {{-- Message --}}
                <div class="rounded-xl bg-amber-500/10 border border-amber-500/20 p-5">
                    <p class="text-amber-200 leading-relaxed">{{ $studentData['message'] }}</p>
                </div>

                {{-- Actions --}}
                <div class="flex justify-center">
                    <button wire:click="resetSearch"
                        class="flex items-center justify-center gap-2 rounded-xl border border-white/10 bg-white/5 px-8 py-3.5 font-semibold text-white transition-all hover:bg-white/10 active:scale-[0.98]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Kembali
                    </button>
                </div>
            </div>
        @endif
    @endif
</div>

{{-- Countdown Alpine.js Component --}}
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
                const now = new Date().getTime();
                const diff = target - now;

                if (diff <= 0) {
                    this.days = '00';
                    this.hours = '00';
                    this.minutes = '00';
                    this.seconds = '00';
                    clearInterval(this.interval);
                    // Reload page when countdown finishes
                    window.location.reload();
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
