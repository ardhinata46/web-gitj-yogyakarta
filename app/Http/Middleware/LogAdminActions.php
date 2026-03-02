<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAdminActions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!$request->user()) {
            return $response;
        }

        if (!in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            return $response;
        }

        $payload = $this->sanitizePayload($request);

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => $request->route()?->getName(),
            'method' => $request->method(),
            'status_code' => $response->getStatusCode(),
            'url' => $request->fullUrl(),
            'route_name' => $request->route()?->getName(),
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
            'payload' => $payload,
        ]);

        return $response;
    }

    private function sanitizePayload(Request $request): array
    {
        $payload = $request->except([
            'password',
            'password_confirmation',
            'current_password',
        ]);

        foreach ($request->allFiles() as $key => $file) {
            if (is_array($file)) {
                $payload[$key] = array_map(static fn($item) => $item?->getClientOriginalName(), $file);
            } else {
                $payload[$key] = $file?->getClientOriginalName();
            }
        }

        return $payload;
    }
}
