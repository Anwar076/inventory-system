<template>
    <AppLayout :breadcrumbs="['Stock Transactions', 'View Transaction']">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Stock Transaction Details</h1>
            <p class="mt-2 text-gray-600">View transaction details</p>
        </div>

        <div class="widget-card">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaction Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Product</dt>
                            <dd class="text-sm text-gray-900">{{ transaction.product?.name || 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                            <dd class="text-sm text-gray-900">{{ transaction.type }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Quantity</dt>
                            <dd class="text-sm text-gray-900">{{ transaction.quantity }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Transaction Date</dt>
                            <dd class="text-sm text-gray-900">{{ transaction.transaction_date }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">User</dt>
                            <dd class="text-sm text-gray-900">{{ transaction.user?.name || 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Details</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Supplier</dt>
                            <dd class="text-sm text-gray-900">{{ transaction.supplier?.name || 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Unit Price</dt>
                            <dd class="text-sm text-gray-900">€{{ transaction.unit_price }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                            <dd class="text-sm text-gray-900">€{{ transaction.total_amount }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Remaining Stock</dt>
                            <dd class="text-sm text-gray-900">{{ transaction.remaining_stock }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Notes</dt>
                            <dd class="text-sm text-gray-900">{{ transaction.notes || 'No notes' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <a :href="`/stock-transactions/${transaction.id}/edit`" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Edit Transaction
                </a>
                <a href="/stock-transactions" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                    Back to List
                </a>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue'

const props = defineProps({
    transaction: Object,
})
</script>