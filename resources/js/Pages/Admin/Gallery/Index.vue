<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    items: Array
});

const showDeleteDialog = ref(false);
const itemToDelete = ref(null);
const loading = ref(false);

const confirmDelete = (item) => {
    itemToDelete.value = item;
    showDeleteDialog.value = true;
};

const deleteItem = () => {
    if (itemToDelete.value) {
        loading.value = true;
        router.delete(route('admin.gallery.destroy', itemToDelete.value.id), {
            onFinish: () => {
                loading.value = false;
                showDeleteDialog.value = false;
                itemToDelete.value = null;
            }
        });
    }
};
</script>

<template>
    <Head title="Galeri Foto" />

    <AdminLayout>
        <template #header>
            Galeri Foto Gereja
        </template>

        <div class="d-flex flex-column flex-sm-row align-center justify-space-between gap-4 mb-8 pt-2">
            <div>
                <div class="text-h5 font-weight-black text-slate-900 dark:text-white leading-tight">Manajemen Galeri</div>
                <div class="text-caption font-bold text-slate-500">Dokumentasikan momen penting dan kegiatan gereja.</div>
            </div>
            
            <v-btn
                color="primary"
                prepend-icon="mdi-camera-plus"
                rounded="lg"
                height="48"
                class="text-none font-weight-black px-6 elevation-2"
                @click="router.visit(route('admin.gallery.create'))"
            >
                Tambah Foto
            </v-btn>
        </div>

        <v-row>
            <v-col v-for="item in items" :key="item.id" cols="12" sm="6" md="4" lg="3">
                <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 overflow-hidden group gallery-card">
                    <div class="relative overflow-hidden aspect-video">
                        <v-img
                            :src="item.image_url"
                            cover
                            class="transition-transform duration-700 group-hover:scale-110"
                        >
                            <template v-slot:placeholder>
                                <div class="d-flex align-center justify-center fill-height bg-slate-100 dark:bg-slate-800">
                                    <v-progress-circular indeterminate color="primary"></v-progress-circular>
                                </div>
                            </template>
                        </v-img>
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <v-btn
                                icon="mdi-pencil"
                                color="white"
                                variant="flat"
                                rounded="lg"
                                size="small"
                                @click="router.visit(route('admin.gallery.edit', item.id))"
                            ></v-btn>
                            <v-btn
                                icon="mdi-delete"
                                color="error"
                                variant="flat"
                                rounded="lg"
                                size="small"
                                @click="confirmDelete(item)"
                            ></v-btn>
                        </div>
                    </div>
                    
                    <div class="pa-4">
                        <div class="text-overline font-weight-black text-primary mb-1 tracking-widest leading-none">{{ item.category }}</div>
                        <h4 class="text-subtitle-1 font-weight-black text-slate-900 dark:text-white mb-1 truncate">{{ item.title }}</h4>
                        <div class="d-flex align-center gap-2 text-caption font-bold text-slate-400">
                            <v-icon size="14">mdi-calendar-range</v-icon>
                            {{ item.event_date }}
                        </div>
                    </div>
                </v-card>
            </v-col>

            <!-- Empty State -->
            <v-col v-if="items.length === 0" cols="12">
                <v-card rounded="xl" elevation="0" class="border-2 border-dashed border-slate-200 dark:border-slate-800 bg-transparent pa-16 text-center">
                    <v-icon size="80" color="slate-lighten-4" class="mb-4">mdi-image-plus-outline</v-icon>
                    <h3 class="text-h5 font-weight-black text-slate-400">Belum Ada Foto di Galeri</h3>
                    <p class="text-slate-500 font-bold mb-8">Berikan kenangan visual dengan mengunggah foto kegiatan jemaat pertama.</p>
                    <v-btn
                        color="primary"
                        prepend-icon="mdi-camera-plus"
                        rounded="lg"
                        height="48"
                        class="text-none font-weight-black px-8"
                        @click="router.visit(route('admin.gallery.create'))"
                    >
                        Unggah Foto Pertama
                    </v-btn>
                </v-card>
            </v-col>
        </v-row>

        <!-- Delete Dialog -->
        <v-dialog v-model="showDeleteDialog" max-width="400">
            <v-card rounded="xl" class="pa-4">
                <v-card-title class="d-flex align-center gap-3 font-weight-black text-error">
                    <v-icon>mdi-alert-circle-outline</v-icon>
                    Hapus Foto?
                </v-card-title>
                <v-card-text class="pt-2 font-weight-bold text-slate-600 dark:text-slate-400">
                    Apakah Anda yakin ingin menghapus foto <strong>{{ itemToDelete?.title }}</strong> secara permanen?
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
                        @click="deleteItem"
                    >Ya, Hapus</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AdminLayout>
</template>

<style>
.gallery-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.gallery-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px -15px rgba(var(--v-theme-primary), 0.2) !important;
}
</style>
