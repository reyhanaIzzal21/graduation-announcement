<div>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <flux:heading size="xl">Log Akses</flux:heading>
            <flux:text class="mt-1">Riwayat pengecekan kelulusan oleh siswa</flux:text>
        </div>
        @if ($logs->total() > 0)
            <flux:button wire:click="clearLogs" wire:confirm="Yakin ingin menghapus semua log akses?" variant="danger"
                size="sm" icon="trash">
                Hapus Semua Log
            </flux:button>
        @endif
    </div>

    @if (session('success'))
        <div
            class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <div class="mb-4">
        <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari berdasarkan nama atau NISN..."
            icon="magnifying-glass" />
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">No
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Siswa</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            NISN</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">IP
                            Address</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Browser</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Waktu Akses</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">
                    @forelse($logs as $i => $log)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-zinc-500">{{ $logs->firstItem() + $i }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-zinc-900 dark:text-white">
                                {{ $log->student?->name ?? '-' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm font-mono text-zinc-500">
                                {{ $log->student?->nisn ?? '-' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm font-mono text-zinc-500">
                                {{ $log->ip_address }}</td>
                            <td class="px-4 py-3 text-sm text-zinc-500 max-w-xs truncate">
                                {{ Str::limit($log->user_agent, 50) }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-zinc-500">
                                {{ $log->accessed_at?->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <flux:icon name="eye" class="size-10 text-zinc-300 dark:text-zinc-600" />
                                    <flux:text class="text-zinc-500">Belum ada log akses.</flux:text>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
