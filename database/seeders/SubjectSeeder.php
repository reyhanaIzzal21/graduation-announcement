<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Fisika',
            'Kimia',
            'Biologi',
            'Pendidikan Agama',
            'Pendidikan Pancasila',
            'Sejarah Indonesia',
            'Pendidikan Jasmani',
            'Seni Budaya',
            'Informatika',
        ];

        foreach ($subjects as $name) {
            Subject::firstOrCreate(['name' => $name]);
        }
    }
}
