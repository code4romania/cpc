<?php

use App\Support\LocaleUrl;

if (! function_exists('localized_route')) {
    function localized_route(string $name, array $parameters = [], ?string $locale = null): string
    {
        return LocaleUrl::localized($name, $parameters, $locale);
    }
}

if (! function_exists('locale_switch_url')) {
    function locale_switch_url(string $locale): string
    {
        return LocaleUrl::switchUrl($locale);
    }
}
