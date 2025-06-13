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
          <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
            <div class="w-10 rounded-full">
              <img alt="User Avatar"
                   src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
            </div>
          </div>

          <ul
            tabindex="0"
            class="menu menu-sm dropdown-content bg-base-200 rounded-box z-10 mt-3 w-52 p-2 shadow">
            <li><a @click.prevent="handleLogout" class="text-white">Logout</a></li>
            <li>

              <label class="swap swap-rotate">
                <input type="checkbox" class="theme-controller" value="dark" @change="toggleTheme" />

                <!-- Sun icon -->
                <svg class="swap-off h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24" fill="white">
                  <path
                    d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41...Z" />
                </svg>

                <!-- Moon icon -->
                <svg class="swap-on h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24" fill="white">
                  <path
                    d="M21.64,13a1,1,0,0,0-1.05-.14...Z" />
                </svg>
              </label>
              
            </li>
          </ul>
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

const { logout } = useSanctumAuth()
const handleLogout = async () => {
  await logout()
}

import { onMounted } from 'vue'

const toggleTheme = (event) => {
  const isDark = event.target.checked
  const html = document.documentElement
  const theme = isDark ? 'dark' : 'light'
  html.setAttribute('data-theme', theme)
  localStorage.setItem('theme', theme)
}

onMounted(() => {
  const savedTheme = localStorage.getItem('theme') || 'light'
  document.documentElement.setAttribute('data-theme', savedTheme)

  const checkbox = document.querySelector('.theme-controller')
  if (checkbox) checkbox.checked = savedTheme === 'dark'
})
</script>
