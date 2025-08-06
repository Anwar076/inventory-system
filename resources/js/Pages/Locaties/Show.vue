<template>
  <AppLayout :breadcrumbs="['Locaties', locatie.name]">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">{{ locatie.name }}</h1>
      <p class="mt-2 text-gray-600">Type: {{ locatie.type }}</p>
      <p class="mt-2 text-gray-600">Adres: {{ locatie.address }}, {{ locatie.city }} {{ locatie.postal_code }} {{ locatie.country }}</p>
      <p class="mt-2 text-gray-600">Code: {{ locatie.code }}</p>
      <p class="mt-2 text-gray-600">Status: <span :class="locatie.is_active ? 'text-green-600' : 'text-red-600'">{{ locatie.is_active ? 'Actief' : 'Inactief' }}</span></p>
    </div>
    <div class="widget-card p-8">
      <h2 class="text-lg font-semibold mb-2">Details</h2>
      <ul class="text-gray-700 space-y-2">
        <li><strong>Naam:</strong> {{ locatie.name }}</li>
        <li><strong>Code:</strong> {{ locatie.code }}</li>
        <li><strong>Type:</strong> {{ locatie.type }}</li>
        <li><strong>Adres:</strong> {{ locatie.address }}</li>
        <li><strong>Stad:</strong> {{ locatie.city }}</li>
        <li><strong>Postcode:</strong> {{ locatie.postal_code }}</li>
        <li><strong>Land:</strong> {{ locatie.country }}</li>
        <li><strong>Status:</strong> <span :class="locatie.is_active ? 'text-green-600' : 'text-red-600'">{{ locatie.is_active ? 'Actief' : 'Inactief' }}</span></li>
      </ul>
    </div>
    <div class="mt-8">
      <a href="/pands" class="px-4 py-2 text-gray-700 bg-gray-100 rounded hover:bg-gray-200">Terug naar overzicht</a>
    </div>
  </AppLayout>
</template>
<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue'
const props = defineProps({ locatie: Object })
</script> 