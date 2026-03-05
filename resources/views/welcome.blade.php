<x-layouts::guest :title="__('SIKAS - Pengumuman Kelulusan')">
    <style>
        /* Custom Colors based on SMAZA Logo */
        :root {
            --smaza-blue: #1A4B99;
            --smaza-red: #E31E24;
            --smaza-gold: #FFD700;
        }

        .bg-smaza-blue {
            background-color: var(--smaza-blue);
        }

        .text-smaza-gold {
            color: var(--smaza-gold);
        }

        .border-smaza-gold {
            border-color: var(--smaza-gold);
        }

        /* Typography Elevation */
        .font-serif-academic {
            font-family: 'Playfair Display', serif;
            /* Pastikan load font ini di layout utama */
        }

        /* Subtle Pattern */
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/00/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>

    <div class="relative min-h-screen bg-[#0A192F] bg-pattern overflow-hidden">
        {{-- Decorative Elements --}}
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[500px] bg-gradient-to-b from-blue-600/10 to-transparent pointer-events-none">
        </div>

        <div class="relative mx-auto max-w-5xl px-6 py-16 sm:py-24">

            {{-- Header/Logo Section --}}
            <div class="flex flex-col items-center text-center mb-12">
                <div class="relative mb-6 group">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-yellow-600 to-yellow-300 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000">
                    </div>
                    <img src="{{ asset('assets/logo-smaza.png') }}" alt="Logo SMAZA"
                        class="relative h-32 w-auto drop-shadow-2xl">
                </div>

                <div class="space-y-2">
                    <span class="text-smaza-gold font-medium tracking-[0.2em] uppercase text-sm">Sistem Informasi
                        Kelulusan Sekolah</span>
                    <h1 class="text-4xl font-extrabold text-white sm:text-6xl tracking-tight leading-tight">
                        GERBANG KELULUSAN<br>
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-white via-blue-100 to-blue-300">
                            ANGKATAN {{ date('Y') }}
                        </span>
                    </h1>
                    <p class="text-lg text-slate-400 font-medium tracking-wide">
                        {{ \App\Models\Setting::get('school_name', 'SMAN 1 Ponorogo') }}
                    </p>
                </div>
            </div>

            @php
                $announcementDate = \App\Models\Setting::get('announcement_date');
                $isOpen = $announcementDate ? \Carbon\Carbon::parse($announcementDate)->isPast() : false;
            @endphp

            {{-- Main Action Area --}}
            <div class="max-w-2xl mx-auto mb-20 text-center">
                @if ($isOpen)
                    <div class="p-[1px] rounded-3xl bg-gradient-to-b from-white/20 to-transparent shadow-2xl">
                        <div class="bg-[#112240]/80 backdrop-blur-xl rounded-3xl p-8 sm:p-12 border border-white/5">
                            <h2 class="text-white text-xl font-semibold mb-2 text-center italic">"Hari yang dinanti
                                telah tiba."</h2>
                            <p class="text-slate-400 mb-8 text-center">Silahkan klik tombol di bawah untuk melihat hasil
                                perjuangan Anda.</p>

                            <a href="{{ route('student.search') }}"
                                class="group relative inline-flex items-center justify-center w-full sm:w-auto px-10 py-4 font-bold text-white transition-all duration-200 bg-sma-blue rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 overflow-hidden"
                                style="background-color: var(--smaza-blue)" wire:navigate>
                                <div
                                    class="absolute inset-0 w-full h-full transition-all duration-300 transform translate-x-full group-hover:translate-x-0 bg-white/10 ease">
                                </div>
                                <span class="relative flex items-center gap-2">
                                    CEK HASIL SEKARANG
                                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </span>
                            </a>
                            <p class="mt-6 text-xs text-slate-500 uppercase tracking-widest leading-relaxed">Persiapkan
                                NISN dan Tanggal Lahir Anda</p>
                        </div>
                    </div>
                @else
                    {{-- Premium Countdown --}}
                    @if ($announcementDate)
                        <div x-data="countdown('{{ $announcementDate }}')" x-init="start()" class="space-y-8">
                            <div
                                class="inline-flex items-center px-4 py-2 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-300 text-xs font-bold tracking-widest uppercase">
                                <span class="relative flex h-2 w-2 mr-3">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                </span>
                                Menuju Pengumuman Resmi
                            </div>

                            <div class="flex justify-center gap-4 sm:gap-8">
                                <template
                                    x-for="(val, label) in {Hari: days, Jam: hours, Menit: minutes, Detik: seconds}"
                                    :key="label">
                                    <div class="flex flex-col items-center">
                                        <div class="relative">
                                            <div class="absolute inset-0 bg-blue-600 blur-xl opacity-20"></div>
                                            <div
                                                class="relative flex h-20 w-20 sm:h-28 sm:w-28 items-center justify-center rounded-2xl bg-[#112240] border border-white/10 shadow-inner">
                                                <span
                                                    class="text-3xl sm:text-5xl font-black text-white tracking-tighter"
                                                    x-text="val">00</span>
                                            </div>
                                        </div>
                                        <span
                                            class="mt-3 text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-[0.3em]"
                                            x-text="label"></span>
                                    </div>
                                </template>
                            </div>

                            <div class="bg-white/5 backdrop-blur-sm rounded-2xl py-4 px-6 inline-block">
                                <p class="text-slate-300 font-medium flex items-center gap-3">
                                    <svg class="w-5 h-5 text-smaza-gold" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($announcementDate)->translatedFormat('l, d F Y | H:i') }}
                                    WIB
                                </p>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            {{-- Feature Grid - Refined --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                @php
                    $features = [
                        [
                            'icon' =>
                                'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                            'title' => 'Sistem Terenkripsi',
                            'desc' => 'Data nilai dan status kelulusan dilindungi enkripsi tingkat tinggi.',
                            'color' => 'blue',
                        ],
                        [
                            'icon' =>
                                'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                            'title' => 'E-SKL Digital',
                            'desc' => 'Unduh Surat Keterangan Lulus resmi langsung setelah pengumuman.',
                            'color' => 'emerald',
                        ],
                        [
                            'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                            'title' => 'Akses Instan',
                            'desc' => 'Server high-performance menjamin akses cepat di waktu puncak.',
                            'color' => 'amber',
                        ],
                    ];
                @endphp

                @foreach ($features as $f)
                    <div
                        class="group p-8 rounded-3xl bg-[#112240]/40 border border-white/5 hover:border-white/20 transition-all duration-300">
                        <div
                            class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-{{ $f['color'] }}-500/10 text-{{ $f['color'] }}-400 group-hover:scale-110 transition-transform">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $f['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">{{ $f['title'] }}</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>

            <footer class="mt-20 text-center">
                <p class="text-slate-600 text-xs tracking-widest uppercase">© {{ date('Y') }} SMA Negeri 1
                    Ponorogo. All Rights Reserved.</p>
            </footer>
        </div>
    </div>

    {{-- Script tetap sama agar fitur tidak error --}}
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
