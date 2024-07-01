<script setup>
import { reactive, ref, watch , onMounted} from 'vue';
import { useRoute } from 'vue-router';
import carcardView from '../components/carcardView.vue';
import { useFetch } from '@/combosables/fetch';
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/swiper-bundle.css';
// import 'swiper/css/navigation';
import 'swiper/css/pagination';
import axios from 'axios';
axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withXSRFToken = true;
axios.defaults.withCredentials = true;
const route = useRoute();

// side
// loading states
const review_load = ref(true);
const dataDetail_load = ref(true);
// end of loading states
// error
const error_message = ref('');
const hideErrorMessage = ref(true);
// end error
const type = reactive({
    'sport': false,
    'suv': false,
    'mpv': false,
    'sedan': false,
    'coupe': false,
    'hatchback': false
});

const capacity = reactive({
    'x2': false,
    'x4': false,
    'x6': false,
    'x8': false,
});

const data = ref([]);
const dataDetail = ref([]);
const dataFilter = ref([]);

const priceFilter = ref(50);

const init_type = route.query.type;
const init_capacity = route.query.capacity;
type[init_type] = true;
capacity[`x${init_capacity}`] = true;

// modal reviews
const stars = ref([]);
const review = ref('');
//user 
const user = ref('');
const profileImage = ref('');
//
const reviews = ref([]);

const addStar = (n)=>{
    stars.value = [];
    if(!stars.value.includes(n)){
        for(let i = 1 ; i <= n ; i++){
            stars.value.push(i);
        }
        stars.value.splice(n, stars.value.length - n);
    }
};

const getSideData = async ()=>{
    try{
        const res = await axios.get('/api/v1/category/data');
        data.value = await res.data;
    }
    catch(e){
        hideErrorMessage.value = false;
        error_message.value = 'Status' +' '+ e.response.status + ' Side Data.';
    }
};

const getDetailData = async (id)=>{
    try{
        const res = await axios.get(`/api/v1/detail/${id}`);
        dataDetail.value = await res.data;
        dataDetail_load.value = false;
    }
    catch(e){
        hideErrorMessage.value = false;
        error_message.value = 'Status' +' '+ e.response.status + ' Detail Data.';
    }
}

const filter = async () =>{
    try{
        const filteredType = [];
        const filteredCapacity = [];
        for(const [key, value] of Object.entries(type)){
            if(value === true){
                filteredType.push(key)
            }
        }
    
        for(const [key, value] of Object.entries(capacity)){
            if(value === true){
                filteredCapacity.push(key.replace('x',''))
            }
        }
        const res = await axios.post(
            '/api/v1/detail/filter',
            {
                'type': filteredType, 
                'capacity': filteredCapacity,
                'price': priceFilter.value
            },
        );
        
        dataFilter.value = await res.data;
    }
    catch(e){
        hideErrorMessage.value = false;
        error_message.value = 'Status' +' '+ e.response.status + ' Cars Filter.';
    }
}

const getUser = async() =>{
    try{
        const res = await axios.get('/api/user');
        user.value = await res.data.name;
        profileImage.value = await res.data.image;
    }
    catch(e){
        hideErrorMessage.value = false;
        error_message.value = 'Status' +' '+ e.response.status + ' User.';
    }
}

const getReviews = async ()=>{
    try{
        const route = useRoute();
        const car_id = route.params.id;
        console.log(car_id)
        const user = await axios.get('/api/user');
        const res = await axios.post('/api/user/data/reviews', {user: user.data, car_id: car_id});
        reviews.value = await res.data;
        review_load.value = false;
    }
    catch(e){
        // hideErrorMessage.value = false;
        // error_message.value = 'Status' +' '+ e.response.status + ' Reviews.';
    }
}

onMounted(()=>{
    const id = route.params.id;
    // side
    getSideData();
    //detail
    getDetailData(id);
    //getuser
    getUser();
    //get review
    getReviews();
});

watch([type, capacity, priceFilter], ()=>{
    filter()
},
{ immediate: true });

// side


const descriptionClick = ref(false);

const sendReview = async() =>{
    try{
        let starsCount = stars.value.length ? stars.value[stars.value.length-1] : 0 ;
        const user = await axios.get('/api/user');
        const res = await axios.post('/api/user/data/make/review',
        {
            'car_id': route.params.id,
            'user': user.data,
            'review': review.value,
            'stars': starsCount,
        });
        // console.log(res.data);
        hideErrorMessage.value = false;
        error_message.value = 'Review Sent';
    }
    catch(e){
        hideErrorMessage.value = false;
        error_message.value = 'Status' +' '+ e.response.status + ' Send Reviews.';
    }
}
// modal
const modal = ref(false);

</script>
<template>
  <div class="bg-white">
      <div class="xl:container mx-auto relative">
        <!-- toast measage -->
         <div class="flex justify-end p-1">
             <div v-if="!hideErrorMessage" id="toast-undo" class="bg-gray-800 flex items-center w-full max-w-xs p-4 text-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
                 <div class="text-sm font-normal">
                 {{ error_message }}
                 </div>
                 <div class="flex items-center ms-auto space-x-2 rtl:space-x-reverse">
                     <button @click="hideErrorMessage = true" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-undo" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                 </div>
             </div>
         </div>
        <!-- modal -->
        <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-1/2 max-h-1/2 z-50" :class="{'hidden': !modal}">
            <div class="bg-gray-100 p-8 rounded-lg border shadow">
                <div class="flex justify-end">
                    <button @click="modal=false"><svg class="w-8 h-8" fill="gray" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M443.6,387.1L312.4,255.4l131.5-130c5.4-5.4,5.4-14.2,0-19.6l-37.4-37.6c-2.6-2.6-6.1-4-9.8-4c-3.7,0-7.2,1.5-9.8,4  L256,197.8L124.9,68.3c-2.6-2.6-6.1-4-9.8-4c-3.7,0-7.2,1.5-9.8,4L68,105.9c-5.4,5.4-5.4,14.2,0,19.6l131.5,130L68.4,387.1  c-2.6,2.6-4.1,6.1-4.1,9.8c0,3.7,1.4,7.2,4.1,9.8l37.4,37.6c2.7,2.7,6.2,4.1,9.8,4.1c3.5,0,7.1-1.3,9.8-4.1L256,313.1l130.7,131.1  c2.7,2.7,6.2,4.1,9.8,4.1c3.5,0,7.1-1.3,9.8-4.1l37.4-37.6c2.6-2.6,4.1-6.1,4.1-9.8C447.7,393.2,446.2,389.7,443.6,387.1z"/></svg></button>
                </div>
                <div class="flex my-6">
                    <div class="flex-shrink-0">
                        <img :src="profileImage" alt="" class="w-12 h-12 rounded-full">
                    </div>
                    <div class="flex-grow px-4">
                        <div>
                            <h3 class="text-gray-800 font-bold text-xl">{{ user }}</h3>
                        </div>
                        <div class="flex justify-between">
                            <h4 class="text-gray-400 text-sm">User</h4>
                        </div>
                    </div>
                </div>
                <textarea v-model="review" rows="5" class="block w-full p-2 rounded-md focus:outline-1 focus:border-gray-100 border focus:outline-gray-200 text-gray-800" placeholder="Review here!"></textarea>
                <div class="flex justify-between items-end">
                    <div>
                        <h5 class="mt-4 text-lg text-gray-800 font-bold">RATE</h5>
                        <div class="flex items-center">
                            <div class="flex">
                                <div class="m-1" @click="addStar(1)">
                                    <svg class="w-6 h-6" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path v-if="stars.includes(1)" fill-rule="evenodd" clip-rule="evenodd" d="M9.16676 2.65838C9.22433 2.47584 9.33858 2.31641 9.49294 2.20324C9.64729 2.09007 9.8337 2.02905 10.0251 2.02905C10.2165 2.02905 10.4029 2.09007 10.5573 2.20324C10.7116 2.31641 10.8259 2.47584 10.8834 2.65838L12.4334 7.42505H17.4334C17.6317 7.41755 17.8269 7.47516 17.9893 7.58908C18.1517 7.70299 18.2724 7.86695 18.3329 8.05589C18.3933 8.24484 18.3903 8.44838 18.3242 8.63542C18.2581 8.82247 18.1325 8.98273 17.9668 9.09171L13.9084 12.0334L15.4584 16.8084C15.5197 16.9903 15.5213 17.187 15.4628 17.3698C15.4044 17.5526 15.2891 17.712 15.1336 17.8246C14.9782 17.9372 14.7908 17.9972 14.5989 17.9958C14.407 17.9944 14.2205 17.9316 14.0668 17.8167L10.0001 14.8417L5.94176 17.7917C5.78802 17.9066 5.60157 17.9694 5.40963 17.9708C5.2177 17.9722 5.03034 17.9122 4.87491 17.7996C4.71948 17.687 4.60412 17.5276 4.54569 17.3448C4.48725 17.162 4.4888 16.9653 4.5501 16.7834L6.1001 12.0084L2.04176 9.06671C1.876 8.95773 1.75047 8.79747 1.68437 8.61042C1.61826 8.42338 1.6152 8.21984 1.67566 8.03089C1.73612 7.84195 1.85678 7.67799 2.0192 7.56408C2.18161 7.45016 2.37686 7.39255 2.5751 7.40005H7.5751L9.16676 2.65838Z" fill="#FBAD39"/>
                                        <path v-else fill-rule="evenodd" clip-rule="evenodd" d="M9.16676 2.65838C9.22433 2.47584 9.33858 2.31641 9.49294 2.20324C9.64729 2.09007 9.8337 2.02905 10.0251 2.02905C10.2165 2.02905 10.4029 2.09007 10.5573 2.20324C10.7116 2.31641 10.8259 2.47584 10.8834 2.65838L12.4334 7.42505H17.4334C17.6317 7.41755 17.8269 7.47516 17.9893 7.58908C18.1517 7.70299 18.2724 7.86695 18.3329 8.05589C18.3933 8.24484 18.3903 8.44838 18.3242 8.63542C18.2581 8.82247 18.1325 8.98273 17.9668 9.09171L13.9084 12.0334L15.4584 16.8084C15.5197 16.9903 15.5213 17.187 15.4628 17.3698C15.4044 17.5526 15.2891 17.712 15.1336 17.8246C14.9782 17.9372 14.7908 17.9972 14.5989 17.9958C14.407 17.9944 14.2205 17.9316 14.0668 17.8167L10.0001 14.8417L5.94176 17.7917C5.78802 17.9066 5.60157 17.9694 5.40963 17.9708C5.2177 17.9722 5.03034 17.9122 4.87491 17.7996C4.71948 17.687 4.60412 17.5276 4.54569 17.3448C4.48725 17.162 4.4888 16.9653 4.5501 16.7834L6.1001 12.0084L2.04176 9.06671C1.876 8.95773 1.75047 8.79747 1.68437 8.61042C1.61826 8.42338 1.6152 8.21984 1.67566 8.03089C1.73612 7.84195 1.85678 7.67799 2.0192 7.56408C2.18161 7.45016 2.37686 7.39255 2.5751 7.40005H7.5751L9.16676 2.65838Z" stroke="#90A3BF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="m-1" @click="addStar(2)">
                                    <svg class="w-6 h-6" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path v-if="stars.includes(2)" fill-rule="evenodd" clip-rule="evenodd" d="M9.16676 2.65838C9.22433 2.47584 9.33858 2.31641 9.49294 2.20324C9.64729 2.09007 9.8337 2.02905 10.0251 2.02905C10.2165 2.02905 10.4029 2.09007 10.5573 2.20324C10.7116 2.31641 10.8259 2.47584 10.8834 2.65838L12.4334 7.42505H17.4334C17.6317 7.41755 17.8269 7.47516 17.9893 7.58908C18.1517 7.70299 18.2724 7.86695 18.3329 8.05589C18.3933 8.24484 18.3903 8.44838 18.3242 8.63542C18.2581 8.82247 18.1325 8.98273 17.9668 9.09171L13.9084 12.0334L15.4584 16.8084C15.5197 16.9903 15.5213 17.187 15.4628 17.3698C15.4044 17.5526 15.2891 17.712 15.1336 17.8246C14.9782 17.9372 14.7908 17.9972 14.5989 17.9958C14.407 17.9944 14.2205 17.9316 14.0668 17.8167L10.0001 14.8417L5.94176 17.7917C5.78802 17.9066 5.60157 17.9694 5.40963 17.9708C5.2177 17.9722 5.03034 17.9122 4.87491 17.7996C4.71948 17.687 4.60412 17.5276 4.54569 17.3448C4.48725 17.162 4.4888 16.9653 4.5501 16.7834L6.1001 12.0084L2.04176 9.06671C1.876 8.95773 1.75047 8.79747 1.68437 8.61042C1.61826 8.42338 1.6152 8.21984 1.67566 8.03089C1.73612 7.84195 1.85678 7.67799 2.0192 7.56408C2.18161 7.45016 2.37686 7.39255 2.5751 7.40005H7.5751L9.16676 2.65838Z" fill="#FBAD39"/>
                                        <path v-else fill-rule="evenodd" clip-rule="evenodd" d="M9.16676 2.65838C9.22433 2.47584 9.33858 2.31641 9.49294 2.20324C9.64729 2.09007 9.8337 2.02905 10.0251 2.02905C10.2165 2.02905 10.4029 2.09007 10.5573 2.20324C10.7116 2.31641 10.8259 2.47584 10.8834 2.65838L12.4334 7.42505H17.4334C17.6317 7.41755 17.8269 7.47516 17.9893 7.58908C18.1517 7.70299 18.2724 7.86695 18.3329 8.05589C18.3933 8.24484 18.3903 8.44838 18.3242 8.63542C18.2581 8.82247 18.1325 8.98273 17.9668 9.09171L13.9084 12.0334L15.4584 16.8084C15.5197 16.9903 15.5213 17.187 15.4628 17.3698C15.4044 17.5526 15.2891 17.712 15.1336 17.8246C14.9782 17.9372 14.7908 17.9972 14.5989 17.9958C14.407 17.9944 14.2205 17.9316 14.0668 17.8167L10.0001 14.8417L5.94176 17.7917C5.78802 17.9066 5.60157 17.9694 5.40963 17.9708C5.2177 17.9722 5.03034 17.9122 4.87491 17.7996C4.71948 17.687 4.60412 17.5276 4.54569 17.3448C4.48725 17.162 4.4888 16.9653 4.5501 16.7834L6.1001 12.0084L2.04176 9.06671C1.876 8.95773 1.75047 8.79747 1.68437 8.61042C1.61826 8.42338 1.6152 8.21984 1.67566 8.03089C1.73612 7.84195 1.85678 7.67799 2.0192 7.56408C2.18161 7.45016 2.37686 7.39255 2.5751 7.40005H7.5751L9.16676 2.65838Z" stroke="#90A3BF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="m-1" @click="addStar(3)">
                                    <svg class="w-6 h-6" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path v-if="stars.includes(3)" fill-rule="evenodd" clip-rule="evenodd" d="M9.16676 2.65838C9.22433 2.47584 9.33858 2.31641 9.49294 2.20324C9.64729 2.09007 9.8337 2.02905 10.0251 2.02905C10.2165 2.02905 10.4029 2.09007 10.5573 2.20324C10.7116 2.31641 10.8259 2.47584 10.8834 2.65838L12.4334 7.42505H17.4334C17.6317 7.41755 17.8269 7.47516 17.9893 7.58908C18.1517 7.70299 18.2724 7.86695 18.3329 8.05589C18.3933 8.24484 18.3903 8.44838 18.3242 8.63542C18.2581 8.82247 18.1325 8.98273 17.9668 9.09171L13.9084 12.0334L15.4584 16.8084C15.5197 16.9903 15.5213 17.187 15.4628 17.3698C15.4044 17.5526 15.2891 17.712 15.1336 17.8246C14.9782 17.9372 14.7908 17.9972 14.5989 17.9958C14.407 17.9944 14.2205 17.9316 14.0668 17.8167L10.0001 14.8417L5.94176 17.7917C5.78802 17.9066 5.60157 17.9694 5.40963 17.9708C5.2177 17.9722 5.03034 17.9122 4.87491 17.7996C4.71948 17.687 4.60412 17.5276 4.54569 17.3448C4.48725 17.162 4.4888 16.9653 4.5501 16.7834L6.1001 12.0084L2.04176 9.06671C1.876 8.95773 1.75047 8.79747 1.68437 8.61042C1.61826 8.42338 1.6152 8.21984 1.67566 8.03089C1.73612 7.84195 1.85678 7.67799 2.0192 7.56408C2.18161 7.45016 2.37686 7.39255 2.5751 7.40005H7.5751L9.16676 2.65838Z" fill="#FBAD39"/>
                                        <path v-else fill-rule="evenodd" clip-rule="evenodd" d="M9.16676 2.65838C9.22433 2.47584 9.33858 2.31641 9.49294 2.20324C9.64729 2.09007 9.8337 2.02905 10.0251 2.02905C10.2165 2.02905 10.4029 2.09007 10.5573 2.20324C10.7116 2.31641 10.8259 2.47584 10.8834 2.65838L12.4334 7.42505H17.4334C17.6317 7.41755 17.8269 7.47516 17.9893 7.58908C18.1517 7.70299 18.2724 7.86695 18.3329 8.05589C18.3933 8.24484 18.3903 8.44838 18.3242 8.63542C18.2581 8.82247 18.1325 8.98273 17.9668 9.09171L13.9084 12.0334L15.4584 16.8084C15.5197 16.9903 15.5213 17.187 15.4628 17.3698C15.4044 17.5526 15.2891 17.712 15.1336 17.8246C14.9782 17.9372 14.7908 17.9972 14.5989 17.9958C14.407 17.9944 14.2205 17.9316 14.0668 17.8167L10.0001 14.8417L5.94176 17.7917C5.78802 17.9066 5.60157 17.9694 5.40963 17.9708C5.2177 17.9722 5.03034 17.9122 4.87491 17.7996C4.71948 17.687 4.60412 17.5276 4.54569 17.3448C4.48725 17.162 4.4888 16.9653 4.5501 16.7834L6.1001 12.0084L2.04176 9.06671C1.876 8.95773 1.75047 8.79747 1.68437 8.61042C1.61826 8.42338 1.6152 8.21984 1.67566 8.03089C1.73612 7.84195 1.85678 7.67799 2.0192 7.56408C2.18161 7.45016 2.37686 7.39255 2.5751 7.40005H7.5751L9.16676 2.65838Z" stroke="#90A3BF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="m-1" @click="addStar(4)">
                                    <svg class="w-6 h-6" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path v-if="stars.includes(4)" fill-rule="evenodd" clip-rule="evenodd" d="M9.16676 2.65838C9.22433 2.47584 9.33858 2.31641 9.49294 2.20324C9.64729 2.09007 9.8337 2.02905 10.0251 2.02905C10.2165 2.02905 10.4029 2.09007 10.5573 2.20324C10.7116 2.31641 10.8259 2.47584 10.8834 2.65838L12.4334 7.42505H17.4334C17.6317 7.41755 17.8269 7.47516 17.9893 7.58908C18.1517 7.70299 18.2724 7.86695 18.3329 8.05589C18.3933 8.24484 18.3903 8.44838 18.3242 8.63542C18.2581 8.82247 18.1325 8.98273 17.9668 9.09171L13.9084 12.0334L15.4584 16.8084C15.5197 16.9903 15.5213 17.187 15.4628 17.3698C15.4044 17.5526 15.2891 17.712 15.1336 17.8246C14.9782 17.9372 14.7908 17.9972 14.5989 17.9958C14.407 17.9944 14.2205 17.9316 14.0668 17.8167L10.0001 14.8417L5.94176 17.7917C5.78802 17.9066 5.60157 17.9694 5.40963 17.9708C5.2177 17.9722 5.03034 17.9122 4.87491 17.7996C4.71948 17.687 4.60412 17.5276 4.54569 17.3448C4.48725 17.162 4.4888 16.9653 4.5501 16.7834L6.1001 12.0084L2.04176 9.06671C1.876 8.95773 1.75047 8.79747 1.68437 8.61042C1.61826 8.42338 1.6152 8.21984 1.67566 8.03089C1.73612 7.84195 1.85678 7.67799 2.0192 7.56408C2.18161 7.45016 2.37686 7.39255 2.5751 7.40005H7.5751L9.16676 2.65838Z" fill="#FBAD39"/>
                                        <path v-else fill-rule="evenodd" clip-rule="evenodd" d="M9.16676 2.65838C9.22433 2.47584 9.33858 2.31641 9.49294 2.20324C9.64729 2.09007 9.8337 2.02905 10.0251 2.02905C10.2165 2.02905 10.4029 2.09007 10.5573 2.20324C10.7116 2.31641 10.8259 2.47584 10.8834 2.65838L12.4334 7.42505H17.4334C17.6317 7.41755 17.8269 7.47516 17.9893 7.58908C18.1517 7.70299 18.2724 7.86695 18.3329 8.05589C18.3933 8.24484 18.3903 8.44838 18.3242 8.63542C18.2581 8.82247 18.1325 8.98273 17.9668 9.09171L13.9084 12.0334L15.4584 16.8084C15.5197 16.9903 15.5213 17.187 15.4628 17.3698C15.4044 17.5526 15.2891 17.712 15.1336 17.8246C14.9782 17.9372 14.7908 17.9972 14.5989 17.9958C14.407 17.9944 14.2205 17.9316 14.0668 17.8167L10.0001 14.8417L5.94176 17.7917C5.78802 17.9066 5.60157 17.9694 5.40963 17.9708C5.2177 17.9722 5.03034 17.9122 4.87491 17.7996C4.71948 17.687 4.60412 17.5276 4.54569 17.3448C4.48725 17.162 4.4888 16.9653 4.5501 16.7834L6.1001 12.0084L2.04176 9.06671C1.876 8.95773 1.75047 8.79747 1.68437 8.61042C1.61826 8.42338 1.6152 8.21984 1.67566 8.03089C1.73612 7.84195 1.85678 7.67799 2.0192 7.56408C2.18161 7.45016 2.37686 7.39255 2.5751 7.40005H7.5751L9.16676 2.65838Z" stroke="#90A3BF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="m-1" @click="addStar(5)">
                                    <svg class="w-6 h-6" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path v-if="stars.includes(5)" fill-rule="evenodd" clip-rule="evenodd" d="M9.16676 2.65838C9.22433 2.47584 9.33858 2.31641 9.49294 2.20324C9.64729 2.09007 9.8337 2.02905 10.0251 2.02905C10.2165 2.02905 10.4029 2.09007 10.5573 2.20324C10.7116 2.31641 10.8259 2.47584 10.8834 2.65838L12.4334 7.42505H17.4334C17.6317 7.41755 17.8269 7.47516 17.9893 7.58908C18.1517 7.70299 18.2724 7.86695 18.3329 8.05589C18.3933 8.24484 18.3903 8.44838 18.3242 8.63542C18.2581 8.82247 18.1325 8.98273 17.9668 9.09171L13.9084 12.0334L15.4584 16.8084C15.5197 16.9903 15.5213 17.187 15.4628 17.3698C15.4044 17.5526 15.2891 17.712 15.1336 17.8246C14.9782 17.9372 14.7908 17.9972 14.5989 17.9958C14.407 17.9944 14.2205 17.9316 14.0668 17.8167L10.0001 14.8417L5.94176 17.7917C5.78802 17.9066 5.60157 17.9694 5.40963 17.9708C5.2177 17.9722 5.03034 17.9122 4.87491 17.7996C4.71948 17.687 4.60412 17.5276 4.54569 17.3448C4.48725 17.162 4.4888 16.9653 4.5501 16.7834L6.1001 12.0084L2.04176 9.06671C1.876 8.95773 1.75047 8.79747 1.68437 8.61042C1.61826 8.42338 1.6152 8.21984 1.67566 8.03089C1.73612 7.84195 1.85678 7.67799 2.0192 7.56408C2.18161 7.45016 2.37686 7.39255 2.5751 7.40005H7.5751L9.16676 2.65838Z" fill="#FBAD39"/>
                                        <path v-else fill-rule="evenodd" clip-rule="evenodd" d="M9.16676 2.65838C9.22433 2.47584 9.33858 2.31641 9.49294 2.20324C9.64729 2.09007 9.8337 2.02905 10.0251 2.02905C10.2165 2.02905 10.4029 2.09007 10.5573 2.20324C10.7116 2.31641 10.8259 2.47584 10.8834 2.65838L12.4334 7.42505H17.4334C17.6317 7.41755 17.8269 7.47516 17.9893 7.58908C18.1517 7.70299 18.2724 7.86695 18.3329 8.05589C18.3933 8.24484 18.3903 8.44838 18.3242 8.63542C18.2581 8.82247 18.1325 8.98273 17.9668 9.09171L13.9084 12.0334L15.4584 16.8084C15.5197 16.9903 15.5213 17.187 15.4628 17.3698C15.4044 17.5526 15.2891 17.712 15.1336 17.8246C14.9782 17.9372 14.7908 17.9972 14.5989 17.9958C14.407 17.9944 14.2205 17.9316 14.0668 17.8167L10.0001 14.8417L5.94176 17.7917C5.78802 17.9066 5.60157 17.9694 5.40963 17.9708C5.2177 17.9722 5.03034 17.9122 4.87491 17.7996C4.71948 17.687 4.60412 17.5276 4.54569 17.3448C4.48725 17.162 4.4888 16.9653 4.5501 16.7834L6.1001 12.0084L2.04176 9.06671C1.876 8.95773 1.75047 8.79747 1.68437 8.61042C1.61826 8.42338 1.6152 8.21984 1.67566 8.03089C1.73612 7.84195 1.85678 7.67799 2.0192 7.56408C2.18161 7.45016 2.37686 7.39255 2.5751 7.40005H7.5751L9.16676 2.65838Z" stroke="#90A3BF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-2">
                        <button @click="sendReview" class="bg-blue-500 text-white text-lg rounded-md py-2 px-4">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <!-- side -->
            <div class="xl:grid grid-cols-12">
                <div class="hidden xl:block col-start-1 col-span-3 bg-white py-6 px-10">
                    <h3 class="text-sm text-gray-400">TYPE</h3>
                    <ul class="p-3">
                        <li>
                            <div class="flex items-center my-4">
                                <input type="checkbox" v-model="type.sport" class="w-4 h-4 text-blue-600 rounded ring-offset-2 focus:ring-2 focus:ring-blue-500" id="one">
                                <label for="one" class="ms-2 text-gray-600 font-semibold">Sport</label>
                                <p v-if="data.length" class="ms-1 text-sm text-gray-400">({{ data[0][0] }})</p>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center my-4">
                                <input type="checkbox" v-model="type.suv" class="w-4 h-4 text-blue-600 rounded ring-offset-2 focus:ring-2 focus:ring-blue-500" id="one">
                                <label for="one" class="ms-2 text-gray-600 font-semibold">SUV</label>
                                <p v-if="data.length" class="ms-1 text-sm text-gray-400">({{ data[0][1] }})</p>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center my-4">
                                <input type="checkbox" v-model="type.mpv" class="w-4 h-4 text-blue-600 rounded ring-offset-2 focus:ring-2 focus:ring-blue-500" id="one">
                                <label for="one" class="ms-2 text-gray-600 font-semibold">MPV</label>
                                <p v-if="data.length" class="ms-1 text-sm text-gray-400">({{ data[0][2] }})</p>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center my-4">
                                <input type="checkbox" v-model="type.sedan" class="w-4 h-4 text-blue-600 rounded ring-offset-2 focus:ring-2 focus:ring-blue-500" id="one">
                                <label for="one" class="ms-2 text-gray-600 font-semibold">Sedan</label>
                                <p v-if="data.length" class="ms-1 text-sm text-gray-400">({{ data[0][3] }})</p>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center my-4">
                                <input type="checkbox" v-model="type.coupe" class="w-4 h-4 text-blue-600 rounded ring-offset-2 focus:ring-2 focus:ring-blue-500" id="one">
                                <label for="one" class="ms-2 text-gray-600 font-semibold">Coupe</label>
                                <p v-if="data.length" class="ms-1 text-sm text-gray-400">({{ data[0][4] }})</p>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center my-4">
                                <input type="checkbox" v-model="type.hatchback" class="w-4 h-4 text-blue-600 rounded ring-offset-2 focus:ring-2 focus:ring-blue-500" id="one">
                                <label for="one" class="ms-2 text-gray-600 font-semibold">Hatchback</label>
                                <p v-if="data.length" class="ms-1 text-sm text-gray-400">({{ data[0][5] }})</p>
                            </div>
                        </li>
                    </ul>
                    <h3 class="text-sm text-gray-400 mt-2">CAPACITY</h3>
                    <ul class="p-3">
                        <li>
                            <div class="flex items-center my-4">
                                <input type="checkbox" v-model="capacity.x2" class="w-4 h-4 text-blue-600 rounded ring-offset-2 focus:ring-2 focus:ring-blue-500" id="one">
                                <label for="one" class="ms-2 text-gray-600 font-semibold">2 Person</label>
                                <p v-if="data.length" class="ms-1 text-sm text-gray-400">({{ data[1][0] }})</p>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center my-4">
                                <input type="checkbox"  v-model="capacity.x4" class="w-4 h-4 text-blue-600 rounded ring-offset-2 focus:ring-2 focus:ring-blue-500" id="one">
                                <label for="one" class="ms-2 text-gray-600 font-semibold">4 Person</label>
                                <p v-if="data.length" class="ms-1 text-sm text-gray-400">({{ data[1][1] }})</p>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center my-4">
                                <input type="checkbox"  v-model="capacity.x6" class="w-4 h-4 text-blue-600 rounded ring-offset-2 focus:ring-2 focus:ring-blue-500" id="one">
                                <label for="one" class="ms-2 text-gray-600 font-semibold">6 Person</label>
                                <p v-if="data.length" class="ms-1 text-sm text-gray-400">({{ data[1][2] }})</p>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center my-4">
                                <input type="checkbox" v-model="capacity.x8" class="w-4 h-4 text-blue-600 rounded ring-offset-2 focus:ring-2 focus:ring-blue-500" id="one">
                                <label for="one" class="ms-2 text-gray-600 font-semibold">8 or More</label>
                                <p v-if="data.length" class="ms-1 text-sm text-gray-400">({{ data[1][3] }})</p>
                            </div>
                        </li>
                    </ul>
                    <h3 class="text-sm text-gray-400 mt-2">PRICE</h3>
                    <div>
                        <input v-model="priceFilter" type="range" class="w-full my-4" min="0" max="100">
                        <h3 class="text-xl font-semibold text-gray-600">Max <span class="ms-2">${{ priceFilter }}</span></h3>
                    </div>
                </div>
                <!-- left - side -->
                <div class="col-start-4 col-span-9 bg-gray-100">
                    <div class="xl:grid grid-cols-2 px-4 py-4 md:px-auto md:py-8">
                        <div class="flex justify-center">
                            <div class="flex flex-col">
                                <div class="w-full xl:w-[450px] xl:h-[360] bg-blue-500 rounded-lg">
                                    <img :src="dataDetail.background" alt="">
                                </div>
                                <div v-if="dataDetail_load" class="flex justify-center items-center rounded bg-gray-200 h-[300px]">                      
                                    <div role="status">
                                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                        </svg>
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div v-else class="flex mt-6">
                                    <div class="w-[150px] h-[90px] bg-blue-500 rounded-lg m-1 flex items-center">
                                        <img :src="dataDetail.image" alt="">
                                    </div>
                                    <div class="w-[150px] h-[90px] bg-blue-500 rounded-lg m-1  flex items-center">
                                        <img :src="dataDetail.image" alt="">
                                    </div>
                                    <div class="w-[150px] h-[90px] bg-blue-500 rounded-lg m-1  flex items-center">
                                        <img :src="dataDetail.image" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- right - side -->
                         <div v-if="dataDetail_load" class="flex justify-center items-center">         
                             <div role="status">
                                 <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                     <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                     <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                 </svg>
                                 <span class="sr-only">Loading...</span>
                             </div>
                         </div>                   
                        <div v-else class="bg-white flex flex-col justify-center rounded-lg p-6 xl:mx-6">
                            <div>
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-2xl">{{ dataDetail.name }}</h3>
                                        <div class="flex items-center">
                                            <div class="flex py-2">
                                                <div class="m-1">
                                                    <svg class="w-4 h-4" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.16676 0.65838C8.22433 0.475844 8.33858 0.316412 8.49294 0.203241C8.64729 0.0900697 8.8337 0.0290527 9.0251 0.0290527C9.21649 0.0290527 9.40291 0.0900697 9.55726 0.203241C9.71161 0.316412 9.82587 0.475844 9.88343 0.65838L11.4334 5.42505H16.4334C16.6317 5.41755 16.8269 5.47516 16.9893 5.58908C17.1517 5.70299 17.2724 5.86695 17.3329 6.05589C17.3933 6.24484 17.3903 6.44838 17.3242 6.63542C17.2581 6.82247 17.1325 6.98273 16.9668 7.09171L12.9084 10.0334L14.4584 14.8084C14.5197 14.9903 14.5213 15.187 14.4628 15.3698C14.4044 15.5526 14.2891 15.712 14.1336 15.8246C13.9782 15.9372 13.7908 15.9972 13.5989 15.9958C13.407 15.9944 13.2205 15.9316 13.0668 15.8167L9.0001 12.8417L4.94176 15.7917C4.78802 15.9066 4.60157 15.9694 4.40963 15.9708C4.2177 15.9722 4.03034 15.9122 3.87491 15.7996C3.71948 15.687 3.60412 15.5276 3.54569 15.3448C3.48725 15.162 3.4888 14.9653 3.5501 14.7834L5.1001 10.0084L1.04176 7.06671C0.876001 6.95773 0.750474 6.79747 0.684365 6.61042C0.618256 6.42338 0.615199 6.21984 0.675661 6.03089C0.736123 5.84195 0.85678 5.67799 1.0192 5.56408C1.18161 5.45016 1.37686 5.39255 1.5751 5.40005H6.5751L8.16676 0.65838Z" fill="#FBAD39"/>
                                                    </svg>
                                                </div>
                                                <div class="m-1">
                                                    <svg class="w-4 h-4" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.16676 0.65838C8.22433 0.475844 8.33858 0.316412 8.49294 0.203241C8.64729 0.0900697 8.8337 0.0290527 9.0251 0.0290527C9.21649 0.0290527 9.40291 0.0900697 9.55726 0.203241C9.71161 0.316412 9.82587 0.475844 9.88343 0.65838L11.4334 5.42505H16.4334C16.6317 5.41755 16.8269 5.47516 16.9893 5.58908C17.1517 5.70299 17.2724 5.86695 17.3329 6.05589C17.3933 6.24484 17.3903 6.44838 17.3242 6.63542C17.2581 6.82247 17.1325 6.98273 16.9668 7.09171L12.9084 10.0334L14.4584 14.8084C14.5197 14.9903 14.5213 15.187 14.4628 15.3698C14.4044 15.5526 14.2891 15.712 14.1336 15.8246C13.9782 15.9372 13.7908 15.9972 13.5989 15.9958C13.407 15.9944 13.2205 15.9316 13.0668 15.8167L9.0001 12.8417L4.94176 15.7917C4.78802 15.9066 4.60157 15.9694 4.40963 15.9708C4.2177 15.9722 4.03034 15.9122 3.87491 15.7996C3.71948 15.687 3.60412 15.5276 3.54569 15.3448C3.48725 15.162 3.4888 14.9653 3.5501 14.7834L5.1001 10.0084L1.04176 7.06671C0.876001 6.95773 0.750474 6.79747 0.684365 6.61042C0.618256 6.42338 0.615199 6.21984 0.675661 6.03089C0.736123 5.84195 0.85678 5.67799 1.0192 5.56408C1.18161 5.45016 1.37686 5.39255 1.5751 5.40005H6.5751L8.16676 0.65838Z" fill="#FBAD39"/>
                                                    </svg>
                                                </div><div class="m-1">
                                                    <svg class="w-4 h-4" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.16676 0.65838C8.22433 0.475844 8.33858 0.316412 8.49294 0.203241C8.64729 0.0900697 8.8337 0.0290527 9.0251 0.0290527C9.21649 0.0290527 9.40291 0.0900697 9.55726 0.203241C9.71161 0.316412 9.82587 0.475844 9.88343 0.65838L11.4334 5.42505H16.4334C16.6317 5.41755 16.8269 5.47516 16.9893 5.58908C17.1517 5.70299 17.2724 5.86695 17.3329 6.05589C17.3933 6.24484 17.3903 6.44838 17.3242 6.63542C17.2581 6.82247 17.1325 6.98273 16.9668 7.09171L12.9084 10.0334L14.4584 14.8084C14.5197 14.9903 14.5213 15.187 14.4628 15.3698C14.4044 15.5526 14.2891 15.712 14.1336 15.8246C13.9782 15.9372 13.7908 15.9972 13.5989 15.9958C13.407 15.9944 13.2205 15.9316 13.0668 15.8167L9.0001 12.8417L4.94176 15.7917C4.78802 15.9066 4.60157 15.9694 4.40963 15.9708C4.2177 15.9722 4.03034 15.9122 3.87491 15.7996C3.71948 15.687 3.60412 15.5276 3.54569 15.3448C3.48725 15.162 3.4888 14.9653 3.5501 14.7834L5.1001 10.0084L1.04176 7.06671C0.876001 6.95773 0.750474 6.79747 0.684365 6.61042C0.618256 6.42338 0.615199 6.21984 0.675661 6.03089C0.736123 5.84195 0.85678 5.67799 1.0192 5.56408C1.18161 5.45016 1.37686 5.39255 1.5751 5.40005H6.5751L8.16676 0.65838Z" fill="#FBAD39"/>
                                                    </svg>
                                                </div><div class="m-1">
                                                    <svg class="w-4 h-4" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.16676 0.65838C8.22433 0.475844 8.33858 0.316412 8.49294 0.203241C8.64729 0.0900697 8.8337 0.0290527 9.0251 0.0290527C9.21649 0.0290527 9.40291 0.0900697 9.55726 0.203241C9.71161 0.316412 9.82587 0.475844 9.88343 0.65838L11.4334 5.42505H16.4334C16.6317 5.41755 16.8269 5.47516 16.9893 5.58908C17.1517 5.70299 17.2724 5.86695 17.3329 6.05589C17.3933 6.24484 17.3903 6.44838 17.3242 6.63542C17.2581 6.82247 17.1325 6.98273 16.9668 7.09171L12.9084 10.0334L14.4584 14.8084C14.5197 14.9903 14.5213 15.187 14.4628 15.3698C14.4044 15.5526 14.2891 15.712 14.1336 15.8246C13.9782 15.9372 13.7908 15.9972 13.5989 15.9958C13.407 15.9944 13.2205 15.9316 13.0668 15.8167L9.0001 12.8417L4.94176 15.7917C4.78802 15.9066 4.60157 15.9694 4.40963 15.9708C4.2177 15.9722 4.03034 15.9122 3.87491 15.7996C3.71948 15.687 3.60412 15.5276 3.54569 15.3448C3.48725 15.162 3.4888 14.9653 3.5501 14.7834L5.1001 10.0084L1.04176 7.06671C0.876001 6.95773 0.750474 6.79747 0.684365 6.61042C0.618256 6.42338 0.615199 6.21984 0.675661 6.03089C0.736123 5.84195 0.85678 5.67799 1.0192 5.56408C1.18161 5.45016 1.37686 5.39255 1.5751 5.40005H6.5751L8.16676 0.65838Z" fill="#FBAD39"/>
                                                    </svg>
                                                </div>
                                                <div class="m-1">
                                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.16676 2.65838C9.22433 2.47584 9.33858 2.31641 9.49294 2.20324C9.64729 2.09007 9.8337 2.02905 10.0251 2.02905C10.2165 2.02905 10.4029 2.09007 10.5573 2.20324C10.7116 2.31641 10.8259 2.47584 10.8834 2.65838L12.4334 7.42505H17.4334C17.6317 7.41755 17.8269 7.47516 17.9893 7.58908C18.1517 7.70299 18.2724 7.86695 18.3329 8.05589C18.3933 8.24484 18.3903 8.44838 18.3242 8.63542C18.2581 8.82247 18.1325 8.98273 17.9668 9.09171L13.9084 12.0334L15.4584 16.8084C15.5197 16.9903 15.5213 17.187 15.4628 17.3698C15.4044 17.5526 15.2891 17.712 15.1336 17.8246C14.9782 17.9372 14.7908 17.9972 14.5989 17.9958C14.407 17.9944 14.2205 17.9316 14.0668 17.8167L10.0001 14.8417L5.94176 17.7917C5.78802 17.9066 5.60157 17.9694 5.40963 17.9708C5.2177 17.9722 5.03034 17.9122 4.87491 17.7996C4.71948 17.687 4.60412 17.5276 4.54569 17.3448C4.48725 17.162 4.4888 16.9653 4.5501 16.7834L6.1001 12.0084L2.04176 9.06671C1.876 8.95773 1.75047 8.79747 1.68437 8.61042C1.61826 8.42338 1.6152 8.21984 1.67566 8.03089C1.73612 7.84195 1.85678 7.67799 2.0192 7.56408C2.18161 7.45016 2.37686 7.39255 2.5751 7.40005H7.5751L9.16676 2.65838Z" stroke="#90A3BF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <h4 class="ms-2 text-gray-600 font-semibold text-sm">440+ Reviewer</h4>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- heart -->
                                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="red" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.62 20.81C12.28 20.93 11.72 20.93 11.38 20.81C8.48 19.82 2 15.69 2 8.68998C2 5.59998 4.49 3.09998 7.56 3.09998C9.38 3.09998 10.99 3.97998 12 5.33998C13.01 3.97998 14.63 3.09998 16.44 3.09998C19.51 3.09998 22 5.59998 22 8.68998C22 15.69 15.52 19.82 12.62 20.81Z" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-4" :class="{'line-clamp-0' : descriptionClick, 'line-clamp-3' : !descriptionClick}" @click="descriptionClick=!descriptionClick">
                                    <p class="leading-7 text-gray-600 text-balance">
                                        {{ dataDetail.description }}
                                    </p>
                                </div>
                                <div class="mt-6 flex flex-wrap justify-between p-1">
                                    <div>
                                        <div class="flex">
                                            <h3 class="text-lg text-gray-500">Type Car</h3>
                                            <h3 class="text-lg text-gray-700 font-semibold ms-4">{{ dataDetail.model }}</h3>
                                        </div>
                                        <div class="flex mt-2">
                                            <h3 class="text-lg text-gray-500">Steering</h3>
                                            <h3 class="text-lg text-gray-700 font-semibold ms-4">{{ dataDetail.type }}</h3>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex">
                                            <h3 class="text-lg text-gray-500">Capacity</h3>
                                            <h3 class="text-lg text-gray-700 font-semibold ms-4">{{ dataDetail.capacity }} Person</h3>
                                        </div>
                                        <div class="flex mt-2">
                                            <h3 class="text-lg text-gray-500">Gasoline</h3>
                                            <h3 class="text-lg text-gray-700 font-semibold ms-4">{{ dataDetail.tank }}L</h3>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="mt-8">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-end">
                                        <h1 v-if="dataDetail.dailyPrice" class="text-gray-800 font-bold text-2xl">${{dataDetail.dailyPrice.toFixed(2)}}/</h1>
                                        <span class="text-sm text-gray-500">day</span>
                                    </div>
                                    <RouterLink class="bg-blue-600 hover:bg-blue-700 rounded px-4 py-2 text-white" :to="`/payment/${dataDetail.id}`">
                                        Rent Now
                                    </RouterLink>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- reviews -->
                    <div class="px-4 py-4 md:px-auto md:py-8">
                        <div class="bg-white p-4 rounded-xl">
                            <div class="flex justify-between">
                                <div class="flex">
                                    <h2 class="text-gray-900 font-semibold text-xl">Reviews</h2>
                                    <div class="ms-4 bg-blue px-4 py-1 bg-blue-500 text-white rounded">{{ reviews.length }}</div>
                                </div>
                                <button @click="modal = !modal" class="bg-blue px-4 py-1 bg-blue-500 text-white rounded-lg">
                                    Add Review
                                </button>
                            </div>
                            <!-- persons -->
                             <div v-if="review_load" class="flex justify-center">
                                 <div class="m-2" role="status">
                                     <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                         <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                         <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                     </svg>
                                     <span class="sr-only">Loading...</span>
                                 </div>
                             </div>

                            <div v-else class="divide-y">
                                <div class="my-6">
                                    <div v-for="item in reviews" class="flex mt-6">
                                        <div class="flex-shrink-0">
                                            <img :src="profileImage" alt="" class="w-12 h-12 rounded-full">
                                        </div>
                                        <div class="flex-grow px-4">
                                            <div class="flex justify-between">
                                                <h3 class="text-gray-800 font-bold text-xl">{{ user }}</h3>
                                                <div>
                                                    <p class="text-sm text-gray-400">{{ item.created_at }}</p>
                                                </div>
                                            </div>
                                            <div class="flex justify-between">
                                                <h4 class="text-gray-400 text-sm">User</h4>
                                                <div>
                                                    <div class="flex items-center">
                                                        <div class="flex">
                                                            <div v-for="star in item.stars" class="m-1">
                                                                <svg class="w-4 h-4" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.16676 0.65838C8.22433 0.475844 8.33858 0.316412 8.49294 0.203241C8.64729 0.0900697 8.8337 0.0290527 9.0251 0.0290527C9.21649 0.0290527 9.40291 0.0900697 9.55726 0.203241C9.71161 0.316412 9.82587 0.475844 9.88343 0.65838L11.4334 5.42505H16.4334C16.6317 5.41755 16.8269 5.47516 16.9893 5.58908C17.1517 5.70299 17.2724 5.86695 17.3329 6.05589C17.3933 6.24484 17.3903 6.44838 17.3242 6.63542C17.2581 6.82247 17.1325 6.98273 16.9668 7.09171L12.9084 10.0334L14.4584 14.8084C14.5197 14.9903 14.5213 15.187 14.4628 15.3698C14.4044 15.5526 14.2891 15.712 14.1336 15.8246C13.9782 15.9372 13.7908 15.9972 13.5989 15.9958C13.407 15.9944 13.2205 15.9316 13.0668 15.8167L9.0001 12.8417L4.94176 15.7917C4.78802 15.9066 4.60157 15.9694 4.40963 15.9708C4.2177 15.9722 4.03034 15.9122 3.87491 15.7996C3.71948 15.687 3.60412 15.5276 3.54569 15.3448C3.48725 15.162 3.4888 14.9653 3.5501 14.7834L5.1001 10.0084L1.04176 7.06671C0.876001 6.95773 0.750474 6.79747 0.684365 6.61042C0.618256 6.42338 0.615199 6.21984 0.675661 6.03089C0.736123 5.84195 0.85678 5.67799 1.0192 5.56408C1.18161 5.45016 1.37686 5.39255 1.5751 5.40005H6.5751L8.16676 0.65838Z" fill="#FBAD39"/>
                                                                </svg>
                                                            </div>
                                                            
                                                            <div v-for="star in 5 - item.stars" class="m-1">
                                                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.16676 2.65838C9.22433 2.47584 9.33858 2.31641 9.49294 2.20324C9.64729 2.09007 9.8337 2.02905 10.0251 2.02905C10.2165 2.02905 10.4029 2.09007 10.5573 2.20324C10.7116 2.31641 10.8259 2.47584 10.8834 2.65838L12.4334 7.42505H17.4334C17.6317 7.41755 17.8269 7.47516 17.9893 7.58908C18.1517 7.70299 18.2724 7.86695 18.3329 8.05589C18.3933 8.24484 18.3903 8.44838 18.3242 8.63542C18.2581 8.82247 18.1325 8.98273 17.9668 9.09171L13.9084 12.0334L15.4584 16.8084C15.5197 16.9903 15.5213 17.187 15.4628 17.3698C15.4044 17.5526 15.2891 17.712 15.1336 17.8246C14.9782 17.9372 14.7908 17.9972 14.5989 17.9958C14.407 17.9944 14.2205 17.9316 14.0668 17.8167L10.0001 14.8417L5.94176 17.7917C5.78802 17.9066 5.60157 17.9694 5.40963 17.9708C5.2177 17.9722 5.03034 17.9122 4.87491 17.7996C4.71948 17.687 4.60412 17.5276 4.54569 17.3448C4.48725 17.162 4.4888 16.9653 4.5501 16.7834L6.1001 12.0084L2.04176 9.06671C1.876 8.95773 1.75047 8.79747 1.68437 8.61042C1.61826 8.42338 1.6152 8.21984 1.67566 8.03089C1.73612 7.84195 1.85678 7.67799 2.0192 7.56408C2.18161 7.45016 2.37686 7.39255 2.5751 7.40005H7.5751L9.16676 2.65838Z" stroke="#90A3BF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="mt-4 text-sm text-gray-600 leading-6">
                                                    {{ item.review }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- show all -->
                            <div class="flex justify-center">
                                <button class="text-gray-400 flex items-center">
                                    <span>Show All</span>
                                    <svg class="h-4 w-4 ms-2" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.00026 11.1996C7.53359 11.1996 7.06692 11.0196 6.71359 10.6663L2.36692 6.31964C2.17359 6.1263 2.17359 5.80631 2.36692 5.61297C2.56026 5.41964 2.88026 5.41964 3.07359 5.61297L7.42026 9.95964C7.74026 10.2796 8.26026 10.2796 8.58026 9.95964L12.9269 5.61297C13.1203 5.41964 13.4403 5.41964 13.6336 5.61297C13.8269 5.80631 13.8269 6.1263 13.6336 6.31964L9.28692 10.6663C8.93359 11.0196 8.46692 11.1996 8.00026 11.1996Z" fill="#90A3BF" stroke="#90A3BF" stroke-width="0.5"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- cars -->
                    <div class="px-8 py-4 md:px-6 md:py-8">
                        <div class="flex justify-between px-6">
                            <h4 class="text-base text-gray-600">Popular Cars</h4>
                            <a class="text-blue-700 font-bold text-base">View All</a>
                        </div>
                        <div class="swiper mt-6">
                            <div class="swiper-wrapper">
                                <div v-if="dataFilter.length" class="swiper-slide" v-for="item in dataFilter">
                                    <carcardView class="m-1" v-bind="item" :to="`/detail/${item.id}?name=${item.name}&type=${item.model}&capacity=${item.capacity}`"/>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</template>
<style>

</style>