<?php

namespace App\Enums;

enum ResourceType: string
{
    case Guide = 'guide';
    case Document = 'document';
    case Video = 'video';
    case Printable = 'printable';
    case Template = 'template';
    case Material = 'material';

    public function label(): string
    {
        return __('enums.resource_type.' . $this->value);
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $type): array => [$type->value => $type->label()])
            ->all();
    }
}
