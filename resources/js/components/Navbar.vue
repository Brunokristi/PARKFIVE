<script setup>
import { computed } from 'vue';
import Logo from './Logo.vue';

const props = defineProps({
    variant: {
        type: String,
        default: 'dark',
    },
});

const colorClass = computed(() => props.variant === 'light' ? 'text-darkcolor' : 'text-lightcolor');
</script>

<template>
    <div class="sticky top-0 z-50 flex justify-between items-center p-4">
        <a href="/" :class="colorClass">
            <Logo :width="20" :height="20" />
        </a>

        <a :class="colorClass">
            <i class="bi bi-list"></i>
        </a>
    </div>
</template>


