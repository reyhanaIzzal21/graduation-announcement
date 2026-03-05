<div>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <flux:heading size="xl">Data Siswa</flux:heading>
            <flux:text class="mt-1">Kelola data siswa dan status kelulusan</flux:text>
        </div>
        <div class="flex gap-2">
            <flux:button wire:click="openAddModal" variant="primary" icon="plus">
                Tambah Siswa
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

    {{-- Import Section --}}
    <div class="mb-6 rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="flex items-center gap-3 mb-4">
            <flux:icon name="arrow-up-tray" class="size-5 text-zinc-500" />
            <flux:heading size="lg">Import Data Excel/CSV</flux:heading>
        </div>
        <flux:text class="mb-4 text-sm">
            Format kolom: <strong>NISN, NIS, Nama, Tanggal Lahir, Kelas, Status, Nilai</strong>
            <br>Header harus menggunakan: <code class="text-xs bg-zinc-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">nisn,
                nis, nama, tanggal_lahir, kelas, status, nilai</code>
        </flux:text>
        <form wire:submit="importExcel" class="flex flex-col gap-4 sm:flex-row sm:items-end">
            <div class="flex-1">
                <input type="file" wire:model="file" accept=".xlsx,.xls,.csv"
                    class="block w-full text-sm text-zinc-500 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-500/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-600 hover:file:bg-blue-500/20 dark:file:text-blue-400" />
            </div>
            <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="importExcel">Import</span>
                <span wire:loading wire:target="importExcel">Mengimport...</span>
            </flux:button>
        </form>
        @if ($importMessage)
            <div
                class="mt-4 rounded-xl p-3 text-sm {{ $importMessageType === 'success' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-400' }}">
                {{ $importMessage }}
            </div>
        @endif
        @error('file')
            <div class="mt-2 text-sm text-red-500">{{ $message }}</div>
        @enderror
    </div>

    {{-- Filters --}}
    <div class="mb-4 flex flex-col gap-3 sm:flex-row">
        <div class="flex-1">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Cari nama, NISN, atau NIS..."
                icon="magnifying-glass" />
        </div>
        <flux:select wire:model.live="filterStatus" class="w-full sm:w-48">
            <option value="">Semua Status</option>
            <option value="lulus">Lulus</option>
            <option value="tidak_lulus">Tidak Lulus</option>
        </flux:select>
        @if ($students->total() > 0)
            <flux:button wire:click="deleteAll" wire:confirm="Yakin ingin menghapus SEMUA data siswa?" variant="danger"
                size="sm" icon="trash">
                Hapus Semua
            </flux:button>
        @endif
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
                            NISN</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Kelas</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Rata-rata</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Token</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">
                    @forelse($students as $i => $student)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-zinc-500">
                                {{ $students->firstItem() + $i }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm font-mono text-zinc-900 dark:text-white">
                                {{ $student->nisn }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-zinc-900 dark:text-white">
                                {{ $student->name }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-zinc-500">{{ $student->class_name }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3">
                                @if ($student->graduation?->status === 'lulus')
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-emerald-500/10 px-2.5 py-1 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Lulus
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-red-500/10 px-2.5 py-1 text-xs font-semibold text-red-600 dark:text-red-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                        Tidak Lulus
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-zinc-500">
                                {{ $student->graduation?->final_score ?? '-' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm font-mono text-zinc-500">
                                {{ $student->graduation?->token ?? '-' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <flux:button href="{{ route('admin.grades', $student->id) }}" variant="ghost"
                                        size="xs" icon="academic-cap" wire:navigate />
                                    <flux:button wire:click="editStudent({{ $student->id }})" variant="ghost"
                                        size="xs" icon="pencil" />
                                    <flux:button wire:click="deleteStudent({{ $student->id }})"
                                        wire:confirm="Hapus data {{ $student->name }}?" variant="ghost" size="xs"
                                        icon="trash" class="text-red-500! hover:text-red-600!" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <flux:icon name="users" class="size-10 text-zinc-300 dark:text-zinc-600" />
                                    <flux:text class="text-zinc-500">Belum ada data siswa. Import atau tambah data siswa
                                        terlebih dahulu.</flux:text>
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
        {{ $students->links() }}
    </div>

    {{-- Add/Edit Modal --}}
    @if ($showAddModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
            wire:click.self="$set('showAddModal', false)">
            <div
                class="w-full max-w-lg rounded-2xl border border-zinc-200 bg-white p-6 shadow-xl dark:border-zinc-700 dark:bg-zinc-900 mx-4">
                <flux:heading size="lg" class="mb-6">
                    {{ $editingStudentId ? 'Edit Data Siswa' : 'Tambah Siswa Baru' }}
                </flux:heading>

                <form wire:submit="saveStudent" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <flux:field>
                            <flux:label>NISN</flux:label>
                            <flux:input wire:model="formNisn" placeholder="0012345678" />
                            @error('formNisn')
                                <flux:text class="text-red-500 text-xs">{{ $message }}</flux:text>
                            @enderror
                        </flux:field>
                        <flux:field>
                            <flux:label>NIS</flux:label>
                            <flux:input wire:model="formNis" placeholder="12345" />
                        </flux:field>
                    </div>

                    <flux:field>
                        <flux:label>Nama Lengkap</flux:label>
                        <flux:input wire:model="formName" placeholder="Nama siswa" />
                        @error('formName')
                            <flux:text class="text-red-500 text-xs">{{ $message }}</flux:text>
                        @enderror
                    </flux:field>

                    <div class="grid grid-cols-2 gap-4">
                        <flux:field>
                            <flux:label>Tanggal Lahir</flux:label>
                            <flux:input type="date" wire:model="formBirthDate" />
                            @error('formBirthDate')
                                <flux:text class="text-red-500 text-xs">{{ $message }}</flux:text>
                            @enderror
                        </flux:field>
                        <flux:field>
                            <flux:label>Kelas</flux:label>
                            <flux:input wire:model="formClassName" placeholder="XII RPL 1" />
                            @error('formClassName')
                                <flux:text class="text-red-500 text-xs">{{ $message }}</flux:text>
                            @enderror
                        </flux:field>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <flux:button wire:click="$set('showAddModal', false)" variant="ghost">Batal</flux:button>
                        <flux:button type="submit" variant="primary">
                            {{ $editingStudentId ? 'Simpan Perubahan' : 'Tambah Siswa' }}
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
