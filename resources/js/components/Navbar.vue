<script setup>
import { computed, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'

import Logo from './Logo.vue'
import Table from './Table.vue'

const props = defineProps({
    variant: {
        type: String,
        default: 'dark',
    },
})

const router = useRouter()
const { t, locale } = useI18n()

const isOpen = ref(false)

const isLight = computed(() => props.variant === 'light')

const colorClass = computed(() =>
    isLight.value ? 'text-darkcolor' : 'text-lightcolor'
)

const headerButtonClass = computed(() =>
    isLight.value
        ? 'bg-darkcolor text-lightcolor border-darkcolor'
        : 'bg-lightcolor text-darkcolor border-lightcolor'
)

const overlayClass = 'bg-darkcolor text-lightcolor'
const overlayButtonClass = 'bg-lightcolor text-darkcolor border-lightcolor'

const hotelSections = computed(() => [
    {
        id: 'hotel-menu',
        heading: t('home.menu'),
        rows: [
            createMenuRow('home', t('nav.home'), '/'),
            createMenuRow('hotel', t('nav.hotel'), '/property'),
            createMenuRow('services', t('nav.services'), '/services'),
            createMenuRow('policies', t('nav.policies'), '/policies'),
            createMenuRow('contact', t('nav.contact'), '/contact'),
        ],
    },
])

const platformSections = computed(() => [
    {
        id: 'platform-menu',
        heading: t('nav.more'),
        rows: [
            createMenuRow('planner', t('nav.planner'), '/planner'),
            createMenuRow('privacy', t('nav.privacy'), '/privacy-policy'),
        ],
    },
])

const languageSections = computed(() => [
    {
        id: 'language-menu',
        heading: t('nav.language'),
        rows: [
            createLanguageRow('sk', 'Slovenčina'),
            createLanguageRow('en', 'English'),
        ],
    },
])

function createMenuRow(id, label, path) {
    return {
        id,
        label,
        actions: [
            {
                id: 'open',
                icon: 'bi bi-chevron-right',
                onClick: () => goTo(path),
            },
        ],
        onClick: () => goTo(path),
    }
}

function createLanguageRow(code, label) {
    return {
        id: code,
        label,
        actions: [
            {
                id: 'open',
                icon: locale.value === code ? 'bi bi-check-lg' : 'bi bi-chevron-right',
                onClick: () => changeLanguage(code),
            },
        ],
        onClick: () => changeLanguage(code),
    }
}

function goTo(path) {
    closeMenu()
    router.push(path)
}

function changeLanguage(code) {
    locale.value = code
    closeMenu()
}

function toggleMenu() {
    isOpen.value = !isOpen.value
}

function closeMenu() {
    isOpen.value = false
}
</script>

<template>
  <div
    class="sticky top-0 z-50 flex items-center justify-between pl-8"
    :class="colorClass"
  >
    <a
      href="/"
      class="flex h-8 items-center border-b border-r px-3"
      :class="headerButtonClass"
    >
      <Logo :width="20" :height="20" />
      <h2 class="ml-1 h2">
        parkFIVE
      </h2>
    </a>

    <div class="absolute right-0 top-0 z-10">
      <button
        type="button"
        class="flex h-8 w-8 cursor-pointer items-center justify-center border-b border-l"
        :class="headerButtonClass"
        @click="toggleMenu"
      >
        <i class="bi bi-list"></i>
      </button>
    </div>
  </div>

  <Teleport to="body">
    <div
      v-if="isOpen"
      class="fixed inset-0 z-[999] flex flex-col backdrop-blur-sm"
      :class="overlayClass"
      @click.self="closeMenu"
    >
      <div class="absolute right-0 top-0 z-10">
        <button
          type="button"
          class="flex h-8 w-8 cursor-pointer items-center justify-center border-b border-l"
          :class="overlayButtonClass"
          @click="closeMenu"
        >
          <i class="bi bi-x-lg"></i>
        </button>
      </div>

      <div class="flex flex-1 items-center justify-center px-4">
        <div class="flex w-full flex-col gap-16">
          <Table
            :sections="hotelSections"
            variant="dark"
          />

          <Table
            :sections="platformSections"
            variant="dark"
          />

          <Table
            :sections="languageSections"
            variant="dark"
          />
        </div>
      </div>
    </div>
  </Teleport>
</template>