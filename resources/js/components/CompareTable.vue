<script setup lang="ts">
import { computed } from 'vue'

interface RoomType {
    id: string
    label: string
    features: string[]
}

const props = defineProps<{
    rooms: RoomType[]
    features: string[]
    variant?: 'light' | 'dark'
}>()

const isLight = computed(() => props.variant === 'light')

const colorClass = computed(() =>
    isLight.value
        ? 'text-darkcolor border-darkcolor'
        : 'text-lightcolor border-lightcolor'
)

function hasFeature(room: RoomType, feature: string) {
    return room.features.includes(feature)
}
</script>

<template>
  <div class="grid w-full grid-cols-[20%_80%]" :class="colorClass">
    <!-- LEFT: room labels, not scrollable -->
    <div>
      <div class="h-24 border-r border-b" :class="colorClass"></div>

      <div
        v-for="room in rooms"
        :key="room.id"
        class="flex h-24 items-center justify-center border-r"
        :class="colorClass"
      >
        <span class="-rotate-90 md:rotate-0 whitespace-nowrap h2">
          {{ room.label }}
        </span>
      </div>
    </div>

    <!-- RIGHT: only this scrolls -->
    <div class="overflow-x-auto">
      <div
        class="grid min-w-max"
        :style="{ gridTemplateColumns: `repeat(${features.length}, 96px)` }"
      >
        <!-- feature headers -->
        <div
          v-for="(feature, featureIndex) in features"
          :key="feature"
          class="flex h-24 items-center justify-center border-b"
          :class="[
            colorClass,
            featureIndex !== features.length - 1 ? 'border-r' : ''
          ]"
        >
          <span class="-rotate-90 whitespace-nowrap h2">
            {{ feature }}
          </span>
        </div>

        <template v-for="(room, roomIndex) in rooms" :key="room.id">
          <div
            v-for="(feature, featureIndex) in features"
            :key="`${room.id}-${feature}`"
            class="flex h-24 items-center justify-center"
            :class="[
              colorClass,
              featureIndex !== features.length - 1 ? 'border-r' : '',
              roomIndex !== rooms.length - 1 ? 'border-b' : ''
            ]"
          >
            <i
              v-if="hasFeature(room, feature)"
              class="bi bi-check-lg"
            ></i>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>