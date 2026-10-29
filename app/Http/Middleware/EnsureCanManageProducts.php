<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCanManageProducts
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->canManageProducts()) {
            abort(403, 'Hanya admin atau uploader yang boleh mengelola produk.');
        }

        return $next($request);
    }
}
