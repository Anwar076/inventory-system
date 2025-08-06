<template>
  <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 dark:bg-gray-900">
    <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded shadow">
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-900 dark:text-white">Verify your email address</h2>
      <p class="mb-6 text-gray-700 dark:text-gray-300 text-center">
        Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you. If you didn't receive the email, we will gladly send you another.
      </p>
      <form @submit.prevent="submit">
        <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded">Resend Verification Email</button>
      </form>
      <div v-if="status === 'verification-link-sent'" class="mt-4 text-green-600 text-center">
        A new verification link has been sent to your email address.
      </div>
      <div class="mt-6 text-center">
        <inertia-link href="/logout" method="post" as="button" class="text-blue-600 hover:underline">Log out</inertia-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { computed } from 'vue';

const page = usePage();
const status = computed(() => page.props.value.status || '');
const form = useForm();

function submit() {
  form.post('/email/verification-notification');
}
</script> 