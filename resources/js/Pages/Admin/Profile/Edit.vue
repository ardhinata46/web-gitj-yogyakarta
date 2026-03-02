<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    profile: Object
});

const form = useForm({
    name: props.profile.name || '',
    vision: props.profile.vision || '',
    mission: props.profile.mission || '',
    history: props.profile.history || '',
    address: props.profile.address || '',
    phone: props.profile.phone || '',
    email: props.profile.email || '',
    google_maps_url: props.profile.google_maps_url || '',
    facebook_url: props.profile.facebook_url || '',
    instagram_url: props.profile.instagram_url || '',
    youtube_url: props.profile.youtube_url || '',
    logo_url: props.profile.logo_url || '',
});

const submit = () => {
    form.put(route('admin.profile.update'));
};
</script>

<template>
    <Head title="Pengaturan Profil Gereja" />

    <AdminLayout>
        <template #header>
            Profil & Pengaturan Website
        </template>

        <v-form @submit.prevent="submit">
            <v-row>
                <v-col cols="12" lg="8">
                    <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-8 mb-6">
                        <div class="d-flex align-center gap-3 mb-6">
                            <v-avatar color="primary" variant="tonal" rounded="lg">
                                <v-icon>mdi-church</v-icon>
                            </v-avatar>
                            <h3 class="text-h6 font-weight-black text-slate-900 dark:text-white">Informasi Dasar</h3>
                        </div>

                        <v-row>
                            <v-col cols="12" md="6">
                                <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Nama Gereja</div>
                                <v-text-field
                                    v-model="form.name"
                                    variant="outlined"
                                    rounded="lg"
                                    color="primary"
                                    hide-details="auto"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Email Kontak</div>
                                <v-text-field
                                    v-model="form.email"
                                    type="email"
                                    variant="outlined"
                                    rounded="lg"
                                    color="primary"
                                    hide-details="auto"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Visi</div>
                                <v-textarea
                                    v-model="form.vision"
                                    variant="outlined"
                                    rounded="lg"
                                    color="primary"
                                    rows="2"
                                    hide-details="auto"
                                ></v-textarea>
                            </v-col>
                            <v-col cols="12">
                                <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Misi</div>
                                <v-textarea
                                    v-model="form.mission"
                                    variant="outlined"
                                    rounded="lg"
                                    color="primary"
                                    rows="4"
                                    placeholder="Pisahkan misi dengan baris baru..."
                                    hide-details="auto"
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-card>

                    <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-8">
                        <div class="d-flex align-center gap-3 mb-6">
                            <v-avatar color="secondary" variant="tonal" rounded="lg">
                                <v-icon>mdi-map-marker-radius</v-icon>
                            </v-avatar>
                            <h3 class="text-h6 font-weight-black text-slate-900 dark:text-white">Kontak & Alamat</h3>
                        </div>

                        <v-row>
                            <v-col cols="12" md="6">
                                <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">No. Telepon / WhatsApp</div>
                                <v-text-field
                                    v-model="form.phone"
                                    variant="outlined"
                                    rounded="lg"
                                    color="primary"
                                    hide-details="auto"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Google Maps URL</div>
                                <v-text-field
                                    v-model="form.google_maps_url"
                                    variant="outlined"
                                    rounded="lg"
                                    color="primary"
                                    placeholder="https://maps.google.com/..."
                                    hide-details="auto"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Alamat Lengkap</div>
                                <v-textarea
                                    v-model="form.address"
                                    variant="outlined"
                                    rounded="lg"
                                    color="primary"
                                    rows="2"
                                    hide-details="auto"
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>

                <v-col cols="12" lg="4">
                    <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-8 mb-6 sticky top-24">
                        <div class="d-flex align-center gap-3 mb-6">
                            <v-avatar color="accent" variant="tonal" rounded="lg">
                                <v-icon>mdi-share-variant</v-icon>
                            </v-avatar>
                            <h3 class="text-h6 font-weight-black text-slate-900 dark:text-white">Media Sosial</h3>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Instagram</div>
                                <v-text-field
                                    v-model="form.instagram_url"
                                    variant="outlined"
                                    rounded="lg"
                                    color="primary"
                                    prepend-inner-icon="mdi-instagram"
                                    hide-details="auto"
                                ></v-text-field>
                            </div>
                            <div>
                                <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">YouTube</div>
                                <v-text-field
                                    v-model="form.youtube_url"
                                    variant="outlined"
                                    rounded="lg"
                                    color="primary"
                                    prepend-inner-icon="mdi-youtube"
                                    hide-details="auto"
                                ></v-text-field>
                            </div>
                            <div>
                                <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Facebook</div>
                                <v-text-field
                                    v-model="form.facebook_url"
                                    variant="outlined"
                                    rounded="lg"
                                    color="primary"
                                    prepend-inner-icon="mdi-facebook"
                                    hide-details="auto"
                                ></v-text-field>
                            </div>
                        </div>

                        <v-divider class="my-8"></v-divider>

                        <v-btn
                            type="submit"
                            color="primary"
                            block
                            size="large"
                            rounded="lg"
                            height="56"
                            class="text-none font-weight-black elevation-4 mb-4"
                            :loading="form.processing"
                        >
                            Simpan Perubahan
                        </v-btn>

                        <v-alert
                            v-if="form.recentlySuccessful"
                            type="success"
                            variant="tonal"
                            rounded="lg"
                            density="compact"
                            class="font-weight-bold"
                        >
                            Berhasil disimpan!
                        </v-alert>
                    </v-card>
                </v-col>
            </v-row>
        </v-form>
    </AdminLayout>
</template>
