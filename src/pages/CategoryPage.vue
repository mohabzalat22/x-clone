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
const {loading, data, error, fetchData} = useFetch();

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

onMounted(()=>{
    fetchData('http://localhost:8000/api/category/data');
});

const {loading:loadingFilter, data:dataFilter, error:errorFilter, fetchData:fetchFilter} = useFetch();

watch([type, capacity, priceFilter], ()=>{
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
    fetchFilter(`http://localhost:8000/api/category/filter`,{
        method: 'POST',
        headers: {
            'Accept': 'application/json, text/plain, */*',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            'type': filteredType, 
            'capacity': filteredCapacity,
            'price': priceFilter.value
        }
        ),
    }).then(()=>{
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
                    <PickdropView class="my-6"/>
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