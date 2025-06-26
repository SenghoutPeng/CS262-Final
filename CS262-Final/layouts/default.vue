<template>

  <div class="navbar bg-base-100 shadow-sm">
        <div class="flex-1">
            <a class="btn btn-ghost text-xl">Banana</a>
        </div>

        <div class="flex-none">
            <ul class="menu menu-horizontal px-1">
                <li @click="handleLogout"><a>logout</a></li>
            </ul>
        </div>

    </div>


    <div>

    <slot />

    </div>
</template>

<script setup>
    const  {logout} = useSanctumAuth()
    const config = useRuntimeConfig()


const handleLogout = async () => {
    await $fetch(`${config.public.baseUrl}/sanctum/csrf-cookie`, {
      credentials: 'include'
    })
  
    await logout()
  }

</script>

<style scoped>

</style>