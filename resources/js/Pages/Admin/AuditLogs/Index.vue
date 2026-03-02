<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

const props = defineProps({
    auditLogs: Object,
    filters: Object,
});

const search = ref(props.filters?.search || '');
const method = ref(props.filters?.method || '');
const userId = ref(props.filters?.user_id || '');
const dateFrom = ref(props.filters?.date_from || '');
const dateTo = ref(props.filters?.date_to || '');
const showDetail = ref(false);
const selectedLog = ref(null);

const headers = [
    { title: 'Waktu', key: 'created_at', align: 'start', sortable: true },
    { title: 'User', key: 'user', sortable: false },
    { title: 'Aksi', key: 'action', sortable: true },
    { title: 'Metode', key: 'method', sortable: true },
    { title: 'Route', key: 'route_name', sortable: true },
    { title: 'IP', key: 'ip_address', sortable: true },
    { title: 'Detail', key: 'detail', sortable: false },
];

const formatDate = (value) => {
    if (!value) return '-';
    return new Date(value).toLocaleString('id-ID', {
        dateStyle: 'medium',
        timeStyle: 'short',
    });
};

const users = computed(() => {
    const unique = new Map();
    props.auditLogs.data.forEach((log) => {
        if (log.user?.id) {
            unique.set(log.user.id, log.user);
        }
    });
    return Array.from(unique.values());
});

const applyFilters = () => {
    router.get(
        route('admin.audit_logs.index'),
        {
            search: search.value || undefined,
            method: method.value || undefined,
            user_id: userId.value || undefined,
            date_from: dateFrom.value || undefined,
            date_to: dateTo.value || undefined,
        },
        { preserveState: true, replace: true }
    );
};

watch([method, userId], applyFilters);
</script>

<template>
    <Head title="Audit Log" />

    <AdminLayout>
        <template #header>
            Audit Log
        </template>

        <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 overflow-hidden">
            <template v-slot:text>
                <div class="d-flex flex-column flex-sm-row align-center justify-space-between gap-4 mb-6 pt-2">
                    <div class="d-flex align-center gap-4 w-full w-sm-auto">
                        <v-text-field
                            v-model="search"
                            label="Cari log..."
                            prepend-inner-icon="mdi-magnify"
                            variant="solo-filled"
                            flat
                            rounded="lg"
                            hide-details
                            density="comfortable"
                            max-width="320"
                            class="grow-1"
                            @keyup.enter="applyFilters"
                        ></v-text-field>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <v-select
                            v-model="method"
                            :items="['GET', 'POST', 'PUT', 'PATCH', 'DELETE']"
                            label="Metode"
                            variant="solo-filled"
                            flat
                            rounded="lg"
                            hide-details
                            density="comfortable"
                            clearable
                            style="min-width: 140px"
                        ></v-select>
                        <v-select
                            v-model="userId"
                            :items="users"
                            item-title="name"
                            item-value="id"
                            label="User"
                            variant="solo-filled"
                            flat
                            rounded="lg"
                            hide-details
                            density="comfortable"
                            clearable
                            style="min-width: 180px"
                        ></v-select>
                        <v-text-field
                            v-model="dateFrom"
                            label="Dari"
                            type="date"
                            variant="solo-filled"
                            flat
                            rounded="lg"
                            hide-details
                            density="comfortable"
                            style="min-width: 170px"
                            @change="applyFilters"
                        ></v-text-field>
                        <v-text-field
                            v-model="dateTo"
                            label="Sampai"
                            type="date"
                            variant="solo-filled"
                            flat
                            rounded="lg"
                            hide-details
                            density="comfortable"
                            style="min-width: 170px"
                            @change="applyFilters"
                        ></v-text-field>
                        <v-btn
                            color="secondary"
                            variant="tonal"
                            rounded="lg"
                            class="text-none font-weight-black"
                            @click="applyFilters"
                        >
                            Terapkan
                        </v-btn>
                    </div>
                </div>

                <v-data-table
                    :headers="headers"
                    :items="auditLogs.data"
                    :search="search"
                    hover
                    class="bg-transparent audit-table"
                >
                    <template v-slot:item.created_at="{ item }">
                        <div class="font-weight-black text-slate-700 dark:text-slate-300">
                            {{ formatDate(item.created_at) }}
                        </div>
                    </template>

                    <template v-slot:item.user="{ item }">
                        <div class="d-flex align-center gap-3 py-2">
                            <v-avatar color="primary" variant="tonal" size="34">
                                <span class="text-caption font-bold">{{ item.user?.name?.charAt(0) || '?' }}</span>
                            </v-avatar>
                            <div>
                                <div class="font-weight-black text-slate-900 dark:text-white">
                                    {{ item.user?.name || 'System' }}
                                </div>
                                <div class="text-caption font-bold text-slate-400">
                                    {{ item.user?.email || '-' }}
                                </div>
                            </div>
                        </div>
                    </template>

                    <template v-slot:item.action="{ item }">
                        <div class="font-weight-bold text-slate-700 dark:text-slate-300">
                            {{ item.action || '-' }}
                        </div>
                    </template>

                    <template v-slot:item.method="{ item }">
                        <v-chip
                            size="x-small"
                            class="font-weight-black uppercase tracking-widest px-3"
                            :color="
                                item.method === 'POST' ? 'success' :
                                item.method === 'PUT' ? 'info' :
                                item.method === 'PATCH' ? 'warning' :
                                item.method === 'DELETE' ? 'error' : 'secondary'
                            "
                            variant="flat"
                        >
                            {{ item.method }}
                        </v-chip>
                    </template>

                    <template v-slot:item.route_name="{ item }">
                        <div class="font-weight-bold text-slate-600 dark:text-slate-400">
                            {{ item.route_name || '-' }}
                        </div>
                        <div class="text-caption text-slate-400 truncate max-w-px-300">
                            {{ item.url }}
                        </div>
                    </template>

                    <template v-slot:item.ip_address="{ item }">
                        <span class="font-weight-bold text-slate-600 dark:text-slate-400">
                            {{ item.ip_address || '-' }}
                        </span>
                    </template>

                    <template v-slot:item.detail="{ item }">
                        <v-btn
                            icon="mdi-eye-outline"
                            variant="text"
                            color="primary"
                            density="comfortable"
                            @click="() => { selectedLog = item; showDetail = true; }"
                        ></v-btn>
                    </template>

                    <template v-slot:no-data>
                        <div class="text-center py-12">
                            <v-icon size="64" color="slate-lighten-4" class="mb-4">mdi-shield-outline</v-icon>
                            <div class="text-h6 font-black text-slate-400">Belum Ada Audit Log</div>
                        </div>
                    </template>
                </v-data-table>
            </template>
        </v-card>

        <v-dialog v-model="showDetail" max-width="720">
            <v-card rounded="xl" class="pa-4">
                <v-card-title class="d-flex align-center gap-3 font-weight-black">
                    <v-icon>mdi-shield-check-outline</v-icon>
                    Detail Audit Log
                </v-card-title>
                <v-card-text class="pt-2">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="label">Waktu</div>
                            <div class="value">{{ formatDate(selectedLog?.created_at) }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">User</div>
                            <div class="value">{{ selectedLog?.user?.name || 'System' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Email</div>
                            <div class="value">{{ selectedLog?.user?.email || '-' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Role</div>
                            <div class="value">{{ selectedLog?.user?.role || '-' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Method</div>
                            <div class="value">{{ selectedLog?.method }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Route</div>
                            <div class="value">{{ selectedLog?.route_name || '-' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">URL</div>
                            <div class="value">{{ selectedLog?.url || '-' }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">IP</div>
                            <div class="value">{{ selectedLog?.ip_address || '-' }}</div>
                        </div>
                        <div class="detail-item full">
                            <div class="label">User Agent</div>
                            <div class="value mono">{{ selectedLog?.user_agent || '-' }}</div>
                        </div>
                        <div class="detail-item full">
                            <div class="label">Payload</div>
                            <pre class="value mono">{{ JSON.stringify(selectedLog?.payload || {}, null, 2) }}</pre>
                        </div>
                    </div>
                </v-card-text>
                <v-card-actions class="pt-4">
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="text"
                        rounded="lg"
                        class="text-none font-weight-black px-4"
                        @click="showDetail = false"
                    >
                        Tutup
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AdminLayout>
</template>

<style>
.audit-table .v-data-table-header th {
    font-weight: 800 !important;
    text-transform: uppercase !important;
    font-size: 0.75rem !important;
    letter-spacing: 0.05em !important;
    color: #64748b !important;
    background: rgba(var(--v-theme-surface), 0.05) !important;
}

.dark .audit-table .v-data-table-header th {
    color: #94a3b8 !important;
}

.audit-table .v-data-table__tr:hover {
    background-color: rgba(var(--v-theme-primary), 0.02) !important;
}

.max-w-px-300 { max-width: 300px; }

.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}

.detail-item.full {
    grid-column: 1 / -1;
}

.detail-item .label {
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #94a3b8;
    margin-bottom: 6px;
}

.detail-item .value {
    font-weight: 700;
    color: #0f172a;
}

.dark .detail-item .value {
    color: #e2e8f0;
}

.mono {
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    white-space: pre-wrap;
}

@media (max-width: 700px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
}
</style>
