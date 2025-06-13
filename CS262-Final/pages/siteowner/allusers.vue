<template >
  <div class="min-h-screen bg-white p-8 font-inter antialiased">
    <div class="max-w-full mx-auto px-4"> <!-- Changed max-w-7xl to max-w-full and adjusted padding -->
      <!-- Header Section -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="text-4xl font-bold text-gray-900">User Management</h1>
          <p class="text-gray-600 mt-1">Manage all registered users and their account details</p>
        </div>
        <button @click="showAddUserCard = true"
          class="btn flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300 ease-in-out"
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
          Add User
        </button>
        
        <!--Show card when click add user-->
        <!-- Modal Overlay -->
        <div v-if="showAddUserCard" class="fixed inset-0 bg-opacity-40 bg-base-200 flex items-center justify-center z-50">
          <!-- Card -->
          <div class="card w-full max-w-md bg-white shadow-2xl rounded-2xl border border-gray-200 overflow-hidden relative">
            <div class="card-body p-6 sm:p-8">
              <h2 class="card-title text-3xl font-bold text-gray-800 mb-6 text-center">Add New User</h2>

              <!-- Close Button -->
              <button @click="showAddUserCard = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>

              <!-- Form -->
              <form class="space-y-5" @submit.prevent="">
                <!-- Username -->
                <div class="form-control">
                  <label class="label">
                    <span class="label-text text-gray-700 font-medium">Username</span>
                  </label>
                  <input type="text" placeholder="Enter username" class="input bg-base-content input-bordered w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" required/>
                </div>

                <!-- Email -->
                <div class="form-control">
                  <label class="label">
                    <span class="label-text text-gray-700 font-medium">Email</span>
                  </label>
                  <input type="email" placeholder="Enter email" class="input bg-base-content input-bordered w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" required/>
                </div>

                <!--Password-->
                <div class="form-control">
                  <label class="label">
                    <span class="label-text text-gray-700 font-medium">Password</span>
                  </label>
                  <input type="password" placeholder="Enter Password" class="input bg-base-content input-bordered w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" required/>
                </div>

                <!--Confirm Password-->
                <div class="form-control">
                  <label class="label">
                    <span class="label-text text-gray-700 font-medium">Confirmation</span>
                  </label>
                  <input type="password" placeholder="Enter Comfirmation" class="input bg-base-content input-bordered w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" required/>
                </div>

                <!-- Submit -->
                <div class="form-control mt-6">
                  <button type="submit" class="btn btn-primary w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-300">
                    Create User
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>

      <!-- Stats Cards Section -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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
              <th>Status</th>
              <th>Joined</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- User Row -->
            <tr v-for="user in filteredUsers" :key="user.id" class=" border-b border-gray-200">
              <td>
                <div class="flex items-center gap-3">
                  <div class="avatar placeholder">
                    <div class="bg-blue-500 text-white rounded-full w-10">
                      <span class="text-sm font-medium">JD</span>
                    </div>
                  </div>
                  <div>
                    <div class="font-bold">{{ user.name }}</div>
                    <div class="text-sm opacity-50">ID: {{ user.id }}</div>
                  </div>
                </div>
              </td>
              <td>{{ user.email }}</td>
              <td>{{ user.balance }}</td>
              <td>
                <span class="badge" :class="user.status === 'active' ? 'badge-success' : 'badge-ghost'">
                      {{ user.status }}
                </span>
              </td>
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
      <div class="flex justify-end mt-4">
    <div class="flex gap-2">
      <input
        class="btn btn-square"
        type="radio"
        name="options"
        aria-label="1"
        checked="checked" />
      <input
        class="btn btn-square"
        type="radio"
        name="options"
        aria-label="2" />
      <input
        class="btn btn-square"
        type="radio"
        name="options"
        aria-label="3" />
      <input
        class="btn btn-square"
        type="radio"
        name="options"
        aria-label="4" />
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

 const { data: userCountData, error: userError } = await useFetch('http://localhost:8000/api/getAllUser', {
  key: 'all-users',
}) // call api to get user data, key: 'all-users' enables Nuxt to cache or share the request (especially useful in SSR or reactivity)

const { data: balanceData, error: balanceError } = await useFetch('http://localhost:8000/api/Balanceuser', {
  key: 'user-balance',
})

const { data: userListData, error: userListError } = await useFetch('http://localhost:8000/api/getUser', {
  key: 'user-list',
})

const allUsers = computed(() => userListData.value?.data || [])
const totalUsers = computed(() => userCountData.value?.totalUsers || 0) //Extracts the actual list of users from the data property, Defaults to an empty array if not available
const totalBalance = computed(() => balanceData.value?.totalBalance || 0)

//show the card add user
const showAddUserCard = ref('false')

// search
const searchQuery = ref('')

/* const filteredUsers = computed(() => {
  const query = searchQuery.value.toLowerCase().trim() //get the value from the input using ref
  if (!query) return allUsers.value // if empty return all list of user
  return allUsers.value.filter(user =>       //other wise filter the name email and id
    user.name.toLowerCase().includes(query) ||
    user.email.toLowerCase().includes(query) ||
    String(user.id).includes(query)
  )
}) */

onMounted(() => { // onMounted is when every component in the website is ready, then it can run
  showAddUserCard.value = false; // Ensure modal is closed after hydration
});

const statusFilter = ref('all')


const filteredUsers = computed(() => {
  const query = searchQuery.value.toLowerCase().trim()

  // Step 1: Filter by search query
  let filtered = allUsers.value.filter(user =>
    user.name.toLowerCase().includes(query) ||
    user.email.toLowerCase().includes(query) ||
    String(user.id).includes(query)
  )

  // Step 2: Filter by status
  if (statusFilter.value !== 'all') {
    filtered = filtered.filter(user => user.status === statusFilter.value) //call back funtion
  }
      return filtered
    })

</script>

<style scoped>


</style>