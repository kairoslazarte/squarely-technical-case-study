<template>
  <div class="min-h-screen bg-gray-50">
    <AppHeader />

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
      <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-900">All Requests</h1>
        <p class="text-sm text-gray-500 mt-1">Review and update the status of employee requests.</p>
      </div>

      <div v-if="loading" class="bg-white rounded-xl border border-gray-200 p-12 text-center">
        <p class="text-sm text-gray-400">Loading...</p>
      </div>

      <RequestsTable
        v-else
        title="Requests"
        :requests="requests"
        :show-user="true"
        :show-actions="true"
        :updating-id="updatingId"
        @status-change="handleStatusChange"
      />
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AppHeader from '@/components/AppHeader.vue'
import RequestsTable from '@/components/RequestsTable.vue'
import { requestsApi } from '@/api/requests'

const requests = ref([])
const loading = ref(true)
const updatingId = ref(null)

async function fetchRequests() {
  try {
    const { data } = await requestsApi.list()
    requests.value = data
  } finally {
    loading.value = false
  }
}

async function handleStatusChange(id, status) {
  updatingId.value = id
  try {
    const { data } = await requestsApi.updateStatus(id, status)
    const index = requests.value.findIndex((r) => r.id === id)
    if (index !== -1) requests.value[index] = data
  } finally {
    updatingId.value = null
  }
}

onMounted(fetchRequests)
</script>
