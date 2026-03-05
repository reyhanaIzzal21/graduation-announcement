<?php

namespace App\Livewire\Admin;

use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class SubjectManager extends Component
{
    use WithPagination;

    public string $search = '';

    // Form fields
    public bool $showModal = false;
    public string $formName = '';
    public ?int $editingId = null;

    protected function rules(): array
    {
        $uniqueRule = 'required|unique:subjects,name';
        if ($this->editingId) {
            $uniqueRule = 'required|unique:subjects,name,' . $this->editingId;
        }

        return [
            'formName' => $uniqueRule,
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openModal(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function editSubject(int $id): void
    {
        $subject = Subject::findOrFail($id);
        $this->editingId = $subject->id;
        $this->formName = $subject->name;
        $this->showModal = true;
    }

    public function saveSubject(): void
    {
        $this->validate();

        Subject::updateOrCreate(
            ['id' => $this->editingId],
            ['name' => $this->formName]
        );

        $this->showModal = false;
        $this->resetForm();
        session()->flash('success', $this->editingId ? 'Mata pelajaran berhasil diperbarui.' : 'Mata pelajaran berhasil ditambahkan.');
    }

    public function deleteSubject(int $id): void
    {
        $subject = Subject::findOrFail($id);
        $gradeCount = $subject->grades()->count();

        if ($gradeCount > 0) {
            session()->flash('error', "Tidak dapat menghapus \"{$subject->name}\" karena masih memiliki {$gradeCount} data nilai.");
            return;
        }

        $subject->delete();
        session()->flash('success', 'Mata pelajaran berhasil dihapus.');
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->formName = '';
        $this->resetValidation();
    }

    public function render()
    {
        $subjects = Subject::withCount('grades')
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%");
            })
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.admin.subject-manager', [
            'subjects' => $subjects,
        ])->layout('layouts.app', ['title' => 'Mata Pelajaran']);
    }
}
