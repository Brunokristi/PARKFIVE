<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'

const props = defineProps({
    images: {
        type: Array,
        default: () => [],
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

const currentIndex = ref(0)
const slideDirection = ref('next')
const isLightboxOpen = ref(false)

const currentImage = computed(() => props.images[currentIndex.value] || null)

const transitionName = computed(() =>
    slideDirection.value === 'prev' ? 'slide-right' : 'slide-left'
)

const isLight = computed(() => props.variant === 'light');

const colorClass = computed(() =>
    isLight.value ? 'text-darkcolor' : 'text-lightcolor'
);

const gradientClass = computed(() =>
    isLight.value
        ? 'from-lightcolor to-transparent'
        : 'from-darkcolor to-transparent'
);

const dotClass = computed(() =>
    isLight.value
        ? 'bg-darkcolor'
        : 'bg-lightcolor'
);

const indicatorBgClass = computed(() =>
    isLight.value
        ? 'bg-lightcolor'
        : 'bg-darkcolor'
);

const swipeStartX = ref(0)
const swipeStartY = ref(0)

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

function handleKeydown(event) {
    if (!isLightboxOpen.value) return

    if (event.key === 'Escape') closeLightbox()
    if (event.key === 'ArrowRight') next()
    if (event.key === 'ArrowLeft') prev()
}

onMounted(() => {
    window.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown)
    document.body.style.overflow = ''
})
</script>

<template>
    <div class="flex justify-center flex-col items-center gap-2  pb-2">
        <div class="relative h-[400px] w-full overflow-hidden border" :class="colorClass">
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
                class="pointer-events-none absolute inset-x-0 bottom-0 z-[5]"
                >
                <div
                    class="absolute inset-x-0 bottom-8 h-32 bg-gradient-to-t -mb-0.5"
                    :class="gradientClass"
                ></div>

                <div
                    class="absolute inset-x-0 bottom-0 flex h-8 items-center justify-center"
                    :class="indicatorBgClass"
                >
                    <div class="flex gap-2">
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
                class="z-10 cursor-pointer" :class="[colorClass]"
                @click="prev"
                aria-label="Previous slide"
            >
                <i class="bi bi-arrow-left"></i>
            </button>

            <button
                v-if="showArrows && images.length > 1"
                class="z-10 cursor-pointer" :class="[colorClass]"
                @click="next"
                aria-label="Next slide"
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