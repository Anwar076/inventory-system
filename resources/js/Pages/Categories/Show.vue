<template>
  <AppLayout :breadcrumbs="['Categories', category.name]">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">{{ category.name }}</h1>
      <p class="mt-2 text-gray-600">{{ category.description || 'Geen beschrijving.' }}</p>
      <div class="mt-2 flex items-center space-x-4">
        <span class="inline-block w-6 h-6 rounded-full border" :style="`background:${category.color}`"></span>
        <span class="text-xs text-gray-500">{{ category.is_active ? 'Actief' : 'Inactief' }}</span>
        <span v-if="category.parent" class="text-xs text-gray-500">Parent: {{ category.parent.name }}</span>
      </div>
    </div>
    <div class="widget-card mb-8">
      <h2 class="text-lg font-semibold mb-2">Gekoppelde producten</h2>
      <ul class="list-disc pl-6">
        <li v-for="prod in category.products" :key="prod.id">
          <a :href="`/products/${prod.id}`" class="text-blue-600 hover:underline">{{ prod.name }}</a>
        </li>
        <li v-if="!category.products.length" class="text-gray-400">Geen producten gekoppeld.</li>
      </ul>
    </div>
    <div class="widget-card">
      <h2 class="text-lg font-semibold mb-2">Subcategorieën</h2>
      <ul class="list-disc pl-6">
        <li v-for="sub in category.children" :key="sub.id">
          <a :href="`/categories/${sub.id}`" class="text-blue-600 hover:underline">{{ sub.name }}</a>
        </li>
        <li v-if="!category.children.length" class="text-gray-400">Geen subcategorieën.</li>
      </ul>
    </div>
    <div class="mt-8">
      <a href="/categories" class="px-4 py-2 text-gray-700 bg-gray-100 rounded hover:bg-gray-200">Terug naar overzicht</a>
    </div>
  </AppLayout>
</template>
<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue'
const props = defineProps({ category: Object })
</script> 