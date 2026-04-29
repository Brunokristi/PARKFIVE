<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'

import Text from '../components/Text.vue'
import { useHotelPageContent } from '../composables/useHotelPageContent'

const route = useRoute()

type Variant = 'light' | 'dark'

interface PrivacySection {
  id: string
  heading: string
  description: string
}

interface PrivacyContent {
  title: string
  lastUpdated: string
  sections: PrivacySection[]
}

const { content } = useHotelPageContent<PrivacyContent>('privacy')

const variant = computed<Variant>(() =>
  route.meta.theme === 'light' ? 'light' : 'dark'
)

const pageClass = computed(() =>
  variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
)

const sections = computed(() => content.value?.sections || [])
</script>

<template>
  <main
    class="grid grid-cols-1 gap-10 p-8 lg:grid-cols-3 lg:items-start"
    :class="pageClass"
  >
    <section class="flex flex-col gap-10 lg:col-span-1">
      <h1
        class="h1"
        :class="pageClass"
      >
        {{ content?.title || '' }}
      </h1>
    </section>

    <section class="flex flex-col gap-10 lg:col-span-2">
      <Text
        v-for="section in sections"
        :key="section.id"
        :heading="section.heading"
        :description="section.description"
        :variant="variant"
      />
    </section>
  </main>
</template>