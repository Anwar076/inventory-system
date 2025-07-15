<template>
    <a 
        :href="href"
        :class="[
            'group relative p-6 rounded-xl border border-gray-200 bg-white hover:bg-gray-50',
            'transition-all duration-200 hover:shadow-md hover:border-gray-300',
            'focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2',
            'flex flex-col items-center justify-center space-y-3 text-center'
        ]"
    >
        <div 
            :class="[
                'w-12 h-12 rounded-lg flex items-center justify-center',
                'bg-blue-100 text-blue-600 group-hover:bg-blue-200 transition-colors duration-200'
            ]"
        >
            <component 
                :is="iconComponent" 
                class="w-6 h-6"
            />
        </div>
        
        <div>
            <h3 class="font-medium text-gray-900">{{ title }}</h3>
            <p class="text-sm text-gray-500 mt-1">{{ description }}</p>
        </div>
        
        <!-- Hover effect -->
        <div 
            class="absolute inset-0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-gradient-to-r from-blue-50 to-indigo-50"
        />
    </a>
</template>

<script>
import { 
    PlusIcon, 
    ArrowUpIcon, 
    TruckIcon,
    DocumentChartBarIcon
} from '@heroicons/vue/24/outline'

export default {
    name: 'QuickActionButton',
    props: {
        title: {
            type: String,
            required: true
        },
        description: {
            type: String,
            required: true
        },
        href: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            required: true
        }
    },
    computed: {
        iconComponent() {
            const iconMap = {
                'PlusIcon': PlusIcon,
                'ArrowUpIcon': ArrowUpIcon,
                'TruckIcon': TruckIcon,
                'DocumentChartBarIcon': DocumentChartBarIcon
            }
            return iconMap[this.icon] || PlusIcon
        }
    }
}
</script>
