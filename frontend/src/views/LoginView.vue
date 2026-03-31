<template>
  <div class="min-h-screen bg-slate-900 flex items-center justify-center p-4">
    <div class="w-full max-w-lg">
      <div class="text-center mb-8">
        <h1 class="text-2xl font-semibold text-white">Squarely - Task & Request Management Module</h1>
        <span class="text-xs text-gray-300 italic">by Fillip Kairos Lazarte</span>
        <p class="text-slate-400 text-sm mt-1">Sign in to continue</p>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-7">
        <form @submit.prevent="handleLogin" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
            <input
              v-model="form.email"
              type="email"
              autocomplete="email"
              required
              placeholder="you@example.com"
              class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              :class="{ 'border-red-400': errors.email }"
            />
            <p v-if="errors.email" class="mt-1 text-xs text-red-500">{{ errors.email[0] }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
            <input
              v-model="form.password"
              type="password"
              autocomplete="current-password"
              required
              placeholder="••••••••"
              class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            />
          </div>

          <button
            type="submit"
            :disabled="loading"
            class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition disabled:opacity-50"
          >
            {{ loading ? 'Signing in...' : 'Sign in' }}
          </button>

          <p v-if="generalError" class="text-center text-sm text-red-500">{{ generalError }}</p>
        </form>

        <div class="mt-5 pt-4 border-t border-gray-100 text-xs text-gray-400">
          <p class="mb-2">Test accounts (password: <span class="font-mono">password</span>)</p>
          <p>admin@example.com — admin</p>
          <p>employee@example.com — employee</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const auth = useAuthStore()

const form = reactive({ email: '', password: '' })
const loading = ref(false)
const errors = ref({})
const generalError = ref('')

async function handleLogin() {
  loading.value = true
  errors.value = {}
  generalError.value = ''

  try {
    await auth.login(form)
    router.push(auth.isAdmin ? '/admin' : '/')
  } catch (err) {
    if (err.response?.status === 422) {
      errors.value = err.response.data.errors ?? {}
    } else {
      generalError.value = err.response?.data?.message ?? 'Something went wrong.'
    }
  } finally {
    loading.value = false
  }
}
</script>
