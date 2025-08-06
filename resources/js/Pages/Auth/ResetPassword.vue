<template>
  <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 dark:bg-gray-900">
    <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded shadow">
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-900 dark:text-white">Reset your password</h2>
      <form @submit.prevent="submit">
        <input type="hidden" v-model="form.token" />
        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-200 mb-2" for="email">Email</label>
          <input v-model="form.email" id="email" type="email" required autofocus class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-white" />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-200 mb-2" for="password">New Password</label>
          <input v-model="form.password" id="password" type="password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-white" />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-200 mb-2" for="password_confirmation">Confirm Password</label>
          <input v-model="form.password_confirmation" id="password_confirmation" type="password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-white" />
        </div>
        <div v-if="form.errors.email" class="mb-4 text-red-500 text-sm">{{ form.errors.email }}</div>
        <div v-if="form.errors.password" class="mb-4 text-red-500 text-sm">{{ form.errors.password }}</div>
        <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded">Reset Password</button>
      </form>
      <div class="mt-6 text-center">
        <inertia-link href="/login" class="text-blue-600 hover:underline">Back to login</inertia-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';

const page = usePage();
const form = useForm({
  token: computed(() => page.props.value.request?.token || ''),
  email: computed(() => page.props.value.request?.email || ''),
  password: '',
  password_confirmation: '',
});

function submit() {
  form.post('/reset-password');
}
</script> 