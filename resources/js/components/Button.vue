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
    align: {
        type: String,
        default: 'center', // start | center | end
    },
})

const emit = defineEmits(['click'])

const buttonColor = computed(() =>
    props.variant === 'light'
        ? 'text-darkcolor'
        : 'text-lightcolor'
)

const wrapperClass = computed(() => {
    if (props.align === 'start') return 'justify-start'
    if (props.align === 'end') return 'justify-end'
    return 'justify-center'
})
</script>

<template>
  <div class="w-full flex" :class="wrapperClass">
    <button
      type="button"
      class="group inline-flex items-start cursor-pointer"
      :class="buttonColor"
      @click="emit('click')"
    >
      <span class="p font-mono lowercase underline group-hover:no-underline transition">
        {{ text }}
      </span>
    </button>
  </div>
</template>