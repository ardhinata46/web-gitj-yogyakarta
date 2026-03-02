<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in - GITJ Admin" />

    <div class="min-h-screen bg-white dark:bg-slate-950 flex font-outfit relative overflow-hidden">
        <!-- Abstract Background -->
        <div class="absolute inset-x-0 top-0 h-screen pointer-events-none overflow-hidden">
             <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-primary-600/10 rounded-full blur-[120px]"></div>
             <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-indigo-600/10 rounded-full blur-[120px]"></div>
        </div>

        <!-- Left Side: Visual -->
        <div class="hidden lg:flex w-1/2 bg-slate-900 relative items-center justify-center p-20 overflow-hidden">
             <div class="absolute inset-0 z-0 opacity-40">
                  <img src="https://images.unsplash.com/photo-1544427928-c49cdfebf19a?q=80&w=2600&auto=format&fit=crop" class="w-full h-full object-cover grayscale" alt="">
                  <div class="absolute inset-0 bg-gradient-to-tr from-slate-950 via-slate-950/60 to-primary-900/40"></div>
             </div>
             <div class="relative z-10 text-white animate-enter-up">
                  <div class="w-20 h-20 bg-primary-600 rounded-3xl flex items-center justify-center mb-12 shadow-2xl shadow-primary-600/30">
                       <span class="material-icons text-4xl font-bold">church</span>
                  </div>
                  <h2 class="text-7xl font-black mb-8 leading-[0.9] tracking-tighter uppercase italic">
                      Harmoni dalam <br/> <span class="text-primary-500">Pelayanan</span>
                  </h2>
                  <p class="text-xl text-slate-400 font-medium max-w-md leading-relaxed">
                      Selamat datang kembali di pusat kendali GITJ Yogyakarta. Mari terus melayani dengan kasih dan integritas.
                  </p>
             </div>
             <!-- Decor -->
             <div class="absolute bottom-20 left-20 right-20 flex justify-between items-center text-slate-500 font-black text-[10px] uppercase tracking-[0.4em] opacity-40">
                  <span>© GITJ YOGYAKARTA</span>
                  <span>SYSTEM MANAGEMENT ALPHA V2</span>
             </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 md:p-16 relative z-10 animate-fade-in">
             <!-- Mobile Logo Only -->
            <div class="lg:hidden mb-12 flex flex-col items-center gap-3">
                 <div class="w-16 h-16 bg-primary-600 rounded-2xl flex items-center justify-center shadow-xl shadow-primary-600/30">
                    <span class="material-icons text-white text-3xl font-bold">church</span>
                 </div>
                 <h1 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tighter italic">GITJ <span class="text-primary-600">Admin</span></h1>
            </div>

            <div class="w-full max-w-md">
                <div class="mb-12">
                    <h2 class="text-4xl font-black text-slate-900 dark:text-white mb-4 tracking-tighter uppercase italic">Akses Sistem</h2>
                    <p class="text-slate-500 dark:text-slate-500 font-bold text-sm tracking-wide leading-relaxed uppercase opacity-80">Gunakan kredensial resmi untuk mengelola database gereja.</p>
                </div>

                <form @submit.prevent="submit" class="space-y-8">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-[0.4em] ml-2">Alamat Email</label>
                        <div class="relative group">
                            <input type="email" v-model="form.email" required 
                                class="w-full px-8 py-6 rounded-[2rem] bg-slate-50 dark:bg-slate-900/50 border-none focus:ring-2 focus:ring-primary-600 transition-all font-black text-slate-800 dark:text-white placeholder:text-slate-300 dark:placeholder:text-slate-800 shadow-inner" 
                                placeholder="name@example.com" />
                            <span class="material-icons-outlined absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 dark:text-slate-800 group-focus-within:text-primary-600 transition-colors">alternate_email</span>
                        </div>
                        <div v-if="form.errors.email" class="mt-2 text-xs font-bold text-red-500 ml-4 animate-shake">{{ form.errors.email }}</div>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-[0.4em] ml-2">Kata Sandi</label>
                        <div class="relative group">
                            <input :type="showPassword ? 'text' : 'password'" v-model="form.password" required 
                                class="w-full px-8 py-6 rounded-[2rem] bg-slate-50 dark:bg-slate-900/50 border-none focus:ring-2 focus:ring-primary-600 transition-all font-black text-slate-800 dark:text-white placeholder:text-slate-300 dark:placeholder:text-slate-800 shadow-inner" 
                                placeholder="••••••••••••" />
                            <button type="button" @click="showPassword = !showPassword" class="material-icons-outlined absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 dark:text-slate-800 hover:text-primary-600 transition-colors outline-none cursor-pointer">
                                {{ showPassword ? 'visibility_off' : 'visibility' }}
                            </button>
                        </div>
                         <div v-if="form.errors.password" class="mt-2 text-xs font-bold text-red-500 ml-4 animate-shake">{{ form.errors.password }}</div>
                    </div>

                    <div class="flex items-center justify-between px-2">
                        <label class="flex items-center gap-4 cursor-pointer group">
                            <div class="relative flex items-center justify-center">
                                <input type="checkbox" v-model="form.remember" class="peer appearance-none w-6 h-6 rounded-xl border-2 border-slate-200 dark:border-slate-800 checked:bg-primary-600 checked:border-primary-600 transition-all cursor-pointer" />
                                <span class="material-icons text-white text-[14px] absolute pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity">check</span>
                            </div>
                            <span class="text-xs font-black text-slate-500 group-hover:text-slate-900 dark:group-hover:text-white transition-colors uppercase tracking-widest">Ingat Sesi Ini</span>
                        </label>
                        
                        <Link href="/" class="text-[10px] font-black text-slate-400 hover:text-primary-600 transition-colors uppercase tracking-[0.2em] italic underline underline-offset-4">
                            Lupa sandi?
                        </Link>
                    </div>

                    <button type="submit" :disabled="form.processing"
                        class="w-full py-7 bg-slate-950 dark:bg-white text-white dark:text-slate-950 rounded-[2rem] font-black text-sm uppercase tracking-[0.4em] shadow-2xl hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-4 disabled:opacity-50 group">
                        {{ form.processing ? 'Memproses...' : 'Masuk ke Beranda' }}
                        <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center text-white scale-90 group-hover:scale-100 group-hover:rotate-12 transition-all">
                                <span class="material-icons text-xl">login</span>
                        </div>
                    </button>
                </form>

                <div class="mt-20 flex flex-col items-center gap-6">
                     <p class="text-slate-400 dark:text-slate-700 font-black text-[10px] uppercase tracking-[0.3em]">Butuh Bantuan Akses?</p>
                     <div class="flex gap-4">
                         <Link href="/" class="px-6 py-3 rounded-xl border border-slate-100 dark:border-slate-900 text-[10px] font-black text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-900 transition-all uppercase tracking-widest">
                             Kembali ke Website
                         </Link>
                     </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap');

.font-outfit {
    font-family: 'Outfit', sans-serif;
}

.animate-enter-up {
    animation: enterUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes enterUp {
    from { opacity: 0; transform: translateY(60px) rotate(2deg); filter: blur(10px); }
    to { opacity: 1; transform: translateY(0) rotate(0); filter: blur(0); }
}

@keyframes fadeIn {
    from { opacity: 0; filter: blur(5px); }
    to { opacity: 1; filter: blur(0); }
}

.animate-fade-in {
    animation: fadeIn 1.2s ease-out forwards;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.animate-shake {
    animation: shake 0.4s ease-in-out;
}
</style>
