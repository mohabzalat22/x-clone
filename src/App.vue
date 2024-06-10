<script setup>
import NavbarView from './components/NavbarView.vue';
import FooterView from './components/FooterView.vue';

</script>
<template>
  <!-- MAIN -->
  <RouterView name="NavbarView" />
  <transition>
    <RouterView />
  </transition>
  <RouterView name="FooterView" />
  <!-- #### -->
</template>
<style>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>