<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    sliders: Array
});

const search = ref('');
const showDeleteDialog = ref(false);
const sliderToDelete = ref(null);
const loading = ref(false);

const headers = [
    { title: 'Pratinjau', key: 'preview', sortable: false },
    { title: 'Judul', key: 'title', sortable: true },
    { title: 'Urutan', key: 'order', sortable: true },
    { title: 'Status', key: 'is_active', align: 'center', sortable: true },
    { title: 'Aksi', key: 'actions', align: 'end', sortable: false },
];

const confirmDelete = (item) => {
    sliderToDelete.value = item;
    showDeleteDialog.value = true;
};

const deleteSlider = () => {
    if (sliderToDelete.value) {
        loading.value = true;
        router.delete(route('admin.sliders.destroy', sliderToDelete.value.id), {
            onFinish: () => {
                loading.value = false;
                showDeleteDialog.value = false;
                sliderToDelete.value = null;
            }
        });
    }
};
</script>

<template>
    <Head title="Manajemen Slider" />

    <AdminLayout>
        <template #header>
            Manajemen Slider Beranda
        </template>

        <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 overflow-hidden">
            <template v-slot:text>
                <div class="d-flex flex-column flex-sm-row align-center justify-space-between gap-4 mb-6 pt-2">
                    <v-text-field
                        v-model="search"
                        label="Cari Slider..."
                        prepend-inner-icon="mdi-magnify"
                        variant="solo-filled"
                        flat
                        rounded="lg"
                        hide-details
                        density="comfortable"
                        max-width="300"
                        class="grow-1"
                    ></v-text-field>
                    
                    <v-btn
                        color="primary"
                        prepend-icon="mdi-plus-circle-outline"
                        rounded="lg"
                        height="48"
                        class="text-none font-weight-black px-6 elevation-2"
                        @click="router.visit(route('admin.sliders.create'))"
                    >
                        Tambah Slider
                    </v-btn>
                </div>

                <v-data-table
                    :headers="headers"
                    :items="sliders"
                    :search="search"
                    hover
                    class="bg-transparent"
                >
                    <template v-slot:item.preview="{ item }">
                        <v-card rounded="lg" elevation="2" class="my-2 border" width="120" height="60" border>
                            <v-img :src="item.image_url" cover height="100%"></v-img>
                        </v-card>
                    </template>

                    <template v-slot:item.title="{ item }">
                        <span class="font-weight-black text-slate-900 dark:text-white">{{ item.title }}</span>
                    </template>

                    <template v-slot:item.is_active="{ item }">
                        <v-chip
                            size="x-small"
                            class="font-weight-black uppercase tracking-widest px-3"
                            :color="item.is_active ? 'success' : 'secondary'"
                            variant="flat"
                        >
                            {{ item.is_active ? 'Aktif' : 'Non-aktif' }}
                        </v-chip>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <div class="d-flex justify-end gap-1">
                            <v-btn
                                icon="mdi-pencil-outline"
                                variant="text"
                                color="primary"
                                density="comfortable"
                                @click="router.visit(route('admin.sliders.edit', item.id))"
                            ></v-btn>
                            <v-btn
                                icon="mdi-delete-outline"
                                variant="text"
                                color="error"
                                density="comfortable"
                                @click="confirmDelete(item)"
                            ></v-btn>
                        </div>
                    </template>
                </v-data-table>
            </template>
        </v-card>

        <!-- Delete Dialog -->
        <v-dialog v-model="showDeleteDialog" max-width="400">
            <v-card rounded="xl" class="pa-4">
                <v-card-title class="d-flex align-center gap-3 font-weight-black text-error">
                    <v-icon>mdi-alert-circle-outline</v-icon>
                    Hapus Slider?
                </v-card-title>
                <v-card-text class="pt-2 font-weight-bold text-slate-600 dark:text-slate-400">
                    Apakah Anda yakin ingin menghapus slider ini secara permanen?
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
                        @click="deleteSlider"
                    >Ya, Hapus</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AdminLayout>
</template>
