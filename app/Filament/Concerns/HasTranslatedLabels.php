<?php

namespace App\Filament\Concerns;

trait HasTranslatedLabels
{
    abstract protected static function translationKey(): string;

    public static function getNavigationLabel(): string
    {
        return __('admin.resources.'.static::translationKey().'.navigation');
    }

    public static function getModelLabel(): string
    {
        return __('admin.resources.'.static::translationKey().'.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.resources.'.static::translationKey().'.plural');
    }
}
