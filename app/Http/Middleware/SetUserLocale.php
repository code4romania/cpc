<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetUserLocale
{
    /**
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = config('cpc.supported_locales', ['ro', 'en']);
        $user = auth()->user();
        $locale = ($user !== null ? $user->locale : null)
            ?? session('locale')
            ?? config('cpc.default_locale', 'ro');

        if (\is_string($locale) && \in_array($locale, $supportedLocales, true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
