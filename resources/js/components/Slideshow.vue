<script setup>
import { ref, computed, onMounted, onUnmounted, nextTick } from 'vue'
import { useI18n } from 'vue-i18n'
import Tag from './Tag.vue'
import Button from './Button.vue'

const { t } = useI18n()

const props = defineProps({
    images: {
        type: Array,
        default: () => [],
    },
    heading: {
        type: String,
        default: '',
    },
    tags: {
        type: Array,
        default: () => [],
    },
    description: {
        type: String,
        default: '',
    },
    buttonText: {
        type: String,
        default: '',
    },
    interval: {
        type: Number,
        default: 4000,
    },
    showArrows: {
        type: Boolean,
        default: true,
    },
    variant: {
        type: String,
        default: 'dark',
    },
})

const emit = defineEmits(['button-click'])

const currentIndex = ref(0)
const slideDirection = ref('next')
const isLightboxOpen = ref(false)

const tagsScroller = ref(null)
const canScrollTagsLeft = ref(false)
const canScrollTagsRight = ref(false)

const currentImage = computed(() => props.images[currentIndex.value] || null)

const transitionName = computed(() =>
    slideDirection.value === 'prev' ? 'slide-right' : 'slide-left'
)

const invertedClass = computed(() =>
    isLight.value
        ? 'bg-darkcolor text-lightcolor border-darkcolor'
        : 'bg-lightcolor text-darkcolor border-lightcolor'
)

const isLight = computed(() => props.variant === 'light')

const colorClass = computed(() =>
    isLight.value ? 'text-darkcolor border-darkcolor' : 'text-lightcolor border-lightcolor'
)

const gradientClass = computed(() =>
    isLight.value ? 'from-lightcolor to-transparent' : 'from-darkcolor to-transparent'
)

const dotClass = computed(() =>
    isLight.value ? 'bg-darkcolor' : 'bg-lightcolor'
)

const indicatorBgClass = computed(() =>
    isLight.value ? 'bg-lightcolor' : 'bg-darkcolor'
)

const swipeStartX = ref(0)
const swipeStartY = ref(0)

function updateTagsScrollState() {
    const el = tagsScroller.value
    if (!el) return

    canScrollTagsLeft.value = el.scrollLeft > 0
    canScrollTagsRight.value = el.scrollLeft + el.clientWidth < el.scrollWidth - 1
}

function scrollTags(direction) {
    const el = tagsScroller.value
    if (!el) return

    el.scrollBy({
        left: direction === 'left' ? -120 : 120,
        behavior: 'smooth',
    })
}

function handleTouchStart(event) {
    if (!props.images.length) return

    const touch = event.changedTouches[0]
    swipeStartX.value = touch.clientX
    swipeStartY.value = touch.clientY
}

function handleTouchEnd(event) {
    if (!props.images.length) return

    const touch = event.changedTouches[0]
    const deltaX = touch.clientX - swipeStartX.value
    const deltaY = touch.clientY - swipeStartY.value
    const horizontalThreshold = 40

    if (Math.abs(deltaX) < horizontalThreshold) return
    if (Math.abs(deltaX) <= Math.abs(deltaY)) return

    if (deltaX < 0) {
        next()
    } else {
        prev()
    }
}

function next() {
    if (!props.images.length) return

    slideDirection.value = 'next'
    currentIndex.value = (currentIndex.value + 1) % props.images.length
}

function prev() {
    if (!props.images.length) return

    slideDirection.value = 'prev'
    currentIndex.value =
        (currentIndex.value - 1 + props.images.length) % props.images.length
}

function closeLightbox() {
    isLightboxOpen.value = false
    document.body.style.overflow = ''
}

function handleKeydown(event) {
    if (!isLightboxOpen.value) return

    if (event.key === 'Escape') closeLightbox()
    if (event.key === 'ArrowRight') next()
    if (event.key === 'ArrowLeft') prev()
}

function handleButtonClick() {
    emit('button-click')
}

onMounted(() => {
    window.addEventListener('keydown', handleKeydown)
    window.addEventListener('resize', updateTagsScrollState)

    nextTick(updateTagsScrollState)
})

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown)
    window.removeEventListener('resize', updateTagsScrollState)
    document.body.style.overflow = ''
})
</script>

<template>
  <div class="flex flex-col gap-4 pb-2" :class="colorClass">
    <div class="relative h-[450px] md:h-[550px] w-full overflow-hidden border" :class="colorClass">
      <div
        class="relative h-full w-full touch-pan-y"
        @touchstart.passive="handleTouchStart"
        @touchend.passive="handleTouchEnd"
      >
        <transition :name="transitionName">
          <div
            v-if="currentImage"
            :key="currentIndex"
            class="absolute inset-0 z-[2]"
          >
            <img
              :src="currentImage.src"
              :alt="currentImage.alt || ''"
              class="h-full w-full object-cover"
            />
          </div>
        </transition>

        <div
          v-if="images.length > 1"
          class="absolute inset-x-0 bottom-0 z-[5] flex flex-col justify-end"
        >
          <div
            class="bg-gradient-to-t px-4 pb-3 pt-16 flex items-center gap-2 min-w-0"
            :class="gradientClass"
          >
            <h2
              v-if="heading"
              class="h2 shrink-0 whitespace-nowrap border px-2 h-7 inline-flex items-center"
              :class="invertedClass"
            >
              {{ heading }}
            </h2>

            <div v-if="tags.length" class="relative min-w-0 flex-1">

              <div
                ref="tagsScroller"
                class="flex h-7 gap-2 overflow-x-auto scrollbar-hide"
                :class="[
                  canScrollTagsLeft ? 'pl-8' : '',
                  canScrollTagsRight ? 'pr-8' : ''
                ]"
                @scroll="updateTagsScrollState"
              >
                <Tag
                  v-for="tag in tags"
                  :key="tag"
                  class="shrink-0 h-7 inline-flex items-center"
                  :text="tag"
                  :variant="variant"
                />
              </div>
            </div>
          </div>

          <div
            class="flex flex-col gap-4 px-4 py-2"
            :class="indicatorBgClass"
          >
            <p v-if="description" class="p text-center">
              {{ description }}
            </p>

            <Button
              v-if="buttonText"
              :text="buttonText"
              :variant="variant"
              @click="handleButtonClick"
            />

            <div class="flex justify-center gap-2">
              <span
                v-for="(_, index) in images"
                :key="index"
                class="h-1.5 w-1.5 rounded-full transition-opacity"
                :class="[dotClass, index === currentIndex ? 'opacity-100' : 'opacity-40']"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-center gap-6 w-full">
      <button
        v-if="showArrows && images.length > 1"
        class="z-10 cursor-pointer"
        :class="colorClass"
        @click="prev"
        :aria-label="t('slideshow.previousSlide')"
      >
        <i class="bi bi-arrow-left"></i>
      </button>

      <button
        v-if="showArrows && images.length > 1"
        class="z-10 cursor-pointer"
        :class="colorClass"
        @click="next"
        :aria-label="t('slideshow.nextSlide')"
      >
        <i class="bi bi-arrow-right"></i>
      </button>
    </div>
  </div>
</template>

<style scoped>
.slide-left-enter-active,
.slide-left-leave-active,
.slide-right-enter-active,
.slide-right-leave-active {
    transition: transform 450ms ease;
}

.slide-left-enter-from {
    transform: translateX(100%);
}

.slide-left-enter-to {
    transform: translateX(0);
}

.slide-left-leave-from {
    transform: translateX(0);
}

.slide-left-leave-to {
    transform: translateX(-100%);
}

.slide-right-enter-from {
    transform: translateX(-100%);
}

.slide-right-enter-to {
    transform: translateX(0);
}

.slide-right-leave-from {
    transform: translateX(0);
}

.slide-right-leave-to {
    transform: translateX(100%);
}
</style>