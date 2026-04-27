<script setup>
import { computed } from 'vue';
import { RouterView, useRoute } from 'vue-router';
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue';
import CookieConsent from './components/CookieConsent.vue';

const route = useRoute();
const theme = computed(() => route.meta.theme ?? 'dark');
const footer = computed(() => route.meta.footer ?? true);
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
        <!-- <CookieConsent /> -->
        </div>
</template>