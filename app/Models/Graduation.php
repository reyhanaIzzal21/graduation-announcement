<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Graduation extends Model
{
    protected $fillable = [
        'student_id',
        'status',
        'gpa',
        'token',
        'message_id',
    ];

    protected function casts(): array
    {
        return [
            'gpa' => 'decimal:2',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Graduation $graduation) {
            if (empty($graduation->token)) {
                $graduation->token = self::generateUniqueToken();
            }
        });
    }

    public static function generateUniqueToken(): string
    {
        do {
            $token = strtoupper(Str::random(6));
        } while (self::where('token', $token)->exists());

        return $token;
    }
}
