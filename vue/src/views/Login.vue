<script setup>
//import '@/assets/app.css';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import {ref} from "vue";
import useAuthStore from "../stores/auth.store";
const AuthStore = useAuthStore();
const signUser = ref({});



</script>

<template>
    <div class="login">
    <div class="surface-card p-4 shadow-2 border-round w-full lg:w-6">
        <div class="text-center mb-5">
            <div class="text-900 text-3xl font-medium mb-3">Hoş Geldiniz</div>
        </div>

        <div>
            <label for="userId" class="block text-900 font-medium mb-2">ID</label>
            <InputText id="userId" v-model="signUser.id" type="text" placeholder="ID Giriniz..." class="w-full mb-3" />

            <label for="password1" class="block text-900 font-medium mb-2">Şifre</label>
            <InputText id="password1" v-model="signUser.pass" type="password" placeholder="Şifre Giriniz..." class="w-full mb-3" />

            <Button label="Giriş" icon="pi pi-user" class="w-full" @click="AuthStore.login(signUser.id, signUser.pass)"></Button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.login {
    justify-content: center;
    align-items: center;
    display: flex;
    flex-wrap: wrap;
}
</style>