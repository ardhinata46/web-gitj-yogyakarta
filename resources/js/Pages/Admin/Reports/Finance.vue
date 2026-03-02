<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    transactions: Array,
    summary: Object,
    church_profile: Object
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
};

const print = () => window.print();
</script>

<template>
    <Head :title="'Laporan Keuangan ' + summary.month_name" />

    <div class="bg-gray-100 min-h-screen p-0 md:p-10 print:p-0">
        <!-- Print Toolbar -->
        <div class="max-w-5xl mx-auto mb-6 flex justify-between items-center bg-white p-4 rounded-2xl shadow-sm print:hidden">
            <p class="text-sm font-bold text-slate-500 font-outfit">Pratinjau Laporan Keuangan - {{ summary.month_name }}</p>
            <button @click="print" class="bg-emerald-600 text-white px-6 py-2 rounded-full font-black text-xs uppercase tracking-widest flex items-center gap-2">
                <span class="material-icons-outlined text-base">print</span>
                CETAK LAPORAN
            </button>
        </div>

        <!-- A4 Page Container -->
        <div class="max-w-[210mm] mx-auto bg-white p-[20mm] shadow-2xl print:shadow-none print:m-0">
             <!-- Header -->
            <div class="flex items-center gap-8 border-b-4 border-emerald-600 pb-10 mb-10">
                <div v-if="church_profile?.logo_url" class="w-24 h-24">
                     <img :src="church_profile.logo_url" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-4xl font-black text-slate-900 uppercase tracking-tighter">{{ church_profile?.name || 'GITJ Yogyakarta' }}</h1>
                    <p class="text-sm font-bold text-slate-500 tracking-widest uppercase">{{ church_profile?.address }}</p>
                    <p class="text-xs font-medium text-slate-400">Telp: {{ church_profile?.phone }} | Email: {{ church_profile?.email }}</p>
                </div>
            </div>

            <div class="text-center mb-12">
                <h2 class="text-2xl font-black text-slate-900 tracking-tighter uppercase">REKAPITULASI KEUANGAN BULAN {{ summary.month_name }}</h2>
                <div class="w-24 h-1 bg-emerald-600 mx-auto mt-2"></div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-3 gap-6 mb-12">
                <div class="p-4 border-2 border-slate-100 rounded-2xl">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Pemasukan</p>
                    <p class="text-lg font-black text-emerald-600 tracking-tighter">{{ formatCurrency(summary.total_income) }}</p>
                </div>
                <div class="p-4 border-2 border-slate-100 rounded-2xl">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Pengeluaran</p>
                    <p class="text-lg font-black text-rose-600 tracking-tighter">{{ formatCurrency(summary.total_expense) }}</p>
                </div>
                <div class="p-4 bg-slate-900 rounded-2xl">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Saldo Akhir</p>
                    <p class="text-lg font-black text-white tracking-tighter">{{ formatCurrency(summary.balance) }}</p>
                </div>
            </div>

            <!-- Table -->
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-emerald-50 text-emerald-900 border-y-2 border-emerald-600">
                        <th class="p-3 text-[10px] font-black uppercase tracking-widest w-10">No</th>
                        <th class="p-3 text-[10px] font-black uppercase tracking-widest">Tanggal</th>
                        <th class="p-3 text-[10px] font-black uppercase tracking-widest">Keterangan</th>
                        <th class="p-3 text-[10px] font-black uppercase tracking-widest text-right">Debit (Rp)</th>
                        <th class="p-3 text-[10px] font-black uppercase tracking-widest text-right">Kredit (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="(tr, index) in transactions" :key="tr.id" class="text-xs font-medium">
                        <td class="p-3 text-slate-400 text-center">{{ index + 1 }}</td>
                        <td class="p-3 text-slate-600">{{ new Date(tr.date).toLocaleDateString() }}</td>
                        <td class="p-3">
                            <p class="font-black text-slate-800">{{ tr.category }}</p>
                            <p class="text-[10px] text-slate-500 italic">{{ tr.description }}</p>
                        </td>
                        <td class="p-3 text-right text-emerald-600 font-black">
                            {{ tr.type === 'income' ? formatCurrency(tr.amount).replace('Rp', '') : '-' }}
                        </td>
                        <td class="p-3 text-right text-rose-500 font-bold">
                            {{ tr.type === 'expense' ? formatCurrency(tr.amount).replace('Rp', '') : '-' }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50 font-black text-slate-900">
                        <td colspan="3" class="p-4 text-right uppercase tracking-widest text-xs">Total Transaksi Sesi Ini</td>
                        <td class="p-4 text-right border-t border-slate-300 underline underline-offset-4 decoration-2 decoration-emerald-600">{{ formatCurrency(summary.total_income).replace('Rp', '') }}</td>
                        <td class="p-4 text-right border-t border-slate-300 underline underline-offset-4 decoration-2 decoration-rose-500">{{ formatCurrency(summary.total_expense).replace('Rp', '') }}</td>
                    </tr>
                </tfoot>
            </table>

             <!-- Footer -->
            <div class="mt-24 flex justify-between">
                <div class="text-center w-56">
                    <p class="text-xs font-bold text-slate-500 mb-20 uppercase tracking-widest">Mengetahui,<br/>Pastoral</p>
                    <div class="border-b border-slate-300 w-full mb-2"></div>
                    <p class="text-[10px] font-black text-slate-800 uppercase tracking-tighter">( ........................................ )</p>
                </div>
                <div class="text-center w-56">
                    <p class="text-xs font-bold text-slate-500 mb-20 uppercase tracking-widest">Dibuat Oleh,<br/>Bendahara</p>
                    <div class="border-b border-slate-300 w-full mb-2"></div>
                    <p class="text-[10px] font-black text-slate-800 uppercase tracking-tighter">( ........................................ )</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@media print {
    body { background: white !important; }
    .bg-gray-100 { background: white !important; }
    .print\:shadow-none { box-shadow: none !important; }
}

/* Force colors on print */
body {
    -webkit-print-color-adjust: exact;
}
</style>
