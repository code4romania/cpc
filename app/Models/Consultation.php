<?php

namespace App\Models;

use App\Enums\ConsultationStatus;
use App\Enums\ConsultationUrgency;
use Database\Factories\ConsultationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'subject',
    'description',
    'urgency',
    'status',
    'category',
    'assigned_to',
])]
class Consultation extends Model
{
    /** @use HasFactory<ConsultationFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => ConsultationStatus::class,
            'urgency' => ConsultationUrgency::class,
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<User, $this> */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /** @return HasMany<ConsultationMessage, $this> */
    public function messages(): HasMany
    {
        return $this->hasMany(ConsultationMessage::class);
    }
}
