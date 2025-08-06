<template>
  <AppLayout :breadcrumbs="['Voorraad']">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Voorraadoverzicht</h1>
      <p class="mt-2 text-gray-600">Bekijk de voorraad van alle locaties</p>
    </div>

    <!-- Statistieken -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-blue-100 rounded-lg">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Totaal Locaties</p>
            <p class="text-2xl font-semibold text-gray-900">{{ locaties.length }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-green-100 rounded-lg">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Totaal Producten</p>
            <p class="text-2xl font-semibold text-gray-900">{{ totalProducts }}</p>
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
            <p class="text-2xl font-semibold text-gray-900">{{ lowStockCount }}</p>
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
            <p class="text-2xl font-semibold text-gray-900">{{ outOfStockCount }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Locaties Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div 
        v-for="locatie in locaties" 
        :key="locatie.id"
        class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-200"
      >
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">{{ locatie.name }}</h3>
            <span class="px-2 py-1 text-xs font-medium rounded-full" 
                  :class="locatie.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
              {{ locatie.is_active ? 'Actief' : 'Inactief' }}
            </span>
          </div>
          
          <div class="space-y-2 text-sm text-gray-600 mb-4">
            <p><span class="font-medium">Type:</span> {{ locatie.type }}</p>
            <p><span class="font-medium">Code:</span> {{ locatie.code }}</p>
            <p v-if="locatie.address">
              <span class="font-medium">Adres:</span> {{ locatie.address }}, {{ locatie.city }}
            </p>
          </div>

          <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="text-center">
              <p class="text-2xl font-bold text-blue-600">{{ locatie.total_products || 0 }}</p>
              <p class="text-xs text-gray-500">Producten</p>
            </div>
            <div class="text-center">
              <p class="text-2xl font-bold text-green-600">{{ locatie.total_stock_value || 0 }}</p>
              <p class="text-xs text-gray-500">Stuks</p>
            </div>
          </div>

          <a 
            :href="`/inventory/${locatie.id}`"
            class="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors duration-200"
          >
            Voorraad Bekijken
          </a>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="!locaties.length" class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">Geen locaties</h3>
      <p class="mt-1 text-sm text-gray-500">Er zijn nog geen locaties aangemaakt.</p>
      <div class="mt-6">
        <a href="/pands/create" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
          Eerste locatie aanmaken
        </a>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { computed } from 'vue'
import AppLayout from '@/Components/Layout/AppLayout.vue'

const props = defineProps({
  locaties: Array,
  globalStats: Object
})

const totalProducts = computed(() => {
  return props.globalStats?.total_products || 0
})

const lowStockCount = computed(() => {
  return props.globalStats?.low_stock_count || 0
})

const outOfStockCount = computed(() => {
  return props.globalStats?.out_of_stock_count || 0
})
</script> 