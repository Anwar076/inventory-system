<template>
    <AppLayout :breadcrumbs="['Suppliers', 'Edit']">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Supplier</h1>
            <p class="mt-2 text-gray-600">Update supplier details</p>
        </div>
        <div class="widget-card">
            <form @submit.prevent="submitForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input v-model="form.name" type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input v-model="form.email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                        <input v-model="form.phone" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.phone" class="text-red-500 text-xs mt-1">{{ form.errors.phone }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mobile</label>
                        <input v-model="form.mobile" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.mobile" class="text-red-500 text-xs mt-1">{{ form.errors.mobile }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                        <input v-model="form.website" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.website" class="text-red-500 text-xs mt-1">{{ form.errors.website }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input v-model="form.address" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.address" class="text-red-500 text-xs mt-1">{{ form.errors.address }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                        <input v-model="form.city" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.city" class="text-red-500 text-xs mt-1">{{ form.errors.city }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
                        <input v-model="form.state" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.state" class="text-red-500 text-xs mt-1">{{ form.errors.state }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                        <input v-model="form.country" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.country" class="text-red-500 text-xs mt-1">{{ form.errors.country }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                        <input v-model="form.postal_code" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.postal_code" class="text-red-500 text-xs mt-1">{{ form.errors.postal_code }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tax Number</label>
                        <input v-model="form.tax_number" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.tax_number" class="text-red-500 text-xs mt-1">{{ form.errors.tax_number }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contact Person</label>
                        <input v-model="form.contact_person" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.contact_person" class="text-red-500 text-xs mt-1">{{ form.errors.contact_person }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Terms</label>
                        <input v-model="form.payment_terms" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.payment_terms" class="text-red-500 text-xs mt-1">{{ form.errors.payment_terms }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Credit Limit</label>
                        <input v-model="form.credit_limit" type="number" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        <div v-if="form.errors.credit_limit" class="text-red-500 text-xs mt-1">{{ form.errors.credit_limit }}</div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Koppel Producten</label>
                    <input v-model="search" type="text" placeholder="Zoek product..." class="w-full px-3 py-2 border border-gray-300 rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    <div class="max-h-60 overflow-y-auto border rounded-md">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Koppelen</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="product in filteredProducts" :key="product.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" :value="product.id" v-model="selectedProducts" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ product.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ product.sku }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea v-model="form.notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    <div v-if="form.errors.notes" class="text-red-500 text-xs mt-1">{{ form.errors.notes }}</div>
                </div>
                <div class="flex items-center justify-end space-x-3 pt-6">
                    <a href="/suppliers" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500" :disabled="form.processing">Save Changes</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Components/Layout/AppLayout.vue'

const props = defineProps({
    supplier: Object,
    products: Array,
    linkedProductIds: Array,
})

const form = useForm({
    name: props.supplier.name || '',
    email: props.supplier.email || '',
    phone: props.supplier.phone || '',
    mobile: props.supplier.mobile || '',
    website: props.supplier.website || '',
    address: props.supplier.address || '',
    city: props.supplier.city || '',
    state: props.supplier.state || '',
    country: props.supplier.country || '',
    postal_code: props.supplier.postal_code || '',
    tax_number: props.supplier.tax_number || '',
    contact_person: props.supplier.contact_person || '',
    payment_terms: props.supplier.payment_terms || '',
    credit_limit: props.supplier.credit_limit || '',
    notes: props.supplier.notes || '',
    product_ids: [],
})

const search = ref('')
const selectedProducts = ref([...props.linkedProductIds])

onMounted(() => {
    form.product_ids = selectedProducts.value
})

const filteredProducts = computed(() => {
    if (!search.value) return props.products
    return props.products.filter(p =>
        p.name.toLowerCase().includes(search.value.toLowerCase()) ||
        (p.sku && p.sku.toLowerCase().includes(search.value.toLowerCase()))
    )
})

function submitForm() {
    form.product_ids = selectedProducts.value
    form.put(route('suppliers.update', props.supplier.id))
}
</script> 