<template>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600">{{ title }}</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ value }}</p>
                <div v-if="change" class="flex items-center mt-2">
                    <span 
                        :class="[
                            'text-sm font-medium',
                            changeType === 'positive' ? 'text-green-600' : 'text-red-600'
                        ]"
                    >
                        {{ change }}
                    </span>
                    <span class="text-gray-500 text-sm ml-1">from last month</span>
                </div>
            </div>
            <div 
                :class="[
                    'w-12 h-12 rounded-lg flex items-center justify-center',
                    color === 'blue' ? 'bg-blue-100' : 
                    color === 'red' ? 'bg-red-100' : 
                    color === 'green' ? 'bg-green-100' : 
                    color === 'yellow' ? 'bg-yellow-100' : 'bg-gray-100'
                ]"
            >
                <component 
                    :is="iconComponent" 
                    :class="[
                        'w-6 h-6',
                        color === 'blue' ? 'text-blue-600' : 
                        color === 'red' ? 'text-red-600' : 
                        color === 'green' ? 'text-green-600' : 
                        color === 'yellow' ? 'text-yellow-600' : 'text-gray-600'
                    ]"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { 
    CubeIcon, 
    ExclamationTriangleIcon, 
    CurrencyDollarIcon, 
    TruckIcon 
} from '@heroicons/vue/24/outline'

export default {
    name: 'StatsCard',
    props: {
        title: {
            type: String,
            required: true
        },
        value: {
            type: [String, Number],
            required: true
        },
        icon: {
            type: String,
            required: true
        },
        color: {
            type: String,
            default: 'blue'
        },
        change: {
            type: String,
            default: null
        },
        changeType: {
            type: String,
            default: 'positive'
        }
    },
    computed: {
        iconComponent() {
            const iconMap = {
                'CubeIcon': CubeIcon,
                'ExclamationTriangleIcon': ExclamationTriangleIcon,
                'CurrencyDollarIcon': CurrencyDollarIcon,
                'TruckIcon': TruckIcon
            }
            return iconMap[this.icon] || CubeIcon
        }
    }
}
</script>
