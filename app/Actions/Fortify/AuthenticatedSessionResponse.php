<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse;

class AuthenticatedSessionResponse implements LoginResponse
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->intended('admin/dashboard');
        } elseif ($user->hasRole('student')) {
            return redirect()->intended('student/dashboard');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
