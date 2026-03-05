<div>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <flux:heading size="xl">Mata Pelajaran</flux:heading>
            <flux:text class="mt-1">Kelola daftar mata pelajaran</flux:text>
        </div>
        <div class="flex gap-2">
            <flux:button wire:click="openModal" variant="primary" icon="plus">
                Tambah Mata Pelajaran
            </flux:button>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div
            class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div
            class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    {{-- Search --}}
    <div class="mb-4">
        <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari mata pelajaran..."
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
                            Nama Mata Pelajaran</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Jumlah Nilai</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">
                    @forelse($subjects as $i => $subject)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-zinc-500">
                                {{ $subjects->firstItem() + $i }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-zinc-900 dark:text-white">
                                {{ $subject->name }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-zinc-500">
                                {{ $subject->grades_count }} data</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <flux:button wire:click="editSubject({{ $subject->id }})" variant="ghost"
                                        size="xs" icon="pencil" />
                                    <flux:button wire:click="deleteSubject({{ $subject->id }})"
                                        wire:confirm="Hapus mata pelajaran {{ $subject->name }}?" variant="ghost"
                                        size="xs" icon="trash" class="text-red-500! hover:text-red-600!" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <flux:icon name="book-open" class="size-10 text-zinc-300 dark:text-zinc-600" />
                                    <flux:text class="text-zinc-500">Belum ada mata pelajaran. Tambahkan mata
                                        pelajaran terlebih dahulu.</flux:text>
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
        {{ $subjects->links() }}
    </div>

    {{-- Add/Edit Modal --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
            wire:click.self="$set('showModal', false)">
            <div
                class="w-full max-w-md rounded-2xl border border-zinc-200 bg-white p-6 shadow-xl dark:border-zinc-700 dark:bg-zinc-900 mx-4">
                <flux:heading size="lg" class="mb-6">
                    {{ $editingId ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' }}
                </flux:heading>

                <form wire:submit="saveSubject" class="space-y-4">
                    <flux:field>
                        <flux:label>Nama Mata Pelajaran</flux:label>
                        <flux:input wire:model="formName" placeholder="Contoh: Matematika" />
                        @error('formName')
                            <flux:text class="text-red-500 text-xs">{{ $message }}</flux:text>
                        @enderror
                    </flux:field>

                    <div class="flex justify-end gap-3 pt-4">
                        <flux:button wire:click="$set('showModal', false)" variant="ghost">Batal</flux:button>
                        <flux:button type="submit" variant="primary">
                            {{ $editingId ? 'Simpan Perubahan' : 'Tambah' }}
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
