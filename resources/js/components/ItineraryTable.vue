<script setup>
import { computed } from 'vue'

const props = defineProps({
  days: {
        type: Array,
        default: () => [],
    },
  hoursPerDay: {
    type: Number,
    default: 8,
  },
    variant: {
        type: String,
        default: 'dark',
    },
})

const emit = defineEmits(['remove', 'move-up', 'move-down'])

const isLight = computed(() => props.variant === 'light')

const colorClass = computed(() =>
    isLight.value
        ? 'text-darkcolor border-darkcolor'
        : 'text-lightcolor border-lightcolor'
)

const totalItems = computed(() =>
  props.days.reduce((sum, day) => sum + day.items.length, 0)
)
</script>

<template>
  <div class="w-full" :class="colorClass">
    <div
      v-for="day in days"
      :key="day.day"
      class="mb-6 last:mb-0 border-b"
      :class="colorClass"
    >
      <div class="flex items-center justify-between py-2">
        <h3 class="h2">
          Deň {{ day.day }}
        </h3>

        <span class="p">
          {{ day.usedHours }} / {{ hoursPerDay }} h
        </span>
      </div>

      <div
        v-for="item in day.items"
        :key="`${item.id}-${item.itineraryIndex}`"
        class="flex items-center border-t px-4 py-2 p"
        :class="colorClass"
      >
        <div class="flex-1">
          <p class="p">
            {{ item.title }}
          </p>
          <p class="text-[10px] opacity-80">
            Trvanie: {{ item.durationHours }} h
          </p>
        </div>

        <div class="flex items-center gap-3 pl-3">
          <button
            type="button"
            class="cursor-pointer transition-opacity hover:opacity-70"
            @click="emit('remove', item)"
          >
            <i class="bi bi-x-lg"></i>
          </button>

          <button
            type="button"
            class="cursor-pointer transition-opacity hover:opacity-70 disabled:opacity-30"
            :disabled="item.itineraryIndex === 0"
            @click="emit('move-up', item.itineraryIndex)"
          >
            <i class="bi bi-chevron-up"></i>
          </button>

          <button
            type="button"
            class="cursor-pointer transition-opacity hover:opacity-70 disabled:opacity-30"
            :disabled="item.itineraryIndex === totalItems - 1"
            @click="emit('move-down', item.itineraryIndex)"
          >
            <i class="bi bi-chevron-down"></i>
          </button>
        </div>
      </div>
    </div>

    <p v-if="!days.length" class="p opacity-80">
      Zatiaľ nemáte vybrané žiadne aktivity.
    </p>
  </div>
</template>