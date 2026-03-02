<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';

defineProps({
    profile: Object
});

const form = useForm({
    name: '',
    phone: '',
    request: ''
});

const submitted = ref(false);

const submit = () => {
    form.post(route('public.prayer_request.store'), {
        onSuccess: () => {
            form.reset();
            submitted.value = true;
            setTimeout(() => submitted.value = false, 5000);
        }
    });
};
</script>

<template>
    <PublicLayout :profile="profile">
        <Head title="Layanan Doa - GITJ Yogyakarta" />

        <section class="page-header py-16 py-md-32">
            <v-container>
                <v-row align="center" class="gy-12">
                    <v-col cols="12" lg="6">
                        <div class="section-badge mb-10">
                            <span class="dot"></span>
                            Pendampingan Iman
                        </div>
                        <h1 class="text-h2 md:text-h1 font-weight-black text-slate-900 dark:text-white mb-10 tracking-tighter uppercase line-height-1 italic sm:not-italic">
                            Beban Anda, <br/> <span class="text-primary italic">Doa Kami</span>
                        </h1>
                        <p class="text-h6 text-md-h5 text-slate-500 dark:text-slate-400 font-weight-medium line-height-relaxed max-w-px-600 italic opacity-80 mb-12">
                            "Berserulah kepada-Ku, maka Aku akan menjawab engkau dan akan memberitahukan kepadamu hal-hal yang besar dan yang tidak terpahami." — Yeremia 33:3
                        </p>
                        
                        <div class="space-y-8">
                             <div v-for="feat in [
                                 { title: 'Tersedia 24/7', desc: 'Kami menerima permohonan doa kapan saja Anda membutuhkannya.', icon: 'mdi-clock-check-outline' },
                                 { title: 'Kerahasiaan Terjamin', desc: 'Pokok doa Anda hanya akan didoakan oleh tim pastoral resmi.', icon: 'mdi-shield-lock-outline' },
                                 { title: 'Dukungan Pastoral', desc: 'Kami siap mendampingi Anda melalui konseling jika dibutuhkan.', icon: 'mdi-account-heart-outline' }
                             ]" :key="feat.title" class="d-flex gap-8 group">
                                 <div class="feature-icon-box bg-white dark:bg-slate-900 shadow-xl border border-slate-100 dark:border-slate-800">
                                     <v-icon color="primary" size="28">{{ feat.icon }}</v-icon>
                                 </div>
                                 <div class="pt-1">
                                     <h3 class="text-subtitle-1 font-weight-black text-slate-900 dark:text-white uppercase tracking-tight mb-2">{{ feat.title }}</h3>
                                     <p class="text-body-2 text-slate-500 font-weight-bold opacity-80 leading-relaxed">{{ feat.desc }}</p>
                                 </div>
                             </div>
                        </div>
                    </v-col>

                    <v-col cols="12" lg="6">
                        <v-card 
                            rounded="60" 
                            elevation="24" 
                            class="prayer-form-card pa-8 pa-md-16 border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden relative"
                        >
                            <!-- Success State Overlay -->
                            <v-fade-transition>
                                <div v-if="submitted" class="success-overlay d-flex flex-column align-center justify-center text-center pa-12 bg-primary">
                                    <v-icon size="100" color="white" class="mb-10">mdi-check-circle-outline</v-icon>
                                    <h3 class="text-h3 font-weight-black text-white mb-6 uppercase tracking-tighter italic">Terima Kasih</h3>
                                    <p class="text-h6 font-weight-black text-white opacity-90 mb-12">Permohonan doa Anda telah kami terima dan akan segera kami bawa dalam hadirat Tuhan.</p>
                                    <v-btn
                                        variant="outlined"
                                        color="white"
                                        rounded="xl"
                                        size="x-large"
                                        class="text-none font-weight-black px-12"
                                        @click="submitted = false"
                                    >
                                        Kirim Pokok Doa Baru
                                    </v-btn>
                                </div>
                            </v-fade-transition>

                            <v-form @submit.prevent="submit" class="space-y-12">
                                <div class="form-group">
                                    <label class="text-overline font-weight-black text-slate-400 dark:text-slate-600 mb-4 d-block tracking-widest pl-2">Nama Lengkap</label>
                                    <v-text-field
                                        v-model="form.name"
                                        placeholder="Panggil kami dengan nama..."
                                        variant="solo-filled"
                                        rounded="xl"
                                        flat
                                        color="primary"
                                        bg-color="slate-50"
                                        class="premium-input dark:bg-slate-950"
                                        prepend-inner-icon="mdi-account-outline"
                                        required
                                        hide-details="auto"
                                    ></v-text-field>
                                </div>
                                
                                <div class="form-group">
                                    <label class="text-overline font-weight-black text-slate-400 dark:text-slate-600 mb-4 d-block tracking-widest pl-2">WhatsApp / Telepon</label>
                                    <v-text-field
                                        v-model="form.phone"
                                        placeholder="08xxxxxxxxxx"
                                        variant="solo-filled"
                                        rounded="xl"
                                        flat
                                        color="primary"
                                        bg-color="slate-50"
                                        class="premium-input dark:bg-slate-950"
                                        prepend-inner-icon="mdi-whatsapp"
                                        required
                                        hide-details="auto"
                                    ></v-text-field>
                                </div>

                                <div class="form-group">
                                    <label class="text-overline font-weight-black text-slate-400 dark:text-slate-600 mb-4 d-block tracking-widest pl-2">Pokok Doa</label>
                                    <v-textarea
                                        v-model="form.request"
                                        placeholder="Tuliskan pergumulan atau ucapan syukur Anda di sini..."
                                        variant="solo-filled"
                                        rounded="xl"
                                        flat
                                        rows="5"
                                        no-resize
                                        color="primary"
                                        bg-color="slate-50"
                                        class="premium-input dark:bg-slate-950"
                                        prepend-inner-icon="mdi-hands-pray"
                                        required
                                        hide-details="auto"
                                    ></v-textarea>
                                </div>

                                <v-btn
                                    type="submit"
                                    :loading="form.processing"
                                    block
                                    color="slate-950"
                                    dark
                                    size="x-large"
                                    rounded="xl"
                                    class="text-none font-weight-black mt-12 py-8 dark:bg-white dark:text-slate-900 elevation-24"
                                    append-icon="mdi-send-variant-outline"
                                >
                                    {{ form.processing ? 'Menghadirkan Berkat...' : 'Kirim Permohonan Doa' }}
                                </v-btn>
                            </v-form>
                        </v-card>
                    </v-col>
                </v-row>

                <div class="mt-24 pt-10 border-t border-slate-100 dark:border-slate-800 text-center">
                    <p class="text-overline font-weight-black text-slate-400 dark:text-slate-700 max-w-px-700 mx-auto line-height-relaxed">
                        Kami menjamin kerahasiaan identitas dan isi doa yang Anda sampaikan. Data Anda hanya akan digunakan untuk kepentingan pelayanan doa resmi GITJ Yogyakarta.
                    </p>
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

.prayer-form-card {
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}

.feature-icon-box {
    width: 64px;
    height: 64px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.5s;
}

.group:hover .feature-icon-box {
    transform: scale(1.1) rotate(6deg);
    border-color: var(--color-primary-300) !important;
}

.premium-input :deep(.v-field) {
    border-radius: 20px !important;
    padding: 10px 16px !important;
    font-weight: 700 !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.premium-input :deep(.v-field--focused) {
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1) !important;
    background-color: white !important;
}

.dark .premium-input :deep(.v-field--focused) {
    background-color: var(--color-dark-bg) !important;
}

.success-overlay {
    position: absolute;
    inset: 0;
    z-index: 100;
}

.max-w-px-600 { max-width: 600px; }
.max-w-px-700 { max-width: 700px; }
.line-height-1 { line-height: 1 !important; }
.line-height-relaxed { line-height: 1.8 !important; }

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

.rounded-60 {
    border-radius: 60px !important;
}
</style>
