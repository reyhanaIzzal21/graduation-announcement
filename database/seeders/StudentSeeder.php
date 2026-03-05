<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Graduation;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = Subject::all();

        $students = [
            [
                'nisn' => '0012345001',
                'nis' => '10001',
                'name' => 'Ahmad Fauzi',
                'birth_date' => '2008-03-15',
                'class_name' => 'XII RPL 1',
                'scores' => [85, 78, 82, 75, 80, 77, 88, 90, 76, 85, 82, 88],
            ],
            [
                'nisn' => '0012345002',
                'nis' => '10002',
                'name' => 'Siti Nurhaliza',
                'birth_date' => '2008-07-22',
                'class_name' => 'XII RPL 1',
                'scores' => [92, 88, 90, 86, 89, 91, 95, 93, 87, 90, 94, 92],
            ],
            [
                'nisn' => '0012345003',
                'nis' => '10003',
                'name' => 'Budi Santoso',
                'birth_date' => '2008-01-10',
                'class_name' => 'XII RPL 2',
                'scores' => [70, 65, 68, 60, 72, 66, 75, 78, 64, 70, 73, 71],
            ],
            [
                'nisn' => '0012345004',
                'nis' => '10004',
                'name' => 'Dewi Rahayu',
                'birth_date' => '2008-11-05',
                'class_name' => 'XII RPL 2',
                'scores' => [88, 85, 87, 82, 84, 86, 90, 89, 83, 87, 91, 85],
            ],
            [
                'nisn' => '0012345005',
                'nis' => '10005',
                'name' => 'Rizki Pratama',
                'birth_date' => '2008-05-18',
                'class_name' => 'XII TKJ 1',
                'scores' => [55, 60, 50, 45, 58, 52, 65, 70, 48, 55, 62, 58],
            ],
            [
                'nisn' => '0012345006',
                'nis' => '10006',
                'name' => 'Anisa Putri',
                'birth_date' => '2008-09-28',
                'class_name' => 'XII TKJ 1',
                'scores' => [80, 82, 79, 76, 81, 78, 85, 84, 77, 82, 86, 80],
            ],
            [
                'nisn' => '0012345007',
                'nis' => '10007',
                'name' => 'Muhammad Ilham',
                'birth_date' => '2008-02-14',
                'class_name' => 'XII TKJ 2',
                'scores' => [73, 70, 75, 68, 71, 69, 78, 80, 67, 74, 77, 72],
            ],
            [
                'nisn' => '0012345008',
                'nis' => '10008',
                'name' => 'Putri Amelia',
                'birth_date' => '2008-06-30',
                'class_name' => 'XII TKJ 2',
                'scores' => [95, 92, 94, 90, 93, 91, 96, 95, 89, 93, 97, 94],
            ],
            [
                'nisn' => '0012345009',
                'nis' => '10009',
                'name' => 'Dimas Aditya',
                'birth_date' => '2008-04-08',
                'class_name' => 'XII MM 1',
                'scores' => [62, 58, 55, 50, 60, 53, 68, 72, 52, 60, 65, 59],
            ],
            [
                'nisn' => '0012345010',
                'nis' => '10010',
                'name' => 'Rina Wulandari',
                'birth_date' => '2008-12-20',
                'class_name' => 'XII MM 1',
                'scores' => [87, 84, 86, 81, 83, 85, 89, 88, 82, 86, 90, 84],
            ],
        ];

        foreach ($students as $data) {
            $scores = $data['scores'];
            unset($data['scores']);

            $student = Student::create($data);

            // Create grades per subject
            $totalScore = 0;
            $count = 0;
            foreach ($subjects as $i => $subject) {
                $score = $scores[$i] ?? rand(60, 95);
                Grade::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'score' => $score,
                ]);
                $totalScore += $score;
                $count++;
            }

            // Calculate final score and create graduation
            $finalScore = $count > 0 ? round($totalScore / $count, 2) : 0;
            Graduation::create([
                'student_id' => $student->id,
                'final_score' => $finalScore,
                'status' => $finalScore >= 70 ? 'lulus' : 'tidak_lulus',
            ]);
        }
    }
}
