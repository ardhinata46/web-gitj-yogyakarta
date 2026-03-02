<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\Announcement;
use App\Models\Devotional;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'members_count' => Member::count(),
            'total_income' => Transaction::where('type', 'income')->sum('amount'),
            'total_expense' => Transaction::where('type', 'expense')->sum('amount'),
            'balance' => Transaction::where('type', 'income')->sum('amount') - Transaction::where('type', 'expense')->sum('amount'),
        ];

        // Monthly trends for the last 6 months
        $monthlyTrends = Transaction::select(
            DB::raw('strftime("%Y-%m", created_at) as month'),
            DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
            DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
        )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get()
            ->reverse()
            ->values();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'charts' => [
                'labels' => $monthlyTrends->pluck('month')->map(fn($m) => date('M Y', strtotime($m . "-01"))),
                'income' => $monthlyTrends->pluck('income'),
                'expense' => $monthlyTrends->pluck('expense'),
            ],
            'recent_announcements' => Announcement::latest()->take(5)->get(),
        ]);
    }
}
