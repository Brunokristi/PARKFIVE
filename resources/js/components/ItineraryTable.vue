<script setup>
import { computed } from 'vue'

const props = defineProps({
    days: {
        type: Array,
        default: () => [],
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

function handleMove(action, index) {
    emit(action, index)
}
</script>

<template>
  <div class="w-full" :class="colorClass">
    <div
      v-for="day in days"
      :key="day.day"
            class="mb-0 last:mb-0"
    >
            <!-- SECTION -->
            <div class="grid grid-cols-[20%_80%] items-stretch">
                <!-- LEFT: day heading -->
                <div class="flex items-center justify-center border-r" :class="colorClass">
                    <div class="-rotate-90 md:rotate-0 flex items-center gap-4 whitespace-nowrap md:pr-8">
                        <div class="h2 md:text-right">
                            Deň {{ day.day }}
                        </div>
                    </div>
                </div>

                <!-- RIGHT: rows -->
                <div class="flex flex-col">
                    <div
                        v-for="item in day.items"
                        :key="`${item.id}-${item.itineraryIndex}`"
                        class="flex items-center border-b pl-4 py-2 p last:border-b-0"
                        :class="colorClass"
                    >
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3">
                                <span class="truncate">
                                    {{ item.title }}
                                </span>

                                <span class="text-[10px] opacity-80 shrink-0">
                                    {{ item.durationHours }} h
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-center w-20 shrink-0">
                            <div class="flex items-center gap-3">
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
                                    @click="handleMove('move-up', item.itineraryIndex)"
                                >
                                    <i class="bi bi-chevron-up"></i>
                                </button>

                                <button
                                    type="button"
                                    class="cursor-pointer transition-opacity hover:opacity-70 disabled:opacity-30"
                                    :disabled="item.itineraryIndex === totalItems - 1"
                                    @click="handleMove('move-down', item.itineraryIndex)"
                                >
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FULL-WIDTH DIVIDER -->
            <div
                v-if="day !== days[days.length - 1]"
                class="w-full border-t"
                :class="colorClass"
            ></div>
        </div>
  </div>
</template>