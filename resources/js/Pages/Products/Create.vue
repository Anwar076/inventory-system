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
                            placeholder="Enter product name"
                        />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                        <input
                            v-model="form.sku"
                            type="text"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter SKU"
                        />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                        <input
                            v-model="form.price"
                            type="number"
                            step="0.01"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0.00"
                        />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                        <input
                            v-model="form.stock"
                            type="number"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0"
                        />
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea
                        v-model="form.description"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter product description"
                    ></textarea>
                </div>
                
                <div class="flex items-center justify-end space-x-3 pt-6">
                    <a href="/products" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import AppLayout from '@/Components/Layout/AppLayout.vue'

const form = ref({
    name: '',
    sku: '',
    price: '',
    stock: '',
    description: ''
})

const submitForm = () => {
    alert('Product creation form submitted! (This is just a demo)')
    console.log('Form data:', form.value)
}
</script>
