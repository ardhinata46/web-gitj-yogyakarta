<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';

const props = defineProps({
    sliders: Array,
    profile: Object,
    announcements: Array,
    devotional: Object
});

const activeSlider = ref(0);
</script>

<template>
    <PublicLayout :profile="profile">
        <Head :title="profile?.name || 'Home - GITJ Yogyakarta'" />

        <!-- Hero Section using v-carousel -->
        <section class="hero-wrapper">
            <v-carousel
                v-model="activeSlider"
                hide-delimiter-background
                show-arrows="hover"
                cycle
                interval="8000"
                height="100vh"
                continuous
                class="hero-carousel"
            >
                <v-carousel-item
                    v-for="(slider, index) in sliders"
                    :key="slider.id"
                >
                    <div class="hero-slide">
                        <v-img
                            :src="slider.image_url"
                            cover
                            class="h-100 fill-height"
                        >
                            <div class="hero-overlay d-flex align-center">
                                <v-container>
                                    <div class="max-w-px-800 animate-enter-up">
                                        <div class="badge-pill mb-8">
                                            <span class="dot animate-pulse"></span>
                                            Selamat Datang di GITJ Yogyakarta
                                        </div>
                                        
                                        <h1 class="hero-title mb-8">
                                            {{ slider.title }}
                                        </h1>
                                        
                                        <p class="hero-subtitle mb-12">
                                            {{ slider.subtitle }}
                                        </p>
                                        
                                        <div class="d-flex flex-wrap gap-6 mt-4">
                                            <v-btn
                                                v-if="slider.cta_link"
                                                :href="slider.cta_link"
                                                color="primary"
                                                size="x-large"
                                                rounded="xl"
                                                class="text-none font-weight-black px-12 elevation-24 hero-btn"
                                                height="64"
                                            >
                                                {{ slider.cta_text || 'Pelajari Lebih Lanjut' }}
                                                <v-icon end class="ml-2">mdi-arrow-right</v-icon>
                                            </v-btn>
                                            
                                            <v-btn
                                                @click="() => $inertia.visit(route('public.schedules'))"
                                                variant="outlined"
                                                color="white"
                                                size="x-large"
                                                rounded="xl"
                                                class="text-none font-weight-black px-12 backdrop-blur-md hero-btn-alt"
                                                height="64"
                                            >
                                                <v-icon start class="mr-2">mdi-calendar-clock</v-icon>
                                                Jadwal Ibadah
                                            </v-btn>
                                        </div>
                                    </div>
                                </v-container>
                            </div>
                        </v-img>
                    </div>
                </v-carousel-item>
            </v-carousel>
            
            <!-- Custom Scroll Indicator -->
            <div class="scroll-indicator">
                <span class="text-overline font-weight-black text-white opacity-40 mb-2">Scroll</span>
                <div class="mouse">
                    <div class="wheel"></div>
                </div>
            </div>
        </section>

        <!-- Featured Quick Cards -->
        <v-container class="mt-n16 relative z-10 px-6">
            <v-row>
                <v-col v-for="(card, i) in [
                    { title: 'Ibadah Raya', time: 'Minggu, 08:00 WIB', icon: 'mdi-auto-fix', color: 'primary' },
                    { title: 'Sekolah Minggu', time: 'Minggu, 08:00 WIB', icon: 'mdi-baby-face-outline', color: 'indigo-accent-2' },
                    { title: 'Warta Jemaat', time: 'Update Mingguan', icon: 'mdi-bullhorn-variant-outline', color: 'amber-darken-1' },
                    { title: 'Layanan Doa', time: 'Sedia Setiap Saat', icon: 'mdi-hand-heart-outline', color: 'rose-accent-2' }
                ]" :key="card.title" cols="12" sm="6" md="3">
                    <v-card 
                        rounded="xl" 
                        class="quick-card pa-8 fill-height border border-slate-100 dark:border-slate-800"
                        elevation="24"
                    >
                        <div :class="['icon-box mb-8', `bg-${card.color}-lighten-4`, `text-${card.color}`]">
                            <v-icon size="32">{{ card.icon }}</v-icon>
                        </div>
                        <h3 class="text-h6 font-weight-black text-slate-900 dark:text-white mb-2 uppercase tracking-tighter">{{ card.title }}</h3>
                        <p class="text-caption font-weight-bold text-slate-400 uppercase tracking-widest">{{ card.time }}</p>
                        
                        <v-card-actions class="pa-0 mt-8">
                            <v-spacer></v-spacer>
                            <v-icon class="opacity-20 arrow-icon">mdi-arrow-right</v-icon>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>

        <!-- Vision Section -->
        <v-container class="py-24">
            <v-row align="center" class="gy-16">
                <v-col cols="12" lg="5">
                    <div class="relative about-image-wrapper">
                        <v-card rounded="xl" elevation="24" class="overflow-hidden bg-slate-200">
                            <v-img 
                                src="https://images.unsplash.com/photo-1544427928-c49cdfebf19a?q=80&w=2600&auto=format&fit=crop"
                                aspect-ratio="4/5"
                                cover
                                class="hover-scale transition-all duration-1000 grayscale hover-grayscale-0"
                            >
                                <div class="fill-height d-flex flex-column justify-end pa-10 bg-gradient-to-t from-slate-950/80 to-transparent">
                                    <div class="text-h2 font-weight-black text-white line-height-1 mb-2">20+</div>
                                    <div class="text-overline font-weight-black text-primary tracking-widest">Tahun Melayani</div>
                                </div>
                            </v-img>
                        </v-card>
                        <!-- Floating Card -->
                        <div class="floating-badge d-none d-md-flex">
                             <v-icon size="36" color="white" class="mb-4">mdi-star-four-points</v-icon>
                             <div class="text-caption font-weight-black text-white uppercase tracking-widest italic">Solas Scriptura</div>
                        </div>
                    </div>
                </v-col>
                
                <v-col cols="12" lg="7" class="pl-lg-16">
                    <div class="section-badge mb-8">
                        <span class="dot"></span>
                        Tentang Gereja Kami
                    </div>
                    <h2 class="text-h3 text-md-h2 font-weight-black text-slate-900 dark:text-white mb-12 tracking-tighter line-height-09 uppercase italic sm:not-italic">
                        Harmoni dalam <span class="text-primary italic">Pelayanan</span> & Kasih
                    </h2>
                    
                    <div class="space-y-12">
                        <div class="v-step-item">
                            <h3 class="text-h5 font-weight-black text-slate-900 dark:text-white mb-4 d-flex align-center uppercase tracking-tighter">
                                <v-icon color="primary" class="mr-4">mdi-rhombus-medium-outline</v-icon>
                                Visi Utama
                            </h3>
                            <p class="text-h5 text-md-h4 text-slate-500 dark:text-slate-400 font-weight-black italic tracking-tighter line-height-12 opacity-80">
                                "{{ profile?.vision }}"
                            </p>
                        </div>
                        
                        <div class="v-step-item">
                            <h3 class="text-h5 font-weight-black text-slate-900 dark:text-white mb-6 d-flex align-center uppercase tracking-tighter">
                                <v-icon color="primary" class="mr-4">mdi-rhombus-medium-outline</v-icon>
                                Misi Kami
                            </h3>
                            <v-row>
                                <v-col v-for="(misi, idx) in (profile?.mission?.split('\n') || [])" :key="idx" cols="12" sm="6" class="mb-4">
                                    <div class="d-flex gap-4">
                                        <span class="text-h6 font-weight-black text-primary italic leading-none">0{{ idx + 1 }}.</span>
                                        <p class="text-body-2 font-weight-bold text-slate-600 dark:text-slate-400 uppercase tracking-wide leading-relaxed">
                                            {{ misi }}
                                        </p>
                                    </div>
                                </v-col>
                            </v-row>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </v-container>

        <!-- Warta Terbaru -->
        <section class="py-24 bg-white dark:bg-slate-950 transition-colors">
            <v-container>
                <v-row align="end" class="mb-16">
                    <v-col cols="12" md="8">
                        <div class="section-badge mb-6">
                            <span class="dot"></span>
                            Warta Terbaru
                        </div>
                        <h2 class="text-h3 md:text-h2 font-weight-black text-slate-900 dark:text-white tracking-tighter uppercase line-height-09">Kabar <br/><span class="text-primary">Jemaat</span></h2>
                    </v-col>
                    <v-col cols="12" md="4" class="text-md-right">
                        <v-btn
                            @click="() => $inertia.visit(route('public.announcements'))"
                            variant="outlined"
                            rounded="xl"
                            size="x-large"
                            class="text-none font-weight-black px-10 border-slate-200 dark:border-slate-800"
                            append-icon="mdi-arrow-right"
                        >
                            Lihat Seluruh Warta
                        </v-btn>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col v-for="(post, idx) in announcements.slice(0, 3)" :key="post.id" cols="12" md="4">
                        <v-card 
                            rounded="xl" 
                            elevation="0" 
                            class="announcement-card border border-slate-100 dark:border-slate-800 pa-6 transition-all duration-500 hover-up bg-white dark:bg-slate-900"
                        >
                            <div class="aspect-4-3 rounded-xl overflow-hidden mb-8 relative">
                                <v-img 
                                    src="https://images.unsplash.com/photo-1510074377623-8cf13fb86c08?q=80&w=2600&auto=format&fit=crop"
                                    cover
                                    class="fill-height hover-scale"
                                >
                                    <div class="date-chip">
                                        {{ new Date(post.created_at).toLocaleDateString('id-ID', {day:'numeric', month:'short'}) }}
                                    </div>
                                </v-img>
                            </div>
                            
                            <h3 class="text-h5 font-weight-black text-slate-900 dark:text-white mb-6 line-clamp-2 uppercase tracking-tighter">
                                {{ post.title }}
                            </h3>
                            
                            <v-btn
                                variant="text"
                                color="primary"
                                class="pa-0 text-none font-weight-bold tracking-widest uppercase text-caption"
                                append-icon="mdi-arrow-right"
                                @click="() => $inertia.visit(route('public.announcements'))"
                            >
                                Selengkapnya
                            </v-btn>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </section>

        <!-- Renungan (Dark Immersive) -->
        <section v-if="devotional" class="py-32 relative bg-slate-950 overflow-hidden">
             <!-- Background Glows -->
            <div class="glow-container">
                <div class="glow-1"></div>
                <div class="glow-2"></div>
            </div>

            <v-container class="relative z-10 text-center py-16">
                <div class="section-badge light mb-12 mx-auto">
                    <span class="dot"></span>
                    Manna Hari Ini
                </div>
                
                <div class="max-w-px-900 mx-auto relative mb-16">
                     <v-icon size="120" color="white" class="quote-icon opacity-5">mdi-format-quote-open</v-icon>
                     <h2 class="text-h4 text-md-h2 font-weight-black text-white italic tracking-tighter line-height-09 uppercase">
                         {{ devotional.title }}
                     </h2>
                </div>

                <v-card 
                    rounded="xl" 
                    variant="outlined" 
                    color="white" 
                    class="max-w-px-800 mx-auto border-opacity-10 dark-card-backdrop pa-10 pa-md-16 mb-16"
                >
                    <p class="text-h5 text-md-h4 text-slate-300 font-weight-medium line-height-relaxed italic opacity-80 mb-12">
                        {{ devotional.content.substring(0, 300) }}...
                    </p>
                    
                    <v-divider color="primary" thickness="4" class="mx-auto mb-10 w-25 border-opacity-100 rounded-pill"></v-divider>
                    
                    <div class="text-center">
                        <p class="text-h5 font-weight-black text-white uppercase tracking-widest mb-1">{{ devotional.author }}</p>
                        <p class="text-primary font-weight-black text-caption tracking-widest uppercase opacity-80 italic">{{ devotional.verse }}</p>
                    </div>
                </v-card>

                <v-btn
                    @click="() => $inertia.visit(route('public.devotionals'))"
                    color="white"
                    size="x-large"
                    rounded="xl"
                    class="text-none font-weight-black px-16 elevation-24"
                    height="70"
                >
                    Baca Selengkapnya
                    <v-icon end class="ml-3">mdi-book-open-page-variant-outline</v-icon>
                </v-btn>
            </v-container>
        </section>

        <!-- Final CTA -->
        <v-container class="py-32">
            <v-card color="primary" rounded="xl" elevation="24" class="pa-12 pa-md-24 overflow-hidden final-cta text-center">
                <!-- Abstract Decor -->
                <div class="cta-decor"></div>
                
                <h2 class="text-h3 md:text-h2 font-weight-black text-white mb-10 tracking-tighter uppercase line-height-09 italic">
                    Jadilah Bagian Dari <br/> <span class="bg-white text-primary px-6 py-2 rounded-pill not-italic">Keluarga</span> Allah
                </h2>
                <p class="text-h6 font-weight-medium text-primary-lighten-4 mb-16 max-w-px-700 mx-auto opacity-90 line-height-relaxed">
                    Kami selalu membuka pintu hati bagi siapa saja yang ingin mencari kedamaian dan pertumbuhan rohani bersama.
                </p>
                
                <div class="d-flex flex-column flex-sm-row justify-center gap-6">
                    <v-btn
                        @click="() => $inertia.visit(route('public.schedules'))"
                        color="slate-950"
                        size="x-large"
                        rounded="xl"
                        class="text-none font-weight-black px-16 elevation-12"
                        height="70"
                    >
                        Cari Lokasi & Jadwal
                    </v-btn>
                    
                    <v-btn
                        @click="() => $inertia.visit(route('public.prayer_request'))"
                        variant="tonal"
                        color="white"
                        size="x-large"
                        rounded="xl"
                        class="text-none font-weight-black px-16 backdrop-blur-md"
                        height="70"
                    >
                        Dukungan Doa
                    </v-btn>
                </div>
            </v-card>
        </v-container>
    </PublicLayout>
</template>

<style scoped>
/* Hero Styles */
.hero-wrapper {
    position: relative;
    overflow: hidden;
}

.hero-slide {
    height: 100vh;
}

.hero-overlay {
    height: 100%;
    background: linear-gradient(90deg, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.4) 50%, rgba(15, 23, 42, 0.2) 100%);
}

.hero-title {
    font-size: clamp(3rem, 10vw, 8rem);
    font-weight: 950;
    line-height: 0.85;
    letter-spacing: -0.05em;
    color: white;
    text-transform: uppercase;
}

.hero-subtitle {
    font-size: clamp(1.1rem, 2vw, 1.5rem);
    color: rgba(255, 255, 255, 0.7);
    max-width: 600px;
    line-height: 1.6;
}

.max-w-px-800 { max-width: 800px; }
.max-w-px-900 { max-width: 900px; }
.max-w-px-700 { max-width: 700px; }

.badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    background: rgba(37, 99, 235, 0.2);
    border: 1px solid rgba(37, 99, 235, 0.3);
    border-radius: 100px;
    color: var(--color-primary-400);
    font-size: 0.75rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    backdrop-filter: blur(10px);
}

.badge-pill .dot {
    width: 8px;
    height: 8px;
    background: var(--color-primary-500);
    border-radius: 50%;
}

.scroll-indicator {
    position: absolute;
    bottom: 50px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 20;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.mouse {
    width: 24px;
    height: 40px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    position: relative;
}

.wheel {
    width: 4px;
    height: 4px;
    background: white;
    border-radius: 50%;
    position: absolute;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    animation: mouse-scroll 2s infinite;
}

@keyframes mouse-scroll {
    0% { top: 10px; opacity: 1; }
    100% { top: 25px; opacity: 0; }
}

/* Quick Cards */
.quick-card {
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    background: rgba(255, 255, 255, 0.8) !important;
    backdrop-filter: blur(20px);
}

.dark .quick-card {
    background: rgba(15, 23, 42, 0.8) !important;
}

.quick-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.1) !important;
}

.icon-box {
    width: 64px;
    height: 62px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.5s;
}

.quick-card:hover .icon-box {
    transform: scale(1.1) rotate(6deg);
}

.quick-card:hover .arrow-icon {
    opacity: 1 !important;
    transform: translateX(5px);
}

/* Section Decor */
.section-badge {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 8px 20px;
    background: var(--color-primary-50);
    border-radius: 100px;
    color: var(--color-primary-600);
    font-size: 0.7rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.2em;
}

.dark .section-badge {
    background: rgba(37, 99, 235, 0.1);
    color: var(--color-primary-400);
}

.section-badge.light {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: white;
}

.section-badge .dot {
    width: 6px;
    height: 6px;
    background: currentColor;
    border-radius: 50%;
}

.line-height-09 { line-height: 0.9 !important; }
.line-height-12 { line-height: 1.2 !important; }

/* Announcement Cards */
.announcement-card {
    background: white !important;
}

.dark .announcement-card {
    background: #0f172a !important;
}

.aspect-4-3 { aspect-ratio: 4/3; }

.date-chip {
    position: absolute;
    top: 20px;
    left: 20px;
    background: white;
    padding: 8px 16px;
    border-radius: 12px;
    font-size: 0.65rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--color-primary-600);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

/* Glow Decorations */
.glow-container {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}

.glow-1 {
    position: absolute;
    top: -100px;
    left: 20%;
    width: 600px;
    height: 600px;
    background: rgba(37, 99, 235, 0.15);
    border-radius: 50%;
    filter: blur(120px);
    animation: drift 20s infinite alternate;
}

.glow-2 {
    position: absolute;
    bottom: -100px;
    right: 20%;
    width: 600px;
    height: 600px;
    background: rgba(99, 102, 241, 0.1);
    border-radius: 50%;
    filter: blur(120px);
    animation: drift 25s infinite alternate-reverse;
}

@keyframes drift {
    from { transform: translate(0, 0); }
    to { transform: translate(100px, 100px); }
}

.dark-card-backdrop {
    background: rgba(255, 255, 255, 0.03) !important;
    backdrop-filter: blur(30px);
}

/* Final CTA */
.final-cta {
    background: linear-gradient(135deg, var(--color-primary-600) 0%, var(--color-primary-700) 100%) !important;
}

.cta-decor {
    position: absolute;
    top: -10%;
    right: -10%;
    width: 400px;
    height: 400px;
    border: 60px solid rgba(255, 255, 255, 0.05);
    border-radius: 50%;
}

/* Animations */
.animate-enter-up {
    animation: enterUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes enterUp {
    from { opacity: 0; transform: translateY(60px) rotate(1deg); filter: blur(10px); }
    to { opacity: 1; transform: translateY(0) rotate(0); filter: blur(0); }
}

.hover-scale { transition: transform 0.8s; }
.hover-scale:hover { transform: scale(1.05); }

.floating-badge {
    position: absolute;
    top: -30px;
    right: -30px;
    width: 160px;
    height: 160px;
    background: var(--color-primary-600);
    border-radius: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: 0 30px 60px -10px rgba(37, 99, 235, 0.5);
    transform: rotate(12deg);
    z-index: 2;
}

/* Image Utilities */
.grayscale { filter: grayscale(100%); }
.hover-grayscale-0:hover { filter: grayscale(0%); }

@media (max-width: 600px) {
    .hero-slide {
        height: 85vh;
    }

    .hero-overlay {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.6) 60%, rgba(15, 23, 42, 0.4) 100%);
    }

    .hero-title {
        font-size: clamp(2.2rem, 9vw, 3.2rem);
        line-height: 0.95;
    }

    .hero-subtitle {
        font-size: 1rem;
    }

    .scroll-indicator {
        display: none;
    }

    .badge-pill {
        font-size: 0.6rem;
        padding: 8px 16px;
    }

    .quick-card {
        padding: 20px !important;
    }

    .date-chip {
        top: 12px;
        left: 12px;
        padding: 6px 10px;
    }

    .cta-decor {
        width: 240px;
        height: 240px;
        border-width: 30px;
    }
}

@media (max-width: 960px) {
    .floating-badge {
        display: none !important;
    }
}
</style>
