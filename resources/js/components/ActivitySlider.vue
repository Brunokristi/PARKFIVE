<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import Tag from './Tag.vue'
import Button from './Button.vue'
import Map from './Map.vue'

const props = defineProps({
    activities: {
        type: Array,
        default: () => [],
    },
    variant: {
        type: String,
        default: 'dark',
    },
    showArrows: {
        type: Boolean,
        default: true,
    },
})
const showAddLabel = ref(true)

onMounted(() => {
    window.addEventListener('keydown', handleKeydown)

    window.setTimeout(() => {
        showAddLabel.value = false
    }, 2000)
})

const emit = defineEmits(['select-activity', 'more-info'])

const currentIndex = ref(0)
const slideDirection = ref('next')

const currentActivity = computed(() => props.activities[currentIndex.value] || null)

const mapSrc = computed(() => {
    if (!currentActivity.value) return ''

    const query =
        currentActivity.value.mapQuery ||
        `${currentActivity.value.lat},${currentActivity.value.lng}`

    return `https://www.google.com/maps?q=${encodeURIComponent(query)}&z=14&output=embed`
})

const isLight = computed(() => props.variant === 'light')

const colorClass = computed(() =>
    isLight.value
        ? 'text-darkcolor border-darkcolor'
        : 'text-lightcolor border-lightcolor'
)

const gradientClass = computed(() =>
    isLight.value
        ? 'from-lightcolor to-transparent'
        : 'from-darkcolor to-transparent'
)

const solidClass = computed(() =>
    isLight.value
        ? 'bg-lightcolor text-darkcolor'
        : 'bg-darkcolor text-lightcolor'
)

const dotClass = computed(() =>
    isLight.value
        ? 'bg-darkcolor'
        : 'bg-lightcolor'
)

const transitionName = computed(() =>
    slideDirection.value === 'prev' ? 'slide-right' : 'slide-left'
)

function next() {
    if (!props.activities.length) return

    slideDirection.value = 'next'
    currentIndex.value = (currentIndex.value + 1) % props.activities.length
}

function prev() {
    if (!props.activities.length) return

    slideDirection.value = 'prev'
    currentIndex.value =
        (currentIndex.value - 1 + props.activities.length) % props.activities.length
}

function selectCurrentActivity() {
    if (!currentActivity.value) return
    emit('select-activity', currentActivity.value)
}

function showMoreInfo() {
    if (!currentActivity.value) return
    emit('more-info', currentActivity.value)
}

function handleKeydown(event) {
    if (event.key === 'ArrowRight') next()
    if (event.key === 'ArrowLeft') prev()
}

onMounted(() => {
    window.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown)
})
</script>

<template>
  <div class="flex flex-col gap-2" :class="colorClass">
    <div class="relative h-[620px] w-full overflow-hidden border" :class="colorClass">
      <transition :name="transitionName">
        <div
          v-if="currentActivity"
          :key="currentActivity.id || currentIndex"
          class="absolute inset-0 flex flex-col"
        >
          <!-- MAP -->
          <div class="h-[42%] w-full border-b" :class="colorClass">
            <div class="absolute top-0 right-0 z-20 flex h-9">
            <button
                type="button"
                class="h-9 overflow-hidden border-b border-l transition-[width,opacity] duration-500 ease-in-out"
                :class="[
                isLight
                    ? 'bg-darkcolor text-lightcolor border-darkcolor'
                    : 'bg-lightcolor text-darkcolor border-lightcolor',
                showAddLabel ? 'w-[184px] opacity-100 px-2' : 'w-0 opacity-0 px-0'
                ]"
                @click.stop="selectCurrentActivity"
            >
                <span class="p whitespace-nowrap">
                pridať lokalitu do plánu
                </span>
            </button>

            <button
                type="button"
                class="flex h-9 w-9 items-center justify-center border-b border-l cursor-pointer"
                :class="isLight
                ? 'bg-darkcolor text-lightcolor border-darkcolor'
                : 'bg-lightcolor text-darkcolor border-lightcolor'"
                @click.stop="selectCurrentActivity"
            >
                <i class="bi bi-plus-lg"></i>
            </button>
            </div>

            <Map
                :lat="currentActivity.lat"
                :lng="currentActivity.lng"
                :name="currentActivity.title"
                :home-lat="48.267"
                :home-lng="19.824"
                home-name="parkFIVE"
                :variant="variant"
            />
          </div>

          <!-- IMAGE -->
          <div class="relative h-[58%] w-full overflow-hidden">

            <img
              :src="currentActivity.image"
              :alt="currentActivity.title || ''"
              class="h-full w-full object-cover"
            />

            <div class="absolute inset-x-0 bottom-0 z-10 flex flex-col justify-end">
              <div
                class="bg-gradient-to-t px-4 pb-0 pt-20"
                :class="gradientClass"
              >
                <div class="flex flex-wrap gap-2">
                  <Tag
                    v-for="tag in currentActivity.tags || []"
                    :key="tag"
                    :text="tag"
                    :variant="variant"
                  />
                  <Tag
                    v-if="currentActivity.durationHours"
                    :text="`${currentActivity.durationHours} h`"
                    :variant="variant"
                  />
                </div>
              </div>

              <div class="flex flex-col gap-4 px-4 py-4" :class="solidClass">
                <p v-if="currentActivity.description" class="p text-center">
                  {{ currentActivity.description }}
                </p>

                <div class="flex justify-center">
                    <Button
                        text="viac informácií"
                        :variant="variant"
                        @click="showMoreInfo"
                    />
                </div>

                <div class="flex justify-center gap-2">
                  <span
                    v-for="(_, index) in activities"
                    :key="index"
                    class="h-1.5 w-1.5 rounded-full transition-opacity"
                    :class="[dotClass, index === currentIndex ? 'opacity-100' : 'opacity-40']"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>

    <div
      v-if="showArrows && activities.length > 1"
      class="flex justify-center gap-6"
    >
      <button type="button" class="cursor-pointer" :class="colorClass" @click="prev">
        <i class="bi bi-arrow-left"></i>
      </button>

      <button type="button" class="cursor-pointer" :class="colorClass" @click="next">
        <i class="bi bi-arrow-right"></i>
      </button>
    </div>
  </div>
</template>