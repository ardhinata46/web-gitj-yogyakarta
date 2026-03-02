<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';

const props = defineProps({
    schedule: Object
});

const form = useForm({
    title: props.schedule.title,
    time: props.schedule.time,
    location: props.schedule.location,
    description: props.schedule.description,
});

const submit = () => {
    form.put(route('admin.schedules.update', props.schedule.id));
};
</script>

<template>
    <Head title="Edit Jadwal" />

    <AdminLayout>
        <template #header>
            Edit Jadwal Kegiatan
        </template>

        <div class="max-w-4xl mx-auto">
            <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-10">
                <v-form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="12">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Nama Kegiatan</div>
                            <v-text-field
                                v-model="form.title"
                                placeholder="Contoh: Ibadah Minggu, Latihan Musik..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.title"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Waktu / Jam</div>
                            <v-text-field
                                v-model="form.time"
                                placeholder="Contoh: Setiap Minggu, 08:30 WIB"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.time"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Lokasi</div>
                            <v-text-field
                                v-model="form.location"
                                placeholder="Gereja GITJ, Ruang Konsistori..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.location"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Keterangan Tambahan</div>
                            <v-textarea
                                v-model="form.description"
                                placeholder="Jelaskan detail kegiatan jika diperlukan..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                rows="4"
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
                                Perbarui Jadwal
                            </v-btn>
                            
                            <v-btn
                                variant="text"
                                block
                                rounded="lg"
                                height="56"
                                class="text-none font-weight-black mt-4 text-slate-500"
                                @click="router.visit(route('admin.schedules.index'))"
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
