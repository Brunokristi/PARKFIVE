<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useI18n } from 'vue-i18n'

import Button from './Button.vue'
import Info from './Info.vue'
import { useToast } from '../composables/useToast'

import {
    disableAnalytics,
    enableAnalytics,
    trackPageViewIfConsented,
} from '../composables/useAnalytics'

import {
    getCookiePreferences,
    setCookiePreferences,
    type CookiePreferences,
} from '../composables/useCookieConsent'

const props = defineProps({
    variant: {
        type: String,
        default: 'dark',
    },
})

const { t } = useI18n()

const isOpen = ref(false)
const { show: showToast } = useToast()

const preferences = ref<CookiePreferences>({
    necessary: true,
    analytics: false,
    marketing: false,
})

const originalPreferences = ref<CookiePreferences>({
    necessary: true,
    analytics: false,
    marketing: false,
})

const isLight = computed(() => props.variant === 'light')

const toastClass = computed(() =>
    isLight.value
        ? 'bg-darkcolor text-lightcolor border-lightcolor'
        : 'bg-lightcolor text-darkcolor border-darkcolor'
)

const invertedClass = computed(() =>
    isLight.value
        ? 'bg-lightcolor text-darkcolor border-darkcolor'
        : 'bg-darkcolor text-lightcolor border-lightcolor'
)

const contentVariant = computed(() =>
    isLight.value ? 'dark' : 'light'
)

const isModified = computed(() =>
    JSON.stringify(preferences.value) !== JSON.stringify(originalPreferences.value)
)

function openModal() {
    isOpen.value = true

    const saved = getCookiePreferences()
    if (saved) {
        originalPreferences.value = { ...saved }
        preferences.value = { ...saved }
    }
}

function closeModal() {
    isOpen.value = false
}

function savePreferences(heading: string, text: string) {
    setCookiePreferences(preferences.value)

    if (preferences.value.analytics) {
        enableAnalytics()
        trackPageViewIfConsented()
    } else {
        disableAnalytics()
    }

    originalPreferences.value = { ...preferences.value }
    closeModal()

    showToast(heading, text)
}

function acceptAll() {
    preferences.value = {
        necessary: true,
        analytics: true,
        marketing: true,
    }

    savePreferences(
        t('cookies.toastAcceptedTitle'),
        t('cookies.toastAcceptedText')
    )
}

function rejectAll() {
    preferences.value = {
        necessary: true,
        analytics: false,
        marketing: false,
    }

    savePreferences(
        t('cookies.toastRejectedTitle'),
        t('cookies.toastRejectedText')
    )
}

function onWindowOpenEvent() {
    openModal()
}

onMounted(() => {
    window.addEventListener('open-cookie-consent', onWindowOpenEvent)
})

onUnmounted(() => {
    window.removeEventListener('open-cookie-consent', onWindowOpenEvent)
})

defineExpose({ openModal })
</script>

<template>
  <Teleport to="body">
    <transition name="toast">
      <div
        v-if="isOpen"
        class="fixed bottom-8 right-8 z-[1000] w-[calc(100vw-2rem)] max-w-lg border flex flex-col overflow-hidden max-h-[calc(100vh-8rem)]"
        :class="toastClass"
        role="dialog"
        aria-modal="true"
        :aria-label="t('cookies.policy.title')"
      >
        <!-- CLOSE BUTTON -->
        <button
          type="button"
          class="absolute right-0 top-0 flex h-8 w-8 items-center justify-center border cursor-pointer"
          :class="invertedClass"
          aria-label="Close cookie policy"
          @click="closeModal"
        >
          <i class="bi bi-x-lg text-xs"></i>
        </button>

        <!-- HEADER -->
        <div class="px-4 py-4 h-[100px] flex items-end justify-end" >
          <h1 class="h1">
            {{ t('cookies.consentTitle') }}
          </h1>
        </div>

        <div class="flex flex-col gap-4 overflow-y-auto px-4 py-4">
          <Info
            :heading="t('cookies.policy.necessary')"
            :text="`${t('cookies.policy.necessaryDesc')}\n\n${t('cookies.policy.necessaryList')}`"
            :variant="contentVariant"
          />

          <Info
            :heading="t('cookies.policy.analytics')"
            :text="`${t('cookies.policy.analyticsDesc')}\n\n${t('cookies.policy.analyticsList')}`"
            :variant="contentVariant"
          />

          <Info
            :heading="t('cookies.policy.marketing')"
            :text="`${t('cookies.policy.marketingDesc')}\n\n${t('cookies.policy.marketingList')}`"
            :variant="contentVariant"
          />
        </div>

        <!-- FOOTER -->
        <div class="flex flex-col gap-2 border-t px-4 py-4">
          <Button :text="t('cookies.policy.rejectAll')" :variant="contentVariant" @click="rejectAll" />
          <Button :text="t('cookies.policy.acceptAll')" :variant="contentVariant" @click="acceptAll" />
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