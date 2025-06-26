<template >
  <div class="min-h-screen bg-white p-8 font-inter antialiased">
    <div class="max-w-full mx-auto px-4"> <!-- Changed max-w-7xl to max-w-full and adjusted padding -->
      <!-- Header Section -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="text-4xl font-bold text-gray-900">User Management</h1>
          <p class="text-gray-600 mt-1">Manage all registered users and their account details</p>
        </div>

      </div>

      <!-- Stats Cards Section -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card 1: Total Users -->
        <div class="bg-white rounded-lg p-6 shadow-md flex items-start space-x-4 border-2 border-gray-200">
          <div class="bg-blue-100 text-blue-600 p-3 rounded-full flex-shrink-0 flex items-center justify-center">
            <!-- Icon for Total Users -->
            <svg
              xmlns=""
              class="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2m2-5a4 4 0 118 0V7a4 4 0 11-8 0v8zm0 0H2"
              />
            </svg>
          </div>
          <div class="flex-grow">
            <h3 class="text-gray-500 text-sm font-medium">Total Users</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-1">{{ totalUsers }}</p>
            <div class="flex items-center text-sm mt-2">
              <span class="font-medium text-green-500"> +6% this month </span>
              <span class="text-gray-500 ml-2">62 per day avg</span>
            </div>
          </div>
        </div>

        <!-- Card 3: Total User Balance -->
        <div class="bg-white rounded-lg p-6 shadow-md flex items-start space-x-4 border-2 border-gray-200">
          <div class="bg-amber-100 text-amber-600 p-3 rounded-full flex-shrink-0 flex items-center justify-center">
            <!-- Icon for Total User Balance -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
              />
            </svg>
          </div>
          <div class="flex-grow">
            <h3 class="text-gray-500 text-sm font-medium">Total User Balance</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-1">{{ totalBalance }}</p>
            <div class="flex items-center text-sm mt-2">
              <span class="font-medium text-green-500">+15% this month</span>
            </div>
          </div>
        </div>

        <!-- Card 4: New This Month -->
        <div class="bg-white rounded-lg p-6 shadow-md flex items-start space-x-4 border-2 border-gray-200">
          <div class="bg-rose-100 text-rose-600 p-3 rounded-full flex-shrink-0 flex items-center justify-center">
            <!-- Icon for New This Month -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-3 0V9m0 0V6m0 3h-3m3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
          </div>
          <div class="flex-grow">
            <h3 class="text-gray-500 text-sm font-medium">New This Month</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-1">{{ newUsers }}</p>
            <div class="flex items-center text-sm mt-2">
              <span class="font-medium text-gray-500">62 per day avg</span>
            </div>
          </div>
        </div>
      </div>
      
  
  <!-- table content -->
  <div class="min-h-screen bg-gray-100 p-6 mt-6 rounded-2xl">
    <div class="max-w-8xl mx-auto">

      <!-- Header -->
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-base-200 mb-4 mt-3">All Users</h1>

        <!-- Search and Filter Bar -->
        <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
          <!-- Search Input -->
          <label class="input input-bordered bg-white flex items-center gap-2 w-64">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input v-model="searchQuery" type="text" class="grow" placeholder="Search users..." />
          </label>

          <!-- Filter and Sort Buttons -->
          <div class="flex gap-2">
            <select v-model="statusFilter" class="btn btn-outline btn-sm">
                <option value="all">All Status</option>
                <option value="active">All Active</option>
                <option value="inactive">All InActive</option>
              </select>
              
          </div>
        </div>
      </div>

      <!-- Users Table -->
      <div class="overflow-x-auto shadow rounded-lg bg-white">
        <table class="table bg-white w-full">
          <thead>
            <tr class="text-base-200 border-b border-gray-200">
              <th>Name</th>
              <th>Email</th>
              <th>Balance</th>
              <th>Joined</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- User Row -->
            <tr v-for="user in paginatedUsers" :key="user.id" class=" border-b border-gray-200">
              <td>
                <div class="flex items-center gap-3">
                  <div class="avatar placeholder">
                    <div class="avatar">
                    <div class="w-16 rounded-full">
                      <img src="https://img.daisyui.com/images/profile/demo/gordon@192.webp" />
                    </div>
                  </div>
                  </div>
                  <div>
                    <div class="font-bold">{{ user.username }}</div>
                    <div class="text-sm opacity-50">ID: {{ user.user_id }}</div>
                  </div>
                </div>
              </td>
              <td>{{ user.email }}</td>
              <td>{{ user.balance }}</td>
              <td>{{ new Date(user.created_at).toLocaleDateString() }}</td>
              <td>
                <div class="flex gap-2">
                  <button class="btn btn-info btn-xs text-gray-500 hover:text-base-cotent">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>
                  
                </div>
              </td>
            </tr>

            <!-- Additional rows can go here -->
          </tbody>
        </table>
      </div>
    </div>

    <!--pagination-->
      <div class="flex justify-end mt-4 space-x-2">
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
import { ref, computed, watch } from 'vue'

definePageMeta({
  layout: 'master1',
})

// API Calls with useAsyncData
const {
  data: UserData,
  error,
  refresh,
  pending
} = useLazyFetch('/api/admin/users', {
  // Options
  baseURL: 'http://localhost:8000', // Better: use runtime config
  server: false,
  lazy: true
})





const newUsers = computed(() => UserData.value?.new_users_this_month || 0)
const allUsers = computed(() => UserData.value?.users || [])
const totalUsers = computed(() => UserData.value?.total_users || 0)
const totalBalance = computed(() => UserData.value?.total_balance || 0)

// Search and filter
const searchQuery = ref('')
const statusFilter = ref('all')

const filteredUsers = computed(() => {
  const query = searchQuery.value.toLowerCase().trim()
  let filtered = allUsers.value.filter(user =>
    user.username.toLowerCase().includes(query) ||
    user.email.toLowerCase().includes(query) ||
    String(user.user_id).includes(query)
  )

  if (statusFilter.value !== 'all') {
    filtered = filtered.filter(user => user.status === statusFilter.value)
  }

  return filtered
})

// Pagination
const currentPage = ref(1)
const itemsPerPage = ref(10)

const totalPages = computed(() => Math.ceil(filteredUsers.value.length / itemsPerPage.value))

const paginatedUsers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  return filteredUsers.value.slice(start, start + itemsPerPage.value)
})

// Reset to page 1 on search/filter change
watch([searchQuery, statusFilter], () => {
  currentPage.value = 1
})
</script>


<style scoped>


</style>