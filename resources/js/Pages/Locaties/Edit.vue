<template>
  <AppLayout :breadcrumbs="['Locaties', 'Locatie bewerken']">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Locatie bewerken</h1>
    </div>
    <div class="widget-card max-w-2xl mx-auto">
      <form @submit.prevent="submitForm" class="space-y-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Naam</label>
          <input v-model="form.name" class="w-full px-3 py-2 border rounded" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Code</label>
          <input v-model="form.code" class="w-full px-3 py-2 border rounded" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
          <select v-model="form.type" class="w-full px-3 py-2 border rounded">
            <option value="warehouse">Warehouse</option>
            <option value="winkel">Winkel</option>
            <option value="andere">Andere</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Adres</label>
          <input v-model="form.address" class="w-full px-3 py-2 border rounded" />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Stad</label>
            <input v-model="form.city" class="w-full px-3 py-2 border rounded" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Postcode</label>
            <input v-model="form.postal_code" class="w-full px-3 py-2 border rounded" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Land</label>
            <input v-model="form.country" class="w-full px-3 py-2 border rounded" />
          </div>
        </div>
        <div>
          <label class="inline-flex items-center">
            <input type="checkbox" v-model="form.is_active" class="form-checkbox" />
            <span class="ml-2">Actief</span>
          </label>
        </div>
        <div class="flex justify-end pt-4">
          <a href="/pands" class="px-4 py-2 text-gray-700 bg-gray-100 rounded hover:bg-gray-200 mr-2">Annuleren</a>
          <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Opslaan</button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Components/Layout/AppLayout.vue'
const props = defineProps({ locatie: Object })
const form = useForm({
  name: props.locatie.name,
  code: props.locatie.code,
  type: props.locatie.type,
  address: props.locatie.address,
  city: props.locatie.city,
  postal_code: props.locatie.postal_code,
  country: props.locatie.country,
  is_active: props.locatie.is_active,
})
function submitForm() {
  form.put(`/pands/${props.locatie.id}`)
}
</script> 