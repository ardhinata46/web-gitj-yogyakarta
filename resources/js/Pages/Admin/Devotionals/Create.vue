<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    content: '',
    verse: '',
    author: '',
    date: new Date().toISOString().split('T')[0],
});

const submit = () => {
    form.post(route('admin.devotionals.store'));
};
</script>

<template>
    <Head title="Tambah Renungan" />

    <AdminLayout>
        <template #header>
            Tambah Renungan Baru
        </template>

        <div class="max-w-4xl mx-auto">
            <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-10">
                <v-form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="12">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Judul Renungan</div>
                            <v-text-field
                                v-model="form.title"
                                placeholder="Masukkan judul renungan..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                required
                                :error-messages="form.errors.title"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Ayat Alkitab</div>
                            <v-text-field
                                v-model="form.verse"
                                placeholder="Contoh: Yohanes 3:16"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.verse"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Tanggal Renungan</div>
                            <v-text-field
                                v-model="form.date"
                                type="date"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                required
                                :error-messages="form.errors.date"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Penulis / Pembawa Renungan</div>
                            <v-text-field
                                v-model="form.author"
                                placeholder="Nama penulis..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.author"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Isi Renungan</div>
                            <v-textarea
                                v-model="form.content"
                                placeholder="Tuliskan isi renungan di sini..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                rows="10"
                                required
                                :error-messages="form.errors.content"
                            ></v-textarea>
                        </v-col>

                        <v-col cols="12" class="pt-6">
                            <div class="d-flex gap-4">
                                <v-btn
                                    type="submit"
                                    color="primary"
                                    size="large"
                                    rounded="lg"
                                    class="flex-1 text-none font-weight-black text-lg elevation-4"
                                    height="56"
                                    :loading="form.processing"
                                >
                                    Simpan Renungan
                                </v-btn>
                                
                                <v-btn
                                    variant="tonal"
                                    size="large"
                                    rounded="lg"
                                    class="flex-1 text-none font-weight-black text-lg"
                                    height="56"
                                    @click="router.visit(route('admin.devotionals.index'))"
                                >
                                    Batal
                                </v-btn>
                            </div>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card>
        </div>
    </AdminLayout>
</template>
