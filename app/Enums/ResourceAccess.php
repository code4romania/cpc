<?php

namespace App\Enums;

enum ResourceAccess: string
{
    case Public = 'public';
    case Ngo = 'ngo';
    case Mai = 'mai';

    public function label(): string
    {
        return __('enums.resource_access.'.$this->value);
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $access): array => [$access->value => $access->label()])
            ->all();
    }
}
