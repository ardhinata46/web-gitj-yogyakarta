<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    devotionals: Object
});

const search = ref('');
const showDeleteDialog = ref(false);
const devotionalToDelete = ref(null);
const loading = ref(false);

const headers = [
    { title: 'Tanggal', key: 'date', sortable: true },
    { title: 'Judul', key: 'title', sortable: true },
    { title: 'Penulis', key: 'author', sortable: true },
    { title: 'Aksi', key: 'actions', align: 'end', sortable: false },
];

const confirmDelete = (item) => {
    devotionalToDelete.value = item;
    showDeleteDialog.value = true;
};

const deleteDevotional = () => {
    if (devotionalToDelete.value) {
        loading.value = true;
        router.delete(route('admin.devotionals.destroy', devotionalToDelete.value.id), {
            onFinish: () => {
                loading.value = false;
                showDeleteDialog.value = false;
                devotionalToDelete.value = null;
            }
        });
    }
};
</script>

<template>
    <Head title="Manajemen Renungan" />

    <AdminLayout>
        <template #header>
            Manajemen Renungan Harian
        </template>

        <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 overflow-hidden">
            <template v-slot:text>
                <div class="d-flex flex-column flex-sm-row align-center justify-space-between gap-4 mb-6 pt-2">
                    <v-text-field
                        v-model="search"
                        label="Cari Renungan..."
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
                        prepend-icon="mdi-book-plus-outline"
                        rounded="lg"
                        height="48"
                        class="text-none font-weight-black px-6 elevation-2"
                        @click="router.visit(route('admin.devotionals.create'))"
                    >
                        Tambah Renungan
                    </v-btn>
                </div>

                <v-data-table
                    :headers="headers"
                    :items="devotionals.data"
                    :search="search"
                    hover
                    class="bg-transparent"
                >
                    <template v-slot:item.date="{ item }">
                        <span class="font-weight-bold text-slate-500">
                             {{ new Date(item.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                        </span>
                    </template>

                    <template v-slot:item.title="{ item }">
                        <span class="font-weight-black text-slate-900 dark:text-white">{{ item.title }}</span>
                    </template>

                    <template v-slot:item.author="{ item }">
                        <span class="text-caption font-bold text-slate-400 italic">{{ item.author || '-' }}</span>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <div class="d-flex justify-end gap-1">
                            <v-btn
                                icon="mdi-pencil-outline"
                                variant="text"
                                color="primary"
                                density="comfortable"
                                @click="router.visit(route('admin.devotionals.edit', item.id))"
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
                    Hapus Renungan?
                </v-card-title>
                <v-card-text class="pt-2 font-weight-bold text-slate-600 dark:text-slate-400">
                    Apakah Anda yakin ingin menghapus renungan ini secara permanen?
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
                        @click="deleteDevotional"
                    >Ya, Hapus</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AdminLayout>
</template>
