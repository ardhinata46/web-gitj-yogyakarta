<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    devotionals: Object
});
</script>

<template>
    <PublicLayout>
        <Head title="Renungan Harian - GITJ Yogyakarta" />

        <section class="page-header py-16 py-md-32 text-center text-md-left">
            <v-container>
                <div class="max-w-px-800">
                    <div class="section-badge mb-8">
                        <span class="dot"></span>
                        Santapan Rohani
                    </div>
                    <h1 class="text-h2 md:text-h1 font-weight-black text-slate-900 dark:text-white mb-8 tracking-tighter uppercase line-height-1 italic sm:not-italic">
                        Renungan <span class="text-primary italic">Harian</span>
                    </h1>
                    <p class="text-h6 text-md-h5 text-slate-500 dark:text-slate-400 font-weight-medium line-height-relaxed max-w-px-600 italic opacity-80">
                        "Hendaklah perkataan Kristus diam dengan segala kekayaannya di antara kamu."
                    </p>
                </div>
            </v-container>
        </section>

        <section class="pb-32 bg-slate-50 dark:bg-slate-950 transition-colors">
            <v-container>
                <div class="max-w-px-900 mx-auto space-y-32">
                    <div v-for="dev in devotionals.data" :key="dev.id" class="relative devotional-block animate-enter-up">
                        
                        <!-- Main Content Card -->
                        <v-card 
                            rounded="60" 
                            elevation="24" 
                            class="pa-8 pa-md-16 border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-visible"
                        >
                            <!-- Quote Decoration -->
                            <div class="quote-decor">
                                <v-icon size="180" color="primary" class="opacity-5">mdi-format-quote-open</v-icon>
                            </div>

                            <v-row align="start" class="mb-12">
                                <v-col cols="12" md="8">
                                    <div class="d-flex align-center gap-3 mb-6">
                                        <div class="dot-box bg-primary"></div>
                                        <span class="text-caption font-weight-black text-primary uppercase tracking-widest leading-none">
                                            {{ new Date(dev.date).toLocaleDateString('id-ID', {weekday:'long', day:'numeric', month:'long', year:'numeric'}) }}
                                        </span>
                                    </div>
                                    <h2 class="text-h4 text-md-h3 font-weight-black text-slate-900 dark:text-white uppercase tracking-tighter line-height-11 italic">
                                        {{ dev.title }}
                                    </h2>
                                </v-col>
                                
                                <v-col v-if="dev.author" cols="auto" class="ml-auto">
                                    <v-chip
                                        prepend-icon="mdi-account-outline"
                                        rounded="xl"
                                        variant="tonal"
                                        color="primary"
                                        class="font-weight-black uppercase tracking-widest px-6"
                                        size="large"
                                    >
                                        {{ dev.author }}
                                    </v-chip>
                                </v-col>
                            </v-row>

                            <!-- Verse Card -->
                            <div v-if="dev.verse" class="verse-wrapper mb-16">
                                <v-card 
                                    rounded="xl" 
                                    color="primary" 
                                    variant="tonal" 
                                    class="pa-10 pa-md-12 border-s-10 border-primary-darken-1 elevation-0"
                                >
                                    <p class="text-h5 text-md-h4 font-weight-black italic text-primary-darken-4 dark:text-primary-lighten-4 leading-relaxed tracking-tight">
                                        "{{ dev.verse }}"
                                    </p>
                                </v-card>
                            </div>

                            <div class="prose-custom text-slate-600 dark:text-slate-400 text-h6 font-weight-medium line-height-relaxed whitespace-pre-line first-letter-premium">
                                {{ dev.content }}
                            </div>

                            <!-- Footer Section -->
                            <v-divider class="mt-20 mb-10 opacity-10"></v-divider>
                            <div class="d-flex flex-wrap justify-space-between align-center gap-6">
                                <div class="share-group d-flex align-center gap-4">
                                    <span class="text-overline font-weight-black text-slate-400 tracking-widest">Share Blessing</span>
                                    <v-btn icon size="40" variant="tonal" color="success" rounded="xl" class="hover-up">
                                        <v-icon size="18">mdi-whatsapp</v-icon>
                                    </v-btn>
                                    <v-btn icon size="40" variant="tonal" color="blue-darken-2" rounded="xl" class="hover-up">
                                        <v-icon size="18">mdi-facebook</v-icon>
                                    </v-btn>
                                </div>
                                <span class="text-overline font-weight-black text-slate-300 dark:text-slate-600 tracking-widest italic">GITJ YK MEDIA CENTER</span>
                            </div>
                        </v-card>
                    </div>
                </div>

                <div v-if="devotionals.data.length === 0" class="text-center py-32 bg-white/50 dark:bg-slate-900/30 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                    <v-icon size="80" color="slate-200" class="mb-8">mdi-book-open-blank-variant</v-icon>
                    <p class="text-overline font-weight-black text-slate-400 tracking-widest">Belum ada renungan tersedia</p>
                </div>
            </v-container>
        </section>
    </PublicLayout>
</template>

<style scoped>
.page-header {
    background: radial-gradient(circle at 100% 0%, var(--color-primary-50) 0%, transparent 50%);
}

.dark .page-header {
    background: radial-gradient(circle at 100% 0%, rgba(37, 99, 235, 0.05) 0%, transparent 50%);
}

.devotional-block {
    position: relative;
    z-index: 1;
}

.quote-decor {
    position: absolute;
    top: -40px;
    left: -40px;
    z-index: -1;
}

.dot-box {
    width: 10px;
    height: 10px;
    border-radius: 3px;
    transform: rotate(45deg);
}

.verse-wrapper {
    position: relative;
}

.verse-wrapper::before {
    content: '';
    position: absolute;
    inset: -5px;
    background: var(--color-primary-600);
    opacity: 0.1;
    border-radius: 28px;
    transform: rotate(-1deg);
    z-index: -1;
}

.prose-custom {
    color: #475569;
}

.dark .prose-custom {
    color: #94a3b8;
}

.first-letter-premium::first-letter {
    font-size: 4rem;
    font-weight: 900;
    float: left;
    margin-right: 12px;
    line-height: 0.8;
    color: var(--color-primary-600);
    font-style: italic;
}

.max-w-px-800 { max-width: 800px; }
.max-w-px-900 { max-width: 900px; }
.max-w-px-600 { max-width: 600px; }
.line-height-1 { line-height: 1 !important; }
.line-height-11 { line-height: 1.1 !important; }

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

.section-badge .dot {
    width: 6px;
    height: 6px;
    background: currentColor;
    border-radius: 50%;
}

.animate-enter-up {
    animation: enterUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes enterUp {
    from { opacity: 0; transform: translateY(80px); }
    to { opacity: 1; transform: translateY(0); }
}

.hover-up:hover { transform: translateY(-3px); }

.border-s-10 {
    border-inline-start-width: 10px !important;
    border-inline-start-style: solid !important;
}
</style>
