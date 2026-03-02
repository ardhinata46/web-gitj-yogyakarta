<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\ChurchProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Reports/Index');
    }

    public function membership()
    {
        $members = Member::with('family')->orderBy('name')->get();
        $profile = ChurchProfile::first();

        return view('reports.membership', compact('members', 'profile'));
    }

    public function finance(Request $request)
    {
        $month = $request->month ?? now()->format('Y-m');
        $date = Carbon::parse($month);

        $transactions = Transaction::whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->orderBy('date')
            ->get();

        $inflow = Transaction::whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->where('type', 'income')
            ->sum('amount');

        $outflow = Transaction::whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->where('type', 'expense')
            ->sum('amount');

        $profile = ChurchProfile::first();

        return view('reports.finance', [
            'transactions' => $transactions,
            'profile' => $profile,
            'month' => $date->translatedFormat('F Y'),
            'inflow' => $inflow,
            'outflow' => $outflow,
            'balance' => $inflow - $outflow
        ]);
    }
}
