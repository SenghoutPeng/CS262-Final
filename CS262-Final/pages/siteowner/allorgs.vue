<template>
  <div class="min-h-screen bg-white p-8 font-inter antialiased">
    <div class="max-w-full mx-auto px-4"> <!-- Changed max-w-7xl to max-w-full and adjusted padding -->
      <!-- Header Section -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="text-4xl font-bold text-gray-900">Organization Management</h1>
          <p class="text-gray-600 mt-1">Manage all registered Organization and their account details</p>
        </div>
        <button
          class="flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300 ease-in-out"
        >
          <!-- User Plus Icon SVG -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 mr-2"
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
          Add Organization
        </button>
      </div>

      <!-- Stats Cards Section -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Total Users -->
        <div class="bg-white rounded-lg p-6 shadow-md flex items-start space-x-4 border-2 border-gray-200">
          <div class="bg-blue-100 text-blue-600 p-3 rounded-full flex-shrink-0 flex items-center justify-center">
            <!-- Icon for Total Users -->
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
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2m2-5a4 4 0 118 0V7a4 4 0 11-8 0v8zm0 0H2"
              />
            </svg>
          </div>
          <div class="flex-grow">
            <h3 class="text-gray-500 text-sm font-medium">Total Organization</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-1">{{ totalUsers }}</p>
            <div class="flex items-center text-sm mt-2">
              <span class="font-medium text-green-500"> +6% this month </span>
              <span class="text-gray-500 ml-2">62 per day avg</span>
            </div>
          </div>
        </div>

        <!-- Card 2: Active Users -->
        <div class="bg-white rounded-lg p-6 shadow-md flex items-start space-x-4 border-2 border-gray-200">
          <div class="bg-green-100 text-green-600 p-3 rounded-full flex-shrink-0 flex items-center justify-center">
            <!-- Icon for Active Users -->
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
                d="M5 13l4 4L19 7m-1 10h2a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2h2m0 0V5"
              />
            </svg>
          </div>
          <div class="flex-grow">
            <h3 class="text-gray-500 text-sm font-medium">Active Users</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-1">18,247</p>
            <div class="flex items-center text-sm mt-2">
              <span class="font-medium text-gray-500">73% activity rate</span>
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
            <p class="text-3xl font-semibold text-gray-900 mt-1">1,847</p>
            <div class="flex items-center text-sm mt-2">
              <span class="font-medium text-gray-500">62 per day avg</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>

    definePageMeta({
        layout: 'master1',
    })

 const { data: userCountData, error: userError } = await useFetch('http://localhost:8000/api/Alluser', {
  key: 'all-users', // Helps Nuxt cache/fetch properly
})

const { data: balanceData, error: balanceError } = await useFetch('http://localhost:8000/api/Balanceuser', {
  key: 'user-balance',
})

const totalUsers = computed(() => userCountData.value?.totalUsers || 0)
const totalBalance = computed(() => balanceData.value?.totalBalance || 0)

</script>

<style scoped>


</style>