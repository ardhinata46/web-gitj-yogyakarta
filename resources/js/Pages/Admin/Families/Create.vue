<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';

defineProps({
    members: Array
});

const form = useForm({
    name: '',
    kk_number: '',
    address: '',
    member_ids: [],
});

const submit = () => {
    form.post(route('admin.families.store'));
};

const toggleMember = (id) => {
    const index = form.member_ids.indexOf(id);
    if (index === -1) {
        form.member_ids.push(id);
    } else {
        form.member_ids.splice(index, 1);
    }
};
</script>

<template>
    <Head title="Tambah Keluarga Baru" />

    <AdminLayout>
        <template #header>
            Tambah Keluarga
        </template>

        <div class="max-w-4xl mx-auto">
            <v-form @submit.prevent="submit">
                <!-- Informasi Dasar -->
                <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-10 mb-8">
                    <div class="d-flex align-center gap-3 mb-8">
                        <v-avatar color="primary" variant="tonal" rounded="lg">
                            <v-icon>mdi-information-outline</v-icon>
                        </v-avatar>
                        <h3 class="text-h6 font-weight-black text-slate-900 dark:text-white">Informasi Dasar</h3>
                    </div>
                    
                    <v-row>
                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Nama Keluarga / Kepala Keluarga</div>
                            <v-text-field
                                v-model="form.name"
                                placeholder="Contoh: Keluarga Budi Santoso"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.name"
                                required
                            ></v-text-field>
                        </v-col>
                        
                        <v-col cols="12" md="6">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Nomor Kartu Keluarga (KK)</div>
                            <v-text-field
                                v-model="form.kk_number"
                                placeholder="16 Digit Nomor KK"
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                :error-messages="form.errors.kk_number"
                            ></v-text-field>
                        </v-col>
                        
                        <v-col cols="12">
                            <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Alamat Domisili</div>
                            <v-textarea
                                v-model="form.address"
                                placeholder="Tuliskan alamat lengkap keluarga..."
                                variant="outlined"
                                rounded="lg"
                                color="primary"
                                rows="3"
                                :error-messages="form.errors.address"
                            ></v-textarea>
                        </v-col>
                    </v-row>
                </v-card>

                <!-- Pemilihan Anggota -->
                <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-10 mb-8">
                    <div class="d-flex align-center gap-3 mb-2">
                        <v-avatar color="primary" variant="tonal" rounded="lg">
                            <v-icon>mdi-account-multiple-plus-outline</v-icon>
                        </v-avatar>
                        <h3 class="text-h6 font-weight-black text-slate-900 dark:text-white">Pilih Anggota Keluarga</h3>
                    </div>
                    <p class="text-caption font-bold text-slate-500 mb-8">Pilih anggota jemaat yang akan didaftarkan ke dalam keluarga ini.</p>

                    <div class="custom-scrollbar overflow-y-auto pr-2" style="max-height: 400px;">
                        <v-row v-if="members && members.length > 0">
                            <v-col v-for="member in members" :key="member.id" cols="12" md="6">
                                <v-card
                                    :color="form.member_ids.includes(member.id) ? 'primary' : ''"
                                    :variant="form.member_ids.includes(member.id) ? 'tonal' : 'outlined'"
                                    rounded="lg"
                                    class="pa-4 cursor-pointer transition-all member-card"
                                    @click="toggleMember(member.id)"
                                >
                                    <div class="d-flex align-center gap-3">
                                        <v-avatar 
                                            :color="form.member_ids.includes(member.id) ? 'primary' : 'grey-lighten-3'" 
                                            size="40"
                                            class="font-weight-black text-caption"
                                        >
                                            {{ member.name.charAt(0) }}
                                        </v-avatar>
                                        <div class="flex-grow-1">
                                            <div class="text-subtitle-2 font-weight-black truncate">{{ member.name }}</div>
                                            <div class="text-caption font-bold text-slate-500 uppercase">{{ member.church_group || 'Umum' }}</div>
                                        </div>
                                        <v-icon 
                                            v-if="form.member_ids.includes(member.id)"
                                            color="primary"
                                        >mdi-check-circle</v-icon>
                                    </div>
                                </v-card>
                            </v-col>
                        </v-row>

                        <div v-else class="py-12 text-center bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                            <v-icon size="48" color="slate-lighten-4" class="mb-2">mdi-account-off-outline</v-icon>
                            <p class="text-caption font-bold text-slate-400">Tidak ada anggota tersedia (Semua sudah terdaftar).</p>
                        </div>
                    </div>

                    <v-divider class="my-6"></v-divider>
                    
                    <div class="d-flex align-center justify-space-between">
                         <div class="text-subtitle-2 font-weight-black text-slate-600 dark:text-slate-400">
                             <span class="text-primary">{{ form.member_ids.length }}</span> Anggota Terpilih
                         </div>
                         <v-btn
                             v-if="form.member_ids.length > 0"
                             variant="text"
                             color="error"
                             size="small"
                             class="text-none font-weight-black"
                             @click="form.member_ids = []"
                         >Bersihkan Pilihan</v-btn>
                    </div>
                </v-card>

                <!-- Tombol Aksi -->
                <div class="d-flex flex-column flex-sm-row gap-4 mb-10">
                    <v-btn
                        type="submit"
                        color="primary"
                        size="large"
                        rounded="xl"
                        height="56"
                        class="px-10 text-none font-weight-black flex-grow-1 elevation-4"
                        :loading="form.processing"
                    >
                        Simpan Data Keluarga
                    </v-btn>
                    <v-btn
                        variant="tonal"
                        color="secondary"
                        size="large"
                        rounded="xl"
                        height="56"
                        class="px-10 text-none font-weight-black"
                        @click="router.visit(route('admin.families.index'))"
                    >
                        Batal
                    </v-btn>
                </div>
            </v-form>
        </div>
    </AdminLayout>
</template>

<style scoped>
.member-card {
    border-width: 2px !important;
}
.member-card:hover {
    border-color: rgb(var(--v-theme-primary)) !important;
    background-color: rgba(var(--v-theme-primary), 0.05);
}
</style>
