<?php

namespace App\Http\Middleware;

use Closure;

class VerifyMidtransWebhook
{
    /**
     * Handle an incoming request.
     * Disable CSRF protection for this webhook.
     */
    public function handle($request, Closure $next)
    {
        // Karena ini khusus untuk webhook Midtrans, kita langsung proses request tanpa CSRF token.
        return $next($request);
    }
}
