<script setup>
import { MenuItem } from '@headlessui/vue'
import { Link } from '@inertiajs/vue3'

defineProps({
    href: String,
    as: {
        type: String,
        default: 'link'
    }
})
</script>

<template>
    <MenuItem v-slot="{ active, close }">
        <Link
            v-if="as === 'link'"
            :href="href"
            :class="[
                active ? 'bg-slate-50 dark:bg-slate-700/50 text-primary-600 dark:text-primary-400' : 'text-slate-700 dark:text-slate-300',
                'group flex w-full items-center px-4 py-3 text-sm font-bold transition-colors'
            ]"
        >
            <slot :active="active" />
        </Link>
        <button
            v-else
            type="button"
            :class="[
                active ? 'bg-slate-50 dark:bg-slate-700/50 text-primary-600 dark:text-primary-400' : 'text-slate-700 dark:text-slate-300',
                'group flex w-full items-center px-4 py-3 text-sm font-bold transition-colors text-left'
            ]"
            @click="close"
        >
            <slot :active="active" :close="close" />
        </button>
    </MenuItem>
</template>
