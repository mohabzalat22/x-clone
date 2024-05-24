<script setup>
import { reactive, ref, watch , onMounted} from 'vue';
import PickdropView from '@/components/PickdropView.vue';
import carcardView from '@/components/carcardView.vue';
import { useFetch } from '@/combosables/fetch';
import { useRoute } from 'vue-router';
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/swiper-bundle.css';
// import 'swiper/css/navigation';
import 'swiper/css/pagination';
// setup for axios during post req
import axios from 'axios';
axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withXSRFToken = true;
axios.defaults.withCredentials = true;

const data = ref([]);
const dataFilter = ref([]);

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

const priceFilter = ref(50);

const route = useRoute();
const init_type = route.query.type;
const init_capacity = route.query.capacity;

type[init_type] = true;
capacity[`x${init_capacity}`]= true;

const getData = async()=>{
    const res = await axios.get('/api/v1/category/data');
    data.value = await res.data;
}
const filter = async(filteredType, filteredCapacity, priceFilter, data)=>{
    const res = await axios.post(
        '/api/v1/category/filter',
        {
            'type': filteredType, 
            'capacity': filteredCapacity,
            'price': priceFilter.value,
            'data': data
        },
    );
    dataFilter.value = await res.data;
}
onMounted(()=>{
    getData();
});

let FILTERDATA = [];

const pick = reactive({
    selected: false,
    location: '',
    date: '',
    time:''
});

const drop = reactive({
    selected: false,
    location: '',
    date: '',
    time:''
});

watch(
    ()=>pick.date,
    ()=>drop.date = pick.date
);

watch([type, capacity, priceFilter, pick, drop], ()=>{
    // car filter
    FILTERDATA = []; // clean old
    if(pick.selected == true && drop.selected == false)
    {   
        FILTERDATA.push({'pick': pick});
    }
    if(pick.selected == false && drop.selected == true)
    {
        FILTERDATA.push({'drop': drop});
    }
    if(pick.selected == true && drop.selected == true)
    {
        FILTERDATA.push({'pick': pick});
        FILTERDATA.push({'drop': drop});
    }

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
    filter(filteredType, filteredCapacity, priceFilter, FILTERDATA)
    .then(()=>{
        const swiper = new Swiper('.swiper', {
            slidesPerView: 1,
            modules: [Pagination],
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints:{
                768 :{
                    slidesPerView: 3,
                },
            }
        });
    });
    // filter
},
{ immediate: true });

const getCurrentDate = ()=> {
  const today = new Date();
  const year = today.getFullYear();
  let month = today.getMonth() + 1;
  let day = today.getDate();
  if (month < 10) {
    month = '0' + month;
  }
  if (day < 10) {
    day = '0' + day;
  }
  return `${year}-${month}-${day}`;
}

const dropDate = ()=> {
    if(pick.date != ''){
        return pick.date;
    }
    else{
        return getCurrentDate();
    }
};

const pickTime = ()=> {
    //today = 
    const date = new Date();
    const time = date.getHours();
    if(pick.date == getCurrentDate(0))
    {
        let time_list = [];
        let i = time;
        for(i; i < 24 ; i++){
            if (i >= 12){
                if( i == 12) {
                    time_list.push(i + ' PM');
                }
                else{
                    time_list.push(i - 12 + ' PM');
                }
            }
            else{
                if(i==0){
                    time_list.push('12 AM');  
                }
                else{
                    time_list.push(i + ' AM');
                }
            }
        }
        return time_list;
    }
    else{
        let time_list = [];
        let i = 0;
        for(i; i < 24 ; i++){
            if (i >= 12){
                if( i == 12) {
                    time_list.push(i + ' PM');
                }
                else{
                    time_list.push(i - 12 + ' PM');
                }
            }
            else{
                if(i==0){
                    time_list.push('12 AM');  
                }
                else{
                    time_list.push(i + ' AM');
                }
            }
        }
        return time_list;
    }
}

const dropTime = ()=> {
    if(pick.date == drop.date) //pick drop == same day
    {
        let time_list = [];
        if(pick.time != ''){
            let time = pick.time.split(' ');
            let i = 0;
            if(time[1] == 'AM'){
                if(time[0]==12){
                    i = 0;
                }

                else{
                    i = +time[0];
                }

            }
            else //pm
            {
                if(time[0]==12){
                    i = 23;
                }

                else{
                    i = +time[0] + 12;
                }
            }
            i+=1;
            // i strats from end of pick date
            for(i; i < 24 ; i++){
                if (i >= 12){
                    if( i == 12) {
                        time_list.push(i + ' PM');
                    }
                    else{
                        time_list.push(i - 12 + ' PM');
                    }
                }
                else{
                    if(i==0){
                        time_list.push('12 AM');  
                    }
                    else{
                        time_list.push(i + ' AM');
                    }
                }
            }
            return time_list;
        }
    }
    else 
    {
        const date = new Date();
        const time = date.getHours();
        let time_list = [];
        let i = 0;
        for(i; i < 24 ; i++){
            if (i >= 12){
                if( i == 12) {
                    time_list.push(i + ' PM');
                }
                else{
                    time_list.push(i - 12 + ' PM');
                }
            }
            else
            {
                if(i==0){
                    time_list.push('12 AM');  
                }
                else{
                    time_list.push(i + ' AM');
                }
            }
        }
        return time_list;
    }
}

</script>
<template>
  <div class="bg-white">
      <div class="xl:container mx-auto">
        <!-- end modal -->
        <div class="">
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
                <div class="col-start-4 col-span-9 bg-gray-100">
                    <div class="px-8 py-0.5 md:px-16 md:py-1 my-6">
                        <div class="flex flex-wrap select-none">
                            <div class="w-full xl:w-5/12 bg-white rounded-2xl py-4 px-4">
                                <!-- pick -->
                                <div class="flex items-center py-1" @click="pick.selected=!pick.selected">
                                    <input v-model="pick.selected" type="checkbox" id="one" class="w-4 h-4">
                                    <label for="one" class="ms-2 text-sm">Pick-Up</label>
                                </div>
                                <div class="flex justify-between mt-3 divide-x">
                                    <div class="px-2">
                                        <strong class="text-gray-800 text-lg block">Locations</strong>
                                        <select v-model="pick.location" class="w-full text-gray-600 outline-none">
                                            <option disabled value="">select your city</option>
                                            <option value="Alexandria">Alexandria</option>
                                            <option value="Cairo">Cairo</option>
                                        </select>
                                    </div>
                                    <div class="px-2">
                                        <strong class="text-gray-800 text-lg block">Date</strong>
                                        <input v-model="pick.date"  type="date" class="w-full text-gray-600 outline-none" :min="getCurrentDate()" @click="(e)=>{
                                            e.target.showPicker();
                                        }">
                                    </div>
                                    <div class="px-2">
                                        <strong class="text-gray-800 text-lg block">Time</strong>
                                        <select v-model="pick.time" class="w-full text-gray-600 outline-none">
                                            <option disabled value="">select your time</option>
                                            <option v-for="item in pickTime()" :value="item">{{ item }}</option>
                                        </select>
                                    </div>
                                </div>  
                            </div>
                            <div class="mx-auto xl:mx-0 xl:w-2/12 rounded-xl flex justify-center items-center">
                                <div class="p-4 rounded-xl bg-blue-500">
                                    <svg class="h-6 w-6" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.16051 0.835774L5.16051 14.4536" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1.08273 4.93188L5.1605 0.835218L9.23828 4.93188" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M15.0887 17.1671L15.0887 3.54934" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M19.1665 13.071L15.0887 17.1677L11.0109 13.071" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- drop -->
                            <div class="w-full xl:w-5/12 bg-white rounded-2xl py-4 px-4">
                                <div class="flex items-center py-1" @click="drop.selected=!drop.selected">
                                    <input v-model="drop.selected" type="checkbox" id="two" class="w-4 h-4">
                                    <label for="two" class="ms-2 text-sm">Drop-Off</label>
                                </div>
                                <div class="flex justify-between mt-3 divide-x">
                                    <div class="px-2">
                                        <strong class="text-gray-800 text-lg block">Locations</strong>
                                        <select v-model="drop.location" name="location" id="location" class="w-full text-gray-600 outline-none">
                                            <option disabled value="">select your city</option>
                                            <option value="Alexandria">Alexandria</option>
                                            <option value="Cairo">Cairo</option>
                                        </select>
                                    </div>
                                    <div class="px-2">
                                        <strong class="text-gray-800 text-lg block">Date</strong>
                                        <input v-model="drop.date" type="date" class="w-full text-gray-600 outline-none" :min="dropDate()" @click="(e)=>{
                                            e.target.showPicker();
                                        }">
                                    </div>
                                    <div class="px-2">
                                        <strong class="text-gray-800 text-lg block">Time</strong>
                                        <select v-model="drop.time" class="w-full text-gray-600 outline-none">
                                            <option disabled value="">select your time</option>
                                            <option v-for="item in dropTime()" :value="item">{{ item }}</option>
                                        </select>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <!-- cars -->
                    <div class="px-4 py-0.5 md:px-6 md:py-1">
                        <!-- --- -->
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                <div v-if="dataFilter.length" class="swiper-slide" v-for="item in dataFilter">
                                    <carcardView class="m-1" v-bind="item" :to="`/detail/${item.id}?name=${item.name}&type=${item.model}&capacity=${item.capacity}`"/>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>

                        <!-- --- -->
                    </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</template>
<style>

</style>