<?php

namespace App\Livewire\Student;

use App\Models\Student;
use App\Models\AccessLog;
use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\RateLimiter;
use Carbon\Carbon;

class SearchResult extends Component
{
    // Search form
    public string $nisn = '';
    public string $birth_date = '';

    // State management
    public string $step = 'search'; // search, result
    public ?array $studentData = null;
    public ?string $errorMessage = null;
    public int $attemptsRemaining = 3;
    public bool $isLocked = false;
    public int $lockoutSeconds = 0;

    // Announcement
    public bool $isAnnouncementTime = false;
    public ?string $announcementDate = null;

    public function mount(): void
    {
        $this->checkAnnouncementTime();
    }

    private function checkAnnouncementTime(): void
    {
        $this->announcementDate = Setting::get('announcement_date');
        if ($this->announcementDate) {
            $this->isAnnouncementTime = Carbon::parse($this->announcementDate)->isPast();
        } else {
            $this->isAnnouncementTime = false;
        }
    }

    public function search(): void
    {
        $this->errorMessage = null;

        // Check if announcement time has arrived
        $this->checkAnnouncementTime();
        if (!$this->isAnnouncementTime) {
            $this->errorMessage = 'Pengumuman belum dibuka. Silakan tunggu hingga waktu pengumuman.';
            return;
        }

        $this->validate([
            'nisn' => 'required|string|min:4',
            'birth_date' => 'required|date',
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.min' => 'NISN minimal 4 karakter.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
        ]);

        // Rate limiting
        $key = 'search:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $this->isLocked = true;
            $this->lockoutSeconds = $seconds;
            $this->errorMessage = "Terlalu banyak percobaan. Silakan coba lagi dalam {$seconds} detik.";
            return;
        }

        // Find student
        $student = Student::with('graduation')
            ->where('nisn', $this->nisn)
            ->whereDate('birth_date', $this->birth_date)
            ->first();

        if (!$student) {
            RateLimiter::hit($key, 300); // 5 minute decay
            $remaining = RateLimiter::remaining($key, 3);
            $this->attemptsRemaining = $remaining;
            $this->errorMessage = "Data tidak ditemukan. Pastikan NISN dan Tanggal Lahir sudah benar. Sisa percobaan: {$remaining}";
            return;
        }

        // Log access
        AccessLog::create([
            'student_id' => $student->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'accessed_at' => now(),
        ]);

        // Prepare student data for display
        $hashids = new \Hashids\Hashids(config('app.key'), 10);

        $this->studentData = [
            'id' => $student->id,
            'name' => $student->name,
            'nisn' => $student->nisn,
            'nis' => $student->nis,
            'class_name' => $student->class_name,
            'birth_date' => $student->birth_date->format('d F Y'),
            'status' => $student->graduation?->status ?? 'tidak_lulus',
            'gpa' => $student->graduation?->gpa,
            'token' => $student->graduation?->token,
            'download_hash' => $hashids->encode($student->id),
            'message' => $student->graduation?->status === 'lulus'
                ? Setting::get('congratulation_message', 'Selamat! Anda dinyatakan LULUS.')
                : Setting::get('condolence_message', 'Mohon maaf, Anda dinyatakan tidak lulus.'),
            'school_name' => Setting::get('school_name', 'Sekolah'),
        ];

        $this->step = 'result';

        // Clear rate limiter on success
        RateLimiter::clear($key);
    }

    public function resetSearch(): void
    {
        $this->step = 'search';
        $this->studentData = null;
        $this->nisn = '';
        $this->birth_date = '';
        $this->errorMessage = null;
    }

    public function render()
    {
        return view('livewire.student.search-result')
            ->layout('layouts.guest', ['title' => 'Cek Kelulusan']);
    }
}
