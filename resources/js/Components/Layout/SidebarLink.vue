<template>
    <a 
        :href="href"
        :class="linkClasses"
        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200"
    >
        <component 
            :is="iconComponent" 
            :class="iconClasses"
            class="flex-shrink-0 h-5 w-5 transition-colors duration-200"
        />
        <span v-if="!collapsed" class="ml-3 truncate">
            <slot />
        </span>
        
        <!-- Tooltip for collapsed sidebar -->
        <div 
            v-if="collapsed" 
            class="absolute left-16 px-2 py-1 ml-2 text-sm text-white bg-gray-900 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50"
        >
            <slot />
        </div>
    </a>
</template>

<script setup>
import { computed } from 'vue'
import {
    HomeIcon,
    CubeIcon,
    TagIcon,
    TruckIcon,
    ArrowsRightLeftIcon,
    ChartBarIcon,
    CogIcon,
} from '@heroicons/vue/24/outline'

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
        default: false,
    },
    icon: {
        type: String,
        required: true,
    },
    collapsed: {
        type: Boolean,
        default: false,
    },
})

const iconComponents = {
    HomeIcon,
    CubeIcon,
    TagIcon,
    TruckIcon,
    ArrowsRightLeftIcon,
    ChartBarIcon,
    CogIcon,
}

const iconComponent = computed(() => iconComponents[props.icon] || HomeIcon)

const linkClasses = computed(() => ({
    'bg-gray-700 text-white': props.active,
    'text-gray-300 hover:bg-gray-700 hover:text-white': !props.active,
    'justify-center': props.collapsed,
    'relative': props.collapsed,
}))

const iconClasses = computed(() => ({
    'text-white': props.active,
    'text-gray-400 group-hover:text-white': !props.active,
}))
</script>