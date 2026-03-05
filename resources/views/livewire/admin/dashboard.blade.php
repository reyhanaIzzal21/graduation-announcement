<div>
    <div class="mb-8">
        <flux:heading size="xl">Dashboard</flux:heading>
        <flux:text class="mt-1">Ringkasan data kelulusan siswa</flux:text>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        {{-- Total Siswa --}}
        <div
            class="relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/10">
                    <flux:icon name="users" class="size-6 text-blue-500" />
                </div>
                <div>
                    <flux:text class="text-sm font-medium text-zinc-500">Total Siswa</flux:text>
                    <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ number_format($totalStudents) }}
                    </div>
                </div>
            </div>
            <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-blue-500/5"></div>
        </div>

        {{-- Lulus --}}
        <div
            class="relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-500/10">
                    <flux:icon name="check" class="size-6 text-emerald-500" />
                </div>
                <div>
                    <flux:text class="text-sm font-medium text-zinc-500">Lulus</flux:text>
                    <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">
                        {{ number_format($totalGraduated) }}</div>
                </div>
            </div>
            <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-emerald-500/5"></div>
        </div>

        {{-- Tidak Lulus --}}
        <div
            class="relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-500/10">
                    <flux:icon name="x-mark" class="size-6 text-red-500" />
                </div>
                <div>
                    <flux:text class="text-sm font-medium text-zinc-500">Tidak Lulus</flux:text>
                    <div class="text-3xl font-bold text-red-600 dark:text-red-400">
                        {{ number_format($totalNotGraduated) }}</div>
                </div>
            </div>
            <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-red-500/5"></div>
        </div>

        {{-- Persentase --}}
        <div
            class="relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10">
                    <flux:icon name="chart-bar-square" class="size-6 text-amber-500" />
                </div>
                <div>
                    <flux:text class="text-sm font-medium text-zinc-500">Persentase Lulus</flux:text>
                    <div class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $graduationPercentage }}%
                    </div>
                </div>
            </div>
            <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-amber-500/5"></div>
        </div>

        {{-- Mata Pelajaran --}}
        <div
            class="relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-500/10">
                    <flux:icon name="book-open" class="size-6 text-purple-500" />
                </div>
                <div>
                    <flux:text class="text-sm font-medium text-zinc-500">Mata Pelajaran</flux:text>
                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                        {{ number_format($totalSubjects) }}</div>
                </div>
            </div>
            <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-purple-500/5"></div>
        </div>
    </div>

    {{-- Additional Info --}}
    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Announcement Date --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center gap-3 mb-4">
                <flux:icon name="calendar-days" class="size-5 text-zinc-500" />
                <flux:heading size="lg">Tanggal Pengumuman</flux:heading>
            </div>
            @if ($announcementDate)
                <div class="text-xl font-semibold text-zinc-900 dark:text-white">
                    {{ \Carbon\Carbon::parse($announcementDate)->translatedFormat('l, d F Y') }}
                </div>
                <flux:text class="mt-1">
                    Pukul {{ \Carbon\Carbon::parse($announcementDate)->format('H:i') }} WIB
                </flux:text>
                @if (\Carbon\Carbon::parse($announcementDate)->isFuture())
                    <div class="mt-3 inline-flex items-center gap-2 rounded-lg bg-amber-500/10 px-3 py-1.5">
                        <div class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></div>
                        <span class="text-sm font-medium text-amber-600 dark:text-amber-400">Belum dimulai</span>
                    </div>
                @else
                    <div class="mt-3 inline-flex items-center gap-2 rounded-lg bg-emerald-500/10 px-3 py-1.5">
                        <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                        <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Sudah dibuka</span>
                    </div>
                @endif
            @else
                <flux:text>Belum diatur. <a href="{{ route('admin.settings') }}" class="text-blue-500 underline"
                        wire:navigate>Atur sekarang</a></flux:text>
            @endif
        </div>

        {{-- Access Logs Summary --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center gap-3 mb-4">
                <flux:icon name="eye" class="size-5 text-zinc-500" />
                <flux:heading size="lg">Log Akses</flux:heading>
            </div>
            <div class="text-xl font-semibold text-zinc-900 dark:text-white">
                {{ number_format($totalAccessLogs) }} kali akses
            </div>
            <flux:text class="mt-1">Total pengecekan kelulusan oleh siswa</flux:text>
            <div class="mt-4">
                <flux:button href="{{ route('admin.logs') }}" variant="ghost" size="sm" wire:navigate>
                    Lihat detail →
                </flux:button>
            </div>
        </div>
    </div>
</div>
