<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    {{-- Import Font Khusus untuk kesan Akademik --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --smaza-blue: #1A4B99;
            --smaza-gold: #FFD700;
            --bg-deep: #0A192F;
            /* Deep Navy Professional */
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-deep);
        }

        .academic-gradient {
            background: radial-gradient(circle at top center, #1E3A8A 0%, #0A192F 70%);
        }

        /* Glassmorphism Standard Industri - Lebih Soft & Clean */
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Tekstur Subtle agar tidak terlihat 'kosong' seperti desain AI */
        .bg-grid-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .font-serif-academic {
            font-family: 'Playfair Display', serif;
        }

        /* Custom Scrollbar untuk vibe premium */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-deep);
        }

        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }
    </style>
</head>

<body class="min-h-screen text-slate-200 antialiased overflow-x-hidden academic-gradient">
    {{-- Overlay Tekstur --}}
    <div class="fixed inset-0 pointer-events-none bg-grid-pattern z-0"></div>

    {{-- Aksen Cahaya (Ambient Light) --}}
    <div
        class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-600/10 blur-[120px] rounded-full pointer-events-none">
    </div>
    <div
        class="fixed bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-yellow-600/5 blur-[120px] rounded-full pointer-events-none">
    </div>

    {{-- Layout Wrapper --}}
    <div class="relative z-10 flex flex-col min-h-screen">

        {{-- Navigation / Header --}}
        <nav class="border-b border-white/5 bg-[#0A192F]/50 backdrop-blur-md sticky top-0 z-50">
            <div class="mx-auto max-w-7xl px-6 py-4">
                <div class="flex items-center justify-between">
                    {{-- Branding --}}
                    <div class="flex items-center gap-4">
                        @php $logo = \App\Models\Setting::get('logo_path'); @endphp
                        <div class="relative group">
                            <div
                                class="absolute -inset-1 bg-blue-500 rounded-lg blur opacity-20 group-hover:opacity-40 transition">
                            </div>
                            @if ($logo)
                                <img src="{{ asset('storage/' . $logo) }}" alt="Logo SMAZA"
                                    class="relative h-11 w-11 object-contain">
                            @else
                                <div
                                    class="relative flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-blue-800 text-white shadow-lg">
                                    <span class="font-bold text-lg">S</span>
                                </div>
                            @endif
                        </div>

                        <div class="hidden sm:block">
                            <h2 class="text-base font-extrabold tracking-tighter text-white leading-none">SIKAS <span
                                    class="text-blue-500 font-light">SMAZA</span></h2>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500 font-semibold mt-1">
                                {{ \App\Models\Setting::get('school_name', 'SMAN 1 Ponorogo') }}
                            </p>
                        </div>
                    </div>

                    {{-- Right Side Actions --}}
                    <div class="flex items-center gap-6">
                        {{-- <a href="{{ route('login') }}"
                            class="group flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-white transition-all">
                            <span
                                class="h-[1px] w-4 bg-slate-700 group-hover:w-8 group-hover:bg-blue-500 transition-all"></span>
                            Admin Access
                        </a> --}}
                    </div>
                </div>
            </div>
        </nav>

        {{-- Main Content Slot --}}
        <main class="flex-grow flex flex-col">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="border-t border-white/5 py-10 mt-auto bg-[#070F1D]">
            <div class="mx-auto max-w-7xl px-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="text-center md:text-left">
                        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-600 mb-1">Official
                            Graduation Portal</p>
                        <p class="text-sm text-slate-500">
                            &copy; {{ date('Y') }} <span class="text-slate-400 font-semibold">SIKAS</span> —
                            {{ \App\Models\Setting::get('school_name', 'Sistem Informasi Kelulusan') }}
                        </p>
                    </div>

                    {{-- Social/Link - Standar Industri biasanya ada link bantuan --}}
                    <div class="flex items-center gap-4 text-xs font-medium text-slate-600">
                        <a href="#" class="hover:text-blue-400 transition-colors">Bantuan</a>
                        <span class="w-1 h-1 rounded-full bg-slate-800"></span>
                        <a href="#" class="hover:text-blue-400 transition-colors">Panduan Kelulusan</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @fluxScripts
</body>

</html>
