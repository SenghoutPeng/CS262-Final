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
        <h2 class="font-bold text-base text-black">{{ profile.name }}</h2>
        <p class="text-sm text-gray-500">{{ profile.email }}</p>
      </div>
    </div>

    <!-- Menu -->
    <ul class="menu bg-content rounded-box flex-1 text-black ">
      <li class="mb-2">
        <NuxtLink to="/Admin/dashboard" active-class="active">
          <Icon name="grid-2x2" />
          Dashboard
        </NuxtLink>
      </li>
      <li class="mb-2">
        <NuxtLink to="/Admin/eventrequest" active-class="active">
          <Icon name="calendar-plus" />
          Event Requests
          <span class="badge badge-sm badge-error ml-auto">1</span>
        </NuxtLink>
      </li>
      <li class="mb-2">
        <NuxtLink to="/Admin/transaction" active-class="active">
          <Icon name="credit-card" />
          Transaction
        </NuxtLink>
      </li>
      <li class="mb-2">
        <NuxtLink to="/Admin/activitylog" active-class="active">
          <Icon name="list" />
          Activity Log
        </NuxtLink>
      </li>
      <li class="mb-2">
        <NuxtLink to="/Admin/allusers" active-class="active">
          <Icon name="users" />
          All Users
        </NuxtLink>
      </li>
      <li class="mb-2">
        <NuxtLink to="/Admin/allorgs" active-class="active">
          <Icon name="shield-check" />
          All Organizers
        </NuxtLink>
      </li>
    </ul>

  </aside>

  <div class=" bg-white">
    <slot />
  </div>


</template>

<script setup>
import { onMounted, ref } from 'vue'
import images from '~/assets/image/images.png'
import { useSanctumAuth } from '#imports'

const profile = ref({
  name: '',
  email: '',
  image: ''
})


onMounted(async () => {
  try {
    const res = await $fetch('http://localhost:8000/api/admin/profile', {
      credentials: 'include'
    })
    profile.value = {
      name: res.name,
      email: res.email,
      image: res.image || images // fallback to default image
    }
  } catch (error) {
    console.error('Failed to fetch profile:', error)
  }
})
</script>

<style scoped>
/* Optional: override active link style */
.active {
  background-color: #99C6FF;
  font-weight: bold;
}

</style>
