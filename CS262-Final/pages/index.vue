<template>
    <div>
        This is Homepage
    </div>
</template>

<script setup>
    
    definePageMeta({
        middleware: ''
    })
    
    const { isAuthenticated } = useSanctumAuth();
</script>

<style scoped>

</style>