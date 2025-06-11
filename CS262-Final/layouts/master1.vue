<template>
  <div class="min-h-screen bg-white text-black">
    <Navbar @toggle-sidebar="sidebarOpen = !sidebarOpen" />
    <div class="flex">
      <!-- Sidebar -->
      <transition name="slide">
        <Sidebar v-if="sidebarOpen" />
      </transition>

      <!-- Page Content -->
      <main class="flex-1 p-4">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import Navbar from '~/layouts/navbar1.vue'
import Sidebar from '~/layouts/sidebar.vue'
import { ref } from 'vue'

const sidebarOpen = ref(true)
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease, opacity 0.3s ease;
  position: absolute;
  z-index: 50;
}

.slide-enter-from {
  transform: translateX(-100%);
  opacity: 0;
}

.slide-enter-to {
  transform: translateX(0);
  opacity: 1;
}

.slide-leave-from {
  transform: translateX(0);
  opacity: 1;
}

.slide-leave-to {
  transform: translateX(-100%);
  opacity: 0;
}


</style>
