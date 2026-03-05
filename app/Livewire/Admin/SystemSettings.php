<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class SystemSettings extends Component
{
    use WithFileUploads;

    public string $school_name = '';
    public string $school_npsn = '';
    public string $school_address = '';
    public string $principal_name = '';
    public string $principal_nip = '';
    public string $announcement_date = '';
    public string $announcement_time = '';
    public string $congratulation_message = '';
    public string $condolence_message = '';
    public $logo_upload;
    public $signature_upload;
    public ?string $current_logo = null;
    public ?string $current_signature = null;

    public function mount(): void
    {
        $this->school_name = Setting::get('school_name', '');
        $this->school_npsn = Setting::get('school_npsn', '');
        $this->school_address = Setting::get('school_address', '');
        $this->principal_name = Setting::get('principal_name', '');
        $this->principal_nip = Setting::get('principal_nip', '');
        $this->congratulation_message = Setting::get('congratulation_message', '');
        $this->condolence_message = Setting::get('condolence_message', '');
        $this->current_logo = Setting::get('logo_path');
        $this->current_signature = Setting::get('signature_path');

        $announcementDateTime = Setting::get('announcement_date');
        if ($announcementDateTime) {
            $dt = \Carbon\Carbon::parse($announcementDateTime);
            $this->announcement_date = $dt->format('Y-m-d');
            $this->announcement_time = $dt->format('H:i');
        }
    }

    public function saveSettings(): void
    {
        $this->validate([
            'school_name' => 'required|min:3',
            'principal_name' => 'required|min:3',
            'announcement_date' => 'required|date',
            'announcement_time' => 'required',
            'congratulation_message' => 'required',
            'condolence_message' => 'required',
            'logo_upload' => 'nullable|image|max:2048',
            'signature_upload' => 'nullable|image|max:2048',
        ]);

        Setting::set('school_name', $this->school_name);
        Setting::set('school_npsn', $this->school_npsn);
        Setting::set('school_address', $this->school_address);
        Setting::set('principal_name', $this->principal_name);
        Setting::set('principal_nip', $this->principal_nip);
        Setting::set('congratulation_message', $this->congratulation_message);
        Setting::set('condolence_message', $this->condolence_message);

        // Combine date and time, explicitly in WIB timezone
        $dateTime = \Carbon\Carbon::parse(
            $this->announcement_date . ' ' . $this->announcement_time . ':00',
            'Asia/Jakarta'
        )->format('Y-m-d H:i:s');
        Setting::set('announcement_date', $dateTime);

        // Handle logo upload
        if ($this->logo_upload) {
            $path = $this->logo_upload->store('uploads', 'public');
            Setting::set('logo_path', $path);
            $this->current_logo = $path;
        }

        // Handle signature upload
        if ($this->signature_upload) {
            $path = $this->signature_upload->store('uploads', 'public');
            Setting::set('signature_path', $path);
            $this->current_signature = $path;
        }

        $this->logo_upload = null;
        $this->signature_upload = null;

        session()->flash('success', 'Pengaturan berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.admin.system-settings')
            ->layout('layouts.app', ['title' => 'Pengaturan Sistem']);
    }
}
