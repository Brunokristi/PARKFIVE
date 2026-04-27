<script setup>
import { computed } from 'vue'

const props = defineProps({
  text: {
    type: String,
    default: '',
  },
  variant: {
    type: String,
    default: 'dark',
  },
})

const emit = defineEmits(['click'])

const buttonColor = computed(() =>
  props.variant === 'light' ? 'text-darkcolor' :
  props.variant === 'dark' ? 'text-lightcolor' :
  'text-lightcolor'
)
</script>

<template>
    <div class="w-full flex justify-center">
    <button
      type="button"
            class="group inline-flex flex-col items-start cursor-pointer"
            :class="buttonColor"
      @click="emit('click')"
        >
            <span class="p font-mono lowercase">
            {{ props.text }}
            </span>

            <span class="relative mt-0.5 h-[1px] w-full bg-current transition-transform duration-300 group-hover:-translate-y-0.5">
            </span>
            </button>
    </div>
</template>