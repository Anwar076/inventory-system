<template>
  <AppLayout :breadcrumbs="['Voorraad', locatie.name]">
    <!-- Success/Error Messages -->
    <div v-if="$page.props.flash && $page.props.flash.success" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
      {{ $page.props.flash.success }}
    </div>
    
    <div v-if="$page.props.flash && $page.props.flash.error" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
      {{ $page.props.flash.error }}
    </div>

    <div class="mb-8">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">{{ locatie.name }}</h1>
          <p class="mt-2 text-gray-600">{{ locatie.type }} • {{ locatie.code }}</p>
          <p v-if="locatie.address" class="text-gray-600">{{ locatie.address }}, {{ locatie.city }}</p>
        </div>
        <a href="/inventory" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200">
          Terug naar overzicht
        </a>
      </div>
    </div>

    <!-- Statistieken -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-blue-100 rounded-lg">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Totaal Producten</p>
            <p class="text-2xl font-semibold text-gray-900">{{ stats.total_products }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-green-100 rounded-lg">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Totaal Voorraad</p>
            <p class="text-2xl font-semibold text-gray-900">{{ stats.total_stock }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-yellow-100 rounded-lg">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Lage Voorraad</p>
            <p class="text-2xl font-semibold text-gray-900">{{ stats.low_stock_products }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-red-100 rounded-lg">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Uitverkocht</p>
            <p class="text-2xl font-semibold text-gray-900">{{ stats.out_of_stock }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-purple-100 rounded-lg">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Totale Waarde</p>
            <p class="text-2xl font-semibold text-gray-900">€{{ formatPrice(stats.total_value) }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Acties -->
    <div class="mb-6 flex justify-between items-center">
      <div class="flex space-x-4">
        <button 
          @click="showAddStockModal = true"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center"
        >
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Product Toevoegen
        </button>
      </div>
      
      <div class="flex space-x-2">
        <input 
          v-model="searchTerm" 
          type="text" 
          placeholder="Zoek producten..." 
          class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        >
        <select 
          v-model="statusFilter" 
          class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        >
          <option value="">Alle statussen</option>
          <option value="normal">Normaal</option>
          <option value="low">Lage voorraad</option>
          <option value="high">Hoge voorraad</option>
          <option value="out">Uitverkocht</option>
        </select>
      </div>
    </div>

    <!-- Voorraad Tabel -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categorie</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Huidige Voorraad</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Minimum</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Maximum</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waarde</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="stock in filteredProductStocks" :key="stock.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div>
                  <div class="text-sm font-medium text-gray-900">{{ stock.product.name }}</div>
                  <div class="text-sm text-gray-500">{{ stock.product.sku }}</div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ stock.product.category?.name || '-' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ stock.current_stock }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ stock.minimum_stock }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ stock.maximum_stock || '-' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 text-xs font-medium rounded-full" 
                      :class="getStatusClass(stock.stock_status)">
                  {{ getStatusText(stock.stock_status) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                €{{ formatPrice(stock.current_stock * (stock.product.purchase_price || 0)) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button 
                  @click="editStock(stock)"
                  class="text-blue-600 hover:text-blue-900 mr-3"
                >
                  Bewerken
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="!filteredProductStocks.length" class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">Geen producten gevonden</h3>
      <p class="mt-1 text-sm text-gray-500">Er zijn nog geen producten toegevoegd aan deze locatie.</p>
      <div class="mt-6">
        <button 
          @click="showAddStockModal = true"
          class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700"
        >
          Eerste product toevoegen
        </button>
      </div>
    </div>

    <!-- Edit Stock Modal -->
    <div v-if="showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
      <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Voorraad Bewerken</h3>
          <form @submit.prevent="updateStock">
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Product</label>
                <p class="text-sm text-gray-500">{{ editingStock?.product?.name }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Huidige Voorraad</label>
                <input 
                  v-model="editForm.current_stock" 
                  type="number" 
                  min="0"
                  class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Minimum Voorraad</label>
                <input 
                  v-model="editForm.minimum_stock" 
                  type="number" 
                  min="0"
                  class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Maximum Voorraad</label>
                <input 
                  v-model="editForm.maximum_stock" 
                  type="number" 
                  min="0"
                  class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
              <button 
                type="button" 
                @click="showEditModal = false"
                class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
              >
                Annuleren
              </button>
              <button 
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
              >
                Opslaan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Add Stock Modal -->
    <div v-if="showAddStockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
      <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Product Toevoegen aan Voorraad</h3>
          <form @submit.prevent="addStock">
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Product</label>
                <select 
                  v-model="addForm.product_id" 
                  class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                >
                  <option value="">Selecteer een product</option>
                  <option 
                    v-for="product in availableProducts" 
                    :key="product.id" 
                    :value="product.id"
                  >
                    {{ product.name }} ({{ product.sku }})
                  </option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Huidige Voorraad</label>
                <input 
                  v-model="addForm.current_stock" 
                  type="number" 
                  min="0"
                  class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Minimum Voorraad</label>
                <input 
                  v-model="addForm.minimum_stock" 
                  type="number" 
                  min="0"
                  class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Maximum Voorraad (optioneel)</label>
                <input 
                  v-model="addForm.maximum_stock" 
                  type="number" 
                  min="0"
                  class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
              </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
              <button 
                type="button" 
                @click="showAddStockModal = false"
                class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
              >
                Annuleren
              </button>
              <button 
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
              >
                Toevoegen
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Components/Layout/AppLayout.vue'

const props = defineProps({
  locatie: Object,
  productStocks: Array,
  allProducts: Array,
  stats: Object
})

const searchTerm = ref('')
const statusFilter = ref('')
const showEditModal = ref(false)
const editingStock = ref(null)
const showAddStockModal = ref(false)

const editForm = useForm({
  current_stock: 0,
  minimum_stock: 0,
  maximum_stock: null
})

const addForm = useForm({
  product_id: '',
  current_stock: 0,
  minimum_stock: 0,
  maximum_stock: null
})

const availableProducts = computed(() => {
  // Filter out products that already have a stock entry for this location
  const existingProductIds = props.productStocks.map(stock => stock.product.id);
  return props.allProducts.filter(product => !existingProductIds.includes(product.id));
});

const filteredProductStocks = computed(() => {
  let filtered = props.productStocks.map(stock => ({
    ...stock,
    stock_status: getStockStatus(stock)
  }))

  if (searchTerm.value) {
    filtered = filtered.filter(stock => 
      stock.product.name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
      stock.product.sku.toLowerCase().includes(searchTerm.value.toLowerCase())
    )
  }

  if (statusFilter.value) {
    filtered = filtered.filter(stock => stock.stock_status === statusFilter.value)
  }

  return filtered
})

const getStockStatus = (stock) => {
  if (stock.current_stock === 0) return 'out'
  if (stock.current_stock <= stock.minimum_stock) return 'low'
  if (stock.maximum_stock && stock.current_stock >= stock.maximum_stock) return 'high'
  return 'normal'
}

const formatPrice = (price) => {
  return new Intl.NumberFormat('nl-NL', { minimumFractionDigits: 2 }).format(price)
}

const getStatusClass = (status) => {
  switch (status) {
    case 'low': return 'bg-yellow-100 text-yellow-800'
    case 'high': return 'bg-red-100 text-red-800'
    case 'out': return 'bg-gray-100 text-gray-800'
    default: return 'bg-green-100 text-green-800'
  }
}

const getStatusText = (status) => {
  switch (status) {
    case 'low': return 'Lage voorraad'
    case 'high': return 'Hoge voorraad'
    case 'out': return 'Uitverkocht'
    default: return 'Normaal'
  }
}

const editStock = (stock) => {
  editingStock.value = stock
  editForm.current_stock = stock.current_stock
  editForm.minimum_stock = stock.minimum_stock
  editForm.maximum_stock = stock.maximum_stock
  showEditModal.value = true
}

const updateStock = () => {
  editForm.put(`/inventory/stock/${editingStock.value.id}`, {
    onSuccess: () => {
      showEditModal.value = false
      editingStock.value = null
    },
    onError: (errors) => {
      console.error('Error updating stock:', errors)
    }
  })
}

const addStock = () => {
  addForm.post(`/inventory/stock/store/${props.locatie.id}`, {
    onSuccess: () => {
      showAddStockModal.value = false
      addForm.reset()
    },
    onError: (errors) => {
      console.error('Error adding stock:', errors)
    }
  })
}
</script> 