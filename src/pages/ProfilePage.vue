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

// user data

const reservations = ref([]);
const reviews = ref([]);

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

const getreservations = async ()=>{
    const user = await axios.get('/api/user');
    const res = await axios.post('/api/user/data/reservations', {user: user.data});
    reservations.value = await res.data;
}

const getreviews = async ()=>{
    const user = await axios.get('/api/user');
    const res = await axios.post('/api/user/data/reviews', {user: user.data});
    reviews.value = await res.data;
}

onMounted(()=>{
    authUser();
    getreservations();
    getreviews();
});

</script>
<template>
    <div class="container mx-auto">
        <div class=" mt-12 bg-gray-200 rounded-md p-4">
            <div class="flex justify-end gap-2">
                <router-link to='/'>
                    <button class="bg-blue-500 p-2 text-white text-lg rounded">Home</button>
                </router-link>
                <button @click="logout" class="bg-blue-500 p-2 text-white text-lg rounded">Log out</button>
            </div>
            <div class="w-[200px] h-[200px]  object-cover overflow-hidden rounded-xl">
                <img :src="image" alt="" class="">
            </div>
            <div class="mt-8">
                <h1 class="text-xl text-gray-500 font-bold my-6">Informations</h1>
                <p class="bg-gray-100 p-2 text-lg m-2 rounded-md">{{ name }}</p>
                <p class="bg-gray-100 p-2 text-lg m-2 rounded-md">{{  email }}</p>
            </div>
            <h1 class="text-xl text-gray-500 font-bold my-6">Reservations</h1>
            <table class="table-auto w-full border-collapse border border-slate-500">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="border border-slate-500 text-white text-lg py-1 w-16">ID</th>
                        <th class="border border-slate-500 text-white text-lg py-1">Pick</th>
                        <th class="border border-slate-500 text-white text-lg py-1">Drop</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr v-for="(item, index) in reservations" class="hover:bg-gray-50">
                        <!-- id -->
                        <td class="border border-slate-500 text-center">
                            {{  index + 1  }}
                        </td>
                        <!-- pick -->
                        <td class="border border-slate-500">
                            <div class="flex justify-between p-4">
                                <div class="">Location</div>
                                <div>
                                    <span class="ms-10">{{ item.pick }}</span>
                                </div>
                            </div>
                            <div class="flex justify-between border border-white border-t-slate-700 p-4">
                                <div class="">Date</div>
                                <div>
                                    <span class="ms-10">{{ item.start_time }}</span>
                                </div>
                            </div>
                        </td>
                        <!-- drop -->
                        <td class="border border-slate-500">
                            <div class="flex justify-between p-4">
                                <div class="">Location</div>
                                <div>
                                    <span class="ms-10">{{ item.drop }}</span>
                                </div>
                            </div>
                            <div class="flex justify-between border border-white border-t-slate-700 p-4">
                                <div class="">Date</div>
                                <div>
                                    <span class="ms-10">{{ item.end_time }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <h1 class="text-xl text-gray-500 font-bold my-6">Reviews</h1>
               <table class="table-auto w-full border-collapse border border-slate-500">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="border border-slate-500 text-white text-lg py-2 w-16">ID</th>
                        <th class="border border-slate-500 text-white text-lg py-2">car_id</th>
                        <th class="border border-slate-500 text-white text-lg py-2">review</th>
                        <th class="border border-slate-500 text-white text-lg py-2">stars</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr v-for="(item, index) in reviews" class="hover:bg-gray-50">
                        <td class="border border-slate-500 p-1 text-center">
                            {{ index+1 }}
                        </td>
                        <td class="border border-slate-500 p-1 text-center">
                            {{ item.car_id }}
                        </td>
                        <td class="border border-slate-500 p-1">
                            {{ item.review }}
                        </td>
                        <td class="border border-slate-500 p-1">
                            {{ item.stars }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <h1 class="text-xl text-gray-500 font-bold my-6">Payments</h1>

        </div>
        <img src="" alt="">
    </div>
</template>