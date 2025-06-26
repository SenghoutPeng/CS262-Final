<template>
  <div class="min-h-screen bg-white p-8 font-inter antialiased">
    <div class="max-w-full mx-auto px-4">

      <!-- Centered Header -->
      <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900">Transaction</h1>
        <p class="text-gray-600 mt-1">Event Ticket Commission Tracking</p>
      </div>

      <!-- Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Card 1 -->
        <div class="bg-white rounded-lg p-6 shadow-md flex items-start space-x-4 border-2 border-gray-200">
          <div class="bg-blue-100 text-blue-600 p-3 rounded-full flex-shrink-0 flex items-center justify-center">
            <!-- Icon placeholder -->
            <svg class="w-6 h-6 text-gray-800 dark:text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
          </svg>

          </div>
          <div class="flex-grow">
            <h3 class="text-gray-500 text-sm font-medium">Total Events</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-1">01283</p>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-lg p-6 shadow-md flex items-start space-x-4 border-2 border-gray-200">
          <div class="bg-green-100 text-green-600 p-3 rounded-full flex-shrink-0 flex items-center justify-center">

            <svg class="w-6 h-6 text-gray-800 dark:text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd"/>
          </svg>


          </div>
          <div class="flex-grow">
            <h3 class="text-gray-500 text-sm font-medium">Active Users</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-1">19283</p>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-lg p-6 shadow-md flex items-start space-x-4 border-2 border-gray-200">
          <div class="bg-amber-100 text-amber-600 p-3 rounded-full flex-shrink-0 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
              viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
          </div>
          <div class="flex-grow">
            <h3 class="text-gray-500 text-sm font-medium">Total User Balance</h3>
            <p class="text-3xl font-semibold text-gray-900 mt-1">124</p>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-success rounded-lg p-6 shadow-md flex items-start space-x-4 border-2 border-gray-200">
          <div class="bg-rose-300 text-rose-600 p-3 rounded-full flex-shrink-0 flex items-center justify-center">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H7Zm8-1a1 1 0 0 1 1-1h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
            </svg>

          </div>
          <div class="flex-grow">
            <h3 class="text-white text-sm font-medium">New This Month</h3>
            <p class="text-3xl font-semibold text-white mt-1">123</p>
          </div>
        </div>
      </div>

      <!-- Search Card Centered -->
      <div class="flex justify-center">
      <div class="bg-white border border-gray-200 rounded-lg shadow-md w-full max-w-md p-6">
        <label class="input input-bordered bg-white flex items-center gap-2 w-full border border-black rounded-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <input v-model="searchQuery" class="grow" type="text" placeholder="Search users..." />
        </label>
      </div>
    </div>

    <!--Table-->
    <div class="overflow-x-auto border border-gray-200 rounded-xl mt-10">
        <table class="table w-full bg-white text-sm">
          <thead class="bg-base-200 text-xs text-base-content/70 uppercase">
            <tr>
              <th class="py-3 px-4">Date</th>
              <th class="py-3 px-4">Organization</th>
              <th class="py-3 px-4">Event</th>
              <th class="py-3 px-4">Ticket Sold</th>
              <th class="py-3 px-4">Commission</th>
            </tr>
          </thead>
          <tbody>
            <tr 
              v-for="(activity, index) in activities" 
              :key="index"
              class="border-t border-gray-200 hover"
            >
             <td class="py-3 px-4">{{ activity.date }}</td>
            <td class="py-3 px-4 font-medium text-blue-600">{{ activity.org }}</td>
            <td class="py-3 px-4">{{ activity.event }}</td>
            <td class="py-3 px-4">{{ activity.ticketsold }}</td>
            <td class="py-3 px-4 text-success">${{ activity.commission }}</td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</template>


<script setup>

    definePageMeta({
        layout: 'master1'
    })

    const activities = ref([
  {
    date: '2025-06-01',
    org: 'Barcelona',
    event: 'El classico',
    ticketsold: '80000',
    commission: '43'
  },
  {
    date: '2025-06-01',
    org: 'Music',
    event: 'Rex Orange',
    ticketsold: '20000',
    commission: '47'
  },
  ])
</script>

<style scoped>


</style>