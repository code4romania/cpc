<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): Response
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['two_factor' => false]);
        }

        $user = $request->user();
        $locale = ($user !== null ? $user->locale : null)
            ?? session('locale')
            ?? config('cpc.default_locale', 'ro');

        if ($user?->isProfessional() && $user->verified_at === null) {
            return redirect()->intended(localized_route('auth.pending', [], $locale));
        }

        return redirect()->intended(localized_route('portal.index', [], $locale));
    }
}
