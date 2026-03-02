<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    members: Array,
    filters: Object,
    church_profile: Object
});

const print = () => window.print();
</script>

<template>
    <Head title="Cetak Laporan Jemaat" />

    <div class="bg-gray-100 min-h-screen p-0 md:p-10 print:p-0">
        <!-- Print Toolbar -->
        <div class="max-w-5xl mx-auto mb-6 flex justify-between items-center bg-white p-4 rounded-2xl shadow-sm print:hidden">
            <p class="text-sm font-bold text-slate-500">Pratinjau Laporan Jemaat</p>
            <button @click="print" class="bg-primary-900 text-white px-6 py-2 rounded-full font-black text-xs uppercase tracking-widest flex items-center gap-2">
                <span class="material-icons-outlined text-base">print</span>
                CETAK PDF
            </button>
        </div>

        <!-- A4 Page Container -->
        <div class="max-w-[210mm] mx-auto bg-white p-[20mm] shadow-2xl print:shadow-none print:m-0">
            <!-- Header -->
            <div class="flex items-center gap-8 border-b-4 border-slate-900 pb-10 mb-10">
                <div v-if="church_profile?.logo_url" class="w-24 h-24">
                     <img :src="church_profile.logo_url" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-4xl font-black text-slate-900 uppercase tracking-tighter">{{ church_profile?.name || 'GITJ Yogyakarta' }}</h1>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">{{ church_profile?.address }}</p>
                    <p class="text-xs font-medium text-slate-400">Telp: {{ church_profile?.phone }} | Email: {{ church_profile?.email }}</p>
                </div>
            </div>

            <div class="text-center mb-10">
                <h2 class="text-2xl font-black text-slate-900 underline underline-offset-8 decoration-slate-200">LAPORAN DATA JEMAAT</h2>
                <p class="text-sm font-medium text-slate-500 mt-2 italic">Dicetak pada: {{ new Date().toLocaleDateString() }}</p>
            </div>

            <!-- Table -->
            <table class="w-full text-left border-collapse border border-slate-300">
                <thead>
                    <tr class="bg-slate-100">
                        <th class="border border-slate-300 p-3 text-[10px] font-black uppercase tracking-widest text-slate-600 w-12 text-center">No</th>
                        <th class="border border-slate-300 p-3 text-[10px] font-black uppercase tracking-widest text-slate-600">Nama Lengkap</th>
                        <th class="border border-slate-300 p-3 text-[10px] font-black uppercase tracking-widest text-slate-600">Wilayah</th>
                        <th class="border border-slate-300 p-3 text-[10px] font-black uppercase tracking-widest text-slate-600">Gender</th>
                        <th class="border border-slate-300 p-3 text-[10px] font-black uppercase tracking-widest text-slate-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(member, index) in members" :key="member.id" class="text-xs">
                        <td class="border border-slate-300 p-3 text-center">{{ index + 1 }}</td>
                        <td class="border border-slate-300 p-3 font-bold text-slate-800">{{ member.name }}</td>
                        <td class="border border-slate-300 p-3">{{ member.church_group }}</td>
                        <td class="border border-slate-300 p-3 text-center">{{ member.gender }}</td>
                        <td class="border border-slate-300 p-3 text-center font-black uppercase tracking-tighter text-[9px]">{{ member.status }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Footer -->
            <div class="mt-20 flex justify-end">
                <div class="text-center w-64">
                    <p class="text-sm font-medium text-slate-800 mb-20 uppercase tracking-widest">Sekretaris Jemaat,</p>
                    <div class="border-b border-slate-900 w-full mb-2"></div>
                    <p class="text-xs font-black text-slate-900 uppercase underline tracking-tighter">( ........................................ )</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@media print {
    body { background: white !important; }
    .bg-gray-100 { background: white !important; }
}
</style>
