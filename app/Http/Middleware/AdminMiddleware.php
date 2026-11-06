<?php

// Esteban Alvarez Garcia

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('login.index');
        }

        $user = User::findOrFail($request->user()->getAuthIdentifier());

        abort_unless($user->getRole() === 'admin', 403, __('messages.access_denied_admin'));

        return $next($request);
    }
}
