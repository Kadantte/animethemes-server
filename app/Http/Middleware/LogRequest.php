<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class LogRequest.
 */
class LogRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure(Request): mixed  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $requestId = Str::uuid()->toString();

        Log::withContext([
            'request-id' => $requestId,
        ]);

        Log::info('Request Info', [
            'method' => $request->method(),
            'full-url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'headers' => $request->headers->all(),
        ]);

        return $next($request)->header('Request-Id', $requestId);
    }
}
