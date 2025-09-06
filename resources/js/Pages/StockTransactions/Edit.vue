<template>
    <AppLayout :breadcrumbs="['Stock Transactions', 'Edit Transaction']">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Stock Transaction</h1>
            <p class="mt-2 text-gray-600">Update transaction details</p>
        </div>

        <div class="widget-card">
            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Product</label>
                        <select v-model="form.product_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Select a product</option>
                            <option v-for="product in products" :key="product.id" :value="product.id">
                                {{ product.name }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                        <select v-model="form.type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Select type</option>
                            <option value="purchase">Purchase</option>
                            <option value="sale">Sale</option>
                            <option value="adjustment">Adjustment</option>
                            <option value="return">Return</option>
                            <option value="transfer">Transfer</option>
                            <option value="waste">Waste</option>
                            <option value="loss">Loss</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <input v-model="form.quantity" type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Transaction Date</label>
                        <input v-model="form.transaction_date" type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Supplier</label>
                        <select v-model="form.supplier_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select a supplier</option>
                            <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
                                {{ supplier.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea v-model="form.notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Update Transaction
                    </button>
                    <a :href="`/stock-transactions/${transaction.id}`" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Components/Layout/AppLayout.vue'

const props = defineProps({
    transaction: Object,
    products: Array,
    suppliers: Array,
})

const form = ref({
    product_id: props.transaction.product_id,
    type: props.transaction.type,
    quantity: props.transaction.quantity,
    transaction_date: props.transaction.transaction_date,
    supplier_id: props.transaction.supplier_id,
    notes: props.transaction.notes,
})

function submit() {
    router.put(`/stock-transactions/${props.transaction.id}`, form.value)
}
</script>