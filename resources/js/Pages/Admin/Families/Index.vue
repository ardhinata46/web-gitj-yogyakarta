<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    families: Array
});

const search = ref('');
const showDeleteDialog = ref(false);
const familyToDelete = ref(null);
const loading = ref(false);

const filteredFamilies = computed(() => {
    if (!search.value) return props.families;
    const s = search.value.toLowerCase();
    return props.families.filter(f => 
        f.name.toLowerCase().includes(s) || 
        (f.kk_number && f.kk_number.includes(s))
    );
});

const confirmDelete = (family) => {
    familyToDelete.value = family;
    showDeleteDialog.value = true;
};

const deleteFamily = () => {
    if (familyToDelete.value) {
        loading.value = true;
        router.delete(route('admin.families.destroy', familyToDelete.value.id), {
            onFinish: () => {
                loading.value = false;
                showDeleteDialog.value = false;
                familyToDelete.value = null;
            }
        });
    }
};
</script>

<template>
    <Head title="Manajemen Keluarga" />

    <AdminLayout>
        <template #header>
            Daftar Keluarga Jemaat
        </template>

        <v-row class="mb-4 pt-2">
            <v-col cols="12" md="6">
                <div class="text-h5 font-weight-black text-slate-900 dark:text-white leading-tight">Kelola Data Keluarga</div>
                <div class="text-caption font-bold text-slate-500">Kumpulkan anggota jemaat dalam ikatan Kartu Keluarga.</div>
            </v-col>
            <v-col cols="12" md="6" class="d-flex flex-column flex-sm-row justify-md-end align-center gap-4">
                <v-text-field
                    v-model="search"
                    label="Cari Nama Keluarga..."
                    prepend-inner-icon="mdi-magnify"
                    variant="solo-filled"
                    flat
                    rounded="lg"
                    hide-details
                    density="comfortable"
                    class="w-100 max-w-[300px]"
                ></v-text-field>
                
                <v-btn
                    color="primary"
                    prepend-icon="mdi-home-plus"
                    rounded="lg"
                    height="48"
                    class="text-none font-weight-black px-6 elevation-2"
                    @click="router.visit(route('admin.families.create'))"
                >
                    Tambah Keluarga
                </v-btn>
            </v-col>
        </v-row>

        <v-row>
            <v-col v-for="family in filteredFamilies" :key="family.id" cols="12" md="6" lg="4">
                <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 transition-all hover-card h-100 d-flex flex-column">
                    <div class="d-flex justify-space-between align-start mb-6">
                        <v-avatar color="primary" variant="tonal" rounded="lg" size="56">
                            <v-icon size="32">mdi-home-variant-outline</v-icon>
                        </v-avatar>
                        
                        <div class="d-flex gap-1">
                            <v-btn
                                icon="mdi-pencil-outline"
                                variant="text"
                                color="primary"
                                density="comfortable"
                                @click="router.visit(route('admin.families.edit', family.id))"
                            ></v-btn>
                            <v-btn
                                icon="mdi-delete-outline"
                                variant="text"
                                color="error"
                                density="comfortable"
                                @click="confirmDelete(family)"
                            ></v-btn>
                        </div>
                    </div>

                    <h3 class="text-h6 font-weight-black text-slate-900 dark:text-white mb-1 truncate">{{ family.name }}</h3>
                    <div class="d-flex align-center gap-2 text-caption font-bold text-slate-400 mb-6">
                        <v-icon size="14">mdi-card-account-details-outline</v-icon>
                        KK: {{ family.kk_number || 'Belum diisi' }}
                    </div>

                    <v-spacer></v-spacer>
                    <v-divider class="mb-6"></v-divider>

                    <div class="d-flex align-center justify-space-between">
                        <div class="d-flex align-center gap-2">
                            <span class="text-h5 font-weight-black text-primary">{{ family.members_count }}</span>
                            <span class="text-overline font-weight-black text-slate-400 leading-none">Anggota<br/>Jemaat</span>
                        </div>
                        
                        <v-btn
                            variant="tonal"
                            color="primary"
                            size="small"
                            rounded="lg"
                            class="text-none font-weight-black"
                            @click="router.visit(route('admin.families.edit', family.id))"
                        >
                            Detail Anggota
                            <v-icon end icon="mdi-arrow-right"></v-icon>
                        </v-btn>
                    </div>
                </v-card>
            </v-col>

            <!-- Empty State Card -->
            <v-col v-if="filteredFamilies.length === 0" cols="12">
                <v-card rounded="xl" elevation="0" class="border-2 border-dashed border-slate-200 dark:border-slate-800 bg-transparent pa-16 text-center">
                    <v-icon size="80" color="slate-lighten-4" class="mb-4">mdi-home-group-remove</v-icon>
                    <h3 class="text-h5 font-weight-black text-slate-400">
                        {{ search ? 'Keluarga Tidak Ditemukan' : 'Belum Ada Data Keluarga' }}
                    </h3>
                    <p class="text-slate-500 font-bold mb-8">
                        {{ search ? 'Coba gunakan kata kunci pencarian yang lain.' : 'Mulailah dengan menambahkan keluarga baru untuk manajemen jemaat yang lebih baik.' }}
                    </p>
                    <v-btn
                        v-if="!search"
                        color="primary"
                        prepend-icon="mdi-plus"
                        rounded="lg"
                        height="48"
                        class="text-none font-weight-black px-8"
                        @click="router.visit(route('admin.families.create'))"
                    >
                        Tambah Sekarang
                    </v-btn>
                    <v-btn
                        v-else
                        variant="text"
                        color="primary"
                        rounded="lg"
                        class="text-none font-weight-black px-8"
                        @click="search = ''"
                    >
                        Bersihkan Pencarian
                    </v-btn>
                </v-card>
            </v-col>
        </v-row>

        <!-- Delete Dialog -->
        <v-dialog v-model="showDeleteDialog" max-width="400">
            <v-card rounded="xl" class="pa-4">
                <v-card-title class="d-flex align-center gap-3 font-weight-black text-error">
                    <v-icon>mdi-alert-circle-outline</v-icon>
                    Hapus Keluarga?
                </v-card-title>
                <v-card-text class="pt-2 font-weight-bold text-slate-600 dark:text-slate-400">
                    Apakah Anda yakin ingin menghapus keluarga <strong>{{ familyToDelete?.name }}</strong>? <br/><br/>
                    <small class="text-error font-bold">Catatan: Anggota dalam keluarga ini akan dilepaskan hubungan keluarganya namun data jemaat tidak akan dihapus.</small>
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
                        @click="deleteFamily"
                    >
                        Ya, Hapus
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AdminLayout>
</template>

<style>
.hover-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.hover-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px -10px rgba(var(--v-theme-primary), 0.15) !important;
    border-color: rgba(var(--v-theme-primary), 0.3) !important;
}
</style>
