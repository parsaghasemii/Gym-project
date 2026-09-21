<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboardingCompleted
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isMember() && ! $user->onboarding_completed) {
            return redirect()->route('onboarding.step1');
        }

        return $next($request);
    }
}
