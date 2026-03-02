<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, Link, router } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    description: '',
    image_url: '',
    category: '',
    event_date: new Date().toISOString().split('T')[0],
});

const submit = () => {
    form.post(route('admin.gallery.store'));
};

const categories = ['Ibadah', 'Sosial', 'Pemuda', 'Sekolah Minggu', 'Lainnya'];
</script>

<template>
    <Head title="Unggah Foto" />

    <AdminLayout>
        <template #header>
            Unggah Foto Galeri
        </template>

        <div class="max-w-4xl mx-auto">
            <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-10">
                <v-form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="12">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Judul Foto</div>
                            <v-text-field
                                v-model="form.title"
                                placeholder="Masukkan judul foto..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                required
                                :error-messages="form.errors.title"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">URL Gambar (Link)</div>
                            <v-text-field
                                v-model="form.image_url"
                                placeholder="https://images.unsplash.com/..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                required
                                prepend-inner-icon="mdi-link-variant"
                                :error-messages="form.errors.image_url"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Kategori</div>
                            <v-select
                                v-model="form.category"
                                :items="categories"
                                placeholder="Pilih kategori..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.category"
                            ></v-select>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Tanggal Kegiatan</div>
                            <v-text-field
                                v-model="form.event_date"
                                type="date"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.event_date"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Deskripsi (Opsional)</div>
                            <v-textarea
                                v-model="form.description"
                                placeholder="Berikan deskripsi singkat mengenai foto ini..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                rows="3"
                                :error-messages="form.errors.description"
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
                                    Unggah ke Galeri
                                </v-btn>
                                
                                <v-btn
                                    variant="tonal"
                                    size="large"
                                    rounded="lg"
                                    class="flex-1 text-none font-weight-black text-lg"
                                    height="56"
                                    @click="router.visit(route('admin.gallery.index'))"
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
