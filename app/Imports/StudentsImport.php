<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Graduation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Support\Carbon;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;

    public int $imported = 0;
    public int $skipped = 0;

    public function model(array $row)
    {
        // Normalize status
        $statusRaw = strtolower(trim($row['status'] ?? 'tidak_lulus'));
        $status = in_array($statusRaw, ['lulus', 'ya', 'yes', 'y', '1']) ? 'lulus' : 'tidak_lulus';

        // Parse birth date - support multiple formats
        $birthDate = null;
        if (!empty($row['tanggal_lahir'])) {
            try {
                $birthDate = Carbon::parse($row['tanggal_lahir'])->format('Y-m-d');
            } catch (\Exception $e) {
                $birthDate = null;
            }
        }

        // Check if student already exists
        $existing = Student::where('nisn', $row['nisn'])->first();
        if ($existing) {
            $this->skipped++;
            return null;
        }

        $student = Student::create([
            'nisn' => $row['nisn'],
            'nis' => $row['nis'] ?? null,
            'name' => $row['nama'],
            'birth_date' => $birthDate,
            'class_name' => $row['kelas'] ?? '-',
        ]);

        Graduation::create([
            'student_id' => $student->id,
            'status' => $status,
            'final_score' => $row['nilai'] ?? null,
        ]);

        $this->imported++;

        return null; // We already saved manually
    }

    public function rules(): array
    {
        return [
            'nisn' => 'required',
            'nama' => 'required',
        ];
    }
}
