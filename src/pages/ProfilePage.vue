<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withXSRFToken = true;
axios.defaults.withCredentials = true;
const router = useRouter();

const name = ref('');
const email = ref('');
const image = ref('');

const authUser = async () =>{
    const req = await axios.get('/api/user');
    if(req.status==200){
        name.value = req.data.name;
        email.value = req.data.email;
        image.value = req.data.image;
    }
}
const logout = async()=>{
    const req = await axios.post('/api/logout');
    console.log(req);
    router.push('/login');
    name.value = '';
    email.value = '';
    image.value = '';

}
onMounted(()=>{
    authUser();
});

</script>
<template>
    <div class="container mx-auto">
        <div class=" mt-12 bg-gray-200 rounded-md p-4">
            <div class="flex justify-end">
                <button @click="logout" class="bg-blue-500 p-2 text-white text-lg rounded">Log out</button>
            </div>
            <div class="w-[200px] h-[200px]  object-cover overflow-hidden rounded-xl">
                <img :src="image" alt="" class="">
            </div>
            <div class="mt-8">
                <p class="bg-gray-100 p-2 text-lg m-2 rounded-md">{{ name }}</p>
                <p class="bg-gray-100 p-2 text-lg m-2 rounded-md">{{  email }}</p>
            </div>
        </div>
        <img src="" alt="">
    </div>
</template>