<template>
  <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
      <h2 class="text-base font-semibold text-gray-900">{{ title }}</h2>
      <span class="text-sm text-gray-400">{{ requests.length }} request{{ requests.length !== 1 ? 's' : '' }}</span>
    </div>

    <div v-if="requests.length === 0" class="py-12 text-center text-sm text-gray-400">
      No requests yet.
    </div>

    <!-- Table -->
    <div v-else class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-gray-100 bg-gray-50/50">
            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
            <th v-if="showUser" class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted by</th>
            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            <th v-if="showActions" class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <tr
            v-for="request in requests"
            :key="request.id"
            class="hover:bg-gray-50/50 transition"
          >
            <td class="px-6 py-4">
              <p class="font-medium text-gray-900 truncate max-w-xs">{{ request.title }}</p>
              <p class="text-gray-400 text-xs mt-0.5 truncate max-w-xs">{{ request.description }}</p>
            </td>
            <td v-if="showUser" class="px-6 py-4 text-gray-600">
              {{ request.user?.name ?? '—' }}
            </td>
            <td class="px-6 py-4">
              <span class="capitalize text-gray-600">{{ request.type }}</span>
            </td>
            <td class="px-6 py-4">
              <StatusBadge :status="request.status" />
            </td>
            <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">
              {{ formatDate(request.created_at) }}
            </td>
            <td v-if="showActions" class="px-6 py-4">
              <select
                :value="request.status"
                @change="(e) => $emit('status-change', request.id, e.target.value)"
                :disabled="updatingId === request.id"
                class="text-xs px-2.5 py-1.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white transition disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import StatusBadge from './StatusBadge.vue'

defineProps({
  title: {
    type: String,
    default: 'Requests',
  },
  requests: {
    type: Array,
    default: () => [],
  },
  showUser: {
    type: Boolean,
    default: false,
  },
  showActions: {
    type: Boolean,
    default: false,
  },
  updatingId: {
    type: [Number, null],
    default: null,
  },
})

defineEmits(['status-change'])

function formatDate(dateString) {
  return new Date(dateString).toLocaleDateString('en-GB', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
  })
}
</script>
