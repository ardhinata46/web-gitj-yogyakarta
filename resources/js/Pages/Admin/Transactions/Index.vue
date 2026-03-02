<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    transactions: Object
});

const search = ref('');
const showDeleteDialog = ref(false);
const transactionToDelete = ref(null);
const loading = ref(false);

const headers = [
    { title: 'Tanggal', key: 'date', sortable: true },
    { title: 'Kategori', key: 'category', sortable: true },
    { title: 'Keterangan', key: 'description' },
    { title: 'Jumlah', key: 'amount', align: 'end', sortable: true },
    { title: 'Aksi', key: 'actions', align: 'end', sortable: false },
];

const confirmDelete = (item) => {
    transactionToDelete.value = item;
    showDeleteDialog.value = true;
};

const deleteTransaction = () => {
    if (transactionToDelete.value) {
        loading.value = true;
        router.delete(route('admin.transactions.destroy', transactionToDelete.value.id), {
            onFinish: () => {
                loading.value = false;
                showDeleteDialog.value = false;
                transactionToDelete.value = null;
            }
        });
    }
};

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
};
</script>

<template>
    <Head title="Manajemen Keuangan" />

    <AdminLayout>
        <template #header>
            Keuangan Gereja
        </template>

        <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 overflow-hidden">
            <template v-slot:text>
                <div class="d-flex flex-column flex-sm-row align-center justify-space-between gap-4 mb-6 pt-2">
                    <v-text-field
                        v-model="search"
                        label="Cari Transaksi..."
                        prepend-inner-icon="mdi-magnify"
                        variant="solo-filled"
                        flat
                        rounded="lg"
                        hide-details
                        density="comfortable"
                        max-width="300"
                        class="grow-1"
                    ></v-text-field>
                    
                    <v-btn
                        color="primary"
                        prepend-icon="mdi-cash-plus"
                        rounded="lg"
                        height="48"
                        class="text-none font-weight-black px-6 elevation-2"
                        @click="router.visit(route('admin.transactions.create'))"
                    >
                        Catat Transaksi
                    </v-btn>
                </div>

                <v-data-table
                    :headers="headers"
                    :items="transactions.data"
                    :search="search"
                    hover
                    class="bg-transparent transactions-table"
                >
                    <template v-slot:item.date="{ item }">
                        <span class="font-weight-bold text-slate-500 dark:text-slate-400">
                            {{ new Date(item.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                        </span>
                    </template>

                    <template v-slot:item.category="{ item }">
                        <v-chip
                            size="x-small"
                            class="font-weight-black uppercase tracking-widest px-3"
                            variant="tonal"
                            color="secondary"
                        >
                            {{ item.category }}
                        </v-chip>
                    </template>

                    <template v-slot:item.description="{ item }">
                        <span class="font-weight-bold text-slate-700 dark:text-slate-300">{{ item.description || '-' }}</span>
                    </template>

                    <template v-slot:item.amount="{ item }">
                        <div class="d-flex flex-column align-end">
                            <span :class="item.type === 'income' ? 'text-success' : 'text-error'" class="text-subtitle-2 font-weight-black">
                                {{ item.type === 'income' ? '+' : '-' }} {{ formatCurrency(item.amount) }}
                            </span>
                            <span class="text-overline font-weight-black opacity-50 leading-none">{{ item.type }}</span>
                        </div>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <div class="d-flex justify-end gap-1">
                            <v-btn
                                icon="mdi-pencil-outline"
                                variant="text"
                                color="primary"
                                density="comfortable"
                                @click="router.visit(route('admin.transactions.edit', item.id))"
                            ></v-btn>
                            <v-btn
                                icon="mdi-delete-outline"
                                variant="text"
                                color="error"
                                density="comfortable"
                                @click="confirmDelete(item)"
                            ></v-btn>
                        </div>
                    </template>
                </v-data-table>
            </template>
        </v-card>

        <!-- Delete Dialog -->
        <v-dialog v-model="showDeleteDialog" max-width="400">
            <v-card rounded="xl" class="pa-4">
                <v-card-title class="d-flex align-center gap-3 font-weight-black text-error">
                    <v-icon>mdi-alert-circle-outline</v-icon>
                    Hapus Transaksi?
                </v-card-title>
                <v-card-text class="pt-2 font-weight-bold text-slate-600 dark:text-slate-400">
                    Apakah Anda yakin ingin menghapus catatan transaksi ini? Tindakan ini akan mempengaruhi laporan keuangan secara permanen.
                </v-card-text>
                <v-card-actions class="pt-4">
                    <v-spacer></v-spacer>
                    <v-btn variant="text" rounded="lg" class="text-none font-weight-black px-4" @click="showDeleteDialog = false">Batal</v-btn>
                    <v-btn
                        color="error"
                        variant="flat"
                        rounded="lg"
                        class="text-none font-weight-black px-6"
                        :loading="loading"
                        @click="deleteTransaction"
                    >
                        Ya, Hapus
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AdminLayout>
</template>

<style>
.transactions-table .v-data-table-header th {
    font-weight: 800 !important;
    text-transform: uppercase !important;
    font-size: 0.75rem !important;
    letter-spacing: 0.05em !important;
    color: #64748b !important;
}

.dark .transactions-table .v-data-table-header th {
    color: #94a3b8 !important;
}

.text-success { color: rgb(var(--v-theme-success)) !important; }
.text-error { color: rgb(var(--v-theme-error)) !important; }
</style>
