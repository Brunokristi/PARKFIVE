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


const tagColor = computed(() =>
  props.variant === 'light' ? 'text-darkcolor' :
  props.variant === 'dark' ? 'text-lightcolor' : 'text-lightcolor'
)
</script>

<template>
    <span
      class="inline-flex items-center border px-2 w-fit align-middle"
      :class="tagColor"
    >
      <span class="p lowercase">
        {{ props.text }}
      </span>
    </span>
</template>