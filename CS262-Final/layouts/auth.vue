<template>
    <div class="navbar bg-base-100 shadow-sm">
        <div class="felx-1">
            <a class="btn btn-ghost text-xl">Banana</a>
        </div>

        <div class="flex-none">
            <ul class="menu menu-horizontal px-1">
                <li><NuxtLink to="/login">login</NuxtLink></li>
                <li><NuxtLink to="/SignUp">SignUp</NuxtLink></li>
                <li><NuxtLink to="/SignupOrg">Org</NuxtLink></li>
            </ul>
        </div>

    </div>

    <div class="container mx-auto p-4">
        <slot />
    </div>
</template>

<script setup>
    
</script>

<style scoped>

</style>