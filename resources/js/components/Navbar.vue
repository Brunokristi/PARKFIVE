<script setup>
import { computed } from 'vue';
import Logo from './Logo.vue';

const props = defineProps({
    variant: {
        type: String,
        default: 'dark',
    },
});

const itemsColor = computed(() => props.variant === 'light' ? 'darkgreen' : 'lightgreen');
</script>

<template>
    <div class="sticky top-0 z-50 flex justify-between items-center p-4">
        <a href="/">
            <Logo :color="itemsColor" :width="20" :height="20" />
        </a>

        <a>
            <i class="bi bi-list" :style="{ color: itemsColor }"></i>
        </a>
    </div>
</template>


