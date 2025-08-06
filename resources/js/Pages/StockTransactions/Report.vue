<template>
    <AppLayout :breadcrumbs="['Stock Transactions', 'Report']">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Stock Transactions Report</h1>
            <p class="mt-2 text-gray-600">Summary of all stock movements</p>
        </div>
        <div class="widget-card mb-8">
            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Staafdiagram: Voorraadmutaties per product/type -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Voorraadmutaties per product/type</h2>
                    <Bar v-if="barChartData" :data="barChartData" :options="barChartOptions" style="max-height:320px" />
                </div>
                <!-- Taartdiagram: Verdeling per type -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Verdeling per type</h2>
                    <Doughnut v-if="doughnutChartData" :data="doughnutChartData" :options="doughnutChartOptions" style="max-height:320px" />
                </div>
            </div>
        </div>
        <div class="widget-card">
            <div class="mb-4 flex flex-wrap gap-4">
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
                <button @click="exportCSV" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Export CSV</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="row in summaryRows" :key="row.product + '-' + row.type">
                            <td class="px-6 py-4 whitespace-nowrap">{{ row.product }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ row.type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ row.total_quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">€{{ row.total_amount.toFixed(2) }}</td>
                        </tr>
                        <tr v-if="summaryRows.length === 0">
                            <td colspan="4" class="text-center py-8 text-gray-400">No data found.</td>
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
import { Bar, Doughnut } from 'vue-chartjs'
import {
    Chart,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
    ArcElement
} from 'chart.js'
Chart.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend, ArcElement)
const props = defineProps({
    transactions: Array,
})

const filters = ref({ type: '', from: '', to: '' })

const uniqueTypes = computed(() => [...new Set(props.transactions.map(tx => tx.type).filter(Boolean))])

const filtered = computed(() => {
    return props.transactions.filter(tx => {
        if (filters.value.type && tx.type !== filters.value.type) return false
        if (filters.value.from && tx.transaction_date < filters.value.from) return false
        if (filters.value.to && tx.transaction_date > filters.value.to) return false
        return true
    })
})

const summaryRows = computed(() => {
    const map = {}
    for (const tx of filtered.value) {
        const key = tx.product_name + '|' + tx.type
        if (!map[key]) {
            map[key] = { product: tx.product_name, type: tx.type, total_quantity: 0, total_amount: 0 }
        }
        map[key].total_quantity += tx.quantity
        map[key].total_amount += parseFloat(tx.total_amount || 0)
    }
    return Object.values(map)
})

const chartColors = [
    '#3B82F6', // blue-500
    '#10B981', // green-500
    '#F59E42', // orange-400
    '#EF4444', // red-500
    '#A78BFA', // purple-400
    '#FBBF24', // yellow-400
    '#6366F1', // indigo-500
    '#F472B6', // pink-400
    '#6EE7B7', // emerald-300
    '#F87171', // red-400
]

const barChartData = computed(() => {
    if (!summaryRows.value.length) return null
    const products = [...new Set(summaryRows.value.map(r => r.product))]
    const types = [...new Set(summaryRows.value.map(r => r.type))]
    const datasets = types.map((type, i) => ({
        label: type,
        data: products.map(p => {
            const row = summaryRows.value.find(r => r.product === p && r.type === type)
            return row ? row.total_quantity : 0
        }),
        backgroundColor: chartColors[i % chartColors.length],
        borderColor: chartColors[i % chartColors.length],
        borderWidth: 1,
    }))
    return {
        labels: products,
        datasets,
    }
})
const barChartOptions = {
    responsive: true,
    plugins: {
        legend: { position: 'top' },
        title: { display: false },
    },
    scales: {
        y: { beginAtZero: true }
    }
}
const doughnutChartData = computed(() => {
    if (!summaryRows.value.length) return null
    const types = [...new Set(summaryRows.value.map(r => r.type))]
    const totalPerType = types.map(type =>
        summaryRows.value.filter(r => r.type === type).reduce((sum, r) => sum + r.total_quantity, 0)
    )
    return {
        labels: types,
        datasets: [{
            data: totalPerType,
            backgroundColor: types.map((_, i) => chartColors[i % chartColors.length]),
            borderColor: '#fff',
            borderWidth: 2,
        }],
    }
})
const doughnutChartOptions = {
    responsive: true,
    plugins: {
        legend: { position: 'bottom' },
        title: { display: false },
    },
}

function exportCSV() {
    // Luxe CSV: header, filters, nette kolommen, totalen
    const now = new Date()
    const header = [
        'Voorraadmutatie Rapport',
        `Gegenereerd op: ${now.toLocaleDateString()} ${now.toLocaleTimeString()}`,
        `Filters: Type=${filters.value.type||'Alle'}, Van=${filters.value.from||'-'}, Tot=${filters.value.to||'-'}`,
        ''
    ]
    const columns = ['Productnaam', 'Type', 'Totaal aantal', 'Totaal bedrag (€)']
    const rows = summaryRows.value.map(r => [r.product, r.type, r.total_quantity, '€'+Number(r.total_amount).toFixed(2)])
    // Totalen
    const totalQuantity = summaryRows.value.reduce((sum, r) => sum + r.total_quantity, 0)
    const totalAmount = summaryRows.value.reduce((sum, r) => sum + Number(r.total_amount), 0)
    rows.push(['TOTAAL', '', totalQuantity, '€'+totalAmount.toFixed(2)])
    // Combineer alles
    const csv = [
        ...header,
        columns.join(';'),
        ...rows.map(r => r.map(v => '"'+String(v).replace(/"/g, '""')+'"').join(';'))
    ].join('\n')
    const blob = new Blob([csv], { type: 'text/csv' })
    const url = URL.createObjectURL(blob)
    const a = document.createElement('a')
    a.href = url
    a.download = 'voorraadmutatie_rapport.csv'
    a.click()
    URL.revokeObjectURL(url)
}
</script> 