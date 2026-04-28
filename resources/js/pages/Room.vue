<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'

import Slideshow from '../components/Slideshow.vue'
import Table from '../components/Table.vue'
import Text from '../components/Text.vue'

const route = useRoute()
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

interface DbRoomTypeContent {
    title: LocalizedText
    description: LocalizedText
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
}

const content = ref<DbRoomTypeContent | null>(null)

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

function loadMockContent() {
    content.value = {
        title: {
            sk: 'Štandardná izba',
            en: 'Standard room',
        },
        description: {
            sk: 'Komfortná izba vhodná na krátkodobý aj dlhší pobyt.',
            en: 'A comfortable room suitable for short and longer stays.',
        },
        images: [
            {
                src: '/assets/image.jpg',
                alt: {
                    sk: 'Štandardná izba',
                    en: 'Standard room',
                },
            },
            {
                src: '/assets/image2.jpg',
                alt: {
                    sk: 'Detail izby',
                    en: 'Room detail',
                },
            },
        ],
        sections: [
            {
                id: 'equipment',
                heading: {
                    sk: 'vybavenie',
                    en: 'equipment',
                },
                rows: [
                    {
                        id: 'beds',
                        label: {
                            sk: 'Postele',
                            en: 'Beds',
                        },
                        count: 2,
                    },
                    {
                        id: 'wifi',
                        label: {
                            sk: 'Wi-Fi',
                            en: 'Wi-Fi',
                        },
                        checked: true,
                    },
                    {
                        id: 'bathroom',
                        label: {
                            sk: 'Kúpeľňa',
                            en: 'Bathroom',
                        },
                        checked: true,
                    },
                ],
            },
            {
                id: 'services',
                heading: {
                    sk: 'služby',
                    en: 'services',
                },
                rows: [
                    {
                        id: 'breakfast',
                        label: {
                            sk: 'Raňajky',
                            en: 'Breakfast',
                        },
                        checked: true,
                    },
                    {
                        id: 'parking',
                        label: {
                            sk: 'Parkovanie',
                            en: 'Parking',
                        },
                        checked: true,
                    },
                ],
            },
        ],
    }
}

watch(locale, loadMockContent, { immediate: true })

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
                ...(row.count
                    ? [{ id: 'count', text: String(row.count) }]
                    : []),
                ...(row.checked
                    ? [{ id: 'check', icon: 'bi bi-check-lg' }]
                    : []),
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
        {{ localize(content.title) }}
      </h1>

      <Slideshow
        :images="slideshowImages"
        :variant="variant"
      />
    </section>

    <section class="flex flex-col gap-10 p-8 lg:col-span-2">
      <Text
        :description="localize(content.description)"
        :variant="variant"
      />

      <Table
        :sections="tableSections"
        :variant="variant"
      />
    </section>
  </main>
</template>