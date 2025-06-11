<template>
  <aside class="w-50 bg-base-content p-4 flex flex-col shadow-md">
    <!-- User Profile -->
    <div class="flex items-center gap-4 mb-6">
      <div class="avatar">
        <div class="w-12 rounded-full">
          <img :src="images" alt="Profile" class="w-12 h-12 rounded-full object-cover" />
        </div>
      </div>
      <div>
        <h2 class="font-bold text-base text-black">Saparali</h2>
        <p class="text-sm text-gray-500">ali@gmail.com</p>
      </div>
    </div>

    <!-- Menu -->
    <ul class="menu bg-content rounded-box flex-1 text-black ">
      <li class="mb-2">
        <NuxtLink to="/siteowner/dashboard" active-class="active">
          <Icon name="grid-2x2" />
          Dashboard
        </NuxtLink>
      </li>
      <li class="mb-2">
        <NuxtLink to="/siteowner/eventrequest" active-class="active">
          <Icon name="calendar-plus" />
          Event Requests
          <span class="badge badge-sm badge-error ml-auto">1</span>
        </NuxtLink>
      </li>
      <li class="mb-2">
        <NuxtLink to="/siteowner/transaction" active-class="active">
          <Icon name="credit-card" />
          Transaction
        </NuxtLink>
      </li>
      <li class="mb-2">
        <NuxtLink to="/siteowner/activitylog" active-class="active">
          <Icon name="list" />
          Activity Log
        </NuxtLink>
      </li>
      <li class="mb-2">
        <NuxtLink to="/siteowner/allusers" active-class="active">
          <Icon name="users" />
          All Users
        </NuxtLink>
      </li>
      <li class="mb-2">
        <NuxtLink to="/siteowner/allorgs" active-class="active">
          <Icon name="shield-check" />
          All Organizers
        </NuxtLink>
      </li>
    </ul>

    <!-- Sign out -->
    <button class="btn mt-2" @click="handleLogout">
      <Icon name="log-out" />
      Sign Out
    </button>
  </aside>

  <div class=" bg-white">
    <slot />
  </div>


</template>

<script setup>
import images from '~/assets/image/images.png'

const { logout } = useSanctumAuth()
const handleLogout = async () => {
  await logout()
}
</script>

<style scoped>
/* Optional: override active link style */
.active {
  background-color: #99C6FF;
  font-weight: bold;
}

</style>
