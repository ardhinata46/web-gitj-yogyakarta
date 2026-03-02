<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    address: '',
    phone: '',
    gender: 'L',
    birth_date: '',
    church_group: '',
    status: 'aktif',
});

const submit = () => {
    form.post(route('admin.members.store'));
};
</script>

<template>
    <Head title="Tambah Anggota" />

    <AdminLayout>
        <template #header>
            Tambah Anggota Jemaat
        </template>

        <div class="max-w-4xl mx-auto">
            <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-10">
                <v-form @submit.prevent="submit">
                    <v-row>
                        <v-col cols="12" md="8">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Nama Lengkap</div>
                            <v-text-field
                                v-model="form.name"
                                placeholder="Masukkan nama lengkap..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.name"
                                required
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="4">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Gender</div>
                            <v-select
                                v-model="form.gender"
                                :items="[
                                    { title: 'Laki-laki', value: 'L' },
                                    { title: 'Perempuan', value: 'P' }
                                ]"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                required
                            ></v-select>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">No. Telepon</div>
                            <v-text-field
                                v-model="form.phone"
                                placeholder="Contoh: 0812..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.phone"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Tanggal Lahir</div>
                            <v-text-field
                                v-model="form.birth_date"
                                type="date"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.birth_date"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Alamat Lengkap</div>
                            <v-textarea
                                v-model="form.address"
                                placeholder="Detail alamat..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                rows="3"
                                :error-messages="form.errors.address"
                            ></v-textarea>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Kelompok / Wilayah</div>
                            <v-text-field
                                v-model="form.church_group"
                                placeholder="Contoh: Wilayah Timur, Pemuda, dll"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.church_group"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Status Keanggotaan</div>
                            <v-select
                                v-model="form.status"
                                :items="[
                                    { title: 'Aktif', value: 'aktif' },
                                    { title: 'Pasif', value: 'pasif' },
                                    { title: 'Pindah', value: 'pindah' },
                                    { title: 'Meninggal', value: 'meninggal' }
                                ]"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                required
                            ></v-select>
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
                                Simpan Data Anggota
                            </v-btn>
                            
                            <v-btn
                                variant="text"
                                block
                                rounded="lg"
                                height="56"
                                class="text-none font-weight-black mt-4 text-slate-500"
                                @click="router.visit(route('admin.members.index'))"
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
