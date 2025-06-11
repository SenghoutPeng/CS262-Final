<template>
  <div>
    <div class="navbar bg-base-content shadow-sm">
      <div class="flex-none">
        <button class="btn btn-square btn-ghost" @click="toggleSidebar">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            class="inline-block h-5 w-5 stroke-current">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
      <div class="flex-1">
        <a class="btn btn-ghost text-xl">daisyUI</a>
      </div>
      <div class="flex-none"> <!--User profile-->
      <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img
            alt="User Avatar"
            src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
        </div>
      </div>
        <ul
          tabindex="0"
          class="menu menu-sm dropdown-content bg-base-content rounded-box z-1 mt-3 w-52 p-2 shadow">
          <li><a @click.prevent="handleLogout">Logout</a></li>
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
</script>
