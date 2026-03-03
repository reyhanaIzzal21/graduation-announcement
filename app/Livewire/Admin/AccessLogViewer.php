<?php

namespace App\Livewire\Admin;

use App\Models\AccessLog;
use Livewire\Component;
use Livewire\WithPagination;

class AccessLogViewer extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function clearLogs(): void
    {
        AccessLog::query()->delete();
        session()->flash('success', 'Semua log akses berhasil dihapus.');
    }

    public function render()
    {
        $logs = AccessLog::with('student')
            ->when($this->search, function ($q) {
                $q->whereHas('student', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('nisn', 'like', "%{$this->search}%");
                });
            })
            ->orderByDesc('accessed_at')
            ->paginate(20);

        return view('livewire.admin.access-log-viewer', [
            'logs' => $logs,
        ])->layout('layouts.app', ['title' => 'Log Akses']);
    }
}
