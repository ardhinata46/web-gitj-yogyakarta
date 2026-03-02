<script setup>
import { TransitionRoot } from '@headlessui/vue'
import { ref, watch, onMounted } from 'vue'

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    type: {
        type: String,
        default: 'success',
        validator: (value) => ['success', 'error', 'warning', 'info'].includes(value)
    },
    message: {
        type: String,
        required: true
    },
    duration: {
        type: Number,
        default: 5000
    }
})

const emit = defineEmits(['close'])

const isShowing = ref(props.show)

watch(() => props.show, (newValue) => {
    isShowing.value = newValue
    if (newValue && props.duration > 0) {
        setTimeout(() => {
            close()
        }, props.duration)
    }
})

const close = () => {
    isShowing.value = false
    emit('close')
}

const typeConfig = {
    success: {
        bg: 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-800',
        icon: 'text-emerald-600 dark:text-emerald-400',
        text: 'text-emerald-800 dark:text-emerald-200',
        iconName: 'check_circle'
    },
    error: {
        bg: 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800',
        icon: 'text-red-600 dark:text-red-400',
        text: 'text-red-800 dark:text-red-200',
        iconName: 'error'
    },
    warning: {
        bg: 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800',
        icon: 'text-yellow-600 dark:text-yellow-400',
        text: 'text-yellow-800 dark:text-yellow-200',
        iconName: 'warning'
    },
    info: {
        bg: 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800',
        icon: 'text-blue-600 dark:text-blue-400',
        text: 'text-blue-800 dark:text-blue-200',
        iconName: 'info'
    }
}
</script>

<template>
    <div class="fixed top-4 right-4 z-50 max-w-sm w-full">
        <TransitionRoot
            :show="isShowing"
            enter="transform ease-out duration-300 transition"
            enter-from="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            enter-to="translate-y-0 opacity-100 sm:translate-x-0"
            leave="transition ease-in duration-200"
            leave-from="opacity-100"
            leave-to="opacity-0"
        >
            <div :class="[typeConfig[type].bg, 'rounded-2xl border p-4 shadow-xl backdrop-blur-sm']">
                <div class="flex items-start gap-3">
                    <span :class="[typeConfig[type].icon, 'material-icons-outlined flex-shrink-0']">
                        {{ typeConfig[type].iconName }}
                    </span>
                    <p :class="[typeConfig[type].text, 'text-sm font-bold flex-1']">
                        {{ message }}
                    </p>
                    <button
                        @click="close"
                        :class="[typeConfig[type].icon, 'hover:opacity-70 transition-opacity']"
                    >
                        <span class="material-icons-outlined text-lg">close</span>
                    </button>
                </div>
            </div>
        </TransitionRoot>
    </div>
</template>
