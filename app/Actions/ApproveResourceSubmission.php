<?php

namespace App\Actions;

use App\Enums\ResourceStatus;
use App\Enums\SubmissionStatus;
use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\ResourceSubmission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApproveResourceSubmission
{
    public function __invoke(ResourceSubmission $submission, User $reviewer): Resource
    {
        return DB::transaction(function () use ($submission, $reviewer): Resource {
            $submission = ResourceSubmission::query()
                ->lockForUpdate()
                ->whereKey($submission->getKey())
                ->firstOrFail();

            if (
                $submission->getRawOriginal('status') === SubmissionStatus::Approved->value
                && $submission->resource_id !== null
            ) {
                return Resource::query()
                    ->whereKey($submission->resource_id)
                    ->firstOrFail();
            }

            $category = $this->resolveCategory($submission->category);
            $slug = $this->uniqueSlug($submission->title);

            $resource = Resource::query()->create([
                'slug' => $slug,
                'title_ro' => $submission->title,
                'title_en' => $submission->title,
                'description_ro' => $submission->description,
                'description_en' => $submission->description,
                'type' => $submission->type,
                'resource_category_id' => $category->getKey(),
                'download_url' => $submission->external_url,
                'status' => ResourceStatus::Published,
                'published_at' => now(),
            ]);

            $submission->update([
                'status' => SubmissionStatus::Approved,
                'rejection_reason' => null,
                'reviewed_by' => $reviewer->getKey(),
                'reviewed_at' => now(),
                'resource_id' => $resource->getKey(),
            ]);

            return $resource;
        });
    }

    private function resolveCategory(?string $category): ResourceCategory
    {
        $name = filled($category) ? trim($category) : 'Uncategorized';
        $slug = Str::slug($name) ?: 'uncategorized';

        return ResourceCategory::query()
            ->where('slug', $slug)
            ->orWhere('name_ro', $name)
            ->orWhere('name_en', $name)
            ->firstOrCreate(
                ['slug' => $slug],
                ['name_ro' => $name, 'name_en' => $name],
            );
    }

    private function uniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title) ?: 'resource';
        $slug = $baseSlug;
        $suffix = 2;

        while (Resource::query()->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
