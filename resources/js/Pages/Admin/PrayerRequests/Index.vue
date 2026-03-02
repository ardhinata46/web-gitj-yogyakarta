<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    items: Array
});

const search = ref('');
const showDeleteDialog = ref(false);
const itemToDelete = ref(null);
const loading = ref(false);

const headers = [
    { title: 'Tanggal', key: 'created_at', sortable: true },
    { title: 'Pengirim', key: 'from', sortable: true },
    { title: 'Permohonan', key: 'request' },
    { title: 'Status', key: 'status', align: 'center', sortable: true },
    { title: 'Aksi', key: 'actions', align: 'end', sortable: false },
];

const updateStatus = (id, status) => {
    router.patch(route('admin.prayer_requests.update_status', id), { status });
};

const confirmDelete = (item) => {
    itemToDelete.value = item;
    showDeleteDialog.value = true;
};

const deleteRequest = () => {
    if (itemToDelete.value) {
        loading.value = true;
        router.delete(route('admin.prayer_requests.destroy', itemToDelete.value.id), {
            onFinish: () => {
                loading.value = false;
                showDeleteDialog.value = false;
                itemToDelete.value = null;
            }
        });
    }
};

const getStatusColor = (status) => {
    switch(status) {
        case 'pending': return 'warning';
        case 'prayed_for': return 'success';
        case 'archived': return 'secondary';
        default: return 'grey';
    }
};
</script>

<template>
    <Head title="Permohonan Doa" />

    <AdminLayout>
        <template #header>
            Permohonan Doa Jemaat
        </template>

        <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 overflow-hidden">
            <template v-slot:text>
                <div class="d-flex flex-column flex-sm-row align-center justify-space-between gap-4 mb-6 pt-2">
                    <v-text-field
                        v-model="search"
                        label="Cari Permohonan..."
                        prepend-inner-icon="mdi-magnify"
                        variant="solo-filled"
                        flat
                        rounded="lg"
                        hide-details
                        density="comfortable"
                        max-width="380"
                        class="grow-1"
                    ></v-text-field>
                </div>

                <v-data-table
                    :headers="headers"
                    :items="items"
                    :search="search"
                    hover
                    class="bg-transparent"
                >
                    <template v-slot:item.created_at="{ item }">
                        <span class="text-caption font-bold text-slate-500">
                            {{ new Date(item.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                        </span>
                    </template>

                    <template v-slot:item.from="{ item }">
                        <div>
                            <div class="font-weight-black text-slate-900 dark:text-white">{{ item.is_anonymous ? 'Hamba Tuhan (Anonim)' : item.name }}</div>
                            <div v-if="!item.is_anonymous" class="text-caption font-bold text-slate-400">{{ item.phone }}</div>
                        </div>
                    </template>

                    <template v-slot:item.request="{ item }">
                        <div class="text-body-2 font-medium py-4 text-slate-700 dark:text-slate-300 leading-relaxed max-w-md">
                            {{ item.request }}
                        </div>
                    </template>

                    <template v-slot:item.status="{ item }">
                        <v-chip
                            size="x-small"
                            class="font-weight-black uppercase tracking-widest px-3"
                            :color="getStatusColor(item.status)"
                            variant="flat"
                        >
                            {{ item.status.replace('_', ' ') }}
                        </v-chip>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <div class="d-flex justify-end gap-1">
                            <v-btn
                                v-if="item.status === 'pending'"
                                icon="mdi-check-circle-outline"
                                variant="text"
                                color="success"
                                density="comfortable"
                                @click="updateStatus(item.id, 'prayed_for')"
                            >
                                <v-tooltip activator="parent" location="top">Didoakan</v-tooltip>
                            </v-btn>
                            <v-btn
                                v-if="item.status !== 'archived'"
                                icon="mdi-archive-outline"
                                variant="text"
                                color="secondary"
                                density="comfortable"
                                @click="updateStatus(item.id, 'archived')"
                            >
                                <v-tooltip activator="parent" location="top">Arsipkan</v-tooltip>
                            </v-btn>
                            <v-btn
                                icon="mdi-delete-outline"
                                variant="text"
                                color="error"
                                density="comfortable"
                                @click="confirmDelete(item)"
                            >
                                <v-tooltip activator="parent" location="top">Hapus</v-tooltip>
                            </v-btn>
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
                    Hapus Permohonan?
                </v-card-title>
                <v-card-text class="pt-2 font-weight-bold text-slate-600 dark:text-slate-400">
                    Apakah Anda yakin ingin menghapus permohonan doa ini?
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
                        @click="deleteRequest"
                    >Ya, Hapus</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AdminLayout>
</template>
