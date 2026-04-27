<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    heading: String,
    text: String,
    variant: {
        type: String,
        default: 'dark',
    },
    opened: {
        type: Boolean,
        default: false,
    },
})

const isOpen = ref(props.opened)

const isLight = computed(() => props.variant === 'light')

const iconClass = computed(() =>
    isOpen.value ? 'rotate-180' : 'rotate-0'
)

function toggleOpen() {
    isOpen.value = !isOpen.value
}

const colorClass = computed(() =>
    isLight.value
        ? 'text-darkcolor border-darkcolor'
        : 'text-lightcolor border-lightcolor'
)
</script>

<template>
  <div class="w-full" :class="colorClass">

    <div class="grid grid-cols-[20%_80%]">

      <div class="flex items-center justify-center border-r " :class="colorClass">
        <button
          class="flex items-center justify-center w-full h-full py-2 cursor-pointer"
          @click="toggleOpen"
        >
          <i
            class="bi bi-chevron-down transition-transform duration-300"
            :class="iconClass"
          ></i>
        </button>
      </div>

      <div class="flex flex-col">

        <button
          class="w-full text-left px-4 py-2 flex items-center cursor-pointer"
          :class="colorClass"
          @click="toggleOpen"
        >
          <h2 class="h2">
            {{ heading }}
          </h2>
        </button>

        <!-- ANSWER -->
        <transition name="accordion">
          <div
            v-show="isOpen"
            class="px-4 py-2 border-t"
            :class="colorClass"
          >
            <p class="p text-left">
              {{ text }}
            </p>
          </div>
        </transition>

      </div>
    </div>

  </div>
</template>