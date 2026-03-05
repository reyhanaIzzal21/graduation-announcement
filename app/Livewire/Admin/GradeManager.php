<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Graduation;
use Livewire\Component;

class GradeManager extends Component
{
    public Student $student;
    public array $scores = [];
    public ?string $successMessage = null;

    public function mount(Student $student): void
    {
        $this->student = $student->load(['graduation', 'grades.subject']);

        // Load existing scores or initialize empty for all subjects
        $subjects = Subject::orderBy('name')->get();
        foreach ($subjects as $subject) {
            $grade = $this->student->grades->firstWhere('subject_id', $subject->id);
            $this->scores[$subject->id] = $grade ? (string) $grade->score : '';
        }
    }

    public function saveGrades(): void
    {
        // Validate all scores
        $rules = [];
        $subjects = Subject::orderBy('name')->get();
        foreach ($subjects as $subject) {
            $rules["scores.{$subject->id}"] = 'nullable|numeric|min:0|max:100';
        }

        $this->validate($rules, [
            'scores.*.numeric' => 'Nilai harus berupa angka.',
            'scores.*.min' => 'Nilai minimal 0.',
            'scores.*.max' => 'Nilai maksimal 100.',
        ]);

        // Save/update grades
        foreach ($this->scores as $subjectId => $score) {
            if ($score !== '' && $score !== null) {
                Grade::updateOrCreate(
                    [
                        'student_id' => $this->student->id,
                        'subject_id' => $subjectId,
                    ],
                    [
                        'score' => (float) $score,
                    ]
                );
            } else {
                // Remove grade if score is empty
                Grade::where('student_id', $this->student->id)
                    ->where('subject_id', $subjectId)
                    ->delete();
            }
        }

        // Recalculate final_score
        $this->student->load('grades');
        $avgScore = $this->student->averageScore();

        // Update or create graduation record
        $graduation = Graduation::updateOrCreate(
            ['student_id' => $this->student->id],
            [
                'final_score' => $avgScore,
                'status' => $avgScore !== null && $avgScore >= 70 ? 'lulus' : 'tidak_lulus',
            ]
        );

        $this->student->load('graduation');
        $this->successMessage = 'Nilai berhasil disimpan. Rata-rata: ' . ($avgScore !== null ? number_format($avgScore, 2) : '-');
    }

    public function render()
    {
        $subjects = Subject::orderBy('name')->get();

        return view('livewire.admin.grade-manager', [
            'subjects' => $subjects,
        ])->layout('layouts.app', ['title' => 'Kelola Nilai - ' . $this->student->name]);
    }
}
