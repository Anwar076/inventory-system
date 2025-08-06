<template>
    <AppLayout :breadcrumbs="['Suppliers', supplier.name, 'Manage Products']">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Koppel producten aan {{ supplier.name }}</h1>
            <p class="mt-2 text-gray-600">Selecteer de producten die bij deze leverancier horen.</p>
        </div>
        <div class="widget-card p-8">
            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <input v-model="search" type="text" placeholder="Zoek product..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                </div>
                <div class="max-h-96 overflow-y-auto border rounded-md mb-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Koppelen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Voorraad</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="product in filteredProducts" :key="product.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" :value="product.id" v-model="selected" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ product.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ product.sku }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ product.current_stock }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-end space-x-3">
                    <a :href="`/suppliers/${supplier.id}`" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">Annuleren</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500" :disabled="processing">Opslaan</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Components/Layout/AppLayout.vue'

const props = defineProps({
    supplier: Object,
    products: Array,
    linkedProductIds: Array,
})

const search = ref('')
const selected = ref([...props.linkedProductIds])
const processing = ref(false)

const filteredProducts = computed(() => {
    if (!search.value) return props.products
    return props.products.filter(p =>
        p.name.toLowerCase().includes(search.value.toLowerCase()) ||
        (p.sku && p.sku.toLowerCase().includes(search.value.toLowerCase()))
    )
})

function submitForm() {
    processing.value = true
    router.post(route('suppliers.updateProducts', props.supplier.id), {
        product_ids: selected.value
    }, {
        onFinish: () => { processing.value = false }
    })
}
</script> 