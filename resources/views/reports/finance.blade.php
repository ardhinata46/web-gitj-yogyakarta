@extends('layouts.print')

@section('title', 'Laporan Keuangan')

@section('content')
    <div class="report-info">
        <span>Laporan: Rekapitulasi Keuangan</span>
        <span>Periode: {{ $month }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Kategori</th>
                <th class="text-right">Pemasukan</th>
                <th class="text-right">Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $tx)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($tx->date)->translatedFormat('d/m/Y') }}</td>
                <td class="font-black">{{ $tx->description }}</td>
                <td>{{ $tx->category }}</td>
                <td class="text-right">{{ $tx->type == 'income' ? number_format($tx->amount, 0, ',', '.') : '-' }}</td>
                <td class="text-right">{{ $tx->type == 'expense' ? number_format($tx->amount, 0, ',', '.') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-slate-50">
                <th colspan="4" class="text-right">Total Pemasukan</th>
                <th class="text-right" style="color: #059669;">Rp {{ number_format($inflow, 0, ',', '.') }}</th>
                <th></th>
            </tr>
            <tr class="bg-slate-50">
                <th colspan="4" class="text-right">Total Pengeluaran</th>
                <th></th>
                <th class="text-right" style="color: #dc2626;">Rp {{ number_format($outflow, 0, ',', '.') }}</th>
            </tr>
            <tr class="bg-slate-50">
                <th colspan="4" class="text-right">Saldo Kas Akhir</th>
                <th colspan="2" class="text-right font-black" style="font-size: 16px;">Rp {{ number_format($balance, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
@endsection
