<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'

import Slideshow from '../components/Slideshow.vue'
import Table from '../components/Table.vue'
import Text from '../components/Text.vue'

const route = useRoute()
const router = useRouter()
const { locale } = useI18n()

type Variant = 'light' | 'dark'
type LocalizedText = Record<string, string>

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

interface DbRoomType {
    id: string
    slug: string
    title: LocalizedText
    features: string[]
}

interface DbPropertyContent {
    hotel: {
        id: number
        slug: string
        name: string
    }
    subtitle: LocalizedText
    description: LocalizedText
    compareHeading: LocalizedText
    compareDescription: LocalizedText
    images: Array<{
        src: string
        alt: LocalizedText
    }>
    sections: Array<{
        id: string
        heading: LocalizedText
        rows: Array<{
            id: string
            label: LocalizedText
            count?: number
            checked?: boolean
        }>
    }>
    roomFeatures: string[]
    roomTypes: DbRoomType[]
}

const content = ref<DbPropertyContent | null>(null)

function localize(value?: string | LocalizedText) {
    if (!value) return ''
    if (typeof value === 'string') return value

    return value[locale.value] || value.sk || Object.values(value)[0] || ''
}

async function loadHotelContent() {
  const response = await fetch(`/api/hotel/property?locale=${locale.value}`, {
    cache: 'no-store',
  })

    if (!response.ok) {
        throw new Error('Failed to load hotel property content')
    }

    content.value = await response.json()
}

watch(locale, () => {
    loadHotelContent().catch((error) => {
        console.error(error)
    })
}, { immediate: true })

const variant = computed<Variant>(() =>
    route.meta.theme === 'light' ? 'light' : 'dark'
)

const pageClass = computed(() =>
    variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
)

const currentSlug = computed(() => String(route.params.slug || 'standard'))

const room = computed(() =>
    content.value?.roomTypes.find((roomType) => roomType.slug === currentSlug.value) || null
)

const slideshowImages = computed(() =>
    content.value?.images.map((image) => ({
        src: image.src,
        alt: localize(image.alt),
    })) || []
)

const tableSections = computed<TableSection[]>(() =>
    content.value?.sections.map((section) => ({
        id: section.id,
        heading: localize(section.heading),
        rows: section.rows.map((row) => ({
            id: row.id,
            label: localize(row.label),
            actions: [
                ...(row.count ? [{ id: 'count', text: String(row.count) }] : []),
                ...(row.checked ? [{ id: 'check', icon: 'bi bi-check-lg' }] : []),
            ],
        })),
    })) || []
)

const roomFeatures = computed(() => content.value?.roomFeatures || [])

const roomSummary = computed(() => {
    if (!room.value) return ''

    if (!room.value.features.length) return ''

    return room.value.features.length === 1
        ? room.value.features[0]
        : room.value.features.slice(0, -1).join(', ') + ` and ${room.value.features[room.value.features.length - 1]}`
})

function backToProperty() {
    router.push('/property')
}
</script>

<template>
  <main
    v-if="content"
    class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:items-start"
    :class="pageClass"
  >
    <section class="flex flex-col gap-4 p-8">
      <h1 class="h1">
        {{ room ? localize(room.title) : currentSlug }}
      </h1>

      <p class="text-sm text-neutral-500 dark:text-neutral-400" v-if="roomSummary">
        {{ roomSummary }}
      </p>

      <Slideshow
        :images="slideshowImages"
        :variant="variant"
      />
    </section>

    <section class="flex flex-col gap-10 p-8 lg:col-span-2">
      <Text
        :heading="room ? localize(room.title) : ''"
        :description="room ? `This room includes ${roomSummary}.` : 'Room not found.'"
        :variant="variant"
      />

      <Table
        :sections="tableSections"
        :variant="variant"
      />

      <div class="rounded-lg border border-neutral-200 bg-white p-4 text-sm text-neutral-700 dark:border-white/10 dark:bg-white/5 dark:text-neutral-300">
        <div class="font-semibold text-neutral-950 dark:text-white">
          Room features
        </div>
        <div class="mt-3 flex flex-wrap gap-2">
          <span
            v-for="feature in roomFeatures"
            :key="feature"
            class="rounded-full border border-neutral-200 px-3 py-1 text-xs dark:border-white/10"
          >
            {{ feature }}
          </span>
        </div>
        <button
          class="mt-4 text-sm underline decoration-neutral-400 underline-offset-4"
          type="button"
          @click="backToProperty"
        >
          View all rooms
        </button>
      </div>
    </section>
  </main>
</template>
