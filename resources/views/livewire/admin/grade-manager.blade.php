<div>
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <flux:button href="{{ route('admin.students') }}" variant="ghost" size="sm" icon="arrow-left"
                wire:navigate>
                Kembali
            </flux:button>
        </div>
        <flux:heading size="xl">Kelola Nilai Siswa</flux:heading>
        <flux:text class="mt-1">Input nilai per mata pelajaran</flux:text>
    </div>

    {{-- Student Info Card --}}
    <div class="mb-6 rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <flux:text class="text-xs text-zinc-500 uppercase tracking-wider">Nama</flux:text>
                <p class="mt-1 font-semibold text-zinc-900 dark:text-white">{{ $student->name }}</p>
            </div>
            <div>
                <flux:text class="text-xs text-zinc-500 uppercase tracking-wider">NISN</flux:text>
                <p class="mt-1 font-mono font-semibold text-zinc-900 dark:text-white">{{ $student->nisn }}</p>
            </div>
            <div>
                <flux:text class="text-xs text-zinc-500 uppercase tracking-wider">Kelas</flux:text>
                <p class="mt-1 font-semibold text-zinc-900 dark:text-white">{{ $student->class_name }}</p>
            </div>
            <div>
                <flux:text class="text-xs text-zinc-500 uppercase tracking-wider">Status</flux:text>
                @if ($student->graduation?->status === 'lulus')
                    <span
                        class="mt-1 inline-flex items-center gap-1 rounded-full bg-emerald-500/10 px-2.5 py-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Lulus ({{ $student->graduation->final_score ?? '-' }})
                    </span>
                @elseif($student->graduation)
                    <span
                        class="mt-1 inline-flex items-center gap-1 rounded-full bg-red-500/10 px-2.5 py-1 text-xs font-semibold text-red-600 dark:text-red-400">
                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                        Tidak Lulus ({{ $student->graduation->final_score ?? '-' }})
                    </span>
                @else
                    <span class="mt-1 inline-flex text-xs text-zinc-400">Belum ada data</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Success Message --}}
    @if ($successMessage)
        <div
            class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
            {{ $successMessage }}
        </div>
    @endif

    {{-- Grades Form --}}
    @if ($subjects->isEmpty())
        <div class="rounded-2xl border border-zinc-200 bg-white p-12 text-center dark:border-zinc-700 dark:bg-zinc-900">
            <flux:icon name="book-open" class="mx-auto size-10 text-zinc-300 dark:text-zinc-600 mb-3" />
            <flux:text class="text-zinc-500">Belum ada mata pelajaran. <a href="{{ route('admin.subjects') }}"
                    class="text-blue-500 underline" wire:navigate>Tambahkan mata pelajaran</a> terlebih
                dahulu.</flux:text>
        </div>
    @else
        <form wire:submit="saveGrades">
            <div class="overflow-hidden rounded-2xl border border-zinc-200 dark:border-zinc-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                                    No</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                                    Mata Pelajaran</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 w-48">
                                    Nilai (0-100)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">
                            @foreach ($subjects as $i => $subject)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="whitespace-nowrap px-4 py-3 text-sm text-zinc-500">{{ $i + 1 }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-4 py-3 text-sm font-medium text-zinc-900 dark:text-white">
                                        {{ $subject->name }}</td>
                                    <td class="whitespace-nowrap px-4 py-3">
                                        <flux:input type="number" wire:model="scores.{{ $subject->id }}"
                                            step="0.01" min="0" max="100" placeholder="0.00"
                                            class="w-32" />
                                        @error("scores.{$subject->id}")
                                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 flex justify-end gap-3">
                <flux:button href="{{ route('admin.students') }}" variant="ghost" wire:navigate>Batal</flux:button>
                <flux:button type="submit" variant="primary" icon="check">
                    Simpan Nilai
                </flux:button>
            </div>
        </form>
    @endif
</div>
