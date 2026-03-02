<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';

const props = defineProps({
    transaction: Object
});

const form = useForm({
    type: props.transaction.type,
    amount: props.transaction.amount,
    category: props.transaction.category,
    description: props.transaction.description,
    date: props.transaction.date,
});

const submit = () => {
    form.put(route('admin.transactions.update', props.transaction.id));
};
</script>

<template>
    <Head title="Edit Transaksi" />

    <AdminLayout>
        <template #header>
            Edit Catatan Transaksi
        </template>

        <div class="max-w-4xl mx-auto">
            <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 pa-6 pa-md-10">
                <v-form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="12" class="mb-4">
                            <div class="text-subtitle-2 font-weight-black mb-4 text-slate-700 dark:text-slate-300">Jenis Transaksi</div>
                            <v-btn-toggle
                                v-model="form.type"
                                mandatory
                                color="primary"
                                class="w-full h-auto d-flex gap-4 bg-transparent"
                                variant="outlined"
                                rounded="lg"
                            >
                                <v-btn
                                    value="income"
                                    class="flex-1 py-6 h-auto text-none font-weight-black"
                                    :variant="form.type === 'income' ? 'flat' : 'outlined'"
                                    :color="form.type === 'income' ? 'success' : 'grey-lighten-3'"
                                    prepend-icon="mdi-trending-up"
                                >
                                    Masuk / Pendapatan
                                </v-btn>
                                <v-btn
                                    value="expense"
                                    class="flex-1 py-6 h-auto text-none font-weight-black"
                                    :variant="form.type === 'expense' ? 'flat' : 'outlined'"
                                    :color="form.type === 'expense' ? 'error' : 'grey-lighten-3'"
                                    prepend-icon="mdi-trending-down"
                                >
                                    Keluar / Pengeluaran
                                </v-btn>
                            </v-btn-toggle>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Jumlah (Rp)</div>
                            <v-text-field
                                v-model="form.amount"
                                type="number"
                                prefix="Rp"
                                placeholder="0"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.amount"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Tanggal</div>
                            <v-text-field
                                v-model="form.date"
                                type="date"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.date"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Kategori</div>
                            <v-text-field
                                v-model="form.category"
                                placeholder="Contoh: Persembahan, Listrik, Gaji, dll"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.category"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Keterangan Transaksi</div>
                            <v-textarea
                                v-model="form.description"
                                placeholder="Detail tambahan mengenai transaksi ini..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                rows="3"
                                :error-messages="form.errors.description"
                            ></v-textarea>
                        </v-col>

                        <v-col cols="12" class="pt-6">
                            <v-btn
                                type="submit"
                                color="primary"
                                size="large"
                                rounded="lg"
                                block
                                height="56"
                                class="text-none font-weight-black text-lg elevation-4"
                                :loading="form.processing"
                            >
                                Perbarui Transaksi
                            </v-btn>
                            
                            <v-btn
                                variant="text"
                                block
                                rounded="lg"
                                height="56"
                                class="text-none font-weight-black mt-4 text-slate-500"
                                @click="router.visit(route('admin.transactions.index'))"
                            >
                                Batalkan & Kembali
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card>
        </div>
    </AdminLayout>
</template>

<style>
.v-btn-toggle .v-btn {
    border: 2px solid transparent !important;
}
</style>
