<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                    ->orWhere('route_name', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('method')) {
            $query->where('method', $request->string('method')->toString());
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->string('date_from')->toString());
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->string('date_to')->toString());
        }

        $auditLogs = $query->paginate(50)
            ->withQueryString()
            ->through(fn ($log) => [
                'id' => $log->id,
                'user' => $log->user ? [
                    'id' => $log->user->id,
                    'name' => $log->user->name,
                    'email' => $log->user->email,
                    'role' => $log->user->role,
                ] : null,
                'action' => $log->action,
                'method' => $log->method,
                'url' => $log->url,
                'route_name' => $log->route_name,
                'ip_address' => $log->ip_address,
                'user_agent' => $log->user_agent,
                'payload' => $log->payload,
                'created_at' => $log->created_at,
            ]);

        return Inertia::render('Admin/AuditLogs/Index', [
            'auditLogs' => $auditLogs,
            'filters' => [
                'search' => $request->string('search')->toString(),
                'method' => $request->string('method')->toString(),
                'user_id' => $request->integer('user_id') ?: null,
                'date_from' => $request->string('date_from')->toString(),
                'date_to' => $request->string('date_to')->toString(),
            ],
        ]);
    }
}
