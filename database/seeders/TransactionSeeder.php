<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'income' => ['Persembahan Mingguan', 'Persembahan Bulanan', 'Donasi Khusus', 'Diakonia'],
            'expense' => ['Listrik & Air', 'Gaji Karyawan', 'Pemeliharaan Gedung', 'Kegiatan Ibadah']
        ];

        // Generate transactions for the last 6 months
        for ($i = 0; $i < 6; $i++) {
            $month = Carbon::now()->subMonths($i);

            // Income
            Transaction::create([
                'type' => 'income',
                'amount' => rand(5000000, 10000000),
                'category' => $categories['income'][array_rand($categories['income'])],
                'description' => 'Penerimaan rutin bulan ' . $month->format('F Y'),
                'date' => $month->copy()->startOfMonth()->addDays(rand(0, 25))->toDateString(),
            ]);

            // Expense
            Transaction::create([
                'type' => 'expense',
                'amount' => rand(1000000, 3000000),
                'category' => $categories['expense'][array_rand($categories['expense'])],
                'description' => 'Pengeluaran rutin bulan ' . $month->format('F Y'),
                'date' => $month->copy()->startOfMonth()->addDays(rand(0, 25))->toDateString(),
            ]);
        }
    }
}
