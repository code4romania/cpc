<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfessionalVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null || ! $user->isProfessional()) {
            abort(403);
        }

        if ($user->verified_at === null) {
            return redirect()->route('auth.pending', ['locale' => app()->getLocale()]);
        }

        return $next($request);
    }
}
