<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'nisn',
        'nis',
        'name',
        'birth_date',
        'class_name',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function graduation(): HasOne
    {
        return $this->hasOne(Graduation::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function accessLogs(): HasMany
    {
        return $this->hasMany(AccessLog::class);
    }

    /**
     * Calculate average score from all grades.
     */
    public function averageScore(): ?float
    {
        $avg = $this->grades()->avg('score');
        return $avg ? round($avg, 2) : null;
    }
}
