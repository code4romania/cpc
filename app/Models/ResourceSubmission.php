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
    'organization_website',
    'counties',
    'phone',
    'language',
    'created_on',
    'target_audience',
    'tags',
    'author_credentials',
    'notes',
    'file_paths',
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
            'counties' => 'array',
            'tags' => 'array',
            'file_paths' => 'array',
            'created_on' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /** @return BelongsTo<\App\Models\Resource, $this> */
    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }
}
