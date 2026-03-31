<template>
  <div class="bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="text-base font-semibold text-gray-900 mb-5">New Request</h2>

    <form @submit.prevent="handleSubmit" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
        <input
          v-model="form.title"
          type="text"
          placeholder="Brief summary"
          required
          class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          :class="{ 'border-red-400': errors.title }"
        />
        <p v-if="errors.title" class="mt-1 text-xs text-red-500">{{ errors.title[0] }}</p>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
        <select
          v-model="form.type"
          required
          class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white"
          :class="{ 'border-red-400': errors.type }"
        >
          <option value="" disabled>Select a type</option>
          <option value="leave">Leave</option>
          <option value="reimbursement">Reimbursement</option>
          <option value="other">Other</option>
        </select>
        <p v-if="errors.type" class="mt-1 text-xs text-red-500">{{ errors.type[0] }}</p>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea
          v-model="form.description"
          rows="4"
          placeholder="Add any details..."
          required
          class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
          :class="{ 'border-red-400': errors.description }"
        />
        <p v-if="errors.description" class="mt-1 text-xs text-red-500">{{ errors.description[0] }}</p>
      </div>

      <button
        type="submit"
        :disabled="loading"
        class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition disabled:opacity-50"
      >
        {{ loading ? 'Submitting...' : 'Submit' }}
      </button>

      <p v-if="success" class="text-sm text-green-600">Request sent.</p>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { requestsApi } from '@/api/requests'

const emit = defineEmits(['created'])

const form = reactive({ title: '', type: '', description: '' })
const loading = ref(false)
const errors = ref({})
const success = ref(false)

async function handleSubmit() {
  loading.value = true
  errors.value = {}
  success.value = false

  try {
    const { data } = await requestsApi.create(form)
    emit('created', data)
    form.title = ''
    form.type = ''
    form.description = ''
    success.value = true
    setTimeout(() => (success.value = false), 3000)
  } catch (err) {
    if (err.response?.status === 422) {
      errors.value = err.response.data.errors ?? {}
    }
  } finally {
    loading.value = false
  }
}
</script>
