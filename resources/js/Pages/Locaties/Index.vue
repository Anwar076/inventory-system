<template>
  <AppLayout :breadcrumbs="['Locaties']">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Locaties</h1>
      <p class="mt-2 text-gray-600">Overzicht van alle locaties (panden, warehouses, vestigingen)</p>
      <div class="mt-4">
        <a href="/pands/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Nieuwe locatie</a>
      </div>
    </div>
    <div class="widget-card overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adres</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actief</th>
            <th class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="loc in locaties" :key="loc.id">
            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
              <a :href="`/pands/${loc.id}`" class="hover:underline">{{ loc.name }}</a>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">{{ loc.type }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ loc.address }}, {{ loc.city }} {{ loc.postal_code }} {{ loc.country }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span :class="loc.is_active ? 'text-green-600' : 'text-red-600'">{{ loc.is_active ? 'Ja' : 'Nee' }}</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right">
              <a :href="`/pands/${loc.id}/edit`" class="text-blue-600 hover:underline mr-4">Bewerken</a>
              <a :href="`/pands/${loc.id}`" class="text-gray-600 hover:underline">Bekijken</a>
            </td>
          </tr>
          <tr v-if="!locaties.length">
            <td colspan="5" class="text-center py-8 text-gray-400">Geen locaties gevonden.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue'
const props = defineProps({ locaties: Array })
</script> 