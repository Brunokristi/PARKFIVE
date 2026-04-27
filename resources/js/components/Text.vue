<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { useGlobalActions } from '../composables/useGlobalActions';
import Logo from './Logo.vue';

const { t } = useI18n();

const props = defineProps({
    description: {
        type: String,
        default: '',
    },
});

const isLight = computed(() => props.variant === 'light');

const colorClass = computed(() =>
    isLight.value ? 'text-darkcolor' : 'text-lightcolor'
);

const linkClass = computed(() => [
    'py-2 px-4 w-full transition-colors',
    isLight.value
        ? 'hover:bg-darkcolor hover:text-lightcolor'
        : 'hover:bg-lightcolor hover:text-darkcolor',
]);
</script>

<template>
  <div class="flex items-center w-full" :class="colorClass">
        <div class="w-[20%] flex justify-center items-center">        
            <div class="transform -rotate-90 md:rotate-0 origin-center whitespace-nowrap">
                <h2 class="h2 md:text-right md:pr-4" :class="colorClass">{{ props.heading }}</h2>
            </div>
        </div>

    <div
      class="w-[80%] flex flex-col items-start border-l text-left divide-y text-sm"
      :class="colorClass"
    >
      <p :class="colorClass" class="p pl-4 py-2">{{ props.description }}</p>
    </div>
  </div>
</template>