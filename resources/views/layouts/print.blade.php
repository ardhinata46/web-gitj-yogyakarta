<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ $profile->name ?? 'Gereja' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; color: #1e293b; margin: 0; padding: 40px; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #0f172a; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; font-weight: 900; font-size: 24px; text-transform: uppercase; letter-spacing: -0.05em; color: #0f172a; }
        .header p { margin: 5px 0 0; font-size: 14px; font-weight: 600; color: #64748b; }
        .report-info { display: flex; justify-content: space-between; margin-bottom: 30px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 12px; }
        th { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; text-align: left; font-weight: 900; text-transform: uppercase; }
        td { border: 1px solid #e2e8f0; padding: 12px; }
        .footer { margin-top: 50px; text-align: right; font-size: 12px; font-weight: 700; }
        .footer .signature-space { margin-top: 60px; }
        @media print {
            body { padding: 0; }
            button { display: none; }
        }
        .text-right { text-align: right; }
        .font-black { font-weight: 900; }
        .bg-slate-50 { background-color: #f8fafc; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $profile->name ?? 'GEREJA INJILI DI TANAH JAWA YOGYAKARTA' }}</h1>
        <p>{{ $profile->address ?? '' }} | {{ $profile->phone ?? '' }}</p>
    </div>

    @yield('content')

    <div class="footer">
        <p>Yogyakarta, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Sekretariat Gereja</p>
        <div class="signature-space">
            ( __________________________ )
        </div>
    </div>

    <div style="position: fixed; bottom: 20px; right: 20px;">
        <button onclick="window.print()" style="background: #0f172a; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">Cetak Laporan</button>
    </div>
</body>
</html>
