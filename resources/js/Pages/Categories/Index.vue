<template>
  <AppLayout :breadcrumbs="['Categories']">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Categorieën</h1>
      <p class="mt-2 text-gray-600">Overzicht van alle categorieën</p>
      <div class="mt-4">
        <a href="/categories/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Nieuwe categorie</a>
      </div>
    </div>
    <div class="widget-card overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"># Producten</th>
            <th class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="cat in categories" :key="cat.id">
            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
              <a :href="`/categories/${cat.id}`" class="hover:underline">{{ cat.name }}</a>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">{{ cat.parent?.name || '-' }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ cat.products_count }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right">
              <a :href="`/categories/${cat.id}/edit`" class="text-blue-600 hover:underline mr-4">Bewerken</a>
              <a :href="`/categories/${cat.id}`" class="text-gray-600 hover:underline">Bekijken</a>
            </td>
          </tr>
          <tr v-if="!categories.length">
            <td colspan="4" class="text-center py-8 text-gray-400">Geen categorieën gevonden.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue'
const props = defineProps({ categories: Array })
</script> 