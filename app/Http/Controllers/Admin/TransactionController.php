<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->paginate(10);
        return Inertia::render('Admin/Transactions/Index', [
            'transactions' => $transactions
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Transactions/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $validated['user_id'] = auth()->id();

        Transaction::create($validated);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil dicatat.');
    }

    public function edit(Transaction $transaction)
    {
        return Inertia::render('Admin/Transactions/Edit', [
            'transaction' => $transaction
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $transaction->update($validated);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
