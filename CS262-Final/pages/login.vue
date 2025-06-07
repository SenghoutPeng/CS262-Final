<template>
    <div>
        <form @submit.prevent="handleLogin">
            <h1>Login page</h1>
            <input type="text" v-model="FormData.email" placeholder="email"/>
            <input type="text" v-model="FormData.password" placeholder="password"/>
            <button type="submit" class="btn btn-primary w-full">Login</button>
        </form>
    </div>
</template>

<script setup>

const {login} = useSanctumAuth()

const FormData = ref({
    email: '',
    password: ''
})

definePageMeta({
    layout: 'auth', // this function include the layout into this page
    middleware: 'sanctum:guest'
})

const handleLogin = async () => {
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