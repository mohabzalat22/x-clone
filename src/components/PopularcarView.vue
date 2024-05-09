<script setup>
import { onMounted, ref} from 'vue';
import carcardView from './carcardView.vue';  
import { useFetch } from '@/combosables/fetch';
const {loading, data, error, fetchData} = useFetch();
onMounted(()=>{
    fetchData('http://localhost:8000/api');
});
</script>
<template>
    <div class="container mx-auto">
        <div class="px-8 py-4 md:px-16 md:py-8">
            <div class="flex justify-between px-10">
                <h4 class="text-base text-gray-600">Popular Cars</h4>
                <a class="text-blue-700 font-bold text-base">View All</a>
            </div>
            <div :v-if="data.length" class="grid justify-items-center md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 mt-8">
                <carcardView v-for="item in data" v-bind="item" :to="`/detail/${item.id}?name=${item.name}&type=${item.model}&capacity=${item.capacity}`"/>
            </div>
            <div class="flex justify-between items-center py-8">
                <div class="flex-grow flex justify-center">
                    <button class="bg-blue-600 text-xl ms-16 text-white px-8 py-2 rounded-md capitalize hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-200">show more</button>
                </div>
                <h5 class="font-bold text-gray-400 m-0">{{ data.length }} cars</h5>
            </div>
            <!-- show more cars -->
        </div>
    </div>
</template>
<style>
</style>