<script setup>
import { ref, onMounted } from 'vue';
import { useTheme } from 'vuetify';

const theme = useTheme();
const isDark = ref(false);

const toggleTheme = () => {
    isDark.value = !isDark.value;
    const newTheme = isDark.value ? 'dark' : 'light';
    
    theme.global.name.value = newTheme;
    localStorage.setItem('theme', newTheme);
    
    if (isDark.value) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

onMounted(() => {
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        isDark.value = true;
        theme.global.name.value = 'dark';
        document.documentElement.classList.add('dark');
    } else {
        isDark.value = false;
        theme.global.name.value = 'light';
        document.documentElement.classList.remove('dark');
    }
});
</script>

<template>
    <v-btn
        icon
        variant="tonal"
        @click="toggleTheme"
        class="rounded-xl transition-all hover:scale-110 active:scale-95"
        :color="isDark ? 'amber-lighten-1' : 'primary'"
        size="40"
    >
        <v-icon size="20">
            {{ isDark ? 'mdi-weather-sunny' : 'mdi-weather-night' }}
        </v-icon>
    </v-btn>
</template>
