<template>
  <AppLayout :breadcrumbs="['Categories', 'Nieuwe categorie']">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Nieuwe categorie</h1>
    </div>
    <div class="widget-card max-w-2xl mx-auto">
      <form @submit.prevent="submitForm" class="space-y-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Naam</label>
          <input v-model="form.name" class="w-full px-3 py-2 border rounded" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Parent categorie</label>
          <select v-model="form.parent_id" class="w-full px-3 py-2 border rounded">
            <option value="">Geen</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Kleur</label>
          <input v-model="form.color" type="color" class="w-16 h-8 p-0 border rounded" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Beschrijving</label>
          <textarea v-model="form.description" class="w-full px-3 py-2 border rounded" rows="2"></textarea>
        </div>
        <div>
          <label class="inline-flex items-center">
            <input type="checkbox" v-model="form.is_active" class="form-checkbox" />
            <span class="ml-2">Actief</span>
          </label>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Koppel producten</label>
          <input v-model="search" placeholder="Zoek product..." class="w-full px-3 py-2 border rounded mb-2" />
          <div class="max-h-40 overflow-y-auto border rounded">
            <label v-for="prod in filteredProducts" :key="prod.id" class="flex items-center px-2 py-1">
              <input type="checkbox" :value="prod.id" v-model="selectedProducts" class="mr-2" />
              {{ prod.name }} <span class="ml-2 text-xs text-gray-400">{{ prod.sku }}</span>
            </label>
            <div v-if="!filteredProducts.length" class="text-gray-400 px-2 py-2">Geen producten gevonden</div>
          </div>
        </div>
        <div class="flex justify-end pt-4">
          <a href="/categories" class="px-4 py-2 text-gray-700 bg-gray-100 rounded hover:bg-gray-200 mr-2">Annuleren</a>
          <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Aanmaken</button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Components/Layout/AppLayout.vue'
const props = defineProps({ categories: Array, products: Array })
const form = useForm({
  name: '',
  parent_id: '',
  color: '#3B82F6',
  description: '',
  is_active: true,
  product_ids: [],
})
const search = ref('')
const selectedProducts = ref([])
const filteredProducts = computed(() => {
  if (!search.value) return props.products
  return props.products.filter(p =>
    p.name.toLowerCase().includes(search.value.toLowerCase()) ||
    (p.sku && p.sku.toLowerCase().includes(search.value.toLowerCase()))
  )
})
function submitForm() {
  form.product_ids = selectedProducts.value
  form.post(route('categories.store'))
}
</script> 