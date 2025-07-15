<template>
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Sidebar -->
        <div :class="sidebarClasses" class="bg-gray-800 text-white sidebar-transition">
            <div class="p-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">IP</span>
                    </div>
                    <h2 v-if="!sidebarCollapsed" class="text-xl font-bold">InventoryPro</h2>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-8">
                <div class="px-4 space-y-1">
                    <SidebarLink 
                        href="/dashboard" 
                        :active="$page.url === '/dashboard'"
                        icon="HomeIcon"
                        :collapsed="sidebarCollapsed"
                    >
                        Dashboard
                    </SidebarLink>
                    
                    <SidebarLink 
                        href="/products" 
                        :active="$page.url.startsWith('/products')"
                        icon="CubeIcon"
                        :collapsed="sidebarCollapsed"
                    >
                        Products
                    </SidebarLink>
                    
                    <SidebarLink 
                        href="/categories" 
                        :active="$page.url.startsWith('/categories')"
                        icon="TagIcon"
                        :collapsed="sidebarCollapsed"
                    >
                        Categories
                    </SidebarLink>
                    
                    <SidebarLink 
                        href="/suppliers" 
                        :active="$page.url.startsWith('/suppliers')"
                        icon="TruckIcon"
                        :collapsed="sidebarCollapsed"
                    >
                        Suppliers
                    </SidebarLink>
                    
                    <SidebarLink 
                        href="/stock-transactions" 
                        :active="$page.url.startsWith('/stock-transactions')"
                        icon="ArrowsRightLeftIcon"
                        :collapsed="sidebarCollapsed"
                    >
                        Stock Movements
                    </SidebarLink>
                    
                    <SidebarLink 
                        href="/reports" 
                        :active="$page.url.startsWith('/reports')"
                        icon="ChartBarIcon"
                        :collapsed="sidebarCollapsed"
                    >
                        Reports
                    </SidebarLink>
                    
                    <SidebarLink 
                        href="/settings" 
                        :active="$page.url.startsWith('/settings')"
                        icon="CogIcon"
                        :collapsed="sidebarCollapsed"
                    >
                        Settings
                    </SidebarLink>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button 
                            @click="toggleSidebar"
                            class="p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-600"
                        >
                            <Bars3Icon class="h-6 w-6" />
                        </button>
                        
                        <!-- Breadcrumbs -->
                        <nav class="ml-4" v-if="breadcrumbs">
                            <ol class="flex items-center space-x-2">
                                <li v-for="(crumb, index) in breadcrumbs" :key="index" class="flex items-center">
                                    <ChevronRightIcon v-if="index > 0" class="h-4 w-4 text-gray-400 mx-2" />
                                    <span :class="index === breadcrumbs.length - 1 ? 'text-gray-900 font-medium' : 'text-gray-500'">
                                        {{ crumb }}
                                    </span>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="p-2 text-gray-400 hover:text-gray-600 relative">
                            <BellIcon class="h-6 w-6" />
                            <span class="absolute top-1 right-1 block h-2 w-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- User Menu -->
                        <div class="relative">
                            <button 
                                @click="showUserMenu = !showUserMenu"
                                class="flex items-center space-x-2 text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <img class="h-8 w-8 rounded-full" :src="user.avatar_url" :alt="user.name" />
                                <span class="text-gray-700">{{ user.name }}</span>
                                <ChevronDownIcon class="h-4 w-4 text-gray-400" />
                            </button>
                            
                            <!-- User Dropdown -->
                            <div v-show="showUserMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <a href="/billing" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Billing</a>
                                <hr class="my-1">
                                <form method="POST" action="/logout" class="block">
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-6 py-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import {
    Bars3Icon,
    BellIcon,
    ChevronDownIcon,
    ChevronRightIcon,
} from '@heroicons/vue/24/outline'
import SidebarLink from './SidebarLink.vue'

defineProps({
    breadcrumbs: Array,
})

const { props } = usePage()
const user = computed(() => props.auth?.user || { name: 'Guest', avatar_url: '/images/default-avatar.png' })

const sidebarCollapsed = ref(false)
const showUserMenu = ref(false)

const sidebarClasses = computed(() => ({
    'w-64': !sidebarCollapsed.value,
    'w-16': sidebarCollapsed.value,
}))

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value
}

const handleClickOutside = (event) => {
    if (!event.target.closest('.relative')) {
        showUserMenu.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>