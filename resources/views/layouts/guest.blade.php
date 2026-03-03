<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 25%, #312e81 50%, #1e1b4b 75%, #0f172a 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .animate-glow {
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
            }

            to {
                box-shadow: 0 0 40px rgba(99, 102, 241, 0.6);
            }
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(99, 102, 241, 0.3);
            animation: particle-float 8s ease-in-out infinite;
        }

        @keyframes particle-float {

            0%,
            100% {
                transform: translateY(0) translateX(0);
                opacity: 0.3;
            }

            25% {
                transform: translateY(-30px) translateX(20px);
                opacity: 0.6;
            }

            50% {
                transform: translateY(-10px) translateX(-10px);
                opacity: 0.4;
            }

            75% {
                transform: translateY(-40px) translateX(15px);
                opacity: 0.5;
            }
        }
    </style>
</head>

<body class="min-h-screen gradient-bg text-white antialiased overflow-x-hidden">
    {{-- Floating Particles --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="particle w-2 h-2 top-[10%] left-[20%]" style="animation-delay: 0s;"></div>
        <div class="particle w-3 h-3 top-[30%] left-[80%]" style="animation-delay: 2s;"></div>
        <div class="particle w-1.5 h-1.5 top-[60%] left-[10%]" style="animation-delay: 4s;"></div>
        <div class="particle w-2.5 h-2.5 top-[80%] left-[70%]" style="animation-delay: 1s;"></div>
        <div class="particle w-2 h-2 top-[20%] left-[50%]" style="animation-delay: 3s;"></div>
        <div class="particle w-1 h-1 top-[50%] left-[40%]" style="animation-delay: 5s;"></div>
        <div class="particle w-3 h-3 top-[70%] left-[90%]" style="animation-delay: 2.5s;"></div>
    </div>

    {{-- Header --}}
    <header class="relative z-10 border-b border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    @php $logo = \App\Models\Setting::get('logo_path'); @endphp
                    @if ($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo"
                            class="h-10 w-10 rounded-lg object-contain bg-white/10 p-1">
                    @else
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-500/20 text-indigo-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-lg font-bold text-white">SIKAS</h1>
                        <p class="text-xs text-indigo-300">
                            {{ \App\Models\Setting::get('school_name', 'Sistem Informasi Kelulusan') }}</p>
                    </div>
                </div>
                <a href="{{ route('login') }}" class="text-sm text-white/60 hover:text-white transition-colors">
                    Admin Login
                </a>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="relative z-10">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="relative z-10 border-t border-white/10 py-6 mt-12">
        <div class="mx-auto max-w-7xl px-4 text-center">
            <p class="text-sm text-white/40">
                &copy; {{ date('Y') }} SIKAS -
                {{ \App\Models\Setting::get('school_name', 'Sistem Informasi Kelulusan SMK') }}
            </p>
        </div>
    </footer>

    @fluxScripts
</body>

</html>
