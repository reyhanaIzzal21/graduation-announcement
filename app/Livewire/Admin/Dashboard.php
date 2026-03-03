<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use App\Models\Graduation;
use App\Models\AccessLog;
use App\Models\Setting;
use Livewire\Component;

class Dashboard extends Component
{
    public int $totalStudents = 0;
    public int $totalGraduated = 0;
    public int $totalNotGraduated = 0;
    public float $graduationPercentage = 0;
    public int $totalAccessLogs = 0;
    public ?string $announcementDate = null;

    public function mount(): void
    {
        $this->totalStudents = Student::count();
        $this->totalGraduated = Graduation::where('status', 'lulus')->count();
        $this->totalNotGraduated = Graduation::where('status', 'tidak_lulus')->count();
        $this->graduationPercentage = $this->totalStudents > 0
            ? round(($this->totalGraduated / $this->totalStudents) * 100, 1)
            : 0;
        $this->totalAccessLogs = AccessLog::count();
        $this->announcementDate = Setting::get('announcement_date');
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
