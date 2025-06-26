<template>
    <div>
        <form @submit.prevent="handleLogin">
            <h1>Login page</h1>
            <input type="text" v-model="FormData.email" placeholder="email"/>
            <input type="text" v-model="FormData.password" placeholder="password"/>
            <input type="hidden" name="_token" value="jdhehg34gh##$$%mfu4n" />
            <button type="submit" class="btn btn-primary w-full">Login</button>
        </form>
    </div>
</template>

<script setup>
    const FormData = ref({
        email: '',
        password: ''
    })

definePageMeta({
        layout: 'auth', // this function include the layout into this page
        middleware: 'sanctum:guest'
    })

const handleLogin = async () => {
  try {
    // First get CSRF cookie
    await $fetch('http://localhost:8000/sanctum/csrf-cookie', {
      credentials: 'include', // Important to send cookies
    });

    // Now send login request with credentials included
    const response = await $fetch('http://localhost:8000/api/admin/login', {
      method: 'POST',
      body: FormData.value,
      credentials: 'include', // important to send cookies
    });

    // Save token manually if your backend returns one
    localStorage.setItem('admin_token', response.token);

    console.log('Admin logged in:', response.admin);
    navigateTo('/Admin/allusers');
  } catch (err) {
    console.error('Login failed:', err?.data?.message || err.message);
  }
};

</script>

<style scoped>
form {
  display: flex;
  flex-direction: column;
  gap: 15px;
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

input[type="text"],
input[type="password"] {
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  width: 100%;
  box-sizing: border-box;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}
</style>
