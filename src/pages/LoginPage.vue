<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withXSRFToken = true;
axios.defaults.withCredentials = true;
const router = useRouter();

const email = ref(null);
const password = ref(null);

const login = async() => {
    const user = await axios.get('/api/user', {  
        validateStatus: function (status) {
        // Allow all status codes
            if(status == 200 || status == 401){
                return true;
            }
        }
    });
    if(user.status == 401){        
        const res = await axios.post('/api/login', {
            email: email.value,
            password: password.value
        });
        if(res.status == 200){ //logged in
            router.push('/profile')
        }
    }
    else{
        console.log('already autheticated');
        router.push('/profile')
    }   
}

</script>
<template>
<div class="">
    <div class="max-w-md border p-6 rounded mx-auto mt-12 bg-gray-50">
        <h1 class="text-2xl font-bold my-4 text-gray-800">Sign in your account</h1>
        <form class="space-y-4 md:space-y-6">
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Your email</label>
                <input v-model="email" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="email@company.com">
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input v-model="password" type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
            </div>
 
            <button @click="login" type="button" class="w-full text-white bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Sign in</button>
            
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                Don’t have an account yet? <RouterLink to="/register" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</RouterLink>
            </p>
        </form>
    </div>

</div>
</template>