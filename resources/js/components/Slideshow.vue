<script setup>
import { ref, computed, onMounted, onUnmounted, nextTick } from 'vue'
import { useI18n } from 'vue-i18n'

import Button from './Button.vue'
import Tag from './Tag.vue'

const { t } = useI18n()

const props = defineProps({
    slides: {
        type: Array,
        default: () => [],
    },
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
    enableGallery: {
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

const swipeStartX = ref(0)
const swipeStartY = ref(0)

let autoplayTimer = null

const isLight = computed(() => props.variant === 'light')
const hasSlides = computed(() => props.slides.length > 0)

const slideItems = computed(() => {
    if (hasSlides.value) return props.slides

    return props.images.map((image) => ({
        image,
        title: '',
        description: '',
        tags: [],
        buttonText: '',
    }))
})

const currentSlide = computed(() => slideItems.value[currentIndex.value] || null)
const currentImage = computed(() => currentSlide.value?.image || props.images[currentIndex.value] || null)
const currentTags = computed(() => currentSlide.value?.tags || props.tags || [])
const currentTitle = computed(() => currentSlide.value?.title || props.heading || '')
const currentDescription = computed(() => currentSlide.value?.description || props.description || '')
const currentButtonText = computed(() => currentSlide.value?.buttonText || props.buttonText || '')

const canOpenGallery = computed(() =>
    props.enableGallery && !!currentImage.value
)

const transitionName = computed(() =>
    slideDirection.value === 'prev' ? 'slide-right' : 'slide-left'
)

const colorClass = computed(() =>
    isLight.value
        ? 'text-darkcolor border-darkcolor'
        : 'text-lightcolor border-lightcolor'
)

const invertedClass = computed(() =>
    isLight.value
        ? 'bg-darkcolor text-lightcolor border-darkcolor'
        : 'bg-lightcolor text-darkcolor border-lightcolor'
)

const gradientClass = computed(() =>
    isLight.value
        ? 'from-lightcolor to-transparent'
        : 'from-darkcolor to-transparent'
)

const dotClass = computed(() =>
    isLight.value ? 'bg-darkcolor' : 'bg-lightcolor'
)

const indicatorBgClass = computed(() =>
    isLight.value
        ? 'bg-lightcolor text-darkcolor'
        : 'bg-darkcolor text-lightcolor'
)

function getImageSrc(slide) {
    return slide?.image?.src || slide?.image || slide?.src || ''
}

function getImageAlt(slide) {
    return slide?.image?.alt || slide?.alt || ''
}

function updateTagsScrollState() {
    const el = tagsScroller.value
    if (!el) return

    canScrollTagsLeft.value = el.scrollLeft > 0
    canScrollTagsRight.value = el.scrollLeft + el.clientWidth < el.scrollWidth - 1
}

function startAutoplay() {
    stopAutoplay()

    if (slideItems.value.length <= 1 || props.interval <= 0 || isLightboxOpen.value) return

    autoplayTimer = window.setInterval(next, props.interval)
}

function stopAutoplay() {
    if (!autoplayTimer) return

    clearInterval(autoplayTimer)
    autoplayTimer = null
}

function next() {
    if (!slideItems.value.length) return

    slideDirection.value = 'next'
    currentIndex.value = (currentIndex.value + 1) % slideItems.value.length
}

function prev() {
    if (!slideItems.value.length) return

    slideDirection.value = 'prev'
    currentIndex.value =
        (currentIndex.value - 1 + slideItems.value.length) % slideItems.value.length
}

function nextManual() {
    next()
    startAutoplay()
}

function prevManual() {
    prev()
    startAutoplay()
}

function openLightbox() {
    if (!canOpenGallery.value) return

    stopAutoplay()
    isLightboxOpen.value = true
    document.body.style.overflow = 'hidden'
}

function closeLightbox() {
    isLightboxOpen.value = false
    document.body.style.overflow = ''
    startAutoplay()
}

function handleTouchStart(event) {
    if (!slideItems.value.length) return

    stopAutoplay()

    const touch = event.changedTouches[0]
    swipeStartX.value = touch.clientX
    swipeStartY.value = touch.clientY
}

function handleTouchEnd(event) {
    if (!slideItems.value.length) return

    const touch = event.changedTouches[0]
    const deltaX = touch.clientX - swipeStartX.value
    const deltaY = touch.clientY - swipeStartY.value
    const horizontalThreshold = 40

    if (Math.abs(deltaX) >= horizontalThreshold && Math.abs(deltaX) > Math.abs(deltaY)) {
        deltaX < 0 ? next() : prev()
    }

    if (!isLightboxOpen.value) {
        startAutoplay()
    }
}

function handleKeydown(event) {
    if (!isLightboxOpen.value) return

    if (event.key === 'Escape') closeLightbox()
    if (event.key === 'ArrowRight') next()
    if (event.key === 'ArrowLeft') prev()
}

function handleButtonClick() {
    emit('button-click', currentSlide.value)
}

onMounted(() => {
    window.addEventListener('keydown', handleKeydown)
    window.addEventListener('resize', updateTagsScrollState)

    nextTick(updateTagsScrollState)
    startAutoplay()
})

onUnmounted(() => {
    stopAutoplay()

    window.removeEventListener('keydown', handleKeydown)
    window.removeEventListener('resize', updateTagsScrollState)
    document.body.style.overflow = ''
})
</script>

<template>
  <div class="flex flex-col gap-2 pb-2" :class="colorClass">
    <div
      class="relative h-[450px] w-full overflow-hidden border md:h-[550px]"
      :class="colorClass"
    >
      <div
        class="relative h-full w-full touch-pan-y"
        @touchstart.passive="handleTouchStart"
        @touchend.passive="handleTouchEnd"
      >
        <div v-if="canOpenGallery" class="absolute right-0 top-0 z-[20]">
          <button
            class="flex h-8 w-8 cursor-pointer items-center justify-center border-b border-l"
            :class="
              isLight
                ? 'bg-lightcolor text-darkcolor border-darkcolor'
                : 'bg-darkcolor text-lightcolor border-lightcolor'
            "
            :aria-label="t('slideshow.openGallery')"
            @click.stop="openLightbox"
          >
            <i class="bi bi-arrows-angle-expand"></i>
          </button>
        </div>

        <transition :name="transitionName">
          <div
            v-if="currentImage"
            :key="currentIndex"
            class="absolute inset-0 z-[2]"
          >
            <img
              :src="getImageSrc(currentSlide)"
              :alt="getImageAlt(currentSlide)"
              class="h-full w-full object-cover"
              :class="canOpenGallery ? 'cursor-pointer' : ''"
              @click="openLightbox"
            />
          </div>
        </transition>

        <div
          v-if="slideItems.length > 1"
          class="absolute inset-x-0 bottom-0 z-[5] flex flex-col justify-end"
        >
          <div
            class="flex min-w-0 items-center gap-2 bg-gradient-to-t px-4 pb-3 pt-16"
            :class="gradientClass"
          >
            <h2
              v-if="currentTitle"
              class="h2 inline-flex h-7 shrink-0 items-center whitespace-nowrap border px-2"
              :class="invertedClass"
            >
              {{ currentTitle }}
            </h2>

            <div v-if="currentTags.length" class="relative min-w-0 flex-1">
              <div
                ref="tagsScroller"
                class="scrollbar-hide flex h-7 gap-2 overflow-x-auto"
                :class="[
                  canScrollTagsLeft ? 'pl-8' : '',
                  canScrollTagsRight ? 'pr-8' : ''
                ]"
                @scroll="updateTagsScrollState"
              >
                <Tag
                  v-for="tag in currentTags"
                  :key="tag"
                  class="inline-flex h-7 shrink-0 items-center"
                  :text="tag"
                  :variant="variant"
                />
              </div>
            </div>
          </div>

          <div
            class="flex flex-col gap-4 px-4 py-4"
            :class="indicatorBgClass"
          >
            <p v-if="currentDescription" class="p text-center">
              {{ currentDescription }}
            </p>

            <Button
              v-if="currentButtonText"
              :text="currentButtonText"
              :variant="variant"
              @click="handleButtonClick"
            />

            <div class="flex justify-center gap-2">
              <span
                v-for="(_, index) in slideItems"
                :key="index"
                class="h-1.5 w-1.5 rounded-full transition-opacity"
                :class="[dotClass, index === currentIndex ? 'opacity-100' : 'opacity-40']"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="flex w-full items-center">
      <div class="flex-1"></div>

      <div class="flex items-center justify-center gap-6">
        <button
          v-if="showArrows && slideItems.length > 1"
          class="z-10 cursor-pointer"
          :class="colorClass"
          :aria-label="t('slideshow.previousSlide')"
          @click="prevManual"
        >
          <i class="bi bi-chevron-left"></i>
        </button>

        <button
          v-if="showArrows && slideItems.length > 1"
          class="z-10 cursor-pointer"
          :class="colorClass"
          :aria-label="t('slideshow.nextSlide')"
          @click="nextManual"
        >
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>

      <div class="flex-1"></div>
    </div>

    <Teleport v-if="enableGallery" to="body">
      <transition name="fade">
        <div
          v-if="isLightboxOpen"
          class="fixed inset-0 z-[999] flex flex-col"
          :class="indicatorBgClass"
        >
          <div class="absolute right-0 top-0 z-10">
            <button
              class="flex h-8 w-8 cursor-pointer items-center justify-center border-b border-l"
              :class="
                isLight
                  ? 'bg-darkcolor text-lightcolor border-darkcolor'
                  : 'bg-lightcolor text-darkcolor border-lightcolor'
              "
              @click="closeLightbox"
            >
              <i class="bi bi-x-lg"></i>
            </button>
          </div>

          <div
            class="relative flex flex-1 items-center justify-center overflow-hidden p-4"
            @touchstart.passive="handleTouchStart"
            @touchend.passive="handleTouchEnd"
          >
            <img
              v-if="currentImage"
              :src="getImageSrc(currentSlide)"
              :alt="getImageAlt(currentSlide)"
              class="max-h-full max-w-full object-contain"
            />

            <button
              v-if="slideItems.length > 1"
              type="button"
              class="absolute left-4 cursor-pointer"
              :class="colorClass"
              :aria-label="t('slideshow.previousSlide')"
              @click="prev"
            >
              <i class="bi bi-chevron-left"></i>
            </button>

            <button
              v-if="slideItems.length > 1"
              type="button"
              class="absolute right-4 cursor-pointer"
              :class="colorClass"
              :aria-label="t('slideshow.nextSlide')"
              @click="next"
            >
              <i class="bi bi-chevron-right"></i>
            </button>
          </div>

          <div
            class="flex gap-2 overflow-x-auto border-t p-4"
            :class="colorClass"
          >
            <button
              v-for="(slide, index) in slideItems"
              :key="index"
              type="button"
              class="h-16 w-24 shrink-0 cursor-pointer overflow-hidden border transition-opacity"
              :class="[colorClass, index === currentIndex ? 'opacity-100' : 'opacity-40']"
              @click="currentIndex = index"
            >
              <img
                :src="getImageSrc(slide)"
                :alt="getImageAlt(slide)"
                class="h-full w-full object-cover"
              />
            </button>
          </div>
        </div>
      </transition>
    </Teleport>
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

.slide-left-enter-to,
.slide-left-leave-from,
.slide-right-enter-to,
.slide-right-leave-from {
    transform: translateX(0);
}

.slide-left-leave-to {
    transform: translateX(-100%);
}

.slide-right-enter-from {
    transform: translateX(-100%);
}

.slide-right-leave-to {
    transform: translateX(100%);
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 250ms ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>