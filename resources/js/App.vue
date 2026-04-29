<script setup>
import { computed } from 'vue';
import { RouterView, useRoute } from 'vue-router';
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue';
import CookieConsent from './components/CookieConsent.vue';
import Toast from './components/Toast.vue';
import { useToast } from './composables/useToast';

const route = useRoute();
const theme = computed(() => route.meta.theme ?? 'dark');
const footer = computed(() => route.meta.footer ?? true);

const { toastVisible: showConfirmationToast, toastHeading, toastText } = useToast();
</script>

<template>
    <div
        class="min-h-screen flex flex-col"
        :class="theme === 'light' ? 'bg-lightcolor' : 'bg-darkcolor'"
    >
        <Navbar :variant="theme" />
        <main class="flex-1 pb-[100px]">
            <RouterView />
        </main>
        <Footer v-if="footer" :variant="theme" />
        <CookieConsent :variant="theme" />
        <Toast
            v-model="showConfirmationToast"
            :heading="toastHeading"
            :text="toastText"
            :variant="theme"
            :duration="3000"
        />
        </div>
</template>