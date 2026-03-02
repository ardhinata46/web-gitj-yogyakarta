<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { ref } from 'vue';

defineProps({
    items: Array
});

const selectedImage = ref(null);
const dialog = ref(false);

const openLightbox = (item) => {
    selectedImage.value = item;
    dialog.value = true;
};
</script>

<template>
    <PublicLayout>
        <Head title="Galeri Foto - GITJ Yogyakarta" />

        <section class="page-header py-16 py-md-32">
            <v-container>
                <v-row align="end" class="gy-8">
                    <v-col cols="12" md="8">
                        <div class="section-badge mb-8">
                            <span class="dot"></span>
                            Dokumentasi Pelayanan
                        </div>
                        <h1 class="text-h2 md:text-h1 font-weight-black text-slate-900 dark:text-white mb-8 tracking-tighter uppercase line-height-1 italic sm:not-italic">
                            Galeri <span class="text-primary italic">Momen</span>
                        </h1>
                        <p class="text-h6 text-md-h5 text-slate-500 dark:text-slate-400 font-weight-medium line-height-relaxed max-w-px-700">
                            Mengabadikan keindahan kebersamaan dan karya Tuhan di tengah-tengah jemaat Yogyakarta.
                        </p>
                    </v-col>
                </v-row>
            </v-container>
        </section>

        <section class="pb-32 bg-slate-50 dark:bg-slate-950 transition-colors">
            <v-container>
                <v-row>
                    <v-col v-for="(item, idx) in items" :key="item.id" cols="12" sm="6" md="4" class="mb-8">
                        <v-card 
                            rounded="xl" 
                            elevation="24" 
                            class="gallery-card pa-0 border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden cursor-pointer"
                            @click="openLightbox(item)"
                        >
                            <div class="gallery-image-wrapper">
                                <v-img 
                                    :src="item.image_url" 
                                    aspect-ratio="4/3"
                                    cover
                                    class="fill-height hover-scale transition-all duration-1000"
                                >
                                    <template v-slot:placeholder>
                                        <div class="d-flex align-center justify-center fill-height bg-slate-100">
                                            <v-progress-circular indeterminate color="primary"></v-progress-circular>
                                        </div>
                                    </template>
                                    
                                    <div class="gallery-overlay d-flex flex-column justify-space-between pa-6">
                                        <div class="d-flex gap-2">
                                            <v-chip size="x-small" color="primary" variant="flat" class="font-weight-black uppercase tracking-widest">{{ item.category }}</v-chip>
                                            <v-chip size="x-small" color="white" variant="flat" class="font-weight-black text-slate-900 uppercase tracking-widest">{{ new Date(item.event_date).getFullYear() }}</v-chip>
                                        </div>
                                        
                                        <div class="zoom-icon-wrapper">
                                            <v-icon size="40" color="white">mdi-magnify-plus-outline</v-icon>
                                        </div>
                                    </div>
                                </v-img>
                            </div>

                            <div class="pa-8">
                                <div class="d-flex align-center gap-3 mb-4">
                                    <div class="dot-small bg-primary"></div>
                                    <span class="text-overline font-weight-black text-slate-400 tracking-widest">
                                        {{ new Date(item.event_date).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'}) }}
                                    </span>
                                </div>
                                <h3 class="text-h6 font-weight-black text-slate-900 dark:text-white mb-4 uppercase tracking-tighter line-height-12 transition-colors gallery-title">
                                    {{ item.title }}
                                </h3>
                                <p class="text-body-2 font-weight-medium text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed italic opacity-80">
                                    {{ item.description }}
                                </p>
                            </div>
                        </v-card>
                    </v-col>
                </v-row>

                <div v-if="items.length === 0" class="text-center py-32 bg-white/50 dark:bg-slate-900/30 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                    <v-icon size="80" color="slate-200" class="mb-8">mdi-camera-off-outline</v-icon>
                    <p class="text-overline font-weight-black text-slate-400 tracking-widest">Koleksi foto sedang dipersiapkan</p>
                </div>
            </v-container>
        </section>

        <!-- Lightbox Dialog -->
        <v-dialog
            v-model="dialog"
            max-width="1200"
            transition="dialog-bottom-transition"
            content-class="lightbox-dialog"
        >
            <div class="relative lightbox-container pa-4" v-if="selectedImage">
                <v-card rounded="xl" elevation="24" class="overflow-hidden bg-transparent shadow-none border-0">
                    <div class="d-flex flex-column align-center">
                        <v-img
                            :src="selectedImage.image_url"
                            max-height="80vh"
                            contain
                            class="rounded-xl shadow-2xl mb-8 border border-white/10"
                        >
                            <template v-slot:placeholder>
                                <v-progress-circular indeterminate color="white"></v-progress-circular>
                            </template>
                        </v-img>
                        
                        <div class="text-center text-white max-w-px-700 animate-enter-up">
                            <h2 class="text-h4 font-weight-black uppercase tracking-tighter mb-4 italic">{{ selectedImage.title }}</h2>
                            <p class="text-body-1 font-weight-medium opacity-80 mb-6 italic">{{ selectedImage.description }}</p>
                            <v-chip color="primary" class="font-weight-black uppercase tracking-widest">
                                {{ new Date(selectedImage.event_date).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'}) }}
                            </v-chip>
                        </div>
                    </div>
                </v-card>
                
                <v-btn
                    icon
                    variant="tonal"
                    color="white"
                    class="absolute top-0 right-0 ma-8"
                    @click="dialog = false"
                >
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </div>
        </v-dialog>
    </PublicLayout>
</template>

<style scoped>
.page-header {
    background: radial-gradient(circle at 0% 100%, var(--color-primary-50) 0%, transparent 50%);
}

.dark .page-header {
    background: radial-gradient(circle at 0% 100%, rgba(37, 99, 235, 0.05) 0%, transparent 50%);
}

.gallery-card {
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}

.gallery-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.2) !important;
}

.gallery-card:hover .gallery-title {
    color: var(--color-primary-600) !important;
}

.gallery-image-wrapper {
    overflow: hidden;
    position: relative;
}

.gallery-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(15, 23, 42, 0.7) 0%, transparent 40%);
    opacity: 0;
    transition: all 0.5s ease;
}

.gallery-card:hover .gallery-overlay {
    opacity: 1;
}

.zoom-icon-wrapper {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -100%);
    opacity: 0;
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}

.gallery-card:hover .zoom-icon-wrapper {
    opacity: 1;
    transform: translate(-50%, -50%);
}

.dot-small {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.hover-scale { transition: transform 0.8s; }
.gallery-card:hover .hover-scale { transform: scale(1.1); }

.max-w-px-700 { max-width: 700px; }
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

.lightbox-dialog {
    box-shadow: none !important;
}

.lightbox-container {
    background: transparent;
}

.animate-enter-up {
    animation: enterUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes enterUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
