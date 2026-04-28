<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'

import Slideshow from '../components/Slideshow.vue'

const route = useRoute()
const { locale } = useI18n()

type Variant = 'light' | 'dark'
type LocalizedText = Record<string, string>

interface DbService {
    id: string
    title: LocalizedText
    description: LocalizedText
    buttonText: LocalizedText
    tags: LocalizedText[]
    images: Array<{
        src: string
        alt: LocalizedText
    }>
}

interface DbCategory {
    id: string
    title: LocalizedText
    services: DbService[]
}

interface DbServicesContent {
    categories: DbCategory[]
}

interface ServiceSlide {
  id: string
  image: { src: string; alt: string }
  title: string
  description: string
  buttonText: string
  tags: string[]
  service: DbService
}

const content = ref<DbServicesContent | null>(null)

const variant = computed<Variant>(() =>
    route.meta.theme === 'light' ? 'light' : 'dark'
)

const pageClass = computed(() =>
    variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
)

function localize(value?: LocalizedText) {
    if (!value) return ''
    return value[locale.value] || value.sk || Object.values(value)[0] || ''
}

/* MOCK DB */
function loadMockContent() {
    content.value = {
        categories: [
            {
                id: 'hotel-services',
                title: {
                    sk: 'Služby hotela',
                    en: 'Hotel services',
                },
                services: [
                    {
                        id: 'breakfast',
                        title: { sk: 'Raňajky', en: 'Breakfast' },
                        description: {
                            sk: 'Čerstvé raňajky každé ráno.',
                            en: 'Fresh breakfast every morning.',
                        },
                        buttonText: { sk: 'viac', en: 'more' },
                        tags: [
                            { sk: 'jedlo', en: 'food' },
                            { sk: 'ráno', en: 'morning' },
                        ],
                        images: [
                            { src: '/assets/image.jpg', alt: { sk: 'Raňajky', en: 'Breakfast' } },
                        ],
                    },
                    {
                        id: 'parking',
                        title: { sk: 'Parkovanie', en: 'Parking' },
                        description: {
                            sk: 'Parkovanie priamo pri objekte.',
                            en: 'Parking at the property.',
                        },
                        buttonText: { sk: 'viac', en: 'more' },
                        tags: [
                            { sk: 'auto', en: 'car' },
                        ],
                        images: [
                            { src: '/assets/image2.jpg', alt: { sk: 'Parkovanie', en: 'Parking' } },
                        ],
                    },
                ],
            },
            {
                id: 'activities',
                title: {
                    sk: 'Aktivity',
                    en: 'Activities',
                },
                services: [
                    {
                        id: 'planner',
                        title: { sk: 'Plánovač', en: 'Planner' },
                        description: {
                            sk: 'Naplánujte si výlet.',
                            en: 'Plan your trip.',
                        },
                        buttonText: { sk: 'otvoriť', en: 'open' },
                        tags: [
                            { sk: 'výlet', en: 'trip' },
                        ],
                        images: [
                            { src: '/assets/image.jpg', alt: { sk: 'Výlet', en: 'Trip' } },
                        ],
                    },
                ],
            },
        ],
    }
}

watch(locale, loadMockContent, { immediate: true })

function mapServiceSlides(services: DbService[]): ServiceSlide[] {
  return services.map((service) => ({
    id: service.id,
    image: {
      src: service.images[0]?.src || '',
      alt: localize(service.images[0]?.alt),
    },
    title: localize(service.title),
    description: localize(service.description),
    buttonText: localize(service.buttonText),
    tags: service.tags.map((t) => localize(t)),
    service,
  }))
}

function handleServiceClick(slide?: ServiceSlide | null) {
  if (!slide) return

  console.log('open service', slide.service.id)
}
</script>

<template>
  <main
    v-if="content"
    class="grid grid-cols-1 gap-10 p-8 lg:grid-cols-3 lg:items-start"
    :class="pageClass"
  >
    <section
      v-for="category in content.categories"
      :key="category.id"
      class="flex flex-col gap-4"
    >
      <h1 class="h1">
        {{ localize(category.title) }}
      </h1>

      <Slideshow
        :slides="mapServiceSlides(category.services)"
        :variant="variant"
        :interval="0"
        :enable-gallery="false"
        @button-click="handleServiceClick"
      />
    </section>
  </main>
</template>
