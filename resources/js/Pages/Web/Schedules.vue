<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    schedules: Array
});
</script>

<template>
    <PublicLayout>
        <Head title="Jadwal Ibadah - GITJ Yogyakarta" />

        <section class="page-header py-16 py-md-32">
            <v-container>
                <v-row align="end" class="gy-8">
                    <v-col cols="12" md="8">
                        <div class="section-badge mb-8">
                            <span class="dot"></span>
                            Waktu Persekutuan
                        </div>
                        <h1 class="text-h2 md:text-h1 font-weight-black text-slate-900 dark:text-white mb-8 tracking-tighter uppercase line-height-1 italic sm:not-italic">
                            Jadwal <span class="text-primary italic">Ibadah</span>
                        </h1>
                        <p class="text-h6 text-md-h5 text-slate-500 dark:text-slate-400 font-weight-medium line-height-relaxed max-w-px-700">
                            Kami mengundang Anda untuk hadir dan bertumbuh bersama dalam iman di setiap persekutuan yang kami selenggarakan.
                        </p>
                    </v-col>
                </v-row>
            </v-container>
        </section>

        <section class="pb-32 bg-slate-50 dark:bg-slate-950 transition-colors">
            <v-container>
                <v-row>
                    <v-col v-for="(sch, idx) in schedules" :key="sch.id" cols="12" lg="6" class="mb-8">
                        <v-card 
                            rounded="60" 
                            elevation="24" 
                            class="schedule-card pa-8 pa-md-12 d-flex flex-column flex-sm-row gap-10 border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden"
                        >
                            <div class="icon-orb bg-primary-lighten-5 dark:bg-primary-darken-4 text-primary shrink-0">
                                <v-icon size="44">mdi-calendar-check-outline</v-icon>
                            </div>
                            
                            <div class="flex-grow-1">
                                <div class="d-flex align-center gap-3 mb-4">
                                    <span class="text-overline font-weight-black text-primary tracking-widest italic opacity-60">Agenda 0{{ idx + 1 }}</span>
                                </div>
                                <h2 class="text-h4 font-weight-black text-slate-900 dark:text-white mb-10 uppercase tracking-tighter line-height-1 italic transition-colors schedule-title">
                                    {{ sch.title }}
                                </h2>
                                
                                <div class="space-y-4">
                                    <div class="d-flex align-center gap-4 pa-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 info-item">
                                        <div class="info-icon bg-primary">
                                            <v-icon size="18" color="white">mdi-clock-outline</v-icon>
                                        </div>
                                        <span class="text-subtitle-2 font-weight-black text-slate-700 dark:text-slate-300 uppercase tracking-widest">{{ sch.time }}</span>
                                    </div>
                                    
                                    <div class="d-flex align-center gap-4 pa-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 info-item">
                                        <div class="info-icon bg-primary">
                                            <v-icon size="18" color="white">mdi-map-marker-outline</v-icon>
                                        </div>
                                        <span class="text-subtitle-2 font-weight-bold text-slate-500 dark:text-slate-400 leading-relaxed">{{ sch.location }}</span>
                                    </div>
                                </div>
                            </div>
                        </v-card>
                    </v-col>
                </v-row>

                <div v-if="schedules.length === 0" class="text-center py-32 bg-white/50 dark:bg-slate-900/30 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                    <v-icon size="80" color="slate-200" class="mb-8">mdi-calendar-remove-outline</v-icon>
                    <p class="text-overline font-weight-black text-slate-400 tracking-widest">Jadwal kegiatan terbaru sedang diperbarui</p>
                </div>

                <!-- Featured CTA for community -->
                <v-card 
                    rounded="60" 
                    elevation="24" 
                    class="mt-32 pa-12 pa-md-24 overflow-hidden call-to-serve bg-slate-900 dark:bg-slate-900 border-0"
                >
                    <div class="cta-decoration"></div>
                    
                    <v-row align="center">
                        <v-col cols="12" lg="7">
                            <div class="section-badge mb-10 light">
                                <span class="dot"></span>
                                Panggilan Pelayanan
                            </div>
                            <h3 class="text-h3 md:text-h2 font-weight-black text-white mb-10 uppercase tracking-tighter line-height-09 italic">
                                Mari Melayani<br/><span class="text-primary italic">Bersama</span> Kami
                            </h3>
                            <p class="text-h6 font-weight-medium text-slate-400 mb-16 opacity-80 line-height-relaxed max-w-px-600">
                                Tuhan memberikan talenta bagi setiap orang untuk menjadi berkat. Temukan tempat Anda untuk bertumbuh dan memberi dampak bagi sesama.
                            </p>
                            <v-btn
                                @click="() => $inertia.visit(route('public.prayer_request'))"
                                color="primary"
                                size="x-large"
                                rounded="xl"
                                class="text-none font-weight-black px-12 elevation-24"
                                height="70"
                                append-icon="mdi-arrow-right"
                            >
                                Hubungi Sekretariat
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card>
            </v-container>
        </section>
    </PublicLayout>
</template>

<style scoped>
.page-header {
    background: radial-gradient(circle at 100% 100%, var(--color-primary-50) 0%, transparent 50%);
}

.dark .page-header {
    background: radial-gradient(circle at 100% 100%, rgba(37, 99, 235, 0.05) 0%, transparent 50%);
}

.schedule-card {
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}

.schedule-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.2) !important;
}

.schedule-card:hover .schedule-title {
    color: var(--color-primary-600) !important;
}

.icon-orb {
    width: 100px;
    height: 100px;
    border-radius: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.5s;
    box-shadow: inset 0 0 20px rgba(0,0,0,0.05);
}

.schedule-card:hover .icon-orb {
    transform: rotate(12deg) scale(1.1);
    background-color: var(--color-primary-600) !important;
    color: white !important;
}

.info-icon {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.info-item {
    transition: all 0.3s ease;
}

.schedule-card:hover .info-item {
    background: white !important;
    border-color: var(--color-primary-100) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.dark .schedule-card:hover .info-item {
    background: var(--color-dark-surface) !important;
    border-color: var(--color-dark-border) !important;
}

.call-to-serve {
    position: relative;
    background: #0f172a !important;
}

.cta-decoration {
    position: absolute;
    top: -100px;
    right: -100px;
    width: 400px;
    height: 400px;
    border: 60px solid rgba(255,255,255,0.03);
    border-radius: 50%;
}

.max-w-px-700 { max-width: 700px; }
.max-w-px-600 { max-width: 600px; }
.line-height-1 { line-height: 1 !important; }
.line-height-09 { line-height: 0.9 !important; }

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

.rounded-60 {
    border-radius: 60px !important;
}
</style>
