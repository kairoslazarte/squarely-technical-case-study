<template>
  <header class="bg-white border-b border-gray-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
          <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
          </svg>
        </div>
        <span class="font-semibold text-gray-900 text-md sm:block hidden">Squarely - Task & Request Management Module</span>

        <nav v-if="auth.isAdmin" class="ml-6 flex items-center gap-1">
          <RouterLink
            to="/"
            class="px-3 py-1.5 text-sm rounded-md transition"
            :class="$route.path === '/' ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-900'"
          >
            My Requests
          </RouterLink>
          <RouterLink
            to="/admin"
            class="px-3 py-1.5 text-sm rounded-md transition"
            :class="$route.path === '/admin' ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-900'"
          >
            Admin
          </RouterLink>
        </nav>
      </div>

      <div class="flex items-center gap-3">
        <div class="text-right hidden sm:block">
          <p class="text-sm font-medium text-gray-900">{{ auth.user?.name }}</p>
          <p class="text-xs text-gray-400">{{ auth.isAdmin ? 'Administrator' : 'Employee' }}</p>
        </div>
        <button
          @click="auth.logout()"
          class="text-sm text-gray-500 hover:text-gray-900 px-3 py-1.5 rounded-md hover:bg-gray-100 transition"
        >
          Sign out
        </button>
      </div>
    </div>
  </header>
</template>

<script setup>
import { RouterLink } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
</script>
