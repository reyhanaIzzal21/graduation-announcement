<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'school_name' => 'SMK Negeri 1 Contoh',
            'school_npsn' => '12345678',
            'principal_name' => 'Drs. Nama Kepala Sekolah, M.Pd.',
            'principal_nip' => '196501011990011001',
            'announcement_date' => now()->addDays(7)->format('Y-m-d H:i:s'),
            'logo_path' => null,
            'signature_path' => null,
            'congratulation_message' => 'Selamat! Anda dinyatakan LULUS dari SMK Negeri 1. Semoga ilmu yang telah diperoleh dapat bermanfaat untuk masa depan yang lebih cerah. Teruslah belajar dan berkarya!',
            'condolence_message' => 'Mohon maaf, berdasarkan hasil evaluasi, Anda dinyatakan belum lulus. Silakan menghubungi wali kelas atau pihak sekolah untuk informasi lebih lanjut mengenai langkah selanjutnya.',
            'school_address' => 'Jl. Pendidikan No. 1, Kota Contoh',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
