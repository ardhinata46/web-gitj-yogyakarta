<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    slider: Object
});

const form = useForm({
    title: props.slider.title,
    subtitle: props.slider.subtitle,
    image_url: props.slider.image_url,
    cta_text: props.slider.cta_text,
    cta_link: props.slider.cta_link,
    order: props.slider.order,
    is_active: !!props.slider.is_active,
});

const submit = () => {
    form.put(route('admin.sliders.update', props.slider.id));
};
</script>

<template>
    <Head title="Edit Slider" />

    <AdminLayout>
        <template #header>
            Edit Slider Beranda
        </template>

        <div class="max-w-4xl mx-auto">
            <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-10">
                <v-form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Judul Utama</div>
                            <v-text-field
                                v-model="form.title"
                                placeholder="Judul banner utama..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.title"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Sub-judul</div>
                            <v-text-field
                                v-model="form.subtitle"
                                placeholder="Teks deskripsi singkat..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
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
                                prepend-inner-icon="mdi-link-variant"
                                required
                                :error-messages="form.errors.image_url"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Teks Tombol (CTA)</div>
                            <v-text-field
                                v-model="form.cta_text"
                                placeholder="Contoh: Selengkapnya"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Link Tombol</div>
                            <v-text-field
                                v-model="form.cta_link"
                                placeholder="Contoh: /gallery atau #kontak"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Urutan Tampil</div>
                            <v-text-field
                                v-model="form.order"
                                type="number"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6" class="d-flex align-center">
                            <v-switch
                                v-model="form.is_active"
                                color="success"
                                label="Aktifkan Slider"
                                hide-details
                                inset
                            ></v-switch>
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
                                    Update Slider
                                </v-btn>
                                
                                <v-btn
                                    variant="tonal"
                                    size="large"
                                    rounded="lg"
                                    class="flex-1 text-none font-weight-black text-lg"
                                    height="56"
                                    @click="router.visit(route('admin.sliders.index'))"
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
