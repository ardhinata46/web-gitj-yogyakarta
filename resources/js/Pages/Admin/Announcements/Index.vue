<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    announcements: Object
});

const search = ref('');
const showDeleteDialog = ref(false);
const announcementToDelete = ref(null);
const loading = ref(false);

const headers = [
    { title: 'Judul Warta', key: 'title', align: 'start', sortable: true },
    { title: 'Status', key: 'status', align: 'center' },
    { title: 'Tanggal', key: 'created_at', sortable: true },
    { title: 'Aksi', key: 'actions', align: 'end', sortable: false },
];

const confirmDelete = (item) => {
    announcementToDelete.value = item;
    showDeleteDialog.value = true;
};

const deleteAnnouncement = () => {
    if (announcementToDelete.value) {
        loading.value = true;
        router.delete(route('admin.announcements.destroy', announcementToDelete.value.id), {
            onFinish: () => {
                loading.value = false;
                showDeleteDialog.value = false;
                announcementToDelete.value = null;
            }
        });
    }
};
</script>

<template>
    <Head title="Manajemen Warta Jemaat" />

    <AdminLayout>
        <template #header>
            Warta Jemaat
        </template>

        <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 overflow-hidden">
            <template v-slot:text>
                <div class="d-flex flex-column flex-sm-row align-center justify-space-between gap-4 mb-6 pt-2">
                    <v-text-field
                        v-model="search"
                        label="Cari Warta..."
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
                        prepend-icon="mdi-bullhorn-plus"
                        rounded="lg"
                        height="48"
                        class="text-none font-weight-black px-6 elevation-2"
                        @click="router.visit(route('admin.announcements.create'))"
                    >
                        Terbitkan Warta
                    </v-btn>
                </div>

                <v-data-table
                    :headers="headers"
                    :items="announcements.data"
                    :search="search"
                    hover
                    class="bg-transparent announcements-table"
                >
                    <template v-slot:item.title="{ item }">
                        <div class="py-3">
                            <div class="font-weight-black text-slate-900 dark:text-white mb-1">{{ item.title }}</div>
                            <div class="text-caption font-bold text-slate-400 line-clamp-1" v-if="item.content">{{ item.content.substring(0, 60) }}...</div>
                        </div>
                    </template>

                    <template v-slot:item.status="{ item }">
                        <v-chip
                            size="x-small"
                            class="font-weight-black uppercase tracking-widest px-4"
                            :color="item.is_published ? 'success' : 'secondary'"
                            variant="tonal"
                        >
                            {{ item.is_published ? 'Published' : 'Draft' }}
                        </v-chip>
                    </template>

                    <template v-slot:item.created_at="{ item }">
                        <span class="font-weight-bold text-slate-500 dark:text-slate-400">
                            {{ new Date(item.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}
                        </span>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <div class="d-flex justify-end gap-1">
                            <v-btn
                                icon="mdi-pencil-outline"
                                variant="text"
                                color="primary"
                                density="comfortable"
                                @click="router.visit(route('admin.announcements.edit', item.id))"
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
                    Hapus Warta?
                </v-card-title>
                <v-card-text class="pt-2 font-weight-bold text-slate-600 dark:text-slate-400">
                    Apakah Anda yakin ingin menghapus warta <strong>{{ announcementToDelete?.title }}</strong>?
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
                        @click="deleteAnnouncement"
                    >
                        Ya, Hapus
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AdminLayout>
</template>

<style>
.announcements-table .v-data-table-header th {
    font-weight: 800 !important;
    text-transform: uppercase !important;
    font-size: 0.75rem !important;
    letter-spacing: 0.05em !important;
    color: #64748b !important;
}

.dark .announcements-table .v-data-table-header th {
    color: #94a3b8 !important;
}
</style>
