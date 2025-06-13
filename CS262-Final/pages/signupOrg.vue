<template>
    <div>
        <form @submit.prevent="handleSignUp" >
            <h1>SignUp page</h1>
            <input type="text" v-model="FormData.Org_name" placeholder="Org_name"/>
            <input type="text" v-model="FormData.Org_email" placeholder="Org_email"/>
            <input type="password" v-model="FormData.password" placeholder="password"/>
            <input type="password" v-model="FormData.password_confirmation" placeholder="password Confirmation"/>
            <input type="text" v-model="FormData.contact_name" placeholder="Contact Name">
            <input type="text" v-model="FormData.contact_phone" placeholder="Contact Phone">
            <input type="text" v-model="FormData.contact_email" placeholder="Contact Email">

            <button type="submit" class="btn btn-primary w-full">Sign Up</button>
        </form>
    </div>
</template>

<script setup>

    const {login} = useSanctumAuth()

    const client = useSanctumClient()

    const config = useRuntimeConfig()


    useHead({
        title: 'register'
    })

    const errors = ref({})

    const FormData = ref({
        email: '',
        Org_name: '',
        password_confirmation: '',
        password: '',
        contact_name: '',
        contact_phone: '',
        contact_email: ''
    })

    definePageMeta({
        layout: 'auth',
        middleware: 'sanctum:guest'
    })

    const handleSignUp = async () => {
        try{

            await client(`${config.public.baseUrl}/api/signup-org`, {
                method: 'POST',
                body: JSON.stringify(FormData.value)
            })

            await login(FormData.value)
        }catch(err){
            errors.value = err.response._data.errors
        }



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