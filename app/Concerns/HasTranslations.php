<?php

namespace App\Concerns;

trait HasTranslations
{
    public function getTranslated(string $attribute, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $fallback = config('cpc.default_locale', 'ro');

        $localized = $this->getAttribute("{$attribute}_{$locale}");

        if (filled($localized)) {
            return $localized;
        }

        return $this->getAttribute("{$attribute}_{$fallback}");
    }
}
