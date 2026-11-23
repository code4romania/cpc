<?php

use App\Enums\ResourceAccess;
use App\Enums\ResourceStatus;
use App\Enums\ResourceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('professional_resources', function (Blueprint $table) {
            $table->text('body_ro')->nullable()->after('description_en');
            $table->text('body_en')->nullable()->after('body_ro');
            $table->foreignId('resource_category_id')->nullable()->after('body_en')->constrained()->nullOnDelete();
            $table->json('tags')->nullable()->after('resource_category_id');
            $table->string('author')->nullable()->after('tags');
            $table->string('download_url')->nullable()->after('author');
            $table->string('video_url')->nullable()->after('download_url');
            $table->boolean('featured')->default(false)->after('video_url');
            $table->json('access_levels')->nullable()->after('featured');
            $table->string('status')->default(ResourceStatus::Draft->value)->index()->after('access_levels');
            $table->timestamp('published_at')->nullable()->index()->after('status');
        });

        $typeMap = [
            'pdf guide' => ResourceType::Guide->value,
            'template pack' => ResourceType::Printable->value,
            'video series' => ResourceType::Video->value,
            'interactive tool' => ResourceType::Online->value,
            'quick reference' => ResourceType::Document->value,
        ];

        $categories = DB::table('professional_resources')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->filter();

        $categoryIds = [];

        foreach ($categories as $category) {
            $slug = Str::slug((string) $category);
            $existingId = DB::table('resource_categories')->where('slug', $slug)->value('id');

            if ($existingId === null) {
                $existingId = DB::table('resource_categories')->insertGetId([
                    'slug' => $slug,
                    'name_ro' => $category,
                    'name_en' => $category,
                    'color_bg' => '#ede9f4',
                    'color_text' => '#7950a4',
                    'color_border' => '#7950a4',
                    'sort_order' => 100,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $categoryIds[$category] = $existingId;
        }

        $fallbackCategoryId = DB::table('resource_categories')->orderBy('id')->value('id');

        if ($fallbackCategoryId === null) {
            $fallbackCategoryId = DB::table('resource_categories')->insertGetId([
                'slug' => 'professional-resources',
                'name_ro' => 'Resurse profesionale',
                'name_en' => 'Professional resources',
                'color_bg' => '#ede9f4',
                'color_text' => '#7950a4',
                'color_border' => '#7950a4',
                'sort_order' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $defaultAccessLevels = json_encode([
            ResourceAccess::Ngo->value,
            ResourceAccess::Mai->value,
        ]);

        foreach (DB::table('professional_resources')->cursor() as $resource) {
            $normalizedType = strtolower(trim((string) $resource->type));
            $type = $typeMap[$normalizedType] ?? ResourceType::Document->value;
            $isPublished = (bool) $resource->is_published;
            $publishedAt = $isPublished
                ? ($resource->last_updated_at ?? now())
                : null;

            DB::table('professional_resources')
                ->where('id', $resource->id)
                ->update([
                    'resource_category_id' => $categoryIds[$resource->category] ?? $fallbackCategoryId,
                    'type' => $type,
                    'access_levels' => $defaultAccessLevels,
                    'status' => $isPublished
                        ? ResourceStatus::Published->value
                        : ResourceStatus::Draft->value,
                    'published_at' => $publishedAt,
                    'featured' => false,
                ]);
        }

        Schema::table('professional_resources', function (Blueprint $table) {
            $table->dropColumn(['category', 'file_size', 'is_published', 'last_updated_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professional_resources', function (Blueprint $table) {
            $table->string('category')->nullable()->after('description_en');
            $table->string('file_size')->nullable()->after('type');
            $table->boolean('is_published')->default(true)->after('file_size');
            $table->timestamp('last_updated_at')->nullable()->after('is_published');
        });

        foreach (DB::table('professional_resources')->cursor() as $resource) {
            $categoryName = DB::table('resource_categories')
                ->where('id', $resource->resource_category_id)
                ->value('name_en');

            DB::table('professional_resources')
                ->where('id', $resource->id)
                ->update([
                    'category' => $categoryName,
                    'type' => $resource->type,
                    'is_published' => $resource->status === ResourceStatus::Published->value,
                    'last_updated_at' => $resource->published_at,
                ]);
        }

        Schema::table('professional_resources', function (Blueprint $table) {
            $table->dropConstrainedForeignId('resource_category_id');
            $table->dropColumn([
                'body_ro',
                'body_en',
                'tags',
                'author',
                'download_url',
                'video_url',
                'featured',
                'access_levels',
                'status',
                'published_at',
            ]);
        });
    }
};
