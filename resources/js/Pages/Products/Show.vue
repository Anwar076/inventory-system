<template>
    <AppLayout :breadcrumbs="['Products', product.name]">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ product.name }}</h1>
            <p class="mt-2 text-gray-600">SKU: {{ product.sku }}</p>
            <div v-if="product.supplier">
                <p class="mt-2 text-gray-600">
                    Supplier:
                    <a :href="`/suppliers/${product.supplier.id}`" class="text-blue-600 hover:underline">{{ product.supplier.name }}</a>
                </p>
            </div>
        </div>
        <div class="widget-card p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-lg font-semibold mb-2">Product Details</h2>
                    <ul class="text-gray-700 space-y-2">
                        <li><strong>Purchase Price:</strong> €{{ product.purchase_price }}</li>
                        <li><strong>Selling Price:</strong> €{{ product.selling_price }}</li>
                        <li><strong>Current Stock:</strong> {{ product.current_stock }}</li>
                        <li><strong>Minimum Stock:</strong> {{ product.minimum_stock }}</li>
                        <li><strong>Status:</strong> <span :class="product.is_active ? 'text-green-600' : 'text-red-600'">{{ product.is_active ? 'Active' : 'Inactive' }}</span></li>
                    </ul>
                </div>
                <div>
                    <h2 class="text-lg font-semibold mb-2">Description</h2>
                    <p class="text-gray-600">{{ product.description || 'No description provided.' }}</p>
                </div>
            </div>
            <div class="mt-8">
                <h2 class="text-lg font-semibold mb-4">Activiteit Log</h2>
                <div v-if="activity && activity.length > 0">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gebruiker</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actie</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="log in activity" :key="log.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ log.created_at }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ log.causer_name || '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ log.description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span v-if="log.properties && log.properties.attributes">
                                        <span v-for="(value, key) in log.properties.attributes" :key="key">
                                            <strong>{{ key }}:</strong> {{ value }}<br>
                                        </span>
                                    </span>
                                    <span v-else>-</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="text-gray-400">Geen activiteit gevonden voor dit product.</div>
            </div>
            <div class="mt-8">
                <a href="/products" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Back to Products</a>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue'
const props = defineProps({
    product: Object,
    activity: Array,
})
</script> 