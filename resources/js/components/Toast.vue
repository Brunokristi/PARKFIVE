<script setup>
import { ref, watch, onBeforeUnmount, computed } from 'vue'

const props = defineProps({
  heading: {
    type: String,
    default: '',
  },
  text: {
    type: String,
    default: '',
  },
  duration: {
    type: Number,
    default: 3000,
  },
  modelValue: {
    type: Boolean,
    default: false,
  },
  variant: {
    type: String,
    default: 'dark',
  },
})

const emit = defineEmits(['update:modelValue'])

const isVisible = ref(props.modelValue)
let timeoutId = null

const isLight = computed(() => props.variant === 'light')

const toastClass = computed(() =>
    isLight.value
    ? 'bg-darkcolor text-lightcolor border-darkcolor'
  : 'bg-lightcolor text-darkcolor border-lightcolor'
)

const closeButtonClass = computed(() =>
    isLight.value
    ? 'bg-lightcolor text-darkcolor border-lightcolor'
    : 'bg-darkcolor text-lightcolor border-darkcolor'
)

function clearTimer() {
  if (!timeoutId) return

  clearTimeout(timeoutId)
  timeoutId = null
}

function closeToast() {
  isVisible.value = false
  emit('update:modelValue', false)
  clearTimer()
}

function startTimer() {
  clearTimer()

  if (props.duration > 0) {
    timeoutId = setTimeout(closeToast, props.duration)
  }
}

watch(
  () => props.modelValue,
  (newValue) => {
    isVisible.value = newValue

    if (newValue) {
      startTimer()
    } else {
      clearTimer()
    }
  },
  { immediate: true }
)

onBeforeUnmount(clearTimer)
</script>

<template>
  <Teleport to="body">
    <transition name="toast">
      <div
        v-if="isVisible"
        class="fixed bottom-0 right-0 md:bottom-8 md:right-8 z-[999] w-[calc(100vw-2rem)] max-w-sm border px-4 py-3"
        :class="toastClass"
        role="status"
        aria-live="polite"
      >
        <button
          type="button"
          class="absolute right-0 top-0 flex h-7 w-7 items-center justify-center border cursor-pointer"
          :class="closeButtonClass"
          aria-label="Close toast"
          @click="closeToast"
        >
          <i class="bi bi-x-lg text-xs"></i>
        </button>

        <div class="pr-8">
          <h3 v-if="heading" class="h2 text-start mb-1">
            {{ heading }}
          </h3>

          <p v-if="text" class="p">
            {{ text }}
          </p>
        </div>
      </div>
    </transition>
  </Teleport>
</template>

<style scoped>
.toast-enter-active,
.toast-leave-active {
  transition: opacity 300ms ease, transform 300ms ease;
}

.toast-enter-from,
.toast-leave-to {
  opacity: 0;
  transform: translate(24px, 24px);
}

.toast-enter-to,
.toast-leave-from {
  opacity: 1;
  transform: translate(0, 0);
}
</style>