<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Line } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  LinearScale,
  PointElement,
  CategoryScale,
  Filler,
} from 'chart.js';
import { computed } from 'vue';
import { useTheme } from 'vuetify';

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  LinearScale,
  PointElement,
  CategoryScale,
  Filler
);

const props = defineProps({
    stats: Object,
    charts: Object,
    recent_announcements: Array
});

const theme = useTheme();
const isDark = computed(() => theme.global.current.value.dark);

const chartData = computed(() => ({
  labels: props.charts.labels,
  datasets: [
    {
      label: 'Pendapatan',
      backgroundColor: 'rgba(16, 185, 129, 0.1)',
      borderColor: '#10b981',
      data: props.charts.income,
      tension: 0.4,
      borderWidth: 4,
      pointRadius: 0,
      pointHoverRadius: 6,
      fill: true,
    },
    {
      label: 'Pengeluaran',
      backgroundColor: 'rgba(244, 63, 94, 0.1)',
      borderColor: '#f43f5e',
      data: props.charts.expense,
      tension: 0.4,
      borderWidth: 4,
      pointRadius: 0,
      pointHoverRadius: 6,
      fill: true,
    }
  ]
}));

const chartOptions = computed(() => ({
  responsive: true,
  maintainAspectRatio: false,
  interaction: {
    intersect: false,
    mode: 'index',
  },
  plugins: {
    legend: {
        position: 'top',
        align: 'end',
        labels: {
            usePointStyle: true,
            pointStyle: 'circle',
            padding: 20,
            color: isDark.value ? '#cbd5e1' : '#475569',
            font: {
                weight: 'bold',
                size: 12,
                family: 'Outfit'
            }
        }
    },
    tooltip: {
        backgroundColor: isDark.value ? '#1e293b' : '#ffffff',
        titleColor: isDark.value ? '#f1f5f9' : '#0f172a',
        bodyColor: isDark.value ? '#cbd5e1' : '#475569',
        borderColor: isDark.value ? '#334155' : '#e2e8f0',
        borderWidth: 1,
        padding: 12,
        displayColors: true,
        boxPadding: 6,
        usePointStyle: true,
        titleFont: { family: 'Outfit', weight: 'bold' },
        bodyFont: { family: 'Outfit' }
    }
  },
  scales: {
    y: {
        beginAtZero: true,
        grid: {
            display: true,
            drawBorder: false,
            color: isDark.value ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)'
        },
        ticks: {
            color: isDark.value ? '#94a3b8' : '#64748b',
            font: {
                weight: 'bold',
                family: 'Outfit'
            },
            callback: (value) => 'Rp ' + value.toLocaleString()
        }
    },
    x: {
        grid: {
            display: false
        },
        ticks: {
            color: isDark.value ? '#94a3b8' : '#64748b',
            font: {
                weight: 'bold',
                family: 'Outfit'
            }
        }
    }
  }
}));
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <template #header>
            Dashboard
        </template>

        <!-- Stats Grid -->
        <v-row class="mb-6">
            <v-col cols="12" sm="6" lg="3">
                <v-card rounded="xl" elevation="0" class="pa-6 stats-card bg-indigo-grow" theme="dark">
                    <div class="d-flex align-center justify-space-between mb-4">
                        <v-avatar color="white" rounded="lg" size="48" class="elevation-4">
                            <v-icon color="indigo" size="28">mdi-account-group</v-icon>
                        </v-avatar>
                        <v-chip size="x-small" color="white" variant="tonal" class="font-weight-black uppercase">Members</v-chip>
                    </div>
                    <div class="text-h4 font-black mb-1">{{ stats.members_count }}</div>
                    <div class="text-caption font-bold text-indigo-lighten-4 uppercase tracking-widest">Total Anggota</div>
                    <v-icon class="card-bg-icon">mdi-account-group</v-icon>
                </v-card>
            </v-col>

            <v-col cols="12" sm="6" lg="3">
                <v-card rounded="xl" elevation="0" class="pa-6 stats-card bg-emerald-grow" theme="dark">
                    <div class="d-flex align-center justify-space-between mb-4">
                        <v-avatar color="white" rounded="lg" size="48" class="elevation-4">
                            <v-icon color="emerald" size="28">mdi-trending-up</v-icon>
                        </v-avatar>
                        <v-chip size="x-small" color="white" variant="tonal" class="font-weight-black uppercase">Income</v-chip>
                    </div>
                    <div class="text-h5 font-black mb-1">Rp {{ stats.total_income.toLocaleString() }}</div>
                    <div class="text-caption font-bold text-emerald-lighten-4 uppercase tracking-widest">Total Pendapatan</div>
                    <v-icon class="card-bg-icon">mdi-cash-plus</v-icon>
                </v-card>
            </v-col>

            <v-col cols="12" sm="6" lg="3">
                <v-card rounded="xl" elevation="0" class="pa-6 stats-card bg-rose-grow" theme="dark">
                    <div class="d-flex align-center justify-space-between mb-4">
                        <v-avatar color="white" rounded="lg" size="48" class="elevation-4">
                            <v-icon color="rose" size="28">mdi-trending-down</v-icon>
                        </v-avatar>
                        <v-chip size="x-small" color="white" variant="tonal" class="font-weight-black uppercase">Expense</v-chip>
                    </div>
                    <div class="text-h5 font-black mb-1">Rp {{ stats.total_expense.toLocaleString() }}</div>
                    <div class="text-caption font-bold text-rose-lighten-4 uppercase tracking-widest">Total Pengeluaran</div>
                    <v-icon class="card-bg-icon">mdi-cash-minus</v-icon>
                </v-card>
            </v-col>

            <v-col cols="12" sm="6" lg="3">
                <v-card rounded="xl" elevation="0" class="pa-6 stats-card bg-amber-grow" theme="dark">
                    <div class="d-flex align-center justify-space-between mb-4">
                        <v-avatar color="white" rounded="lg" size="48" class="elevation-4">
                            <v-icon color="amber" size="28">mdi-wallet-outline</v-icon>
                        </v-avatar>
                        <v-chip size="x-small" color="white" variant="tonal" class="font-weight-black uppercase">Balance</v-chip>
                    </div>
                    <div class="text-h5 font-black mb-1">Rp {{ stats.balance.toLocaleString() }}</div>
                    <div class="text-caption font-bold text-amber-lighten-4 uppercase tracking-widest">Saldo Saat Ini</div>
                    <v-icon class="card-bg-icon">mdi-bank-outline</v-icon>
                </v-card>
            </v-col>
        </v-row>

        <v-row>
            <!-- Analytics Chart -->
            <v-col cols="12" lg="8">
                <v-card rounded="xl" elevation="0" class="pa-8 border border-slate-100 dark:border-slate-800 overflow-hidden">
                    <div class="d-flex align-center justify-space-between mb-8">
                        <div>
                            <div class="text-h6 font-black text-slate-900 dark:text-white mb-1">Tren Keuangan</div>
                            <div class="text-caption font-bold text-slate-400 uppercase tracking-widest">6 Bulan Terakhir</div>
                        </div>
                        <v-btn icon="mdi-dots-vertical" variant="text" density="comfortable" color="secondary"></v-btn>
                    </div>
                    <div class="h-80 w-full relative">
                        <Line :data="chartData" :options="chartOptions" />
                    </div>
                </v-card>
            </v-col>

            <!-- Recent Activity -->
            <v-col cols="12" lg="4">
                <v-card rounded="xl" elevation="0" class="pa-8 border border-slate-100 dark:border-slate-800 fill-height">
                    <div class="d-flex align-center justify-space-between mb-8">
                        <div class="text-h6 font-black text-slate-900 dark:text-white">Warta Terbaru</div>
                        <v-btn icon="mdi-arrow-right-circle-outline" variant="text" color="primary" @click="router.visit(route('admin.announcements.index'))"></v-btn>
                    </div>
                    
                    <v-list class="bg-transparent pa-0">
                        <v-list-item
                            v-for="ann in recent_announcements"
                            :key="ann.id"
                            rounded="xl"
                            class="mb-3 pa-4 border border-transparent hover-border-slate-200 dark:hover-border-slate-700 hover-bg-light transition-all cursor-pointer"
                            @click="router.visit(route('admin.announcements.index'))"
                        >
                            <template v-slot:prepend>
                                <v-avatar color="primary" rounded="lg" size="44" variant="tonal">
                                    <v-icon size="20">mdi-bullhorn-outline</v-icon>
                                </v-avatar>
                            </template>
                            <v-list-item-title class="font-weight-black text-body-2 mb-1">{{ ann.title }}</v-list-item-title>
                            <v-list-item-subtitle class="text-caption font-bold text-slate-400 uppercase tracking-wider">
                                {{ new Date(ann.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                            </v-list-item-subtitle>
                        </v-list-item>

                        <div v-if="recent_announcements.length === 0" class="text-center py-10">
                            <v-icon size="48" color="slate-lighten-4" class="mb-4">mdi-inbox-outline</v-icon>
                            <div class="text-body-2 font-bold text-slate-400">Belum ada warta terbaru</div>
                        </div>
                    </v-list>
                </v-card>
            </v-col>
        </v-row>

        <!-- Quick Actions -->
        <div class="mt-8">
            <div class="text-subtitle-1 font-black text-slate-900 dark:text-white mb-4 px-2">Akses Cepat</div>
            <v-row>
                <v-col v-for="action in [
                    { title: 'Input Keuangan', icon: 'mdi-plus-circle', color: 'emerald', route: 'admin.transactions.index' },
                    { title: 'Tambah Anggota', icon: 'mdi-account-plus', color: 'indigo', route: 'admin.members.index' },
                    { title: 'Buat Warta', icon: 'mdi-message-draw', color: 'amber', route: 'admin.announcements.index' },
                    { title: 'Lihat Laporan', icon: 'mdi-chart-box', color: 'rose', route: 'admin.reports.index' },
                ]" :key="action.title" cols="6" sm="3">
                    <v-btn
                        block
                        rounded="xl"
                        height="64"
                        variant="flat"
                        :color="action.color"
                        class="text-none font-weight-black elevation-2 transition-all hover-scale"
                        @click="router.visit(route(action.route))"
                    >
                        <v-icon :icon="action.icon" class="me-2" size="24"></v-icon>
                        {{ action.title }}
                    </v-btn>
                </v-col>
            </v-row>
        </div>
    </AdminLayout>
</template>

<style scoped>
.stats-card {
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px -10px rgba(0,0,0,0.3) !important;
}

.card-bg-icon {
    position: absolute;
    right: -10px;
    bottom: -10px;
    font-size: 80px;
    opacity: 0.1;
    transform: rotate(-15deg);
}

.bg-indigo-grow {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
}
.bg-emerald-grow {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}
.bg-rose-grow {
    background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
}
.bg-amber-grow {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.hover-border-slate-200:hover {
    border-color: #e2e8f0 !important;
}

.dark .hover-border-slate-700:hover {
    border-color: #334155 !important;
}

.hover-bg-light:hover {
    background-color: rgba(var(--v-theme-primary), 0.05) !important;
}

.hover-scale:hover {
    transform: scale(1.02);
}

.hover-scale:active {
    transform: scale(0.98);
}
</style>
