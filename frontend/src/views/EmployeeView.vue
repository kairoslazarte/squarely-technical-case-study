<template>
  <div class="min-h-screen bg-gray-50">
    <AppHeader />

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
      <!-- Page header -->
      <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-900">My Requests</h1>
        <p class="text-sm text-gray-500 mt-0.5">Submit and track your requests.</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form column -->
        <div class="lg:col-span-1">
          <RequestForm @created="onRequestCreated" />
        </div>

        <div class="lg:col-span-2">
          <div v-if="loading" class="text-sm text-gray-400 py-8 text-center">Loading...</div>

          <RequestsTable
            v-else
            title="Your Requests"
            :requests="requests"
          />
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AppHeader from '@/components/AppHeader.vue'
import RequestForm from '@/components/RequestForm.vue'
import RequestsTable from '@/components/RequestsTable.vue'
import { requestsApi } from '@/api/requests'

const requests = ref([])
const loading = ref(true)

async function fetchRequests() {
  try {
    const { data } = await requestsApi.list()
    requests.value = data
  } finally {
    loading.value = false
  }
}

function onRequestCreated(newRequest) {
  requests.value.unshift(newRequest)
}

onMounted(fetchRequests)
</script>
