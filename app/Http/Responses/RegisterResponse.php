<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Symfony\Component\HttpFoundation\Response;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request): Response
    {
        if ($request->wantsJson()) {
            return new JsonResponse('', 201);
        }

        $user = $request->user();

        $locale = ($user !== null ? $user->locale : null)
            ?? session('locale')
            ?? config('cpc.default_locale', 'ro');

        Auth::logout();

        return redirect(localized_route('auth.requested', [], $locale));
    }
}
