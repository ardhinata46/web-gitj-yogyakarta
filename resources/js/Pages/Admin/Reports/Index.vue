<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const selectedMonth = ref(new Date().toISOString().slice(0, 7)); // YYYY-MM
</script>

<template>
    <Head title="Laporan & Ekspor" />

    <AdminLayout>
        <template #header>
            Pusat Laporan
        </template>

        <div class="mb-8">
            <h2 class="text-h4 font-weight-black text-slate-900 dark:text-white mb-2">Pilih Jenis Laporan</h2>
            <p class="text-caption font-bold text-slate-500 uppercase tracking-widest">Unduh atau cetak data jemaat dan keuangan dalam format profesional.</p>
        </div>

        <v-row>
            <!-- Membership Report -->
            <v-col cols="12" md="6">
                <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-10 fill-height d-flex flex-column">
                    <v-avatar color="primary" rounded="lg" size="64" class="mb-8 elevation-4">
                        <v-icon size="32">mdi-account-group-outline</v-icon>
                    </v-avatar>
                    
                    <h3 class="text-h5 font-weight-black text-slate-900 dark:text-white mb-4">Laporan Jemaat</h3>
                    <p class="text-body-1 font-medium text-slate-500 dark:text-slate-400 mb-10 grow">
                        Daftar anggota jemaat lengkap dengan status, alamat, dan data keluarga. Cocok untuk keperluan administrasi wilayah.
                    </p>
                    
                    <v-btn
                        :href="route('admin.reports.membership')"
                        target="_blank"
                        color="primary"
                        block
                        size="x-large"
                        rounded="lg"
                        class="text-none font-weight-black px-6"
                        variant="flat"
                        prepend-icon="mdi-printer-outline"
                        append-icon="mdi-chevron-right"
                    >
                        Cetak Seluruh Jemaat
                    </v-btn>
                </v-card>
            </v-col>

            <!-- Financial Report -->
            <v-col cols="12" md="6">
                <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-10 fill-height d-flex flex-column">
                    <v-avatar color="success" rounded="lg" size="64" class="mb-8 elevation-4">
                        <v-icon size="32">mdi-cash-register</v-icon>
                    </v-avatar>
                    
                    <h3 class="text-h5 font-weight-black text-slate-900 dark:text-white mb-4">Laporan Keuangan</h3>
                    <p class="text-body-1 font-medium text-slate-500 dark:text-slate-400 mb-8">
                        Rekapitulasi pemasukan dan pengeluaran gereja. Dilengkapi dengan rincian kategori dan saldo akhir.
                    </p>
                    
                    <div class="mt-auto">
                        <div class="bg-slate-50 dark:bg-slate-900 pa-4 rounded-xl border border-slate-100 dark:border-slate-700 mb-6">
                            <div class="text-overline font-weight-black text-slate-400 mb-2">Pilih Periode Bulan</div>
                            <v-text-field
                                v-model="selectedMonth"
                                type="month"
                                variant="outlined"
                                rounded="lg"
                                density="comfortable"
                                hide-details
                                color="success"
                            ></v-text-field>
                        </div>
                        
                        <v-btn
                            :href="route('admin.reports.finance', { month: selectedMonth })"
                            target="_blank"
                            color="success"
                            block
                            size="x-large"
                            rounded="lg"
                            class="text-none font-weight-black px-6"
                            variant="flat"
                            prepend-icon="mdi-file-document-outline"
                            append-icon="mdi-chevron-right"
                        >
                            Cetak Laporan Bulanan
                        </v-btn>
                    </div>
                </v-card>
            </v-col>
        </v-row>
    </AdminLayout>
</template>
