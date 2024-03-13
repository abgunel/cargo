<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Navi from './views/Nav.vue';
import 'primeicons/primeicons.css';
import "/node_modules/primeflex/primeflex.css";
import './axios';
import "primevue/resources/themes/lara-light-indigo/theme.css"; 
import "primevue/resources/primevue.min.css";
import useAuthStore from "./stores/auth.store";
import Button from 'primevue/button';
</script>

<template>
  <div class="grid">
    <div class="col-12">
      <Navi/>
    </div>
    <div class="col-12 mt-6">
      <RouterView />
    </div>
    
  </div>


</template>

<style scoped>


</style>
