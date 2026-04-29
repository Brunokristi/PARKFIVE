<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'

import Slideshow from '../components/Slideshow.vue'
import { useHotelPageContent } from '../composables/useHotelPageContent'

const route = useRoute()

type Variant = 'light' | 'dark'

interface DbService {
    id: string
    title: string
    description: string
    buttonText: string
    tags: string[]
    images: Array<{
        src: string
        alt: string
    }>
}

interface DbCategory {
    id: string
    title: string
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

const { content } = useHotelPageContent<DbServicesContent>('services')

const variant = computed<Variant>(() =>
    route.meta.theme === 'light' ? 'light' : 'dark'
)

const pageClass = computed(() =>
    variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
)

function mapServiceSlides(services: DbService[]): ServiceSlide[] {
  return services.map((service) => ({
    id: service.id,
    image: {
      src: service.images[0]?.src || '',
      alt: service.images[0]?.alt || '',
    },
    title: service.title,
    description: service.description,
    buttonText: service.buttonText,
    tags: service.tags,
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
                {{ category.title }}
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
