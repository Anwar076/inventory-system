<template>
    <AppLayout :breadcrumbs="['Products']">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Products</h1>
            <p class="mt-2 text-gray-600">Manage your inventory products</p>
        </div>

        <div class="widget-card">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Product List</h2>
                <a href="/products/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Add Product
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="product in products.data" :key="product.id">
                            <td class="px-6 py-4 whitespace-nowrap">{{ product.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ product.sku }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">€{{ product.selling_price }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ product.current_stock }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="product.is_active ? 'text-green-600' : 'text-red-600'">
                                    {{ product.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a :href="`/products/${product.id}/edit`" class="text-blue-600 hover:underline mr-2">Edit</a>
                                <a :href="`/products/${product.id}`" class="text-gray-600 hover:underline">View</a>
                            </td>
                        </tr>
                        <tr v-if="products.data.length === 0">
                            <td colspan="6" class="text-center py-8 text-gray-400">No products found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { computed } from 'vue'
import AppLayout from '@/Components/Layout/AppLayout.vue'

const props = defineProps({
    products: Object,
})
</script>
