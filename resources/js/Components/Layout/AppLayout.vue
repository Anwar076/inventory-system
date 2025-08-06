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

                    <SidebarLink 
                        href="/pands" 
                        :active="$page.url.startsWith('/pands')"
                        icon="HomeIcon" 
                        :collapsed="sidebarCollapsed"
                    >
                        Locaties
                    </SidebarLink>
                    
                    <SidebarLink 
                        href="/inventory" 
                        :active="$page.url.startsWith('/inventory')"
                        icon="ArchiveBoxIcon" 
                        :collapsed="sidebarCollapsed"
                    >
                        Voorraad
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
                        <div class="relative">
                            <button @click="toggleNotifications" class="p-2 text-gray-400 hover:text-gray-600 relative transition-colors duration-200">
                                <BellIcon class="h-6 w-6" />
                                <span v-if="unreadCount > 0" class="absolute -top-1 -right-1 block h-5 w-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-medium">
                                    {{ unreadCount > 99 ? '99+' : unreadCount }}
                                </span>
                            </button>
                            
                            <!-- Notification Dropdown -->
                            <div v-if="showNotifications" class="absolute right-0 mt-3 w-96 bg-white rounded-xl shadow-2xl border border-gray-200 py-0 z-50 max-h-96 overflow-hidden">
                                <!-- Header -->
                                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-900">Notificaties</h3>
                                        <button 
                                            @click="markAllAsRead" 
                                            class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200"
                                            v-if="unreadCount > 0"
                                        >
                                            Alles als gelezen
                                        </button>
                                    </div>
                                </div>

                                <!-- Tabs -->
                                <div class="flex border-b border-gray-100">
                                    <button 
                                        @click="activeTab = 'all'" 
                                        :class="[
                                            'flex-1 py-3 px-4 text-sm font-medium transition-colors duration-200',
                                            activeTab === 'all' 
                                                ? 'text-blue-600 border-b-2 border-blue-600 bg-blue-50' 
                                                : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'
                                        ]"
                                    >
                                        Alle ({{ notifications.length }})
                                    </button>
                                    <button 
                                        @click="activeTab = 'proposals'" 
                                        :class="[
                                            'flex-1 py-3 px-4 text-sm font-medium transition-colors duration-200',
                                            activeTab === 'proposals' 
                                                ? 'text-blue-600 border-b-2 border-blue-600 bg-blue-50' 
                                                : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'
                                        ]"
                                    >
                                        Voorstellen ({{ proposalCount }})
                                    </button>
                                </div>

                                <!-- Content -->
                                <div class="max-h-80 overflow-y-auto">
                                    <div v-if="loadingNotifications" class="px-6 py-8 text-center">
                                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                                        <p class="mt-2 text-sm text-gray-500">Laden...</p>
                                    </div>
                                    
                                    <div v-else-if="filteredNotifications.length === 0" class="px-6 py-8 text-center">
                                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <BellIcon class="h-6 w-6 text-gray-400" />
                                        </div>
                                        <p class="text-sm text-gray-500">Geen notificaties</p>
                                    </div>
                                    
                                    <div v-else class="divide-y divide-gray-100">
                                        <div 
                                            v-for="notification in filteredNotifications" 
                                            :key="notification.id" 
                                            :class="[
                                                'px-6 py-4 hover:bg-gray-50 transition-colors duration-200 cursor-pointer',
                                                !notification.read_at ? 'bg-blue-50 border-l-4 border-blue-500' : ''
                                            ]"
                                            @click="markAsRead(notification.id)"
                                        >
                                            <!-- Proposal Notifications -->
                                            <template v-if="notification.data && notification.data.proposal_id">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <div class="flex items-center space-x-2 mb-2">
                                                            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                                            <span class="text-xs font-medium text-yellow-700 bg-yellow-100 px-2 py-1 rounded-full">
                                                                Voorstel
                                                            </span>
                                                        </div>
                                                        <p class="text-sm font-medium text-gray-900 mb-2">
                                                            {{ notification.data.message }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 mb-3">
                                                            {{ formatNotificationDate(notification.created_at) }}
                                                        </p>
                                                        <div class="flex space-x-2">
                                                            <button 
                                                                @click.stop="openApproveModal(notification)"
                                                                class="px-3 py-1.5 bg-green-500 text-white text-xs font-medium rounded-lg hover:bg-green-600 transition-colors duration-200 flex items-center space-x-1"
                                                            >
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                                <span>Goedkeuren</span>
                                                            </button>
                                                            <button 
                                                                @click.stop="rejectProposal(notification.data.proposal_id)"
                                                                class="px-3 py-1.5 bg-red-500 text-white text-xs font-medium rounded-lg hover:bg-red-600 transition-colors duration-200 flex items-center space-x-1"
                                                            >
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                                <span>Afkeuren</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <button 
                                                        @click.stop="markAsRead(notification.id)"
                                                        class="text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                                        v-if="!notification.read_at"
                                                    >
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                            </div>
                                        </template>
                                            
                                            <!-- Regular Notifications -->
                                        <template v-else>
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <div class="flex items-center space-x-2 mb-2">
                                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                                            <span class="text-xs font-medium text-blue-700 bg-blue-100 px-2 py-1 rounded-full">
                                                                Systeem
                                                            </span>
                                                        </div>
                                                        <a 
                                                            :href="notification.data.url" 
                                                            class="block text-sm font-medium text-gray-900 mb-1 hover:text-blue-600 transition-colors duration-200"
                                                        >
                                                            {{ notification.data.message }}
                                                        </a>
                                                        <p class="text-xs text-gray-500">
                                                            {{ formatNotificationDate(notification.created_at) }}
                                                        </p>
                                                    </div>
                                                    <button 
                                                        @click.stop="markAsRead(notification.id)"
                                                        class="text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                                        v-if="!notification.read_at"
                                                    >
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                        </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Approval Modal -->
                        <div v-if="showApprovalModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
                                <!-- Modal Header -->
                                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-900">Voorstel Goedkeuren</h3>
                                        <button 
                                            @click="closeApprovalModal"
                                            class="text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Modal Content -->
                                <div class="px-6 py-4">
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-2">Product: <span class="font-medium text-gray-900">{{ selectedProposal?.data?.product_name }}</span></p>
                                        <p class="text-sm text-gray-600">Huidige voorraad: <span class="font-medium text-gray-900">{{ selectedProposal?.data?.current_stock || 0 }}</span></p>
                                        <p class="text-sm text-gray-600">Minimum voorraad: <span class="font-medium text-gray-900">{{ selectedProposal?.data?.minimum_stock || 0 }}</span></p>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Hoeveelheid bijbestellen
                                        </label>
                                        <div class="flex items-center space-x-2">
                                            <input 
                                                v-model="approvalQuantity" 
                                                type="number" 
                                                min="1"
                                                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                                placeholder="Aantal stuks"
                                            >
                                            <button 
                                                @click="setRecommendedQuantity"
                                                class="px-3 py-2 text-xs bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200"
                                            >
                                                Aanbevolen
                                            </button>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Aanbevolen: {{ recommendedQuantity }} stuks (tot minimum voorraad)
                                        </p>
                                    </div>
                                </div>

                                <!-- Modal Footer -->
                                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex space-x-3">
                                    <button 
                                        @click="closeApprovalModal"
                                        class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200"
                                    >
                                        Annuleren
                                    </button>
                                    <button 
                                        @click="approveProposalWithQuantity"
                                        :disabled="!approvalQuantity || approvalQuantity < 1"
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200 flex items-center justify-center space-x-2"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Goedkeuren</span>
                                    </button>
                                </div>
                            </div>
                        </div>
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
                                <Link href="/logout" method="post" as="button" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Sign out
                                </Link>
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
import { Link } from '@inertiajs/vue3'
import {
    Bars3Icon,
    BellIcon,
    ChevronDownIcon,
    ChevronRightIcon,
} from '@heroicons/vue/24/outline'
import SidebarLink from './SidebarLink.vue'

// Notificatie logica
const notifications = ref([])
const showNotifications = ref(false)
const loadingNotifications = ref(false)
let notificationsInterval = null

const fetchNotifications = async () => {
    loadingNotifications.value = true
    try {
        // Haal ALLE notificaties op uit de database
        const res = await fetch('/api/all-notifications', { 
            credentials: 'include',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        })
        
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`)
        }
        
        let data = await res.json()
        console.log('Raw API response:', data)
        
        if (Array.isArray(data)) {
            notifications.value = data.map(n => ({...n, data: typeof n.data === 'string' ? JSON.parse(n.data) : n.data}))
        } else if (Array.isArray(data.data)) {
            notifications.value = data.data.map(n => ({...n, data: typeof n.data === 'string' ? JSON.parse(n.data) : n.data}))
        } else {
            notifications.value = []
        }
        console.log('Processed notifications:', notifications.value)
    } catch (e) {
        console.error('Error fetching notifications:', e)
        notifications.value = []
    }
    loadingNotifications.value = false
}

const unreadCount = computed(() => notifications.value.filter(n => !n.read_at).length)

const activeTab = ref('all')
const tabClass = (tab) => `flex-1 py-2 text-center text-sm font-semibold ${activeTab.value === tab ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500'}`
const filteredNotifications = computed(() => {
    if (activeTab.value === 'proposals') {
        return notifications.value.filter(n => n.data && n.data.proposal_id && !n.read_at)
    }
    return notifications.value
})

// Helper functie om CSRF token op te halen
const getCsrfToken = () => {
    // Probeer eerst de meta tag
    const metaTag = document.querySelector('meta[name="csrf-token"]')
    if (metaTag) {
        return metaTag.getAttribute('content')
    }
    
    // Fallback: probeer de cookie
    const token = document.cookie
        .split('; ')
        .find(row => row.startsWith('XSRF-TOKEN='))
        ?.split('=')[1]
    
    if (token) {
        return decodeURIComponent(token)
    }
    
    return null
}

const approveProposal = async (proposalId) => {
    try {
        console.log('Approving proposal:', proposalId)
        const csrfToken = getCsrfToken()
        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
        
        if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken
        }
        
        const response = await fetch(`/api/low-stock-proposals/${proposalId}/approve`, { 
            method: 'POST', 
            credentials: 'include',
            headers
        })
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`)
        }
        
        const result = await response.json()
        console.log('Proposal approved:', result)
        
        // Refresh notifications
        await fetchNotifications()
        
        // Show detailed success message
        const message = `${result.message}\n\nProduct: ${result.product_name}\nToegevoegd: ${result.quantity_added} stuks\nNieuwe voorraad: ${result.new_stock} stuks`
        alert(message)
    } catch (e) {
        console.error('Error approving proposal:', e)
        alert('Fout bij goedkeuren voorstel: ' + e.message)
    }
}

const rejectProposal = async (proposalId) => {
    try {
        console.log('Rejecting proposal:', proposalId)
        const csrfToken = getCsrfToken()
        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
        
        if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken
        }
        
        const response = await fetch(`/api/low-stock-proposals/${proposalId}/reject`, { 
            method: 'POST', 
            credentials: 'include',
            headers
        })
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`)
        }
        
        const result = await response.json()
        console.log('Proposal rejected:', result)
        
        // Refresh notifications
        await fetchNotifications()
        
        // Show modern success message
        showSuccessToast('Voorstel afgekeurd.')
    } catch (e) {
        console.error('Error rejecting proposal:', e)
        showErrorToast('Fout bij afkeuren voorstel: ' + e.message)
    }
}

const toggleNotifications = async () => {
    showNotifications.value = !showNotifications.value
    if (showNotifications.value) {
        // Markeer alle als gelezen
        try {
            const csrfToken = getCsrfToken()
            const headers = {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken
            }
            await fetch('/api/notifications/mark-all-read', { 
                method: 'POST', 
                credentials: 'include',
                headers
            })
        } catch (e) {
            console.error('Error marking notifications as read:', e)
        }
        fetchNotifications()
    }
}

const markAllAsRead = async () => {
    try {
        console.log('Marking all notifications as read')
        const csrfToken = getCsrfToken()
        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
        
        if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken
        }
        
        const response = await fetch('/api/notifications/mark-all-read', { 
            method: 'POST', 
            credentials: 'include',
            headers
        })
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`)
        }
        
        console.log('All notifications marked as read')
        await fetchNotifications()
    } catch (e) {
        console.error('Error marking all notifications as read:', e)
        alert('Fout bij markeren als gelezen: ' + e.message)
    }
}

const markAsRead = async (notificationId) => {
    try {
        console.log('Marking notification as read:', notificationId)
        const csrfToken = getCsrfToken()
        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
        
        if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken
        }
        
        const response = await fetch(`/api/notifications/${notificationId}/mark-read`, { 
            method: 'POST', 
            credentials: 'include',
            headers
        })
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`)
        }
        
        console.log('Notification marked as read:', notificationId)
        await fetchNotifications()
    } catch (e) {
        console.error('Error marking notification as read:', e)
        alert('Fout bij markeren als gelezen: ' + e.message)
    }
}

const formatNotificationDate = (timestamp) => {
    const date = new Date(timestamp)
    const now = new Date()
    const diffInHours = (now - date) / (1000 * 60 * 60)
    
    if (diffInHours < 1) {
        return 'Zojuist'
    } else if (diffInHours < 24) {
        return `${Math.floor(diffInHours)} uur geleden`
    } else {
        return date.toLocaleDateString('nl-NL', { 
            day: 'numeric', 
            month: 'short',
            hour: '2-digit',
            minute: '2-digit'
        })
    }
}

const proposalCount = computed(() => {
    return notifications.value.filter(n => n.data && n.data.proposal_id).length
})

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

const openTestNotifications = () => {
    window.open('http://127.0.0.1:8000/test-notifications', '_blank')
}

// Modal state
const showApprovalModal = ref(false)
const selectedProposal = ref(null)
const approvalQuantity = ref(null)
const recommendedQuantity = ref(null)

const openApproveModal = async (notification) => {
    selectedProposal.value = notification
    approvalQuantity.value = null // Reset quantity
    recommendedQuantity.value = null // Reset recommended quantity
    showApprovalModal.value = true
    
    // Haal de product data op om de huidige voorraad en minimum voorraad te tonen
    try {
        const productId = notification.data.product_id
        const response = await fetch(`/api/products/${productId}`, {
            credentials: 'include',
            headers: {
                'Accept': 'application/json',
            }
        })
        
        if (response.ok) {
            const product = await response.json()
            // Update de notification data met de product informatie
            selectedProposal.value = {
                ...notification,
                data: {
                    ...notification.data,
                    current_stock: product.current_stock,
                    minimum_stock: product.minimum_stock,
                    product_name: product.name
                }
            }
            
            // Bereken de aanbevolen hoeveelheid
            const currentStock = product.current_stock || 0
            const minimumStock = product.minimum_stock || 0
            const difference = minimumStock - currentStock
            recommendedQuantity.value = difference > 0 ? difference : 1
        }
    } catch (e) {
        console.error('Error fetching product data:', e)
        // Fallback naar standaard waarden
        recommendedQuantity.value = 1
    }
}

const closeApprovalModal = () => {
    showApprovalModal.value = false
    selectedProposal.value = null
    approvalQuantity.value = null
    recommendedQuantity.value = null
}

const setRecommendedQuantity = () => {
    if (selectedProposal.value?.data?.minimum_stock !== undefined) {
        const currentStock = selectedProposal.value.data.current_stock || 0
        const minimumStock = selectedProposal.value.data.minimum_stock || 0
        const difference = minimumStock - currentStock
        if (difference > 0) {
            approvalQuantity.value = difference
        } else {
            approvalQuantity.value = 1 // Default to 1 if no difference or negative
        }
    } else {
        approvalQuantity.value = 1 // Default to 1 if no minimum stock
    }
}

const approveProposalWithQuantity = async () => {
    if (!selectedProposal.value || !approvalQuantity.value) {
        alert('Kies een hoeveelheid om te goed te keuren.')
        return
    }

    try {
        console.log('Approving proposal with quantity:', selectedProposal.value.data.proposal_id, approvalQuantity.value)
        const csrfToken = getCsrfToken()
        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        }
        
        if (csrfToken) {
            headers['X-CSRF-TOKEN'] = csrfToken
        }
        
        const response = await fetch(`/api/low-stock-proposals/${selectedProposal.value.data.proposal_id}/approve`, { 
            method: 'POST', 
            credentials: 'include',
            headers,
            body: JSON.stringify({ quantity: approvalQuantity.value })
        })
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`)
        }
        
        const result = await response.json()
        console.log('Proposal approved with quantity:', result)
        
        // Refresh notifications
        await fetchNotifications()
        closeApprovalModal()
        
        // Show modern success message
        showSuccessToast(`${result.message}\nProduct: ${result.product_name}\nToegevoegd: ${result.quantity_added} stuks\nNieuwe voorraad: ${result.new_stock} stuks`)
    } catch (e) {
        console.error('Error approving proposal with quantity:', e)
        showErrorToast('Fout bij goedkeuren voorstel: ' + e.message)
    }
}

// Modern toast notifications
const showSuccessToast = (message) => {
    const toast = document.createElement('div')
    toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full'
    toast.innerHTML = `
        <div class="flex items-center space-x-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <div class="whitespace-pre-line">${message}</div>
        </div>
    `
    document.body.appendChild(toast)
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full')
    }, 100)
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full')
        setTimeout(() => {
            document.body.removeChild(toast)
        }, 300)
    }, 5000)
}

const showErrorToast = (message) => {
    const toast = document.createElement('div')
    toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full'
    toast.innerHTML = `
        <div class="flex items-center space-x-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <div>${message}</div>
        </div>
    `
    document.body.appendChild(toast)
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full')
    }, 100)
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full')
        setTimeout(() => {
            document.body.removeChild(toast)
        }, 300)
    }, 5000)
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
    notificationsInterval = setInterval(fetchNotifications, 30000)
    fetchNotifications()
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
    if (notificationsInterval) clearInterval(notificationsInterval)
})
</script>