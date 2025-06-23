<template>
    <form @submit.prevent="handleLogin">
      <h1>Login</h1>
      <input v-model="FormData.email" placeholder="Email" />
      <input v-model="FormData.password" placeholder="Password" type="password" />
      <button>Login</button>
    </form>
  </template>
  
  <script setup>
  const { login } = useSanctumAuth()
  const config = useRuntimeConfig()
  const FormData = ref({ email: '', password: '' })
  
  definePageMeta({
    layout: 'auth',
    middleware: 'sanctum:guest' // only allow guests to see this page
  })
  
  const handleLogin = async () => {
    await $fetch(`${config.public.baseUrl}/sanctum/csrf-cookie`, {
      credentials: 'include'
    })
  
    await login(FormData.value)
  }
  </script>
  

<style scoped>

form {
  display: flex;
  flex-direction: column; /* Stack items vertically */
  gap: 15px; /* Space between elements */
  max-width: 400px;
  margin: 50px auto; /* Center the form */
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

input[type="text"],
input[type="password"] {
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  width: 100%; /* Make inputs take full width */
  box-sizing: border-box; /* Include padding/border in width */
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

</style>