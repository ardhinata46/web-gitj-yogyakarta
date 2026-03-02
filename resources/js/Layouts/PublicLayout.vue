<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import ThemeSwitcher from '@/Components/ThemeSwitcher.vue';
import { computed, ref, onMounted, watch } from 'vue';
import { useDisplay } from 'vuetify';

const profile = computed(() => usePage().props.church_profile);
const isScrolled = ref(false);
const mobileMenu = ref(false);
const page = usePage();
const { mdAndUp } = useDisplay();

const navItems = [
    { name: 'Home', href: '/', id: 'home' },
    { name: 'Warta', href: '/warta', id: 'public.announcements' },
    { name: 'Renungan', href: '/renungan', id: 'public.devotionals' },
    { name: 'Jadwal', href: '/jadwal', id: 'public.schedules' },
    { name: 'Galeri', href: '/galeri', id: 'public.gallery' },
    { name: 'Layanan Doa', href: '/permohonan-doa', id: 'public.prayer_request' }
];

onMounted(() => {
    window.addEventListener('scroll', () => {
        isScrolled.value = window.scrollY > 20;
    });
});

watch(
    () => page.url,
    () => {
        mobileMenu.value = false;
    }
);

watch(
    () => mdAndUp.value,
    (isDesktop) => {
        if (isDesktop) {
            mobileMenu.value = false;
        }
    }
);
</script>

<template>
    <v-app class="public-app">
        <!-- Navigation Bar -->
        <v-app-bar
            flat
            :height="isScrolled ? 70 : 90"
            :class="[
                'public-app-bar transition-all duration-500 border-b overflow-visible',
                isScrolled 
                    ? 'bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-slate-200 dark:border-slate-800' 
                    : 'bg-transparent border-transparent'
            ]"
        >
            <v-container class="public-app-bar__inner d-flex align-center py-0">
                <!-- Logo -->
                <Link href="/" class="d-flex align-center text-decoration-none group">
                    <div class="logo-box mr-4">
                        <v-icon color="white" size="24">mdi-church</v-icon>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="text-h6 font-weight-black text-slate-900 dark:text-white line-height-1 tracking-tighter uppercase">GITJ</span>
                        <span class="text-caption font-weight-bold text-primary tracking-widest uppercase mt-n1">Yogyakarta</span>
                    </div>
                </Link>

                <v-spacer></v-spacer>

                <!-- Desktop Menu -->
                <div v-if="mdAndUp" class="d-flex align-center gap-1">
                    <Link v-for="item in navItems" :key="item.name" :href="item.href"
                        :class="[
                            'nav-link px-4 py-2 rounded-xl text-sm font-bold transition-all',
                            route().current(item.id) 
                                ? 'active text-primary bg-primary-lighten-5 dark:bg-primary-darken-4' 
                                : 'text-slate-600 dark:text-slate-400 hover:text-primary'
                        ]"
                    >
                        {{ item.name }}
                    </Link>
                    
                    <v-divider vertical inset class="mx-6 opacity-10"></v-divider>
                    
                    <div class="d-flex align-center gap-4">
                        <ThemeSwitcher />
                        <v-btn
                            color="slate-900"
                            class="text-none font-weight-black rounded-xl px-6 dark:bg-white dark:text-slate-900 elevation-4"
                            size="large"
                            @click="() => $inertia.visit(route('login'))"
                        >
                            Admin Access
                        </v-btn>
                    </div>
                </div>

                <!-- Mobile Menu Toggle -->
                <div v-else class="d-flex align-center gap-2">
                    <v-btn
                        icon
                        variant="tonal"
                        @click="mobileMenu = !mobileMenu"
                        class="rounded-xl"
                        color="primary"
                    >
                        <v-icon>{{ mobileMenu ? 'mdi-close' : 'mdi-menu' }}</v-icon>
                    </v-btn>
                </div>
            </v-container>
        </v-app-bar>

        <!-- Navigation Drawer (Mobile) -->
        <v-navigation-drawer
            v-model="mobileMenu"
            location="right"
            temporary
            width="320"
            class="mobile-drawer border-0"
            elevation="24"
            transition="scroll-x-reverse-transition"
        >
            <div class="mobile-drawer__content pa-8 h-100 d-flex flex-column">
                <div class="d-flex align-center mb-12">
                    <div class="logo-box small mr-3">
                        <v-icon color="white" size="20">mdi-church</v-icon>
                    </div>
                    <span class="text-h6 font-weight-black text-slate-900 dark:text-white uppercase tracking-tighter">GITJ YK</span>
                </div>

                <v-list class="pa-0 mobile-nav-list">
                    <v-list-item
                        v-for="item in navItems"
                        :key="item.name"
                        :title="item.name"
                        :active="route().current(item.id)"
                        rounded="xl"
                        class="mb-2 nav-list-item"
                        @click="() => { $inertia.visit(item.href); mobileMenu = false; }"
                    >
                        <template v-slot:prepend>
                            <v-icon size="20" class="mr-n2">mdi-circle-small</v-icon>
                        </template>
                    </v-list-item>
                </v-list>

                <div class="d-flex align-center gap-3 mt-8">
                    <ThemeSwitcher />
                    <span class="text-caption font-weight-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Mode</span>
                </div>

                <v-btn
                    block
                    color="primary"
                    size="x-large"
                    rounded="xl"
                    class="text-none font-weight-black mt-12 shadow-xl mobile-login-btn"
                    prepend-icon="mdi-login"
                    @click="() => $inertia.visit(route('login'))"
                >
                    Admin Access
                </v-btn>
            </div>
        </v-navigation-drawer>

        <v-main class="bg-slate-50 dark:bg-slate-950 transition-colors duration-500">
            <slot />
        </v-main>

        <!-- Footer -->
        <v-footer class="bg-white dark:bg-slate-900 pt-16 pb-12 d-block border-t border-slate-100 dark:border-slate-800">
            <v-container>
                <v-row class="mb-12">
                    <v-col cols="12" lg="5" class="pr-lg-12">
                        <div class="d-flex align-center mb-8">
                            <div class="logo-box mr-4">
                                <v-icon color="white" size="24">mdi-church</v-icon>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="text-h5 font-weight-black text-slate-900 dark:text-white tracking-tighter uppercase">GITJ YOGYAKARTA</span>
                                <span class="text-caption font-weight-bold text-primary tracking-widest uppercase">Harmoni dalam Pelayanan</span>
                            </div>
                        </div>
                        <p class="text-h6 font-weight-medium italic text-slate-500 dark:text-slate-400 mb-10 line-height-relaxed">
                            "{{ profile?.vision }}"
                        </p>
                        <div class="d-flex gap-3">
                            <v-btn
                                v-for="soc in [
                                    { icon: 'mdi-facebook', href: profile?.facebook_url },
                                    { icon: 'mdi-instagram', href: profile?.instagram_url },
                                    { icon: 'mdi-youtube', href: profile?.youtube_url }
                                ]"
                                :key="soc.icon"
                                v-show="soc.href"
                                icon
                                variant="tonal"
                                :href="soc.href"
                                target="_blank"
                                class="rounded-xl hover-up"
                                color="primary"
                            >
                                <v-icon size="22">{{ soc.icon }}</v-icon>
                            </v-btn>
                        </div>
                    </v-col>

                    <v-col cols="12" sm="6" lg="3">
                        <h4 class="text-overline font-weight-black text-slate-400 dark:text-slate-600 mb-8 tracking-widest uppercase">Hubungi Kami</h4>
                        <v-list bg-color="transparent" class="pa-0 space-y-4">
                            <v-list-item class="pa-0 mb-6" min-height="auto">
                                <template v-slot:prepend>
                                    <v-icon color="primary" class="mr-4 mt-n4">mdi-map-marker-outline</v-icon>
                                </template>
                                <span class="text-body-2 font-weight-bold text-slate-600 dark:text-slate-400">{{ profile?.address }}</span>
                            </v-list-item>
                            <v-list-item class="pa-0 mb-6" min-height="auto">
                                <template v-slot:prepend>
                                    <v-icon color="primary" class="mr-4">mdi-phone-outline</v-icon>
                                </template>
                                <span class="text-body-2 font-weight-black text-slate-900 dark:text-white">{{ profile?.phone }}</span>
                            </v-list-item>
                            <v-list-item class="pa-0 mb-6" min-height="auto">
                                <template v-slot:prepend>
                                    <v-icon color="primary" class="mr-4">mdi-email-outline</v-icon>
                                </template>
                                <span class="text-body-2 font-weight-black text-slate-900 dark:text-white">{{ profile?.email }}</span>
                            </v-list-item>
                        </v-list>
                    </v-col>

                    <v-col cols="12" sm="6" lg="4">
                        <h4 class="text-overline font-weight-black text-slate-400 dark:text-slate-600 mb-8 tracking-widest uppercase">Eksplorasi</h4>
                        <v-row no-gutters>
                            <v-col v-for="link in [
                                { name: 'Warta Jemaat', href: '/warta' },
                                { name: 'Renungan', href: '/renungan' },
                                { name: 'Jadwal Ibadah', href: '/jadwal' },
                                { name: 'Galeri Foto', href: '/galeri' },
                                { name: 'Layanan Doa', href: '/permohonan-doa' },
                                { name: 'Login Admin', href: '/login' }
                            ]" :key="link.name" cols="6" class="mb-4">
                                <Link :href="link.href" class="text-body-2 font-weight-black text-slate-400 hover:text-primary transition-all text-decoration-none uppercase tracking-wide d-flex align-center group">
                                    <v-icon size="6" class="mr-2 group-hover:text-primary">mdi-circle</v-icon>
                                    {{ link.name }}
                                </Link>
                            </v-col>
                        </v-row>
                        
                        <v-card variant="tonal" color="primary" rounded="xl" class="mt-8 pa-6 border-0">
                             <p class="text-overline font-weight-black mb-2 opacity-60">Motto Kami</p>
                             <p class="text-body-2 font-weight-bold italic opacity-90">
                                 "Bersama Membangun Iman, Berbagi Kasih dalam Persaudaraan."
                             </p>
                        </v-card>
                    </v-col>
                </v-row>

                <v-divider class="opacity-10 mb-8"></v-divider>

                <div class="d-flex flex-column flex-md-row align-center justify-space-between gap-4">
                    <p class="text-overline font-weight-black text-slate-400 dark:text-slate-600 mb-0">
                        © {{ new Date().getFullYear() }} GITJ YOGYAKARTA. <span class="hidden-sm-and-down">CRAFTED FOR WORSHIP.</span>
                    </p>
                    <div class="d-flex gap-8">
                        <a v-for="l in ['Privacy', 'Terms', 'Security']" :key="l" href="#" class="text-overline font-weight-black text-slate-400 hover:text-primary text-decoration-none">{{ l }}</a>
                    </div>
                </div>
            </v-container>
        </v-footer>
    </v-app>
</template>

<style>
@reference "../../css/app.css";

/* Premium Overrides */
.public-app {
    font-family: 'Outfit', sans-serif !important;
}

.logo-box {
    width: 48px;
    height: 48px;
    background: var(--color-primary-600);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.4);
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.logo-box.small {
    width: 36px;
    height: 36px;
    border-radius: 12px;
}

.group:hover .logo-box {
    transform: scale(1.1) rotate(6deg);
}

.nav-link {
    text-decoration: none;
    position: relative;
    font-size: 0.8rem !important;
    letter-spacing: 0.05em !important;
    text-transform: uppercase;
}

.nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -6px;
    left: 50%;
    transform: translateX(-50%);
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--color-primary-600);
}

.hover-up:hover {
    transform: translateY(-5px);
}

.mobile-drawer {
    backdrop-filter: blur(20px);
}

.mobile-drawer .v-navigation-drawer__content {
    height: 100%;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
}

.mobile-drawer__content {
    height: 100%;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    min-height: 0;
}

.mobile-nav-list {
    flex: 1 1 auto;
    min-height: 0;
    overflow-y: auto;
}

.nav-list-item .v-list-item-title {
    font-weight: 900 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.1em !important;
    font-size: 0.9rem !important;
}

.v-list-item--active .v-list-item-title {
    color: var(--color-primary-600) !important;
}

/* Scrollbar Customization */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.dark ::-webkit-scrollbar-thumb {
    background: #334155;
}

::-webkit-scrollbar-thumb:hover {
    background: var(--color-primary-600);
}

.line-height-1 { line-height: 1 !important; }
.line-height-relaxed { line-height: 1.6 !important; }

@media (max-width: 600px) {
    .public-app-bar {
        min-height: 64px !important;
    }

    .public-app-bar__inner {
        padding-left: 16px !important;
        padding-right: 16px !important;
    }

    .logo-box {
        width: 40px;
        height: 40px;
        border-radius: 12px;
    }

    .logo-box + div span.text-caption {
        font-size: 0.6rem !important;
        letter-spacing: 0.2em !important;
    }

    .mobile-nav-list .v-list-item {
        min-height: 52px !important;
    }

    .nav-list-item .v-list-item-title {
        font-size: 0.85rem !important;
        letter-spacing: 0.12em !important;
    }

    .mobile-login-btn {
        height: 52px !important;
        font-size: 0.9rem !important;
    }
}
</style>
