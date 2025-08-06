<template>
    <AppLayout :breadcrumbs="['Suppliers', supplier.name]">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ supplier.name }}</h1>
            <p class="mt-2 text-gray-600">Email: {{ supplier.email }}</p>
        </div>
        <div class="widget-card p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-lg font-semibold mb-2">Contact Details</h2>
                    <ul class="text-gray-700 space-y-2">
                        <li><strong>Phone:</strong> {{ supplier.phone }}</li>
                        <li><strong>Mobile:</strong> {{ supplier.mobile }}</li>
                        <li><strong>Website:</strong> {{ supplier.website }}</li>
                        <li><strong>Contact Person:</strong> {{ supplier.contact_person }}</li>
                        <li><strong>Status:</strong> <span :class="supplier.is_active ? 'text-green-600' : 'text-red-600'">{{ supplier.is_active ? 'Active' : 'Inactive' }}</span></li>
                    </ul>
                </div>
                <div>
                    <h2 class="text-lg font-semibold mb-2">Address & Info</h2>
                    <ul class="text-gray-700 space-y-2">
                        <li><strong>Address:</strong> {{ supplier.address }}</li>
                        <li><strong>City:</strong> {{ supplier.city }}</li>
                        <li><strong>State:</strong> {{ supplier.state }}</li>
                        <li><strong>Country:</strong> {{ supplier.country }}</li>
                        <li><strong>Postal Code:</strong> {{ supplier.postal_code }}</li>
                        <li><strong>Tax Number:</strong> {{ supplier.tax_number }}</li>
                        <li><strong>Payment Terms:</strong> {{ supplier.payment_terms }}</li>
                        <li><strong>Credit Limit:</strong> €{{ supplier.credit_limit }}</li>
                    </ul>
                </div>
            </div>
            <div class="mt-8">
                <h2 class="text-lg font-semibold mb-2">Notes</h2>
                <p class="text-gray-600">{{ supplier.notes || 'No notes provided.' }}</p>
            </div>
            <div class="mt-8">
                <h2 class="text-lg font-semibold mb-4">Products from this Supplier</h2>
                <div v-if="products.length > 0">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="product in products" :key="product.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ product.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ product.sku }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">€{{ product.selling_price }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ product.current_stock }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="text-gray-400">No products linked to this supplier.</div>
            </div>
            <div class="mt-8">
                <h2 class="text-lg font-semibold mb-4">Activiteit Log</h2>
                <div v-if="activity && activity.length > 0">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gebruiker</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actie</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="log in activity" :key="log.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ log.created_at }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ log.causer_name || '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ log.description }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span v-if="log.properties && log.properties.attributes">
                                        <span v-for="(value, key) in log.properties.attributes" :key="key">
                                            <strong>{{ key }}:</strong> {{ value }}<br>
                                        </span>
                                    </span>
                                    <span v-else>-</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="text-gray-400">Geen activiteit gevonden voor deze leverancier.</div>
            </div>
            <div class="mt-8">
                <a href="/suppliers" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Back to Suppliers</a>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue'
const props = defineProps({
    supplier: Object,
    products: Array,
    activity: Array,
})
</script> 