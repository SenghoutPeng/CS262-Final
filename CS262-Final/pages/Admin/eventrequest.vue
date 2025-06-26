<template>
  <div class="min-h-screen bg-white p-8">
    <div class="bg-gray-200 rounded-xl shadow px-6 py-6">
      <!-- Header -->
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">All Event Requests</h1>
        <div class="flex gap-3 w-full md:w-auto">
          <input 
            type="text" 
            v-model="searchQuery"
            placeholder="Search events..."
            class="input input-bordered w-full md:w-64"
          />
          <select class="select select-bordered w-40 bg-white">
            <option>All Status</option>
            <option>Approved</option>
            <option>Pending</option>
            <option>Rejected</option>
          </select>
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="table w-full bg-white">
          <thead>
            <tr class="text-sm text-white bg-gray-800">
              <th class="py-3 px-4 text-left font-medium">Organizer</th>
              <th class="py-3 px-4 text-left font-medium">Event Name</th>
              <th class="py-3 px-4 text-left font-medium">Submit Date</th>
              <th class="py-3 px-4 text-left font-medium">Status</th>
              <th class="py-3 px-4 text-left font-medium">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr 
              v-for="request in eventRequests" 
              :key="request.event_id" 
              class="border-t border-gray-200 hover:bg-gray-50 text-sm"
            >
              <td class="py-3 px-4 font-medium text-gray-800">{{ request.org_name }}</td>
              <td class="py-3 px-4 text-gray-700">{{ request.title }}</td>
              <td class="py-3 px-4 text-gray-600">{{ request.created_at }}</td>
              <td class="py-3 px-4">
                <span
                  class="badge text-xs px-2 py-1 rounded-full"
                  :class="getStatusClass(request.status)"
                >
                  {{ request.status }}
                </span>
              </td>
              <td class="py-3 px-4">
                <button class="btn btn-sm btn-outline" @click="viewDetails(request.event_id)">View</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Details Card -->
      <div v-if="selectedEvent" class="mt-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Event Details</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Left Info -->
          <div class="space-y-3 text-gray-700 text-sm">
            <p><strong>Title:</strong> {{ selectedEvent.title }}</p>
            <p><strong>Description:</strong> {{ selectedEvent.description }}</p>
            <p><strong>Date:</strong> {{ selectedEvent.created_at }}</p>
            <p><strong>Location:</strong> {{ selectedEvent.location }}</p>
            <div class="mt-4 flex gap-2">
              <button class="btn btn-success btn-sm" @click="submitDecision('approve')">Approve</button>
              <button class="btn btn-error btn-sm" @click="submitDecision('reject')">Reject</button>
            </div>
          </div>

          <!-- Right Image/Visual -->
          <div class="rounded-xl overflow-hidden min-h-[300px] bg-gradient-to-r from-blue-900 to-red-900 flex items-center justify-center relative">
            <div class="absolute left-6 text-white text-center">
              <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center">
                <div>
                  <div class="text-sm font-bold">FCB</div>
                  <div class="text-yellow-400">⚽</div>
                </div>
              </div>
            </div>
            <div class="text-4xl font-bold text-white">VS</div>
            <div class="absolute right-6 text-center">
              <div class="w-20 h-20 bg-white border-4 border-yellow-400 rounded-full flex items-center justify-center">
                <div class="text-blue-900 font-bold">
                  <div>RM</div>
                  <div class="text-yellow-500">👑</div>
                </div>
              </div>
            </div>
            <div class="absolute bottom-4 text-white bg-black/50 px-4 py-1 rounded text-sm font-semibold">
              EL CLÁSICO
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

definePageMeta({
  layout: 'master1'
})

const searchQuery = ref('')
const eventRequests = ref([])
const selectedEvent = ref(null)

// Fetch all event requests
const fetchEventRequests = async () => {
  try {
    const res = await fetch('http://localhost:8000/api/admin/all-event-requests')
    const data = await res.json()
    eventRequests.value = data.event_requests
  } catch (error) {
    console.error("Error loading event requests:", error)
  }
}

// Fetch detail of selected event
const viewDetails = async (event_id) => {
  if (!event_id) {
    console.warn("Missing event_id for viewDetails")
    return
  }

  try {
    const res = await fetch(`http://localhost:8000/api/admin/detail-event-request/${event_id}`)
    const data = await res.json()
    selectedEvent.value = data.event_request_detail
  } catch (error) {
    console.error("Error fetching event detail:", error)
  }
}

const emit = defineEmits(['refresh'])

const submitDecision = async (decision) => {
  try{
    await fetch(`http://localhost:8000/api/admin/decision`, {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',  // ✅ tells Laravel you're sending JSON
    'Accept': 'application/json'         // ✅ ensures Laravel returns JSON
    },
    body: JSON.stringify({
      id: selectedEvent.value.event_id,
      status: decision
    })
  })

    emit('refresh') //trigger to reload the page
  }catch (e) {
    console.error('Failed to update status:', e)
  }
}

// Badge class by status
const getStatusClass = (status) => {
  const normalize = status.toLowerCase()
  return normalize === 'pending'
    ? 'bg-yellow-100 text-yellow-800'
    : normalize === 'approved'
    ? 'bg-green-100 text-green-800'
    : normalize === 'rejected'
    ? 'bg-red-100 text-red-800'
    : 'bg-gray-100 text-gray-800'
}

onMounted(() => {
  fetchEventRequests()
})
</script>

<style scoped>
input {
  background: white;
}
</style>
