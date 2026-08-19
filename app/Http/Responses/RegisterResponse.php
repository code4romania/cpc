<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Symfony\Component\HttpFoundation\Response;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request): Response
    {
        if ($request->wantsJson()) {
            return new JsonResponse('', 201);
        }

        $locale = $request->user()?->locale
            ?? session('locale')
            ?? config('cpc.default_locale', 'ro');

        return redirect(localized_route('auth.pending', [], $locale));
    }
}
