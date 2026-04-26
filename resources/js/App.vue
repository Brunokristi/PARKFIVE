<script setup>
import { computed, onMounted, onBeforeUnmount, ref } from 'vue';
import { RouterView, useRoute } from 'vue-router';
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue';
import CookieConsent from './components/CookieConsent.vue';

const route = useRoute();
const theme = computed(() => route.meta.theme ?? 'dark');
const footer = computed(() => route.meta.footer ?? true);

const backgroundColor = computed(() => theme.value === 'light' ? 'bg-light' : 'bg-dark');

const LOADER_DURATION_MS = 2000;
const REVEAL_START_MS = 2100;
const LOADER_SHOWN_SESSION_KEY = 'studio-kristian-loader-shown';

const isPageLoading = ref(true);
const isRevealing = ref(false);

let loaderTimeoutId = null;
let revealTimeoutId = null;

function clearLoaderTimers() {
    if (loaderTimeoutId) {
        window.clearTimeout(loaderTimeoutId);
        loaderTimeoutId = null;
    }

    if (revealTimeoutId) {
        window.clearTimeout(revealTimeoutId);
        revealTimeoutId = null;
    }
}

function startLoader() {
    clearLoaderTimers();

    isPageLoading.value = true;
    isRevealing.value = false;

    revealTimeoutId = window.setTimeout(() => {
        isRevealing.value = true;
        revealTimeoutId = null;
    }, REVEAL_START_MS);

    loaderTimeoutId = window.setTimeout(() => {
        isPageLoading.value = false;
        isRevealing.value = false;
        loaderTimeoutId = null;
    }, LOADER_DURATION_MS);
}

function updateLoaderForRoute() {
    const hasShownLoader = sessionStorage.getItem(LOADER_SHOWN_SESSION_KEY) === '1';

    if (hasShownLoader) {
        clearLoaderTimers();
        isPageLoading.value = false;
        isRevealing.value = false;
        return;
    }

    startLoader();
    sessionStorage.setItem(LOADER_SHOWN_SESSION_KEY, '1');
}

onMounted(() => {
    updateLoaderForRoute();
});

onBeforeUnmount(() => {
    clearLoaderTimers();
});
</script>

<template>
    <div :class="[backgroundColor]">
        <div

        >
            <div class="min-h-screen flex flex-col">
                <Navbar :variant="theme" />
                <main class="flex-1 pt-14">
                    <RouterView />
                </main>
                <Footer v-if="footer" />
                <CookieConsent />
            </div>
        </div>
    </div>
</template>