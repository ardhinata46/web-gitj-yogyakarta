<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    schedules: Object
});

const search = ref('');
const showDeleteDialog = ref(false);
const scheduleToDelete = ref(null);
const loading = ref(false);

const headers = [
    { title: 'Nama Kegiatan', key: 'title', align: 'start', sortable: true },
    { title: 'Waktu', key: 'time', sortable: true },
    { title: 'Lokasi', key: 'location', sortable: true },
    { title: 'Aksi', key: 'actions', align: 'end', sortable: false },
];

const confirmDelete = (item) => {
    scheduleToDelete.value = item;
    showDeleteDialog.value = true;
};

const deleteSchedule = () => {
    if (scheduleToDelete.value) {
        loading.value = true;
        router.delete(route('admin.schedules.destroy', scheduleToDelete.value.id), {
            onFinish: () => {
                loading.value = false;
                showDeleteDialog.value = false;
                scheduleToDelete.value = null;
            }
        });
    }
};
</script>

<template>
    <Head title="Manajemen Jadwal" />

    <AdminLayout>
        <template #header>
            Jadwal Ibadah & Kegiatan
        </template>

        <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 overflow-hidden">
            <template v-slot:text>
                <div class="d-flex flex-column flex-sm-row align-center justify-space-between gap-4 mb-6 pt-2">
                    <v-text-field
                        v-model="search"
                        label="Cari Kegiatan..."
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
                        prepend-icon="mdi-calendar-plus"
                        rounded="lg"
                        height="48"
                        class="text-none font-weight-black px-6 elevation-2"
                        @click="router.visit(route('admin.schedules.create'))"
                    >
                        Tambah Jadwal
                    </v-btn>
                </div>

                <v-data-table
                    :headers="headers"
                    :items="schedules.data"
                    :search="search"
                    hover
                    class="bg-transparent schedules-table"
                >
                    <template v-slot:item.title="{ item }">
                        <div class="d-flex align-center gap-3 py-2">
                            <v-avatar color="primary" variant="tonal" size="36">
                                <v-icon size="18">mdi-calendar-star</v-icon>
                            </v-avatar>
                            <div class="font-weight-black text-slate-900 dark:text-white">{{ item.title }}</div>
                        </div>
                    </template>

                    <template v-slot:item.time="{ item }">
                        <div class="d-flex align-center gap-2 font-weight-bold text-slate-600 dark:text-slate-400">
                            <v-icon size="16" color="primary">mdi-clock-outline</v-icon>
                            {{ item.time }}
                        </div>
                    </template>

                    <template v-slot:item.location="{ item }">
                        <div class="d-flex align-center gap-2 font-weight-bold text-slate-600 dark:text-slate-400">
                            <v-icon size="16" color="secondary">mdi-map-marker-outline</v-icon>
                            {{ item.location }}
                        </div>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <div class="d-flex justify-end gap-1">
                            <v-btn
                                icon="mdi-pencil-outline"
                                variant="text"
                                color="primary"
                                density="comfortable"
                                @click="router.visit(route('admin.schedules.edit', item.id))"
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
                    Hapus Jadwal?
                </v-card-title>
                <v-card-text class="pt-2 font-weight-bold text-slate-600 dark:text-slate-400">
                    Apakah Anda yakin ingin menghapus jadwal <strong>{{ scheduleToDelete?.title }}</strong>? Tindakan ini tidak dapat dibatalkan.
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
                        @click="deleteSchedule"
                    >
                        Ya, Hapus
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AdminLayout>
</template>

<style>
.schedules-table .v-data-table-header th {
    font-weight: 800 !important;
    text-transform: uppercase !important;
    font-size: 0.75rem !important;
    letter-spacing: 0.05em !important;
    color: #64748b !important;
}

.dark .schedules-table .v-data-table-header th {
    color: #94a3b8 !important;
}
</style>
