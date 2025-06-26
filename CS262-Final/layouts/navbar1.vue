<template>
  <div>
    <div class="navbar bg-base-content shadow-sm flex flex-wrap justify-between px-4">
      <!-- Sidebar Toggle -->
      <div class="flex items-center gap-2">
        <button class="btn btn-square btn-ghost" @click="toggleSidebar">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            class="inline-block h-5 w-5 stroke-current">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <a href="Dashboard" class="btn btn-ghost normal-case text-xl hidden sm:inline-block">Banana</a>
      </div>

      <!-- Right-side: Avatar and Theme Toggle -->
      <div class="flex items-center gap-2">
        <div class="dropdown dropdown-end">
          <button class="btn mt-2" @click="handleLogout">
            <Icon name="log-out" />
            Sign Out
            </button>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const emit = defineEmits(['toggle-sidebar'])

const toggleSidebar = () => {
  emit('toggle-sidebar')
}

const handleLogout = async () => {
  try {
    // Get CSRF cookie
    await $fetch(`${config.public.baseUrl}/sanctum/csrf-cookie`, {
      credentials: 'include'
    })

    // Logout request
    await $fetch(`${config.public.baseUrl}/api/logout`, {
      method: 'POST',
      credentials: 'include'
    })

    // Redirect to login page or clear user state
    // Example: navigateTo('/login')
  } catch (error) {
    console.error('Logout failed:', error)
  }
}


</script>
