<x-layouts::guest :title="__('SIKAS - Pengumuman Kelulusan')">
    <div class="mx-auto max-w-4xl px-4 py-12 sm:py-20">
        {{-- Hero Section --}}
        <div class="text-center mb-16">
            <div class="mb-8 animate-float">
                <div
                    class="inline-flex h-24 w-24 items-center justify-center rounded-2xl bg-indigo-500/20 border border-indigo-500/30">
                    <svg class="h-12 w-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
            </div>

            <h1 class="text-4xl font-bold text-white sm:text-6xl mb-4 tracking-tight">
                Pengumuman<br>
                <span class="bg-linear-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                    Kelulusan {{ date('Y') }}
                </span>
            </h1>

            <p class="mx-auto max-w-2xl text-lg text-white/60 mb-8">
                {{ \App\Models\Setting::get('school_name', 'SMK Negeri 1') }}
            </p>

            @php
                $announcementDate = \App\Models\Setting::get('announcement_date');
                $isOpen = $announcementDate ? \Carbon\Carbon::parse($announcementDate)->isPast() : false;
            @endphp

            @if ($isOpen)
                {{-- CTA Button --}}
                <a href="{{ route('student.search') }}"
                    class="inline-flex items-center gap-3 rounded-2xl bg-indigo-600 px-8 py-4 text-lg font-semibold text-white transition-all hover:bg-indigo-500 hover:scale-105 active:scale-95 animate-glow"
                    wire:navigate>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cek Kelulusan Sekarang
                </a>
                <p class="mt-4 text-sm text-white/40">Masukkan NISN dan Tanggal Lahir untuk mengecek status kelulusan
                </p>
            @else
                {{-- Countdown --}}
                @if ($announcementDate)
                    <div class="glass-card rounded-2xl p-8 max-w-xl mx-auto mb-8">
                        <div class="flex items-center justify-center gap-2 mb-6">
                            <div class="h-2 w-2 rounded-full bg-amber-400 animate-pulse"></div>
                            <span class="text-sm font-medium text-amber-300">Pembukaan Pengumuman</span>
                        </div>

                        <div x-data="countdown('{{ $announcementDate }}')" x-init="start()">
                            <div class="flex justify-center gap-3 sm:gap-5 mb-6">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="flex h-20 w-20 sm:h-24 sm:w-24 items-center justify-center rounded-2xl bg-white/10 text-3xl sm:text-4xl font-bold text-white border border-white/10">
                                        <span x-text="days">00</span>
                                    </div>
                                    <span class="mt-2 text-xs text-white/40 uppercase tracking-wider">Hari</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div
                                        class="flex h-20 w-20 sm:h-24 sm:w-24 items-center justify-center rounded-2xl bg-white/10 text-3xl sm:text-4xl font-bold text-white border border-white/10">
                                        <span x-text="hours">00</span>
                                    </div>
                                    <span class="mt-2 text-xs text-white/40 uppercase tracking-wider">Jam</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div
                                        class="flex h-20 w-20 sm:h-24 sm:w-24 items-center justify-center rounded-2xl bg-white/10 text-3xl sm:text-4xl font-bold text-white border border-white/10">
                                        <span x-text="minutes">00</span>
                                    </div>
                                    <span class="mt-2 text-xs text-white/40 uppercase tracking-wider">Menit</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div
                                        class="flex h-20 w-20 sm:h-24 sm:w-24 items-center justify-center rounded-2xl bg-white/10 text-3xl sm:text-4xl font-bold text-indigo-400 border border-indigo-500/20">
                                        <span x-text="seconds">00</span>
                                    </div>
                                    <span class="mt-2 text-xs text-white/40 uppercase tracking-wider">Detik</span>
                                </div>
                            </div>
                        </div>

                        <p class="text-center text-sm text-white/40">
                            {{ \Carbon\Carbon::parse($announcementDate)->translatedFormat('l, d F Y - H:i') }} WIB
                        </p>
                    </div>
                @endif
            @endif
        </div>

        {{-- Info Cards --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
            <div class="glass-card rounded-2xl p-6 text-center transition-transform hover:scale-105">
                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/10">
                    <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-white mb-1">Aman & Terverifikasi</h3>
                <p class="text-xs text-white/50">Sistem dilindungi dengan verifikasi ganda (NISN + Tanggal Lahir)</p>
            </div>

            <div class="glass-card rounded-2xl p-6 text-center transition-transform hover:scale-105">
                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-500/10">
                    <svg class="h-6 w-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-white mb-1">Unduh SKL</h3>
                <p class="text-xs text-white/50">Surat Keterangan Lulus dapat diunduh langsung dalam format PDF</p>
            </div>

            <div class="glass-card rounded-2xl p-6 text-center transition-transform hover:scale-105">
                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-purple-500/10">
                    <svg class="h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-white mb-1">Real-time</h3>
                <p class="text-xs text-white/50">Hasil pengumuman tersedia secara real-time sesuai jadwal sekolah</p>
            </div>
        </div>
    </div>

    {{-- Countdown Script --}}
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
                        clearInterval(this.interval);
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
</x-layouts::guest>
