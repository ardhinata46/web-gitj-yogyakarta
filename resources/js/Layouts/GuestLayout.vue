<script setup>
import { Link } from '@inertiajs/vue3';

const navItems = [
    { name: 'Beranda', href: route('home') },
    { name: 'Warta Jemaat', href: route('public.announcements') },
    { name: 'Renungan', href: route('public.devotionals') },
    { name: 'Jadwal', href: route('public.schedules') },
];
</script>

<template>
    <div class="min-h-screen bg-white">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <Link href="/" class="flex items-center gap-2">
                    <span class="text-2xl font-bold tracking-tight text-gray-900">
                        <span class="text-indigo-600">GITJ</span> Yogyakarta
                    </span>
                </Link>
                
                <div class="hidden md:flex items-center gap-8">
                    <Link v-for="item in navItems" :key="item.name" :href="item.href"
                        class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">
                        {{ item.name }}
                    </Link>
                    <Link :href="route('login')" class="bg-indigo-600 text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
                        Login Admin
                    </Link>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-gray-50 border-t border-gray-100 py-12 mt-20">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p class="text-gray-500 text-sm">© 2026 GITJ Yogyakarta. Melayani dengan Kasih.</p>
            </div>
        </footer>
    </div>
</template>
