<script setup>
import RentalsummaryView from '@/components/payment/RentalsummaryView.vue';
import { ref } from 'vue';
import { useRoute,  useRouter } from 'vue-router';
const currentStep = ref(1);
const router = useRouter();
const route = useRoute();

const payment_id = route.params.id;

const nextStep = ()=>{
  if(currentStep.value >= 4 ){

  }
  else{
    currentStep.value +=1;
    router.push(`/payment/${payment_id}/step/${currentStep.value}`);
  }
}
const backStep = ()=>{
  if(currentStep.value > 1 ){
    currentStep.value -=1;
    router.push(`/payment/${payment_id}/step/${currentStep.value}`);
  }
  else{

  }
  
}
</script>
<template>
    <div class="container mx-auto p-4">
      <div class="flex flex-col-reverse lg:grid lg:grid-cols-12">
        <div class="col-start-1 col-span-7">
          <Transition>
            <RouterView class="my-4"></RouterView>
          </Transition>
          <div class="bg-white p-4 flex justify-end rounded-md">
            <button class="bg-blue-600 py-2 px-6 mx-2 text-white text-lg rounded-md" @click="backStep">Back</button>
            <button class="bg-blue-600 py-2 px-6 mx-2 text-white text-lg rounded-md" @click="nextStep">Next</button>
          </div>
        </div>
        <div class="col-start-8 col-span-5 lg:px-4">
          <RentalsummaryView class="my-4"/>
        </div>
      </div>
    </div>
</template>
<style>
</style>