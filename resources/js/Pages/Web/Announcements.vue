<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    announcements: Object
});
</script>

<template>
    <PublicLayout>
        <Head title="Warta Jemaat - GITJ Yogyakarta" />

        <section class="page-header py-16 py-md-32">
            <v-container>
                <div class="max-w-px-800">
                    <div class="section-badge mb-8">
                        <span class="dot"></span>
                        Informasi & Kegiatan
                    </div>
                    <h1 class="text-h2 md:text-h1 font-weight-black text-slate-900 dark:text-white mb-8 tracking-tighter uppercase italic sm:not-italic line-height-1">
                        Warta <span class="text-primary italic">Jemaat</span>
                    </h1>
                    <p class="text-h6 text-md-h5 text-slate-500 dark:text-slate-400 font-weight-medium line-height-relaxed max-w-px-600">
                        Ikuti perkembangan terbaru, pengumuman, dan agenda kegiatan di lingkungan GITJ Yogyakarta.
                    </p>
                </div>
            </v-container>
        </section>

        <section class="pb-32">
            <v-container>
                <v-row v-if="announcements.data.length > 0">
                    <v-col v-for="(ann, idx) in announcements.data" :key="ann.id" cols="12" md="4" class="mb-10">
                        <v-card 
                            rounded="xl" 
                            elevation="24" 
                            class="ann-list-card pa-8 fill-height d-flex flex-column border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden"
                        >
                            <div class="d-flex justify-space-between align-center mb-8">
                                <div class="icon-box-small bg-primary-lighten-5 dark:bg-primary-darken-4 text-primary">
                                    <v-icon size="20">mdi-newspaper-variant-outline</v-icon>
                                </div>
                                <span class="text-overline font-weight-black text-slate-300 dark:text-slate-600 tracking-widest">
                                    {{ new Date(ann.created_at).toLocaleDateString('id-ID', {day:'numeric', month:'short'}) }}
                                </span>
                            </div>

                            <h2 class="text-h5 font-weight-black text-slate-900 dark:text-white mb-6 uppercase tracking-tighter line-height-12 line-clamp-3">
                                {{ ann.title }}
                            </h2>
                            
                            <p class="text-body-2 font-weight-medium text-slate-500 dark:text-slate-400 mb-10 line-clamp-5 leading-relaxed">
                                {{ ann.content }}
                            </p>
                            
                            <v-spacer></v-spacer>
                            
                            <v-btn
                                variant="tonal"
                                color="primary"
                                block
                                rounded="xl"
                                size="large"
                                class="text-none font-weight-black tracking-wide"
                                append-icon="mdi-arrow-right"
                            >
                                Baca Lengkap
                            </v-btn>
                        </v-card>
                    </v-col>
                </v-row>

                <!-- Empty State -->
                <div v-else class="text-center py-32 bg-white/50 dark:bg-slate-900/30 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                    <v-icon size="80" color="slate-200" class="mb-8">mdi-inbox-outline</v-icon>
                    <p class="text-overline font-weight-black text-slate-400 tracking-widest">Warta belum tersedia untuk saat ini</p>
                </div>
                
                <!-- Pagination (Placeholder) -->
                <div v-if="announcements.links && announcements.links.length > 3" class="mt-16 d-flex justify-center">
                    <!-- Vuetify pagination logic can be added here -->
                </div>
            </v-container>
        </section>
    </PublicLayout>
</template>

<style scoped>
.page-header {
    background: radial-gradient(circle at 0% 0%, var(--color-primary-50) 0%, transparent 50%);
}

.dark .page-header {
    background: radial-gradient(circle at 0% 0%, rgba(37, 99, 235, 0.05) 0%, transparent 50%);
}

.ann-list-card {
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}

.ann-list-card:hover {
    transform: translateY(-12px);
    border-color: var(--color-primary-200) !important;
}

.icon-box-small {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.max-w-px-800 { max-width: 800px; }
.max-w-px-600 { max-width: 600px; }
.line-height-1 { line-height: 1 !important; }
.line-height-12 { line-height: 1.2 !important; }

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
</style>
