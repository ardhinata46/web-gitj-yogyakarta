<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { useTheme } from 'vuetify';

const props = defineProps({
    auth: Object
});

const theme = useTheme();
const drawer = ref(null);
const rail = ref(false);

const allNavItems = [
    { name: 'Dashboard', routeName: 'admin.dashboard', icon: 'mdi-view-dashboard-outline', roles: ['super_admin', 'secretary', 'treasurer', 'editor'] },
    { name: 'Keluarga', routeName: 'admin.families.index', icon: 'mdi-home-group', roles: ['super_admin', 'secretary'] },
    { name: 'Anggota', routeName: 'admin.members.index', icon: 'mdi-account-group-outline', roles: ['super_admin', 'secretary'] },
    { name: 'Keuangan', routeName: 'admin.transactions.index', icon: 'mdi-cash-multiple', roles: ['super_admin', 'treasurer'] },
    { name: 'Warta Jemaat', routeName: 'admin.announcements.index', icon: 'mdi-bullhorn-outline', roles: ['super_admin', 'editor', 'secretary'] },
    { name: 'Renungan', routeName: 'admin.devotionals.index', icon: 'mdi-book-open-page-variant-outline', roles: ['super_admin', 'editor', 'secretary'] },
    { name: 'Permohonan Doa', routeName: 'admin.prayer_requests.index', icon: 'mdi-hands-pray', roles: ['super_admin', 'secretary'] },
    { name: 'Jadwal Ibadah', routeName: 'admin.schedules.index', icon: 'mdi-calendar-clock-outline', roles: ['super_admin', 'secretary'] },
    { name: 'Galeri Foto', routeName: 'admin.gallery.index', icon: 'mdi-image-multiple-outline', roles: ['super_admin', 'editor'] },
    { name: 'Slider Depan', routeName: 'admin.sliders.index', icon: 'mdi-view-carousel-outline', roles: ['super_admin', 'editor'] },
    { name: 'Laporan', routeName: 'admin.reports.index', icon: 'mdi-file-chart-outline', roles: ['super_admin', 'secretary', 'treasurer'] },
    { name: 'Audit Log', routeName: 'admin.audit_logs.index', icon: 'mdi-shield-check-outline', roles: ['super_admin', 'secretary'] },
    { name: 'Role & Akses', routeName: 'admin.roles_permissions.index', icon: 'mdi-account-key-outline', roles: ['super_admin', 'roles_manager'] },
    { name: 'Pengguna', routeName: 'admin.users.index', icon: 'mdi-account-multiple-outline', roles: ['super_admin', 'roles_manager'] },
    { name: 'Profil Gereja', routeName: 'admin.profile.edit', icon: 'mdi-cog-outline', roles: ['super_admin'] },
];

const navItems = computed(() => {
    const roles = usePage().props.auth.user.role || [];
    return allNavItems.filter(item => item.roles.some((r) => roles.includes(r)));
});

const toggleTheme = () => {
    const newTheme = theme.global.name.value === 'dark' ? 'light' : 'dark';
    theme.global.name.value = newTheme;
    localStorage.setItem('theme', newTheme);
    
    if (newTheme === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

const logout = () => {
    router.post(route('logout'));
};

onMounted(() => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        theme.global.name.value = savedTheme;
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    } else {
        // Handle system preference or default
        const isDark = theme.global.name.value === 'dark';
        if (isDark) document.documentElement.classList.add('dark');
    }
});
</script>

<template>
    <v-app :theme="theme.global.name.value">
        <Head :title="$page.props.title" />

        <!-- Navigation Drawer -->
        <v-navigation-drawer
            v-model="drawer"
            :rail="rail"
            permanent
            @click="rail = false"
            elevation="0"
            class="sidebar-glow border-e"
        >
            <div class="pa-6 pb-2">
                <div class="d-flex align-center gap-3">
                    <v-avatar
                        color="primary"
                        rounded="xl"
                        size="44"
                        class="elevation-12"
                    >
                        <v-icon color="white" size="24">mdi-church</v-icon>
                    </v-avatar>
                    <div v-if="!rail" class="overflow-hidden">
                        <div class="text-subtitle-1 font-black leading-tight tracking-tight">GITJ Admin</div>
                        <div class="text-caption font-bold text-primary uppercase tracking-widest" style="font-size: 0.65rem;">System Management</div>
                    </div>
                </div>
            </div>

            <v-list nav density="comfortable" class="px-4 py-6">
                <v-list-item
                    v-for="item in navItems"
                    :key="item.name"
                    :prepend-icon="item.icon"
                    :active="route().current(item.routeName + '*')"
                    color="primary"
                    rounded="xl"
                    class="mb-2"
                    @click="router.visit(route(item.routeName))"
                    variant="flat"
                >
                    <v-list-item-title class="font-weight-black text-body-2">{{ item.name }}</v-list-item-title>
                    
                    <template v-slot:append v-if="route().current(item.routeName + '*')">
                        <div class="active-indicator"></div>
                    </template>
                </v-list-item>
            </v-list>

            <template v-slot:append>
                <div class="pa-4 bg-background">
                    <v-btn
                        block
                        color="error"
                        variant="tonal"
                        prepend-icon="mdi-logout-variant"
                        rounded="xl"
                        class="font-weight-black text-none"
                        @click="logout"
                        height="44"
                    >
                        <span v-if="!rail">Keluar Sistem</span>
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>

        <!-- App Bar -->
        <v-app-bar elevation="0" class="px-4 border-b" height="72">
            <v-btn
                icon="mdi-menu-open"
                variant="text"
                color="secondary"
                @click.stop="rail = !rail"
                :class="{ 'rotate-180 transition-transform': rail }"
            ></v-btn>
            
            <v-app-bar-title>
                <div class="d-flex align-center gap-2">
                    <span class="text-h6 font-black tracking-tight">
                        <slot name="header" />
                    </span>
                </div>
            </v-app-bar-title>

            <v-spacer></v-spacer>

            <div class="d-flex align-center gap-2">
                <!-- Theme Toggle -->
                <v-btn 
                    icon 
                    variant="tonal" 
                    size="small" 
                    @click="toggleTheme"
                    class="rounded-xl"
                >
                    <v-icon size="20">{{ theme.global.current.value.dark ? 'mdi-white-balance-sunny' : 'mdi-weather-night' }}</v-icon>
                </v-btn>

                <!-- Notifications -->
                <v-btn 
                    icon 
                    variant="tonal" 
                    size="small"
                    class="rounded-xl"
                >
                    <v-badge color="error" dot offset-x="2" offset-y="2">
                        <v-icon size="20">mdi-bell-outline</v-icon>
                    </v-badge>
                </v-btn>

                <div class="mx-2 h-6 w-px bg-border"></div>

                <!-- User Menu -->
                <v-menu min-width="240px" rounded="xl" transition="scale-transition">
                    <template v-slot:activator="{ props }">
                        <v-btn
                            v-bind="props"
                            variant="text"
                            class="px-2 rounded-xl h-auto py-2 hover-bg-light"
                        >
                            <div class="d-flex align-center gap-3">
                                <v-avatar color="primary" size="36" class="elevation-4 border-2 border-white">
                                    <span class="text-caption font-black">{{ $page.props.auth.user.name.charAt(0) }}</span>
                                </v-avatar>
                                <div class="text-start d-none d-sm-block">
                                    <div class="text-subtitle-2 font-black leading-tight">{{ $page.props.auth.user.name }}</div>
                                    <div class="text-caption font-bold text-primary uppercase" style="font-size: 0.6rem;">
                                        {{ ($page.props.auth.user.role || []).join(', ').replace(/_/g, ' ') }}
                                    </div>
                                </div>
                                <v-icon size="small" color="secondary">mdi-chevron-down</v-icon>
                            </div>
                        </v-btn>
                    </template>

                    <v-list nav class="pa-2 bg-surface elevation-24">
                        <div class="px-4 py-4 mb-2 bg-background rounded-xl">
                            <div class="text-caption font-bold text-slate-400 uppercase tracking-widest" style="font-size: 0.6rem;">Signed in as</div>
                            <div class="text-subtitle-2 font-black">{{ $page.props.auth.user.email }}</div>
                        </div>
                        
                        <v-list-item
                            prepend-icon="mdi-account-circle-outline"
                            title="Profile Saya"
                            rounded="lg"
                            class="font-weight-bold"
                            @click="router.visit(route('admin.profile.edit'))"
                        ></v-list-item>
                        
                        <v-list-item
                            prepend-icon="mdi-view-dashboard-outline"
                            title="Dashboard"
                            rounded="lg"
                            class="font-weight-bold"
                            @click="router.visit(route('admin.dashboard'))"
                        ></v-list-item>

                        <v-divider class="my-2"></v-divider>
                        
                        <v-list-item
                            prepend-icon="mdi-logout-variant"
                            title="Keluar"
                            color="error"
                            rounded="lg"
                            class="text-error font-weight-black"
                            @click="logout"
                        ></v-list-item>
                    </v-list>
                </v-menu>
            </div>
        </v-app-bar>

        <!-- Main Content -->
        <v-main>
            <v-container fluid class="pa-4 pa-md-8 max-w-[1600px] mx-auto">
                <v-fade-transition mode="out-in">
                    <div :key="$page.url">
                        <slot />
                    </div>
                </v-fade-transition>
            </v-container>
        </v-main>
    </v-app>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100;300;400;500;700;900&display=swap');

.v-application {
    font-family: 'Outfit', sans-serif !important;
}

.text-error {
    color: rgb(var(--v-theme-error)) !important;
}

.sidebar-glow {
    background: linear-gradient(180deg, rgba(var(--v-theme-surface), 1) 0%, rgba(var(--v-theme-surface), 0.95) 100%) !important;
}

.v-list-item--active {
    background: rgba(var(--v-theme-primary), 0.1) !important;
    position: relative;
}

.active-indicator {
    width: 4px;
    height: 20px;
    background: rgb(var(--v-theme-primary));
    border-radius: 4px;
    position: absolute;
    right: -4px;
}

.v-list-item__prepend > .v-icon {
    opacity: 0.8;
}

.v-list-item--active .v-list-item__prepend > .v-icon {
    opacity: 1;
}

.hover-bg-light:hover {
    background-color: rgba(var(--v-theme-on-surface), 0.03) !important;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: rgba(var(--v-theme-on-surface), 0.1);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(var(--v-theme-on-surface), 0.2);
}
</style>
