<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cegah user biasa mengakses route admin dan tahu route itu ada.
 * Alih-alih 403 (ketahuan route ada), kembalikan 404 seolah tidak ada.
 */
class PreventAdminEnumeration
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isAdmin()) {
            abort(404);
        }

        return $next($request);
    }
}
