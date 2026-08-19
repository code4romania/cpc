<?php

namespace App\Models;

use App\Enums\ResourceType;
use App\Enums\SubmissionStatus;
use Database\Factories\ResourceSubmissionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'title',
    'description',
    'type',
    'category',
    'submitter_name',
    'submitter_email',
    'submitter_organization',
    'file_path',
    'external_url',
    'locale',
    'status',
    'rejection_reason',
    'reviewed_by',
    'reviewed_at',
    'resource_id',
])]
class ResourceSubmission extends Model
{
    /** @use HasFactory<ResourceSubmissionFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'type' => ResourceType::class,
            'status' => SubmissionStatus::class,
            'reviewed_at' => 'datetime',
        ];
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }
}
