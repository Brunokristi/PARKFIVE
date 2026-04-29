<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'

import Text from '../components/Text.vue'

const route = useRoute()
const { t } = useI18n()

type Variant = 'light' | 'dark'

const variant = computed<Variant>(() =>
    route.meta.theme === 'light' ? 'light' : 'dark'
)

const pageClass = computed(() =>
    variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
)

const sections = computed(() => [
    {
        id: 'overview',
        heading: t('privacy.sectionOverviewTitle'),
        description: t('privacy.sectionOverviewText'),
    },
    {
        id: 'cookies',
        heading: t('privacy.sectionCookiesTitle'),
        description: t('privacy.sectionCookiesText'),
    },
    {
        id: 'analytics',
        heading: t('privacy.sectionAnalyticsTitle'),
        description: t('privacy.sectionAnalyticsText'),
    },
    {
        id: 'control',
        heading: t('privacy.sectionControlTitle'),
        description: t('privacy.sectionControlText'),
    },
    {
        id: 'contact',
        heading: t('privacy.sectionContactTitle'),
        description: t('privacy.sectionContactText'),
    },
])
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
        {{ t('privacy.title') }}
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