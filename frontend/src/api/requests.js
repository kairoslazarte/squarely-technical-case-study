import client from './client'

export const requestsApi = {
  list() {
    return client.get('/requests')
  },

  create(payload) {
    return client.post('/requests', payload)
  },

  updateStatus(id, status) {
    return client.patch(`/requests/${id}`, { status })
  },
}
