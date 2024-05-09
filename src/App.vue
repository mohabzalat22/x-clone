<script>
import NavbarView from './components/NavbarView.vue';
import FooterView from './components/FooterView.vue';

export default{
  components: {
    NavbarView,
    FooterView
  }

}
</script>
<template>
  <NavbarView />
  <!-- MAIN -->
  <Transition>
    <RouterView />
  </Transition>
  <!-- #### -->
  <FooterView />
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