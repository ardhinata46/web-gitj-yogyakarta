<script setup>
import { Menu, MenuButton, MenuItems, MenuItem, TransitionRoot, TransitionChild } from '@headlessui/vue'

defineProps({
    align: {
        type: String,
        default: 'right',
        validator: (value) => ['left', 'right'].includes(value)
    },
    width: {
        type: String,
        default: '48',
        validator: (value) => ['48', '56', '64'].includes(value)
    }
})

const widthClass = {
    '48': 'w-48',
    '56': 'w-56',
    '64': 'w-64'
}

const alignmentClasses = {
    left: 'origin-top-left left-0',
    right: 'origin-top-right right-0'
}
</script>

<template>
    <Menu as="div" class="relative inline-block text-left">
        <MenuButton class="inline-flex w-full justify-center items-center">
            <slot name="trigger" />
        </MenuButton>

        <TransitionRoot
            enter="transition ease-out duration-100"
            enter-from="transform opacity-0 scale-95"
            enter-to="transform opacity-100 scale-100"
            leave="transition ease-in duration-75"
            leave-from="transform opacity-100 scale-100"
            leave-to="transform opacity-0 scale-95"
        >
            <MenuItems :class="[widthClass[width], alignmentClasses[align], 'absolute mt-2 rounded-2xl bg-white dark:bg-slate-800 shadow-xl ring-1 ring-black/5 dark:ring-white/10 focus:outline-none border border-slate-100 dark:border-slate-700 overflow-hidden']">
                <div class="py-1">
                    <slot name="content" />
                </div>
            </MenuItems>
        </TransitionRoot>
    </Menu>
</template>
