<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    family: Object,
    available_members: Array
});

const form = useForm({
    name: props.family.name,
    kk_number: props.family.kk_number,
    address: props.family.address,
});

const addMemberForm = useForm({
    member_id: '',
    family_role: 'Kepala Keluarga'
});

const showRemoveDialog = ref(false);
const memberToRemove = ref(null);

const submit = () => {
    form.put(route('admin.families.update', props.family.id));
};

const addMember = () => {
    addMemberForm.post(route('admin.families.add_member', props.family.id), {
        onSuccess: () => {
            addMemberForm.reset();
        }
    });
};

const confirmRemove = (member) => {
    memberToRemove.value = member;
    showRemoveDialog.value = true;
};

const removeMember = () => {
    if (memberToRemove.value) {
        router.delete(route('admin.families.remove_member', [props.family.id, memberToRemove.value.id]), {
            onFinish: () => {
                showRemoveDialog.value = false;
                memberToRemove.value = null;
            }
        });
    }
};

const roles = ['Kepala Keluarga', 'Istri', 'Anak', 'Orang Tua', 'Saudara/Lainnya'];
</script>

<template>
    <Head :title="'Edit ' + family.name" />

    <AdminLayout>
        <template #header>
            Kelola Keluarga: {{ family.name }}
        </template>

        <v-row>
            <v-col cols="12" lg="8">
                <!-- Basic Info Card -->
                <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-10 mb-8">
                    <div class="d-flex align-center gap-3 mb-8">
                        <v-avatar color="primary" variant="tonal" rounded="lg">
                            <v-icon>mdi-information-outline</v-icon>
                        </v-avatar>
                        <h3 class="text-h6 font-weight-black text-slate-900 dark:text-white">Informasi Dasar</h3>
                    </div>

                    <v-form @submit.prevent="submit">
                        <v-row>
                            <v-col cols="12" md="6">
                                <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Nama Keluarga</div>
                                <v-text-field
                                    v-model="form.name"
                                    variant="outlined"
                                    rounded="lg"
                                    color="primary"
                                    required
                                    hide-details="auto"
                                    :error-messages="form.errors.name"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Nomor KK</div>
                                <v-text-field
                                    v-model="form.kk_number"
                                    variant="outlined"
                                    rounded="lg"
                                    color="primary"
                                    hide-details="auto"
                                    :error-messages="form.errors.kk_number"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Alamat</div>
                                <v-textarea
                                    v-model="form.address"
                                    variant="outlined"
                                    rounded="lg"
                                    color="primary"
                                    rows="3"
                                    hide-details="auto"
                                    :error-messages="form.errors.address"
                                ></v-textarea>
                            </v-col>
                            <v-col cols="12" class="pt-6">
                                <v-btn
                                    type="submit"
                                    color="primary"
                                    rounded="lg"
                                    class="text-none font-weight-black px-8"
                                    :loading="form.processing"
                                >Update Informasi</v-btn>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card>

                <!-- Members List Card -->
                <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 pa-md-10">
                    <div class="d-flex align-center gap-3 mb-8">
                        <v-avatar color="primary" variant="tonal" rounded="lg">
                            <v-icon>mdi-account-group-outline</v-icon>
                        </v-avatar>
                        <h3 class="text-h6 font-weight-black text-slate-900 dark:text-white">Anggota Keluarga</h3>
                    </div>

                    <v-list class="bg-transparent pa-0">
                        <template v-for="(member, index) in family.members" :key="member.id">
                            <v-list-item class="px-0 py-4">
                                <template v-slot:prepend>
                                    <v-avatar color="slate-lighten-4" class="dark:bg-slate-800" size="48" rounded="lg">
                                        <span class="text-subtitle-1 font-weight-black text-slate-500">{{ member.name.charAt(0) }}</span>
                                    </v-avatar>
                                </template>

                                <v-list-item-title class="text-subtitle-1 font-weight-black text-slate-900 dark:text-white">
                                    {{ member.name }}
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    <v-chip size="x-small" color="primary" class="font-weight-black px-3 mt-1" variant="flat">
                                        {{ member.family_role.toUpperCase() }}
                                    </v-chip>
                                </v-list-item-subtitle>

                                <template v-slot:append>
                                    <v-btn
                                        icon="mdi-account-remove-outline"
                                        variant="text"
                                        color="error"
                                        density="comfortable"
                                        @click="confirmRemove(member)"
                                    >
                                        <v-tooltip activator="parent" location="top">Lepaskan dari Keluarga</v-tooltip>
                                    </v-btn>
                                </template>
                            </v-list-item>
                            <v-divider v-if="index < family.members.length - 1" class="border-opacity-25"></v-divider>
                        </template>

                        <div v-if="family.members.length === 0" class="py-12 bg-slate-50 dark:bg-slate-800/50 rounded-xl text-center">
                            <v-icon size="48" color="slate-lighten-4" class="mb-2">mdi-account-question-outline</v-icon>
                            <p class="text-caption font-bold text-slate-400 italic">Belum ada anggota yang terhubung.</p>
                        </div>
                    </v-list>
                </v-card>
            </v-col>

            <!-- Sidebar -->
            <v-col cols="12" lg="4">
                <v-card rounded="xl" elevation="0" class="border border-slate-100 dark:border-slate-800 pa-6 sticky-top">
                    <h3 class="text-h6 font-weight-black text-slate-900 dark:text-white mb-2">Hubungkan Anggota</h3>
                    <p class="text-caption font-bold text-slate-500 mb-8">Tambahkan jemaat ke dalam struktur keluarga ini.</p>

                    <v-form @submit.prevent="addMember">
                        <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Pilih Jemaat</div>
                        <v-select
                            v-model="addMemberForm.member_id"
                            :items="available_members"
                            item-title="name"
                            item-value="id"
                            placeholder="Cari nama anggota..."
                            variant="outlined"
                            rounded="lg"
                            color="primary"
                            class="mb-4"
                            hide-details="auto"
                            :error-messages="addMemberForm.errors.member_id"
                        ></v-select>

                        <div class="text-subtitle-2 font-weight-black mb-2 text-slate-700 dark:text-slate-300">Hubungan / Peran</div>
                        <v-select
                            v-model="addMemberForm.family_role"
                            :items="roles"
                            variant="outlined"
                            rounded="lg"
                            color="primary"
                            class="mb-6"
                            hide-details="auto"
                            :error-messages="addMemberForm.errors.family_role"
                        ></v-select>

                        <v-btn
                            type="submit"
                            color="primary"
                            block
                            height="48"
                            rounded="lg"
                            class="text-none font-weight-black"
                            prepend-icon="mdi-account-plus-outline"
                            :disabled="!addMemberForm.member_id"
                            :loading="addMemberForm.processing"
                        >Tambah Anggota</v-btn>
                    </v-form>

                    <v-alert
                        v-if="available_members.length === 0"
                        color="warning"
                        variant="tonal"
                        rounded="lg"
                        class="mt-6 border-0"
                        density="compact"
                    >
                        <template v-slot:prepend>
                            <v-icon size="small">mdi-alert-circle-outline</v-icon>
                        </template>
                        <div class="text-caption font-bold">Semua jemaat sudah terdaftar dalam keluarga.</div>
                    </v-alert>
                </v-card>
            </v-col>
        </v-row>

        <!-- Remove Member Dialog -->
        <v-dialog v-model="showRemoveDialog" max-width="400">
            <v-card rounded="xl" class="pa-4">
                <v-card-title class="d-flex align-center gap-3 font-weight-black text-warning">
                    <v-icon>mdi-account-remove-outline</v-icon>
                    Lepaskan Anggota?
                </v-card-title>
                <v-card-text class="pt-2 font-weight-bold text-slate-600 dark:text-slate-400">
                    Apakah Anda yakin ingin melepaskan <strong>{{ memberToRemove?.name }}</strong> dari keluarga ini? Data anggota tetap ada, hanya hubungan keluarganya yang dihapus.
                </v-card-text>
                <v-card-actions class="pt-4">
                    <v-spacer></v-spacer>
                    <v-btn variant="text" rounded="lg" class="text-none font-weight-black px-4" @click="showRemoveDialog = false">Batal</v-btn>
                    <v-btn
                        color="warning"
                        variant="flat"
                        rounded="lg"
                        class="text-none font-weight-black px-6"
                        @click="removeMember"
                    >Ya, Lepaskan</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </AdminLayout>
</template>

<style scoped>
.sticky-top {
    position: sticky;
    top: 24px;
}
</style>
