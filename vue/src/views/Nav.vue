<script setup>
import useAuthStore from "../stores/auth.store";
import { PrimeIcons } from "primevue/api";
import Button from 'primevue/button';
const AuthStore = useAuthStore();
import 'primeicons/primeicons.css';
</script>

<template>
    <div id="nav"> 
        <router-link v-if="!AuthStore.user"  to="/">Kullanıcı Girişi</router-link>

            <router-link v-if="AuthStore.user" to="/orders">Siparişler</router-link>
            <router-link v-if="AuthStore.user" to="/cargo-status">Kargo Takip</router-link>
            <router-link v-if="AuthStore.user" to="/cargo-confirm">Kargo Onayla</router-link>


        <div v-if="AuthStore.user" class="user">
            <Button :icon="PrimeIcons.USER" size="small" :label="AuthStore.user"/> 
        </div>
        <div v-if="AuthStore.user" class="btnClass">
            <Button :icon="PrimeIcons.SIGN_OUT" size="small" label="Çıkış Yap" @click="AuthStore.logout"/> 
        </div>
    </div> 
</template>

<style lang="css">

    .btnClass{
        margin-left: 2rem;
    }


    .user{
        margin-left: 50%;
        display: flex;     
    }

    #nav .active{
        color: mediumturquoise;
    }

    #nav {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        margin-top: 0;
        padding: 30px;
        background: rgb(230, 170, 59);
        color: white;
        display: flex;
        align-items: center;
        border-bottom: 5px solid #4e6c71;
        z-index: 2;
        opacity: 90%;
        max-height: 4rem;
    }

    #nav a {
        display: inline-block;
        margin-right: 20px;
        color: white;
        opacity: 0.7;
        transition: 0.2 ease color;
    }

    #nav a:hover {
        opacity: 1;
    }

    a {
        text-decoration: none;
        font-weight: bold;
    }
</style>