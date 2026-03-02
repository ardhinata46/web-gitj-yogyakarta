<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Audit Logs</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #0f172a; }
        h1 { font-size: 16px; margin: 0 0 8px; }
        .meta { margin-bottom: 10px; color: #64748b; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e2e8f0; padding: 6px; vertical-align: top; }
        th { background: #f1f5f9; text-transform: uppercase; font-size: 9px; letter-spacing: 0.08em; }
        .muted { color: #64748b; }
    </style>
</head>
<body>
    <h1>Audit Logs</h1>
    <div class="meta">Generated at: {{ $generated_at->format('d M Y H:i') }}</div>
    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>User</th>
                <th>Action</th>
                <th>Method</th>
                <th>Status</th>
                <th>Route</th>
                <th>IP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->created_at?->format('d M Y H:i') }}</td>
                    <td>
                        {{ $log->user?->name ?? 'System' }}<br>
                        <span class="muted">{{ $log->user?->email }}</span>
                    </td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->method }}</td>
                    <td>{{ $log->status_code }}</td>
                    <td>{{ $log->route_name }}</td>
                    <td>{{ $log->ip_address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
