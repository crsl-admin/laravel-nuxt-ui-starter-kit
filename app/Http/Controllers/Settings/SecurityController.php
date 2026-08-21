<?php

namespace App\Http\Controllers\Settings;

use App\Data\PasskeyData;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Fortify;

class SecurityController extends Controller
{
    /**
     * Show the security settings: password, two-factor authentication and passkeys.
     */
    public function __invoke(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        $isPendingConfirmation = $user->two_factor_secret && ! $user->two_factor_confirmed_at;

        return Inertia::render('settings/Security', [
            'twoFactorEnabled' => (bool) $user->two_factor_secret,
            'twoFactorConfirmed' => (bool) $user->two_factor_confirmed_at,
            'qrCodeSvg' => $isPendingConfirmation ? $user->twoFactorQrCodeSvg() : null,
            'setupKey' => $isPendingConfirmation ? Fortify::currentEncrypter()->decrypt($user->two_factor_secret) : null,
            'recoveryCodes' => Inertia::optional(
                fn (): array => $user->two_factor_recovery_codes ? $user->recoveryCodes() : []
            ),
            'passkeys' => PasskeyData::collect($user->passkeys()->latest()->get()),
        ]);
    }
}
