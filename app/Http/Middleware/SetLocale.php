<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if (! \is_string($locale) || ! \in_array($locale, config('cpc.supported_locales', ['ro', 'en']), true)) {
            abort(404);
        }

        app()->setLocale($locale);
        session(['locale' => $locale]);

        return $next($request);
    }
}
