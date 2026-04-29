<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'

import Slideshow from '../components/Slideshow.vue'
import Table from '../components/Table.vue'
import Text from '../components/Text.vue'
import { useHotelPageContent } from '../composables/useHotelPageContent'

const route = useRoute()

type Variant = 'light' | 'dark'

interface RowAction {
    id: string
    text?: string
    icon?: string
}

interface TableRow {
    id: string
    label: string
    actions: RowAction[]
}

interface TableSection {
    id: string
    heading: string
    rows: TableRow[]
}

interface DbRoomTypeContent {
    title: string
    description: string
    images: Array<{
        src: string
        alt: string
    }>
    sections: Array<{
        id: string
        heading: string
        rows: Array<{
            id: string
            label: string
            count?: number
            checked?: boolean
        }>
    }>
}

const { content } = useHotelPageContent<DbRoomTypeContent>('room')

const variant = computed<Variant>(() =>
    route.meta.theme === 'light' ? 'light' : 'dark'
)

const pageClass = computed(() =>
    variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
)

const slideshowImages = computed(() => content.value?.images || [])

const tableSections = computed<TableSection[]>(() =>
    content.value?.sections.map((section) => ({
        id: section.id,
        heading: section.heading,
        rows: section.rows.map((row) => ({
            id: row.id,
            label: row.label,
            actions: [
                ...(row.count ? [{ id: 'count', text: String(row.count) }] : []),
                ...(row.checked ? [{ id: 'check', icon: 'bi bi-check-lg' }] : []),
            ],
        })),
    })) || []
)
</script>

<template>
  <main
    v-if="content"
    class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:items-start"
    :class="pageClass"
  >
    <section class="flex flex-col gap-4 p-8">
      <h1 class="h1">
        {{ content.title }}
      </h1>

      <Slideshow
        :images="slideshowImages"
        :variant="variant"
      />
    </section>

    <section class="flex flex-col gap-10 p-8 lg:col-span-2">
      <Text
        :description="content.description"
        :variant="variant"
      />

      <Table
        :sections="tableSections"
        :variant="variant"
      />
    </section>
  </main>
</template>
