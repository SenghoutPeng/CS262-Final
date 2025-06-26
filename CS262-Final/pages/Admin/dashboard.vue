<template>
  <div class="min-h-screen bg-white py-10 px-6 font-inter antialiased">
    <div class="max-w-7xl mx-auto">

      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900">Dashboard Data</h1>
        <p class="text-gray-600 mt-2 text-lg">Track performance, user engagement, and revenue insights</p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total User -->
        <div class="stat bg-white rounded-xl shadow-lg p-6">
          <div class="stat-figure text-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 stroke-current" fill="none"
              viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="stat-title text-sm text-gray-500">TotalUsers</div>
          <div class="stat-value text-3xl font-semibold text-gray-900">{{ TotalUsers }}</div>
          <!--<div class="stat-desc text-green-500">↗ Jan 1st - Feb 1st</div> -->
        </div>

        <!-- Total Org -->
        <div class="stat bg-white rounded-xl shadow-lg p-6">
          <div class="stat-figure text-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 stroke-current" fill="none"
              viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
          </div>
          <div class="stat-title text-sm text-gray-500">Total Organization</div>
          <div class="stat-value text-3xl font-semibold text-gray-900">{{ TotalOrgs }}</div>
          <!-- <div class="stat-desc text-green-500">↗︎ 400 (22%)</div> -->
        </div>

        <!-- Total Revenue -->
        <div class="stat bg-white rounded-xl shadow-lg p-6">
          <div class="stat-figure text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 stroke-current" fill="none"
              viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
          </div>
          <div class="stat-title text-sm text-gray-500">Total revenue</div>
          <div class="stat-value text-3xl font-semibold text-gray-900">{{ TotalRevenue }}</div>
          <!--<div class="stat-desc text-red-500">↘︎ 90 (14%)</div>-->
        </div>

        <!--Total ticket sold-->
        <div class="stat bg-white rounded-xl shadow-lg p-6">
          <div class="stat-figure text-red-500">
            <img width="50" height="50" src="https://img.icons8.com/ios/50/ticket--v1.png" alt="ticket--v1"/>
          </div>
          <div class="stat-title text-sm text-gray-500">Total Ticket Sold</div>
          <div class="stat-value text-3xl font-semibold text-gray-900">{{ TicketSold }}</div>
          <!--<div class="stat-desc text-red-500">↘︎ 90 (14%)</div> -->
        </div>


      </div>

      <!-- Top Performing Events (with gray background wrapper) -->
    <div class="bg-gray-200 rounded-xl p-6 mt-10">
      <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold text-gray-900">Top Performing Events</h2>
        </div>

        <div v-for="(event, index) in paginatedTopEvents" :key="index" class="flex justify-between items-center py-4 first:border-t-0">
          <div class="flex items-center gap-4">
            <!-- Placeholder Icon -->
            <div class="bg-gray-100 p-2 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6h13M9 6H5v13h4" />
              </svg>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-900">{{ event.event_name }}</p>
              <p class="text-xs text-gray-500">by {{ event.organizer || 'Unknown Organizer' }}</p>
            </div>
          </div>
          <div class="text-right">
            <p class="text-sm font-semibold text-gray-900">{{ event.tickets_sold.toLocaleString() }} sold</p>
            <p class="text-xs text-green-500">${{ event.revenue.toLocaleString() }} revenue</p>
          </div>
        </div>
      </div>

      <!--Pagination-->
      <div v-if="totalPages > 1" class="flex justify-end mt-4 space-x-2">
        <button
          class="btn btn-outline"
          :disabled="currentPage === 1"
          @click="currentPage--"
        >
          Previous
        </button>

        <button
          v-for="page in totalPages"
          :key="page"
          @click="currentPage = page"
          :class="['btn btn-outline', currentPage === page ? 'btn-active' : '']"
        >
          {{ page }}
        </button>

        <button
          class="btn btn-outline"
          :disabled="currentPage === totalPages"
          @click="currentPage++"
        >
          Next
        </button>
      </div>

    </div>



    </div>
  </div>
</template>


<script setup>

import { onMounted, computed, ref } from 'vue'

    definePageMeta({
        layout: 'master1',
       
    })

    const {
      data: DashboardData,
      error,
      refresh,
      pending
    } = useLazyFetch('/api/admin/dashboard', {
      // Options
      baseURL: 'http://localhost:8000', // Better: use runtime config
      server: false,
      lazy: true
    })

    const TotalUsers = computed(() => DashboardData.value?.total_users || 0)
    const TotalOrgs = computed(() => DashboardData.value?.total_organizations || 0)
    const TicketSold = computed(() => DashboardData.value?.ticket_sold || 0)
    const TotalRevenue = computed(() => DashboardData.value?.total_revenue || 0)
    const TopEvent = computed(() => DashboardData.value?.top_events_by_ticket_sold || [])

    const fallbackTopEvents = ref([
  {
    event_name: 'Summer Music Festival',
    organizer: 'MusicEvents Ltd.',
    tickets_sold: 1247,
    revenue: 62350
  },
  {
    event_name: 'Tech Conference 2024',
    organizer: 'EventCorp Inc.',
    tickets_sold: 892,
    revenue: 44600
  },
  {
    event_name: 'Sports Championship',
    organizer: 'SportEvents Co.',
    tickets_sold: 756,
    revenue: 37800
  },
  {
    event_name: 'Food Carnival 2024',
    organizer: 'GastroGroup',
    tickets_sold: 680,
    revenue: 34000
  },
  {
    event_name: 'Art Expo',
    organizer: 'CreativeMinds',
    tickets_sold: 510,
    revenue: 25500
  },
  {
    event_name: 'Startup Pitch Day',
    organizer: 'InvestNow',
    tickets_sold: 468,
    revenue: 23400
  },
  {
    event_name: 'Health & Wellness Fair',
    organizer: 'Wellness Inc.',
    tickets_sold: 420,
    revenue: 21000
  },
  {
    event_name: 'Kids Talent Show',
    organizer: 'FunTime Co.',
    tickets_sold: 392,
    revenue: 19600
  },
  {
    event_name: 'Book Fair 2024',
    organizer: 'ReadersHub',
    tickets_sold: 375,
    revenue: 18750
  },
  {
    event_name: 'Gaming Convention',
    organizer: 'GameZone',
    tickets_sold: 360,
    revenue: 18000
  }
])

const currentPage = ref(1)
const itemsPerPage = ref(6)

const startIndex = computed(() => (currentPage.value - 1) * itemsPerPage.value)
const endIndex = computed(() => startIndex.value + itemsPerPage.value)

const paginatedTopEvents = computed(() => {
  return fallbackTopEvents.value.slice(startIndex.value, endIndex.value)
})

const totalPages = computed(() => {
  return Math.ceil(fallbackTopEvents.value.length / itemsPerPage.value)
})

function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page
  }
}

function nextPage() {
  if (currentPage.value < totalPages.value) {
    currentPage.value++
  }
}

function prevPage() {
  if (currentPage.value > 1) {
    currentPage.value--
  }
}



onMounted(() => {
  refresh()  // trigger lazy fetch on mount
})

</script>

<style scoped>


</style>