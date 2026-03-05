<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Hashids\Hashids;
use Illuminate\Http\Request;

class GraduationPdf extends Controller
{
    public function download(string $hash)
    {
        $hashids = new Hashids(config('app.key'), 10);
        $decoded = $hashids->decode($hash);

        if (empty($decoded)) {
            abort(404, 'Link tidak valid.');
        }

        $studentId = $decoded[0];
        $student = Student::with(['graduation', 'grades.subject'])->findOrFail($studentId);

        // Only allow download for graduated students
        if (!$student->graduation || $student->graduation->status !== 'lulus') {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh surat ini.');
        }

        $data = [
            'student' => $student,
            'graduation' => $student->graduation,
            'grades' => $student->grades->sortBy(fn($g) => $g->subject->name),
            'school_name' => Setting::get('school_name', 'Sekolah'),
            'school_npsn' => Setting::get('school_npsn', ''),
            'school_address' => Setting::get('school_address', ''),
            'principal_name' => Setting::get('principal_name', ''),
            'principal_nip' => Setting::get('principal_nip', ''),
            'logo_path' => Setting::get('logo_path'),
            'signature_path' => Setting::get('signature_path'),
        ];

        $pdf = Pdf::loadView('pdf.skl-pdf', $data)
            ->setPaper('a4', 'portrait');

        $filename = 'SKL_' . $student->nisn . '_' . str_replace(' ', '_', $student->name) . '.pdf';

        return $pdf->download($filename);
    }
}
