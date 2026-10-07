<?php

namespace App\Models;

use App\Enums\PartnershipEntityType;
use Database\Factories\PartnershipIntentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'entity_name',
    'entity_type',
    'activity_domain',
    'contact_name',
    'contact_role',
    'phone',
    'email',
    'intent',
    'personal_data_consent',
    'locale',
])]
class PartnershipIntent extends Model
{
    /** @use HasFactory<PartnershipIntentFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'entity_type' => PartnershipEntityType::class,
            'personal_data_consent' => 'boolean',
        ];
    }
}
