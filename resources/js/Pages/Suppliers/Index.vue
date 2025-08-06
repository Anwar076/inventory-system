<template>
    <AppLayout :breadcrumbs="['Suppliers']">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Suppliers</h1>
            <p class="mt-2 text-gray-600">Manage your suppliers</p>
        </div>
        <div class="widget-card">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Supplier List</h2>
                <a href="/suppliers/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Add Supplier
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="supplier in suppliers.data" :key="supplier.id">
                            <td class="px-6 py-4 whitespace-nowrap">{{ supplier.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ supplier.email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ supplier.phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="supplier.is_active ? 'text-green-600' : 'text-red-600'">
                                    {{ supplier.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a :href="`/suppliers/${supplier.id}/edit`" class="text-blue-600 hover:underline mr-2">Edit</a>
                                <a :href="`/suppliers/${supplier.id}`" class="text-gray-600 hover:underline mr-2">View</a>
                                <button @click="deleteSupplier(supplier.id)" class="text-red-600 hover:underline">Delete</button>
                            </td>
                        </tr>
                        <tr v-if="suppliers.data.length === 0">
                            <td colspan="5" class="text-center py-8 text-gray-400">No suppliers found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    suppliers: Object,
})

function deleteSupplier(id) {
    if (confirm('Are you sure you want to delete this supplier?')) {
        router.delete(`/suppliers/${id}`)
    }
}
</script> 