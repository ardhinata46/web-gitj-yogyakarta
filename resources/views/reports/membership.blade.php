@extends('layouts.print')

@section('title', 'Laporan Data Jemaat')

@section('content')
    <div class="report-info">
        <span>Laporan: Data Anggota Jemaat</span>
        <span>Jumlah Total: {{ count($members) }} Orang</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Nama Lengkap</th>
                <th>Jenis Kelamin</th>
                <th>Keluarga</th>
                <th>Status</th>
                <th>Telepon</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $index => $member)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="font-black">{{ $member->name }}</td>
                <td>{{ $member->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $member->family->name ?? '-' }}</td>
                <td>{{ $member->status }}</td>
                <td>{{ $member->phone ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
