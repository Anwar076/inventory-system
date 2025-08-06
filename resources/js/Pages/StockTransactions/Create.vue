<template>
    <AppLayout :breadcrumbs="['Stock Transactions', 'Add']">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Add Stock Transaction</h1>
            <p class="mt-2 text-gray-600">Register a new stock movement</p>
        </div>
        <div class="widget-card">
            <form @submit.prevent="submitForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Product</label>
                        <select v-model="form.product_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a product</option>
                            <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</option>
                        </select>
                        <div v-if="form.errors.product_id" class="text-red-500 text-xs mt-1">{{ form.errors.product_id }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                        <select v-model="form.type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select type</option>
                            <option value="purchase">Purchase</option>
                            <option value="sale">Sale</option>
                            <option value="adjustment">Adjustment</option>
                            <option value="return">Return</option>
                            <option value="transfer">Transfer</option>
                            <option value="waste">Waste</option>
                            <option value="loss">Loss</option>
                        </select>
                        <div v-if="form.errors.type" class="text-red-500 text-xs mt-1">{{ form.errors.type }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <input v-model="form.quantity" type="number" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.quantity" class="text-red-500 text-xs mt-1">{{ form.errors.quantity }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input v-model="form.transaction_date" type="date" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.transaction_date" class="text-red-500 text-xs mt-1">{{ form.errors.transaction_date }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Supplier (optional)</label>
                        <select v-model="form.supplier_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a supplier</option>
                            <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{ supplier.name }}</option>
                        </select>
                        <div v-if="form.errors.supplier_id" class="text-red-500 text-xs mt-1">{{ form.errors.supplier_id }}</div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea v-model="form.notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    <div v-if="form.errors.notes" class="text-red-500 text-xs mt-1">{{ form.errors.notes }}</div>
                </div>
                <div class="flex items-center justify-end space-x-3 pt-6">
                    <a href="/stock-transactions" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500" :disabled="form.processing">Add Transaction</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Components/Layout/AppLayout.vue'

const props = defineProps({
    products: Array,
    suppliers: Array,
})

const form = useForm({
    product_id: '',
    type: '',
    quantity: '',
    transaction_date: '',
    supplier_id: '',
    notes: '',
})

function submitForm() {
    form.post(route('stock-transactions.store'))
}
</script> 