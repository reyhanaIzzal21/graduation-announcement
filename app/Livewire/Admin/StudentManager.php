<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use App\Models\Graduation;
use App\Imports\StudentsImport;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class StudentManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public string $filterStatus = '';
    public $file;

    // Form fields for manual add
    public bool $showAddModal = false;
    public string $formNisn = '';
    public string $formNis = '';
    public string $formName = '';
    public string $formBirthDate = '';
    public string $formClassName = '';
    public ?int $editingStudentId = null;

    // Import result
    public ?string $importMessage = null;
    public string $importMessageType = 'success';

    protected function rules(): array
    {
        $nisnRule = 'required|unique:students,nisn';
        if ($this->editingStudentId) {
            $nisnRule = 'required|unique:students,nisn,' . $this->editingStudentId;
        }

        return [
            'formNisn' => $nisnRule,
            'formName' => 'required|min:2',
            'formBirthDate' => 'required|date',
            'formClassName' => 'required',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function openAddModal(): void
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function editStudent(int $id): void
    {
        $student = Student::findOrFail($id);
        $this->editingStudentId = $student->id;
        $this->formNisn = $student->nisn;
        $this->formNis = $student->nis ?? '';
        $this->formName = $student->name;
        $this->formBirthDate = $student->birth_date->format('Y-m-d');
        $this->formClassName = $student->class_name;
        $this->showAddModal = true;
    }

    public function saveStudent(): void
    {
        $this->validate();

        $isNew = !$this->editingStudentId;

        $student = Student::updateOrCreate(
            ['id' => $this->editingStudentId],
            [
                'nisn' => $this->formNisn,
                'nis' => $this->formNis ?: null,
                'name' => $this->formName,
                'birth_date' => $this->formBirthDate,
                'class_name' => $this->formClassName,
            ]
        );

        // Create graduation record if new student (without score yet)
        if ($isNew) {
            Graduation::firstOrCreate(
                ['student_id' => $student->id],
                ['status' => 'tidak_lulus']
            );
        }

        $this->showAddModal = false;
        $this->resetForm();
        session()->flash('success', $this->editingStudentId ? 'Data siswa berhasil diperbarui.' : 'Data siswa berhasil ditambahkan.');
    }

    public function deleteStudent(int $id): void
    {
        Student::findOrFail($id)->delete();
        session()->flash('success', 'Data siswa berhasil dihapus.');
    }

    public function importExcel(): void
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $import = new StudentsImport();
            Excel::import($import, $this->file->getRealPath());

            $this->importMessage = "Import berhasil! {$import->imported} data diimport, {$import->skipped} data dilewati (duplikat).";
            $this->importMessageType = 'success';
        } catch (\Exception $e) {
            $this->importMessage = 'Import gagal: ' . $e->getMessage();
            $this->importMessageType = 'error';
        }

        $this->file = null;
        $this->resetPage();
    }

    public function deleteAll(): void
    {
        Student::query()->delete();
        session()->flash('success', 'Semua data siswa berhasil dihapus.');
        $this->resetPage();
    }

    private function resetForm(): void
    {
        $this->editingStudentId = null;
        $this->formNisn = '';
        $this->formNis = '';
        $this->formName = '';
        $this->formBirthDate = '';
        $this->formClassName = '';
        $this->resetValidation();
    }

    public function render()
    {
        $query = Student::with('graduation')
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
            ->orderBy('name');

        return view('livewire.admin.student-manager', [
            'students' => $query->paginate(15),
        ])->layout('layouts.app', ['title' => 'Data Siswa']);
    }
}
