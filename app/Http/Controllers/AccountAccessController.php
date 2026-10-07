<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountAccessController extends Controller
{
    public function showPasswordForm(Request $request, string $locale, User $user): View
    {
        return view('account.password', [
            'user' => $user,
        ]);
    }

    public function storePassword(Request $request, string $locale, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => $validated['password'],
        ]);

        Auth::login($user);

        return redirect(localized_route('account.index', [], $user->locale));
    }

    public function renew(Request $request, string $locale, User $user): RedirectResponse
    {
        $user->update([
            'expires_at' => now()->addYear(),
            'renewal_notified_at' => null,
        ]);

        return redirect(localized_route('home', [], $user->locale))
            ->with('status', __('auth.renewed'));
    }
}
