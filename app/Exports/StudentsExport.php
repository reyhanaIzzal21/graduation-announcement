<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected string $search;
    protected string $filterStatus;

    public function __construct(string $search = '', string $filterStatus = '')
    {
        $this->search = $search;
        $this->filterStatus = $filterStatus;
    }

    public function collection()
    {
        return Student::with(['graduation', 'grades.subject'])
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('nisn', 'like', "%{$this->search}%")
                        ->orWhere('nis', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterStatus, function ($q) {
                $q->whereHas('graduation', function ($q) {
                    $q->where('status', $this->filterStatus);
                });
            })
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NISN',
            'NIS',
            'Nama',
            'Tanggal Lahir',
            'Kelas',
            'Status',
            'Rata-rata Nilai',
        ];
    }

    public function map($student): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $student->nisn,
            $student->nis ?? '-',
            $student->name,
            $student->birth_date?->format('d/m/Y') ?? '-',
            $student->class_name,
            $student->graduation?->status === 'lulus' ? 'Lulus' : 'Tidak Lulus',
            $student->graduation?->final_score ? number_format($student->graduation->final_score, 2) : '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 15,
            'C' => 12,
            'D' => 30,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
        ];
    }
}
