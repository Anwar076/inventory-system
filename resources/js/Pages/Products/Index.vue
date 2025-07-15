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
                        <tr v-for="product in products" :key="product.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ product.name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ product.sku }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                €{{ product.price }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ product.stock }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="product.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                                    {{ product.status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-2">Edit</button>
                                <button class="text-red-600 hover:text-red-900">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue'

const props = defineProps({
    products: Array,
})
</script>
