<template>
    <div>
        This is Homepage
    </div>
</template>

<script setup>
    
    definePageMeta({
        middleware: 'sanctum:auth'
    })
    
    const {
        isAuthenticated} = useSanctumAuth();
</script>

<style scoped>

</style>