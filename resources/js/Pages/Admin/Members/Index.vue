<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    members: Object
});

const search = ref('');
const showDeleteDialog = ref(false);
const memberToDelete = ref(null);
const loading = ref(false);

const headers = [
    { title: 'Nama', key: 'name', align: 'start', sortable: true },
    { title: 'Gender', key: 'gender', sortable: true },
    { title: 'Kelompok', key: 'church_group', sortable: true },
    { title: 'Status', key: 'status', align: 'center' },
    { title: 'Aksi', key: 'actions', align: 'end', sortable: false },
];

const confirmDelete = (item) => {
    memberToDelete.value = item;
    showDeleteDialog.value = true;
};

const deleteMember = () => {
    if (memberToDelete.value) {
        loading.value = true;
        router.delete(route('admin.members.destroy', memberToDelete.value.id), {
            onFinish: () => {
                loading.value = false;
                showDeleteDialog.value = false;
                memberToDelete.value = null;
            }
        });
    }
};
</script>

<template>
    <Head title="Manajemen Anggota" />

    <AdminLayout>
        <template #header>
            Manajemen Anggota
        </template>

        <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 overflow-hidden">
            <template v-slot:text>
                <div class="d-flex flex-column flex-sm-row align-center justify-space-between gap-4 mb-6 pt-2">
                    <div class="d-flex align-center gap-4 w-full w-sm-auto">
                        <v-text-field
                            v-model="search"
                            label="Cari Anggota..."
                            prepend-inner-icon="mdi-magnify"
                            variant="solo-filled"
                            flat
                            rounded="lg"
                            hide-details
                            density="comfortable"
                            max-width="300"
                            class="grow-1"
                        ></v-text-field>
                    </div>
                    
                    <v-btn
                        color="primary"
                        prepend-icon="mdi-account-plus"
                        rounded="lg"
                        height="48"
                        class="text-none font-weight-black px-6 elevation-2"
                        @click="router.visit(route('admin.members.create'))"
                    >
                        Tambah Anggota
                    </v-btn>
                </div>

                <v-data-table
                    :headers="headers"
                    :items="members.data"
                    :search="search"
                    hover
                    class="bg-transparent members-table"
                >
                    <template v-slot:item.name="{ item }">
                        <div class="d-flex align-center gap-3 py-2">
                            <v-avatar color="primary" variant="tonal" size="36">
                                <span class="text-caption font-bold">{{ item.name.charAt(0) }}</span>
                            </v-avatar>
                            <div>
                                <div class="font-weight-black text-slate-900 dark:text-white">{{ item.name }}</div>
                                <div class="text-caption font-bold text-slate-400">{{ item.phone || 'Tanpa Telepon' }}</div>
                            </div>
                        </div>
                    </template>

                    <template v-slot:item.gender="{ item }">
                        <v-chip size="small" :color="item.gender === 'L' ? 'info' : 'pink'" variant="tonal" class="font-weight-bold">
                            {{ item.gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </v-chip>
                    </template>

                    <template v-slot:item.church_group="{ item }">
                        <span class="font-weight-bold text-slate-600 dark:text-slate-400">{{ item.church_group || '-' }}</span>
                    </template>

                    <template v-slot:item.status="{ item }">
                        <v-chip
                            size="x-small"
                            class="font-weight-black uppercase tracking-widest px-4"
                            :color="
                                item.status === 'aktif' ? 'success' : 
                                item.status === 'pasif' ? 'warning' : 
                                item.status === 'meninggal' ? 'error' : 'secondary'
                            "
                            variant="flat"
                        >
                            {{ item.status }}
                        </v-chip>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <div class="d-flex justify-end gap-1">
                            <v-btn
                                icon="mdi-pencil-outline"
                                variant="text"
                                color="primary"
                                density="comfortable"
                                @click="router.visit(route('admin.members.edit', item.id))"
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

                    <template v-slot:no-data>
                        <div class="text-center py-12">
                            <v-icon size="64" color="slate-lighten-4" class="mb-4">mdi-account-off</v-icon>
                            <div class="text-h6 font-black text-slate-400">Data Tidak Ditemukan</div>
                        </div>
                    </template>
                </v-data-table>
            </template>
        </v-card>

        <!-- Delete Dialog -->
        <v-dialog v-slot:default="{ isActive }" v-model="showDeleteDialog" max-width="400">
            <v-card rounded="xl" class="pa-4">
                <v-card-title class="d-flex align-center gap-3 font-weight-black text-error">
                    <v-icon>mdi-alert-circle-outline</v-icon>
                    Konfirmasi Hapus
                </v-card-title>
                <v-card-text class="pt-2 font-weight-bold text-slate-600 dark:text-slate-400">
                    Apakah Anda yakin ingin menghapus <strong>{{ memberToDelete?.name }}</strong>? Data yang dihapus tidak dapat dipulihkan.
                </v-card-text>
                <v-card-actions class="pt-4">
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="text"
                        rounded="lg"
                        class="text-none font-weight-black px-4"
                        @click="showDeleteDialog = false"
                    >
                        Batal
                    </v-btn>
                    <v-btn
                        color="error"
                        variant="flat"
                        rounded="lg"
                        class="text-none font-weight-black px-6"
                        :loading="loading"
                        @click="deleteMember"
                    >
                        Ya, Hapus
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AdminLayout>
</template>

<style>
.members-table .v-data-table-header th {
    font-weight: 800 !important;
    text-transform: uppercase !important;
    font-size: 0.75rem !important;
    letter-spacing: 0.05em !important;
    color: #64748b !important;
    background: rgba(var(--v-theme-surface), 0.05) !important;
}

.dark .members-table .v-data-table-header th {
    color: #94a3b8 !important;
}

.members-table .v-data-table__tr:hover {
    background-color: rgba(var(--v-theme-primary), 0.02) !important;
}
</style>
