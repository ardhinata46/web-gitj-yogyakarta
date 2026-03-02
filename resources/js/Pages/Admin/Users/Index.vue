<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    users: Array,
    roles: Array,
});

const savingId = ref(null);

const updateRoles = (userId, roleIds) => {
    savingId.value = userId;
    router.put(route('admin.users.roles.update', userId), { role_ids: roleIds }, {
        onFinish: () => { savingId.value = null; },
    });
};
</script>

<template>
    <Head title="Manajemen Pengguna" />

    <AdminLayout>
        <template #header>
            Manajemen Pengguna
        </template>

        <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 overflow-hidden">
            <template v-slot:text>
                <v-data-table
                    :headers="[
                        { title: 'Nama', key: 'name' },
                        { title: 'Email', key: 'email' },
                        { title: 'Role', key: 'roles' },
                        { title: 'Aksi', key: 'actions' },
                    ]"
                    :items="users"
                    class="bg-transparent users-table"
                >
                    <template v-slot:item.roles="{ item }">
                        <v-select
                            :items="roles"
                            item-title="name"
                            item-value="id"
                            multiple
                            chips
                            density="compact"
                            variant="solo-filled"
                            rounded="lg"
                            hide-details
                            :model-value="item.roles?.map(r => r.id)"
                            @update:model-value="(val) => updateRoles(item.id, val)"
                            style="min-width: 220px"
                        ></v-select>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <v-chip
                            v-if="savingId === item.id"
                            size="x-small"
                            color="primary"
                            variant="tonal"
                            class="font-weight-black"
                        >
                            Menyimpan...
                        </v-chip>
                    </template>
                </v-data-table>
            </template>
        </v-card>
    </AdminLayout>
</template>

<style>
.users-table .v-data-table-header th {
    font-weight: 800 !important;
    text-transform: uppercase !important;
    font-size: 0.75rem !important;
    letter-spacing: 0.05em !important;
    color: #64748b !important;
    background: rgba(var(--v-theme-surface), 0.05) !important;
}

.dark .users-table .v-data-table-header th {
    color: #94a3b8 !important;
}
</style>
