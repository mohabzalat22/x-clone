<script setup>
import {reactive, watch} from 'vue';

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
    <div class="container mx-auto">
        <div class="px-8 py-0.5 md:px-16 md:py-1">
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
    </div>
</template>
<style>
</style>