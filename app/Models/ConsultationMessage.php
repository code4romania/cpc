<?php

namespace App\Models;

use Database\Factories\ConsultationMessageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'consultation_id',
    'user_id',
    'body',
    'is_expert',
])]
class ConsultationMessage extends Model
{
    /** @use HasFactory<ConsultationMessageFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_expert' => 'boolean',
        ];
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
