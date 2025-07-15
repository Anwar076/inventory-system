<template>
    <AppLayout :breadcrumbs="['Dashboard']">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="mt-2 text-gray-600">Welcome to your inventory management dashboard</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <StatsCard
                title="Total Products"
                :value="stats.totalProducts"
                icon="CubeIcon"
                color="blue"
                :change="'+12%'"
                changeType="positive"
            />
            <StatsCard
                title="Low Stock Items"
                :value="stats.lowStockItems"
                icon="ExclamationTriangleIcon"
                color="yellow"
                :change="-8%'"
                changeType="negative"
            />
            <StatsCard
                title="Total Value"
                :value="`€${stats.totalValue.toLocaleString()}`"
                icon="CurrencyEuroIcon"
                color="green"
                :change="'+5%'"
                changeType="positive"
            />
            <StatsCard
                title="Monthly Sales"
                :value="stats.monthlySales"
                icon="ChartBarIcon"
                color="purple"
                :change="'+15%'"
                changeType="positive"
            />
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Transactions -->
            <div class="widget-card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Transactions</h3>
                    <a href="/stock-transactions" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View all
                    </a>
                </div>
                <div class="space-y-4">
                    <div v-for="transaction in recentTransactions" :key="transaction.id" class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                        <div class="flex items-center space-x-3">
                            <div :class="`w-8 h-8 rounded-full flex items-center justify-center ${getTransactionColor(transaction.type)}`">
                                <component :is="getTransactionIcon(transaction.type)" class="h-4 w-4" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ transaction.product_name }}</p>
                                <p class="text-xs text-gray-500">{{ transaction.type }} • {{ formatDate(transaction.date) }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p :class="`text-sm font-medium ${transaction.quantity > 0 ? 'text-green-600' : 'text-red-600'}`">
                                {{ transaction.quantity > 0 ? '+' : '' }}{{ transaction.quantity }}
                            </p>
                            <p class="text-xs text-gray-500">€{{ transaction.amount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Low Stock Alerts -->
            <div class="widget-card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Low Stock Alerts</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        {{ lowStockProducts.length }} items
                    </span>
                </div>
                <div class="space-y-4">
                    <div v-for="product in lowStockProducts" :key="product.id" class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                        <div class="flex items-center space-x-3">
                            <img :src="product.image" :alt="product.name" class="w-10 h-10 rounded-lg object-cover" />
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ product.name }}</p>
                                <p class="text-xs text-gray-500">SKU: {{ product.sku }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-red-600">{{ product.current_stock }} left</p>
                            <p class="text-xs text-gray-500">Min: {{ product.minimum_stock }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8">
            <div class="widget-card">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <QuickActionButton
                        href="/products/create"
                        icon="PlusIcon"
                        title="Add Product"
                        description="Create new product"
                    />
                    <QuickActionButton
                        href="/stock-transactions/create"
                        icon="ArrowUpIcon"
                        title="Add Stock"
                        description="Increase inventory"
                    />
                    <QuickActionButton
                        href="/suppliers/create"
                        icon="TruckIcon"
                        title="Add Supplier"
                        description="New supplier"
                    />
                    <QuickActionButton
                        href="/reports"
                        icon="DocumentChartBarIcon"
                        title="Generate Report"
                        description="View analytics"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { computed } from 'vue'
import AppLayout from '@/Components/Layout/AppLayout.vue'
import StatsCard from '@/Components/UI/StatsCard.vue'
import QuickActionButton from '@/Components/UI/QuickActionButton.vue'
import {
    ArrowUpIcon,
    ArrowDownIcon,
    PlusIcon,
    TruckIcon,
    DocumentChartBarIcon,
} from '@heroicons/vue/24/outline'

const props = defineProps({
    stats: Object,
    recentTransactions: Array,
    lowStockProducts: Array,
})

// Mock data for demonstration
const stats = {
    totalProducts: 1247,
    lowStockItems: 23,
    totalValue: 156789,
    monthlySales: 89,
}

const recentTransactions = [
    { id: 1, product_name: 'Wireless Headphones', type: 'sale', quantity: -2, amount: '159.98', date: '2025-01-15' },
    { id: 2, product_name: 'Office Chair', type: 'purchase', quantity: 10, amount: '1299.90', date: '2025-01-15' },
    { id: 3, product_name: 'Laptop Stand', type: 'sale', quantity: -1, amount: '45.99', date: '2025-01-14' },
    { id: 4, product_name: 'Desk Lamp', type: 'adjustment', quantity: -1, amount: '0.00', date: '2025-01-14' },
    { id: 5, product_name: 'Notebook Set', type: 'purchase', quantity: 50, amount: '299.50', date: '2025-01-13' },
]

const lowStockProducts = [
    { id: 1, name: 'Wireless Mouse', sku: 'WM-001', current_stock: 3, minimum_stock: 10, image: '/images/products/mouse.jpg' },
    { id: 2, name: 'USB Cable', sku: 'UC-002', current_stock: 5, minimum_stock: 20, image: '/images/products/cable.jpg' },
    { id: 3, name: 'Phone Case', sku: 'PC-003', current_stock: 2, minimum_stock: 15, image: '/images/products/case.jpg' },
    { id: 4, name: 'Screen Protector', sku: 'SP-004', current_stock: 1, minimum_stock: 25, image: '/images/products/protector.jpg' },
]

const getTransactionColor = (type) => {
    const colors = {
        sale: 'bg-blue-100 text-blue-600',
        purchase: 'bg-green-100 text-green-600',
        adjustment: 'bg-yellow-100 text-yellow-600',
        return: 'bg-purple-100 text-purple-600',
    }
    return colors[type] || 'bg-gray-100 text-gray-600'
}

const getTransactionIcon = (type) => {
    const icons = {
        sale: ArrowDownIcon,
        purchase: ArrowUpIcon,
        adjustment: PlusIcon,
        return: ArrowUpIcon,
    }
    return icons[type] || PlusIcon
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', { 
        month: 'short', 
        day: 'numeric' 
    })
}
</script>