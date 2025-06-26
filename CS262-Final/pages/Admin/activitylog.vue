<template>
  <div class="min-h-screen bg-white p-8">
    <div class="bg-gray-100 p-6 rounded-xl shadow-md">
      <!-- Header -->
      <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h2 class="text-2xl font-bold text-content-100">Activity Log</h2>
        <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
          <input 
            type="text" 
            v-model="searchQuery" 
            placeholder="Search user, org, or activity..."
            class="input input-bordered w-full md:w-64"
          />
          <input type="date" v-model="fromDate" class="input input-bordered" />
          <input type="date" v-model="toDate" class="input input-bordered" />
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto border border-gray-200 rounded-xl">
        <table class="table w-full bg-white text-sm">
          <thead class="bg-base-200 text-xs text-base-content/70 uppercase">
            <tr>
              <th class="py-3 px-4 w-1/4">Date</th>
              <th class="py-3 px-4 w-1/4">User/Organization</th>
              <th class="py-3 px-4 w-1/4">Activity</th>
              <th class="py-3 px-4 w-1/4">Details</th>
            </tr>
          </thead>
          <tbody>
            <tr 
              v-for="(activity, index) in paginatedActivities" 
              :key="index"
              class="border-t border-gray-200 hover"
            >
              <td class="py-3 px-4">{{ activity.timestamp }}</td>
              <td class="py-3 px-4 font-medium">
                <span class="text-blue-600">{{ activity.causer_name }}</span>
              </td>
              <td class="py-3 px-4 text-content-200">{{ activity.activity }}</td>
              <td class="py-3 px-4 text-content-200">{{ activity.description }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
        <div class="mt-6 flex justify-between items-center">
        <button 
            class="btn btn-outline btn-sm btn-neutral"
            :disabled="currentPage === 1"
            @click="currentPage--"
        >
            « Prev
        </button>

        <div class="text-sm font-medium text-black">Page {{ currentPage }}</div>

        <button 
            class="btn btn-outline btn-sm btn-neutral"
            :disabled="endIndex >= filteredActivities.length"
            @click="currentPage++"
        >
            Next »
        </button>
        </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

definePageMeta({
        layout: 'master1'
    })

const searchQuery = ref('')
const fromDate = ref('')
const toDate = ref('')
const currentPage = ref(1)
const perPage = 10

const activities = ref([])

const fetchActivityLog = async () => {
  try {
    const res = await fetch('http://localhost:8000/api/admin/activity-log')
    const data = await res.json()
    activities.value = data.all_activity_logs
  } catch (error) {
    console.error("Error loading event requests:", error)
  }
}

const fetchViewDetail = async () => {
  try {
    const res = await fetch('http://localhost:8000/api/admin/activity-log')
    const data = await res.json()
    activities.value = data.all_activity_logs
  } catch (error) {
    console.error("Error loading event requests:", error)
  }
}

const filteredActivities = computed(() => {
  return activities.value.filter(activity => {
    const search = searchQuery.value.toLowerCase()
    const matchesSearch = search === '' || JSON.stringify(activity).toLowerCase().includes(search)
    const matchesFrom = !fromDate.value || activity.timestamp >= fromDate.value
    const matchesTo = !toDate.value || activity.timestamp <= toDate.value
    return matchesSearch && matchesFrom && matchesTo
  })
})

const startIndex = computed(() => (currentPage.value - 1) * perPage)
const endIndex = computed(() => startIndex.value + perPage)
const paginatedActivities = computed(() => {
  return filteredActivities.value.slice(startIndex.value, endIndex.value)
})

onMounted(() => {
  fetchActivityLog()
})
</script>

<style scoped>
input {
    background: white;
}
body {
  overflow-y: scroll;
}
table {
  table-layout: fixed;
  width: 100%;
}
</style>
