<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    roles: Array,
    permissions: Array,
    users: Array,
});

const saving = ref(false);
const roleMap = ref(
    props.roles?.reduce((acc, role) => {
        acc[role.name] = role.permissions?.map((p) => p.name) || [];
        return acc;
    }, {}) || {}
);

const roleNames = computed(() => Object.keys(roleMap.value));

const isSuperAdmin = (role) => role === 'super_admin';

const hasPermission = (role, permission) => {
    const perms = roleMap.value[role] || [];
    if (perms.includes('*')) return true;
    return perms.includes(permission);
};

const togglePermission = (role, permission) => {
    const perms = roleMap.value[role] || [];
    if (perms.includes('*')) return;
    if (perms.includes(permission)) {
        roleMap.value[role] = perms.filter((p) => p !== permission);
    } else {
        roleMap.value[role] = [...perms, permission];
    }
};

const save = () => {
    saving.value = true;
    router.post(route('admin.roles_permissions.update'), { roles: roleMap.value }, {
        onFinish: () => { saving.value = false; },
    });
};

const roleForm = ref({ name: '', label: '' });
const permissionForm = ref({ name: '', label: '' });
const selectedUserId = ref('');
const selectedRoleIds = ref([]);
const showEditDialog = ref(false);
const showDeleteDialog = ref(false);
const editType = ref('role');
const editForm = ref({ id: null, name: '', label: '' });
const deleteTarget = ref(null);

const submitRole = () => {
    if (!roleForm.value.name) return;
    router.post(route('admin.roles_permissions.roles.store'), roleForm.value, {
        onFinish: () => { roleForm.value = { name: '', label: '' }; },
    });
};

const submitPermission = () => {
    if (!permissionForm.value.name) return;
    router.post(route('admin.roles_permissions.permissions.store'), permissionForm.value, {
        onFinish: () => { permissionForm.value = { name: '', label: '' }; },
    });
};

const assignRoles = () => {
    if (!selectedUserId.value) return;
    router.post(route('admin.roles_permissions.assign'), {
        user_id: selectedUserId.value,
        role_ids: selectedRoleIds.value,
    });
};

const editRole = (role) => {
    if (role.name === 'super_admin') return;
    editType.value = 'role';
    editForm.value = { id: role.id, name: role.name, label: role.label || '' };
    showEditDialog.value = true;
};

const editPermission = (permission) => {
    editType.value = 'permission';
    editForm.value = { id: permission.id, name: permission.name, label: permission.label || '' };
    showEditDialog.value = true;
};

const saveEdit = () => {
    if (!editForm.value.name) return;
    if (editType.value === 'role') {
        router.put(route('admin.roles_permissions.roles.update', editForm.value.id), editForm.value, {
            onFinish: () => { showEditDialog.value = false; },
        });
    } else {
        router.put(route('admin.roles_permissions.permissions.update', editForm.value.id), editForm.value, {
            onFinish: () => { showEditDialog.value = false; },
        });
    }
};

const confirmDelete = (type, item) => {
    if (type === 'role' && item.name === 'super_admin') return;
    deleteTarget.value = item;
    editType.value = type;
    showDeleteDialog.value = true;
};

const doDelete = () => {
    if (!deleteTarget.value) return;
    if (editType.value === 'role') {
        router.delete(route('admin.roles_permissions.roles.destroy', deleteTarget.value.id), {
            onFinish: () => { showDeleteDialog.value = false; },
        });
    } else {
        router.delete(route('admin.roles_permissions.permissions.destroy', deleteTarget.value.id), {
            onFinish: () => { showDeleteDialog.value = false; },
        });
    }
};
</script>

<template>
    <Head title="Role & Akses" />

    <AdminLayout>
        <template #header>
            Role & Akses
        </template>

        <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 overflow-hidden">
            <template v-slot:text>
                <div class="d-flex flex-column flex-sm-row align-center justify-space-between gap-4 mb-6 pt-2">
                    <div>
                        <div class="text-h6 font-black">Manajemen Role & Permission</div>
                        <div class="text-caption font-weight-bold text-slate-500 dark:text-slate-400">
                            Perubahan akan disimpan ke database
                        </div>
                    </div>
                    <v-btn
                        color="primary"
                        rounded="lg"
                        class="text-none font-weight-black"
                        :loading="saving"
                        @click="save"
                    >
                        Simpan Perubahan
                    </v-btn>
                </div>

                <div class="role-grid mb-8">
                    <div v-for="role in roleNames" :key="role" class="role-card">
                        <div class="role-header">
                            <div class="role-title">{{ role.replace('_', ' ') }}</div>
                            <v-chip v-if="isSuperAdmin(role)" color="primary" size="x-small" class="font-weight-black">ALL</v-chip>
                        </div>

                        <div class="permission-list">
                            <v-checkbox
                                v-for="permission in permissions"
                                :key="permission.name"
                                :label="permission.name"
                                :model-value="hasPermission(role, permission.name)"
                                density="compact"
                                hide-details
                                :disabled="isSuperAdmin(role)"
                                @update:model-value="() => togglePermission(role, permission.name)"
                            ></v-checkbox>
                        </div>
                    </div>
                </div>

                <div class="grid-two">
                    <v-card class="pa-4 rounded-xl border" elevation="0">
                        <div class="text-subtitle-1 font-black mb-4">Tambah Role</div>
                        <v-text-field v-model="roleForm.name" label="Role key (alpha_dash)" density="comfortable" variant="solo-filled" rounded="lg" hide-details class="mb-3"></v-text-field>
                        <v-text-field v-model="roleForm.label" label="Label (opsional)" density="comfortable" variant="solo-filled" rounded="lg" hide-details class="mb-3"></v-text-field>
                        <v-btn color="primary" class="text-none font-weight-black" rounded="lg" @click="submitRole">Simpan Role</v-btn>
                        <v-divider class="my-4"></v-divider>
                        <div class="text-caption font-weight-black text-slate-500 mb-2">Role Tersedia</div>
                        <div class="list-box">
                            <div v-for="role in roles" :key="role.id" class="list-item">
                                <div>
                                    <div class="font-weight-black">{{ role.name }}</div>
                                    <div class="text-caption text-slate-400">{{ role.label || '-' }}</div>
                                </div>
                                <div class="d-flex gap-1">
                                    <v-btn icon="mdi-pencil-outline" variant="text" size="small" :disabled="role.name === 'super_admin'" @click="editRole(role)"></v-btn>
                                    <v-btn icon="mdi-delete-outline" variant="text" size="small" color="error" :disabled="role.name === 'super_admin'" @click="confirmDelete('role', role)"></v-btn>
                                </div>
                            </div>
                        </div>
                    </v-card>

                    <v-card class="pa-4 rounded-xl border" elevation="0">
                        <div class="text-subtitle-1 font-black mb-4">Tambah Permission</div>
                        <v-text-field v-model="permissionForm.name" label="Permission key (alpha_dash)" density="comfortable" variant="solo-filled" rounded="lg" hide-details class="mb-3"></v-text-field>
                        <v-text-field v-model="permissionForm.label" label="Label (opsional)" density="comfortable" variant="solo-filled" rounded="lg" hide-details class="mb-3"></v-text-field>
                        <v-btn color="primary" class="text-none font-weight-black" rounded="lg" @click="submitPermission">Simpan Permission</v-btn>
                        <v-divider class="my-4"></v-divider>
                        <div class="text-caption font-weight-black text-slate-500 mb-2">Permission Tersedia</div>
                        <div class="list-box">
                            <div v-for="permission in permissions" :key="permission.id" class="list-item">
                                <div>
                                    <div class="font-weight-black">{{ permission.name }}</div>
                                    <div class="text-caption text-slate-400">{{ permission.label || '-' }}</div>
                                </div>
                                <div class="d-flex gap-1">
                                    <v-btn icon="mdi-pencil-outline" variant="text" size="small" @click="editPermission(permission)"></v-btn>
                                    <v-btn
                                        icon="mdi-delete-outline"
                                        variant="text"
                                        size="small"
                                        color="error"
                                        :disabled="permission.role_count > 0"
                                        @click="confirmDelete('permission', permission)"
                                    ></v-btn>
                                </div>
                            </div>
                        </div>
                    </v-card>
                </div>

                <v-card class="pa-4 rounded-xl border mt-6" elevation="0">
                    <div class="text-subtitle-1 font-black mb-4">Assign Role ke User</div>
                    <div class="d-flex flex-column flex-sm-row gap-4">
                        <v-select
                            v-model="selectedUserId"
                            :items="users"
                            item-title="name"
                            item-value="id"
                            label="Pilih User"
                            variant="solo-filled"
                            rounded="lg"
                            hide-details
                            density="comfortable"
                            class="flex-1"
                        ></v-select>
                        <v-select
                            v-model="selectedRoleIds"
                            :items="roles"
                            item-title="name"
                            item-value="id"
                            label="Pilih Role"
                            variant="solo-filled"
                            rounded="lg"
                            hide-details
                            density="comfortable"
                            multiple
                            chips
                            class="flex-1"
                        ></v-select>
                        <v-btn color="primary" class="text-none font-weight-black" rounded="lg" @click="assignRoles">Simpan</v-btn>
                    </div>
                </v-card>

                <v-dialog v-model="showEditDialog" max-width="420">
                    <v-card rounded="xl" class="pa-4">
                        <v-card-title class="font-weight-black">
                            {{ editType === 'role' ? 'Edit Role' : 'Edit Permission' }}
                        </v-card-title>
                        <v-card-text>
                            <v-text-field v-model="editForm.name" label="Key" density="comfortable" variant="solo-filled" rounded="lg" hide-details class="mb-3"></v-text-field>
                            <v-text-field v-model="editForm.label" label="Label (opsional)" density="comfortable" variant="solo-filled" rounded="lg" hide-details></v-text-field>
                        </v-card-text>
                        <v-card-actions class="pt-2">
                            <v-spacer></v-spacer>
                            <v-btn variant="text" rounded="lg" class="text-none font-weight-black" @click="showEditDialog=false">Batal</v-btn>
                            <v-btn color="primary" rounded="lg" class="text-none font-weight-black" @click="saveEdit">Simpan</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-dialog v-model="showDeleteDialog" max-width="420">
                    <v-card rounded="xl" class="pa-4">
                        <v-card-title class="font-weight-black text-error">Konfirmasi Hapus</v-card-title>
                        <v-card-text class="font-weight-bold text-slate-600 dark:text-slate-400">
                            Yakin ingin menghapus <strong>{{ deleteTarget?.name }}</strong>?
                        </v-card-text>
                        <v-card-actions class="pt-2">
                            <v-spacer></v-spacer>
                            <v-btn variant="text" rounded="lg" class="text-none font-weight-black" @click="showDeleteDialog=false">Batal</v-btn>
                            <v-btn color="error" rounded="lg" class="text-none font-weight-black" @click="doDelete">Hapus</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </template>
        </v-card>
    </AdminLayout>
</template>

<style>
.role-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 16px;
}

.role-card {
    border: 1px solid rgba(var(--v-theme-on-surface), 0.08);
    border-radius: 16px;
    padding: 16px;
    background: rgba(var(--v-theme-surface), 0.7);
}

.role-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}

.role-title {
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    font-size: 0.7rem;
    color: #64748b;
}

.permission-list {
    display: grid;
    grid-template-columns: 1fr;
    gap: 6px;
}

.grid-two {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}

@media (max-width: 900px) {
    .grid-two {
        grid-template-columns: 1fr;
    }
}

.list-box {
    display: grid;
    gap: 8px;
    max-height: 280px;
    overflow: auto;
    padding-right: 4px;
}

.list-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding: 8px 10px;
    border-radius: 12px;
    background: rgba(var(--v-theme-surface), 0.6);
    border: 1px solid rgba(var(--v-theme-on-surface), 0.06);
}
</style>
