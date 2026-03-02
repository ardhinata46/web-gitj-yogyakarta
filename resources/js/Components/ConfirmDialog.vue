<script setup>
import { Dialog, DialogPanel, DialogTitle, TransitionRoot, TransitionChild } from '@headlessui/vue'
import { ref, watch } from 'vue'

const props = defineProps({
    show: Boolean,
    title: {
        type: String,
        default: 'Konfirmasi'
    },
    message: {
        type: String,
        required: true
    },
    confirmText: {
        type: String,
        default: 'Hapus'
    },
    cancelText: {
        type: String,
        default: 'Batal'
    },
    type: {
        type: String,
        default: 'danger', // danger, warning, info
        validator: (value) => ['danger', 'warning', 'info'].includes(value)
    }
})

const emit = defineEmits(['confirm', 'cancel', 'update:show'])

const isOpen = ref(props.show)

watch(() => props.show, (newValue) => {
    isOpen.value = newValue
})

const closeModal = () => {
    isOpen.value = false
    emit('update:show', false)
    emit('cancel')
}

const confirm = () => {
    isOpen.value = false
    emit('update:show', false)
    emit('confirm')
}

const typeColors = {
    danger: {
        icon: 'bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400',
        button: 'bg-red-600 hover:bg-red-700 dark:bg-red-600 dark:hover:bg-red-700'
    },
    warning: {
        icon: 'bg-yellow-100 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400',
        button: 'bg-yellow-600 hover:bg-yellow-700 dark:bg-yellow-600 dark:hover:bg-yellow-700'
    },
    info: {
        icon: 'bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400',
        button: 'bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700'
    }
}
</script>

<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-50">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/50 dark:bg-black/70 backdrop-blur-sm" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-3xl bg-white dark:bg-slate-800 p-8 text-left align-middle shadow-2xl transition-all border border-slate-100 dark:border-slate-700">
                            <div class="flex items-start gap-4">
                                <div :class="[typeColors[type].icon, 'flex-shrink-0 w-12 h-12 rounded-2xl flex items-center justify-center']">
                                    <span class="material-icons-outlined text-2xl">
                                        {{ type === 'danger' ? 'warning' : type === 'warning' ? 'error_outline' : 'info' }}
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <DialogTitle as="h3" class="text-xl font-black text-slate-900 dark:text-white mb-2 tracking-tight">
                                        {{ title }}
                                    </DialogTitle>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                        {{ message }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-8 flex gap-3">
                                <button
                                    type="button"
                                    :class="[typeColors[type].button, 'flex-1 px-6 py-3 text-sm font-bold text-white rounded-xl transition-all hover:shadow-lg']"
                                    @click="confirm"
                                >
                                    {{ confirmText }}
                                </button>
                                <button
                                    type="button"
                                    class="flex-1 px-6 py-3 text-sm font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 transition-all"
                                    @click="closeModal"
                                >
                                    {{ cancelText }}
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
