<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

class LocaleUrl
{
    public static function currentLocale(): string
    {
        $locale = request()->route('locale');

        if (\is_string($locale) && \in_array($locale, config('cpc.supported_locales', ['ro', 'en']), true)) {
            return $locale;
        }

        return config('cpc.default_locale', 'ro');
    }

    public static function localized(string $name, array $parameters = [], ?string $locale = null): string
    {
        $locale ??= self::currentLocale();

        return route($name, array_merge(['locale' => $locale], $parameters));
    }

    public static function switchUrl(string $locale): string
    {
        $route = request()->route();

        if ($route === null || $route->getName() === null) {
            return route('home', ['locale' => $locale]);
        }

        $parameters = $route->parameters();
        $parameters['locale'] = $locale;

        return route($route->getName(), $parameters);
    }

    public static function isActive(string $routeName): bool
    {
        return Route::currentRouteNamed($routeName);
    }
}
