<div>
    <div class="mb-6">
        <flux:heading size="xl">Pengaturan Sistem</flux:heading>
        <flux:text class="mt-1">Konfigurasi sekolah, pengumuman, dan template pesan</flux:text>
    </div>

    @if (session('success'))
        <div
            class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="saveSettings" class="space-y-6">
        {{-- Informasi Sekolah --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center gap-3 mb-6">
                <flux:icon name="building-office-2" class="size-5 text-zinc-500" />
                <flux:heading size="lg">Informasi Sekolah</flux:heading>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <flux:field>
                    <flux:label>Nama Sekolah</flux:label>
                    <flux:input wire:model="school_name" placeholder="SMK Negeri 1 ..." />
                    @error('school_name')
                        <flux:text class="text-red-500 text-xs">{{ $message }}</flux:text>
                    @enderror
                </flux:field>
                <flux:field>
                    <flux:label>NPSN</flux:label>
                    <flux:input wire:model="school_npsn" placeholder="12345678" />
                </flux:field>
                <flux:field class="md:col-span-2">
                    <flux:label>Alamat Sekolah</flux:label>
                    <flux:input wire:model="school_address" placeholder="Jl. Pendidikan No. 1 ..." />
                </flux:field>
            </div>
        </div>

        {{-- Kepala Sekolah --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center gap-3 mb-6">
                <flux:icon name="user-circle" class="size-5 text-zinc-500" />
                <flux:heading size="lg">Kepala Sekolah</flux:heading>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <flux:field>
                    <flux:label>Nama Kepala Sekolah</flux:label>
                    <flux:input wire:model="principal_name" placeholder="Drs. Nama, M.Pd." />
                    @error('principal_name')
                        <flux:text class="text-red-500 text-xs">{{ $message }}</flux:text>
                    @enderror
                </flux:field>
                <flux:field>
                    <flux:label>NIP</flux:label>
                    <flux:input wire:model="principal_nip" placeholder="196501011990011001" />
                </flux:field>
            </div>
        </div>

        {{-- Waktu Pengumuman --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center gap-3 mb-6">
                <flux:icon name="calendar-days" class="size-5 text-zinc-500" />
                <flux:heading size="lg">Waktu Pengumuman</flux:heading>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <flux:field>
                    <flux:label>Tanggal</flux:label>
                    <flux:input type="date" wire:model="announcement_date" />
                    @error('announcement_date')
                        <flux:text class="text-red-500 text-xs">{{ $message }}</flux:text>
                    @enderror
                </flux:field>
                <flux:field>
                    <flux:label>Jam</flux:label>
                    <flux:input type="time" wire:model="announcement_time" />
                    @error('announcement_time')
                        <flux:text class="text-red-500 text-xs">{{ $message }}</flux:text>
                    @enderror
                </flux:field>
            </div>
        </div>

        {{-- Upload Logo & Tanda Tangan --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center gap-3 mb-6">
                <flux:icon name="photo" class="size-5 text-zinc-500" />
                <flux:heading size="lg">Logo & Tanda Tangan</flux:heading>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <flux:label class="mb-2">Logo Sekolah</flux:label>
                    @if ($current_logo)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $current_logo) }}" alt="Logo"
                                class="h-20 w-auto rounded-lg border border-zinc-200 dark:border-zinc-700 p-2 bg-white">
                        </div>
                    @endif
                    <input type="file" wire:model="logo_upload" accept="image/*"
                        class="block w-full text-sm text-zinc-500 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-500/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-600 hover:file:bg-blue-500/20 dark:file:text-blue-400" />
                    @error('logo_upload')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <flux:label class="mb-2">Tanda Tangan Digital</flux:label>
                    @if ($current_signature)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $current_signature) }}" alt="Tanda Tangan"
                                class="h-20 w-auto rounded-lg border border-zinc-200 dark:border-zinc-700 p-2 bg-white">
                        </div>
                    @endif
                    <input type="file" wire:model="signature_upload" accept="image/*"
                        class="block w-full text-sm text-zinc-500 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-500/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-600 hover:file:bg-blue-500/20 dark:file:text-blue-400" />
                    @error('signature_upload')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Template Pesan --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center gap-3 mb-6">
                <flux:icon name="chat-bubble-left-right" class="size-5 text-zinc-500" />
                <flux:heading size="lg">Template Pesan</flux:heading>
            </div>
            <div class="space-y-4">
                <flux:field>
                    <flux:label>Pesan Selamat (untuk siswa LULUS)</flux:label>
                    <flux:textarea wire:model="congratulation_message" rows="3"
                        placeholder="Selamat! Anda dinyatakan LULUS..." />
                    @error('congratulation_message')
                        <flux:text class="text-red-500 text-xs">{{ $message }}</flux:text>
                    @enderror
                </flux:field>
                <flux:field>
                    <flux:label>Pesan Simpatik (untuk siswa TIDAK LULUS)</flux:label>
                    <flux:textarea wire:model="condolence_message" rows="3"
                        placeholder="Mohon maaf, berdasarkan hasil evaluasi..." />
                    @error('condolence_message')
                        <flux:text class="text-red-500 text-xs">{{ $message }}</flux:text>
                    @enderror
                </flux:field>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">
                <span wire:loading.remove wire:target="saveSettings">Simpan Pengaturan</span>
                <span wire:loading wire:target="saveSettings">Menyimpan...</span>
            </flux:button>
        </div>
    </form>
</div>
