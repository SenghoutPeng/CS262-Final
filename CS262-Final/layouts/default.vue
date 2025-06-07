<template>

  <div class="navbar bg-base-100 shadow-sm">
        <div class="felx-1">
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
    
</script>

<style scoped>

</style>