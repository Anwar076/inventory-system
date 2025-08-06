<template>
  <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 dark:bg-gray-900">
    <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded shadow">
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-900 dark:text-white">Sign in to your account</h2>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-200 mb-2" for="email">Email</label>
          <input v-model="form.email" id="email" type="email" required autofocus class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-white" />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-200 mb-2" for="password">Password</label>
          <input v-model="form.password" id="password" type="password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-white" />
        </div>
        <div class="flex items-center justify-between mb-6">
          <label class="flex items-center">
            <input v-model="form.remember" type="checkbox" class="form-checkbox" />
            <span class="ml-2 text-gray-600 dark:text-gray-300">Remember me</span>
          </label>
          <inertia-link href="/forgot-password" class="text-sm text-blue-600 hover:underline">Forgot password?</inertia-link>
        </div>
        <div v-if="form.errors.email" class="mb-4 text-red-500 text-sm">{{ form.errors.email }}</div>
        <div v-if="form.errors.password" class="mb-4 text-red-500 text-sm">{{ form.errors.password }}</div>
        <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded">Sign In</button>
      </form>
      <div class="mt-6 text-center">
        <span class="text-gray-600 dark:text-gray-300">Don't have an account?</span>
        <inertia-link href="/register" class="text-blue-600 hover:underline ml-1">Sign up</inertia-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

function submit() {
  form.post('/login');
}
</script> 