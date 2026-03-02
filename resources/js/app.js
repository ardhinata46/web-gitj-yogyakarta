import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';

// Vuetify
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/styles';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Vuetify theme configuration
const vuetify = createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: localStorage.getItem('theme') || 'light',
        themes: {
            light: {
                dark: false,
                colors: {
                    primary: '#2563eb',      // Blue
                    secondary: '#64748b',    // Slate
                    accent: '#059669',       // Emerald
                    error: '#ef4444',        // Red
                    warning: '#f59e0b',      // Amber
                    info: '#3b82f6',         // Blue
                    success: '#10b981',      // Emerald
                    background: '#f8fafc',   // Slate 50
                    surface: '#ffffff',      // White
                },
            },
            dark: {
                dark: true,
                colors: {
                    primary: '#3b82f6',      // Lighter blue for dark mode
                    secondary: '#94a3b8',    // Lighter slate
                    accent: '#10b981',       // Brighter emerald
                    error: '#f87171',        // Lighter red
                    warning: '#fbbf24',      // Lighter amber
                    info: '#60a5fa',         // Lighter blue
                    success: '#34d399',      // Lighter emerald
                    background: '#0f172a',   // Slate 900
                    surface: '#1e293b',      // Slate 800
                },
            },
        },
    },
    defaults: {
        VBtn: {
            style: 'text-transform: none;', // Disable uppercase buttons
        },
    },
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(vuetify)
            .mount(el);
    },
    progress: {
        color: '#2563eb', // Match primary color
    },
});
