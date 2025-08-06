<template>
    <AppLayout :breadcrumbs="['Stock Transactions']">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Stock Movements</h1>
            <p class="mt-2 text-gray-600">Overview of all stock transactions</p>
        </div>
        <div class="widget-card">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Transaction List</h2>
                <div class="flex gap-2">
                    <a href="/stock-transactions/report" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Report</a>
                    <button @click="exportCSV" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Export CSV</button>
                    <a href="/stock-transactions/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add Transaction</a>
                </div>
            </div>
            <div class="mb-4 flex flex-wrap gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Product</label>
                    <select v-model="filters.product" class="px-2 py-1 border rounded">
                        <option value="">All</option>
                        <option v-for="p in uniqueProducts" :key="p" :value="p">{{ p }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Type</label>
                    <select v-model="filters.type" class="px-2 py-1 border rounded">
                        <option value="">All</option>
                        <option v-for="t in uniqueTypes" :key="t" :value="t">{{ t }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">From</label>
                    <input v-model="filters.from" type="date" class="px-2 py-1 border rounded" />
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">To</label>
                    <input v-model="filters.to" type="date" class="px-2 py-1 border rounded" />
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="tx in filteredTransactions" :key="tx.id">
                            <td class="px-6 py-4 whitespace-nowrap">{{ tx.transaction_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ tx.product_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ tx.type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ tx.quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ tx.user_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ tx.notes }}</td>
                        </tr>
                        <tr v-if="filteredTransactions.length === 0">
                            <td colspan="6" class="text-center py-8 text-gray-400">No transactions found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import AppLayout from '@/Components/Layout/AppLayout.vue'
const props = defineProps({
    transactions: Object,
})

const filters = ref({ product: '', type: '', from: '', to: '' })

const uniqueProducts = computed(() => [...new Set(props.transactions.data.map(tx => tx.product_name).filter(Boolean))])
const uniqueTypes = computed(() => [...new Set(props.transactions.data.map(tx => tx.type).filter(Boolean))])

const filteredTransactions = computed(() => {
    return props.transactions.data.filter(tx => {
        if (filters.value.product && tx.product_name !== filters.value.product) return false
        if (filters.value.type && tx.type !== filters.value.type) return false
        if (filters.value.from && tx.transaction_date < filters.value.from) return false
        if (filters.value.to && tx.transaction_date > filters.value.to) return false
        return true
    })
})

function exportCSV() {
    const rows = [
        ['Date', 'Product', 'Type', 'Quantity', 'User', 'Notes'],
        ...filteredTransactions.value.map(tx => [tx.transaction_date, tx.product_name, tx.type, tx.quantity, tx.user_name, tx.notes])
    ]
    const csv = rows.map(r => r.map(v => '"' + String(v).replace(/"/g, '""') + '"').join(',')).join('\n')
    const blob = new Blob([csv], { type: 'text/csv' })
    const url = URL.createObjectURL(blob)
    const a = document.createElement('a')
    a.href = url
    a.download = 'stock_transactions.csv'
    a.click()
    URL.revokeObjectURL(url)
}
</script> 