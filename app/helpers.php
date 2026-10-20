<?php

use App\Models\StaticPage;
use App\Support\LocaleUrl;

if (! function_exists('localized_route')) {
    /**
     * @param  array<string, mixed>  $parameters
     */
    function localized_route(string $name, array $parameters = [], ?string $locale = null): string
    {
        return LocaleUrl::localized($name, $parameters, $locale);
    }
}

if (! function_exists('page_text')) {
    function page_text(?StaticPage $page, string $key, string $fallback): string
    {
        return $page?->text($key, $fallback) ?? __($fallback);
    }
}

if (! function_exists('page_lines')) {
    /**
     * @return list<string>
     */
    function page_lines(?StaticPage $page, string $key, string $fallback): array
    {
        if ($page instanceof StaticPage) {
            return $page->lines($key, $fallback);
        }

        $translated = __($fallback);

        return is_array($translated) ? array_values(array_map(strval(...), $translated)) : [];
    }
}

if (! function_exists('locale_switch_url')) {
    function locale_switch_url(string $locale): string
    {
        return LocaleUrl::switchUrl($locale);
    }
}
