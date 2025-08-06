<template>
    <AppLayout :breadcrumbs="['Products', 'Create']">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Add New Product</h1>
            <p class="mt-2 text-gray-600">Create a new product in your inventory</p>
        </div>

        <div class="widget-card">
            <form @submit.prevent="submitForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                        <input
                            v-model="form.name"
                            type="text"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                        <input
                            v-model="form.sku"
                            type="text"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div v-if="form.errors.sku" class="text-red-500 text-xs mt-1">{{ form.errors.sku }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Purchase Price</label>
                        <input
                            v-model="form.purchase_price"
                            type="number"
                            step="0.01"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div v-if="form.errors.purchase_price" class="text-red-500 text-xs mt-1">{{ form.errors.purchase_price }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Selling Price</label>
                        <input
                            v-model="form.selling_price"
                            type="number"
                            step="0.01"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div v-if="form.errors.selling_price" class="text-red-500 text-xs mt-1">{{ form.errors.selling_price }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                        <input
                            v-model="form.current_stock"
                            type="number"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div v-if="form.errors.current_stock" class="text-red-500 text-xs mt-1">{{ form.errors.current_stock }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Stock</label>
                        <input
                            v-model="form.minimum_stock"
                            type="number"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        <div v-if="form.errors.minimum_stock" class="text-red-500 text-xs mt-1">{{ form.errors.minimum_stock }}</div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea
                        v-model="form.description"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    ></textarea>
                    <div v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</div>
                </div>
                <div class="flex items-center justify-end space-x-3 pt-6">
                    <a href="/products" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :disabled="form.processing"
                    >
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Components/Layout/AppLayout.vue'

const form = useForm({
    name: '',
    sku: '',
    purchase_price: '',
    selling_price: '',
    current_stock: '',
    minimum_stock: '',
    description: '',
})

function submitForm() {
    form.post(route('products.store'))
}
</script>
