<script setup lang="ts">
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { useRoute, useRouter } from 'vue-router'

import Info from '../components/Info.vue'
import Slideshow from '../components/Slideshow.vue'
import Table from '../components/Table.vue'
import Text from '../components/Text.vue'
import { useHotelPageContent } from '../composables/useHotelPageContent'

const route = useRoute()
const router = useRouter()
const { t } = useI18n()

type Variant = 'light' | 'dark'

type LocalizedText = Record<string, string>

interface DbRoomType {
    id: string
    slug: string
    title: string | LocalizedText
    features: string[]
}

interface DbHomeContent {
    heading: string
    description: string
    images: Array<{ src: string; alt: string }>
    roomTypes: DbRoomType[]
    infos: Array<{
        id: string
        heading: string
        text: string
        opened?: boolean
    }>
}

interface RowAction {
    id: string
    text?: string
    icon?: string
    onClick?: () => void
}

interface TableRow {
    id: string
    label: string
    actions: RowAction[]
    onClick?: () => void
}

interface TableSection {
    id: string
    heading: string
    rows: TableRow[]
}

const variant = computed<Variant>(() =>
    route.meta.theme === 'light' ? 'light' : 'dark'
)

const pageClass = computed(() =>
    variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
)

const { content } = useHotelPageContent<DbHomeContent>('home')
const { locale } = useI18n()

function localize(value?: string | LocalizedText) {
    if (!value) return ''
    if (typeof value === 'string') return value

    return (value as LocalizedText)[locale.value] || (value as LocalizedText).sk || Object.values(value as LocalizedText)[0] || ''
}

const slideshowImages = computed(() => content.value?.images || [])

const roomTypeSections = computed<TableSection[]>(() => [
    {
        id: 'room-types',
        heading: t('home.roomTypes'),
                rows:
            content.value?.roomTypes.map((room) => ({
                id: room.id,
                label: localize(room.title),
                actions: [
                    {
                        id: 'open',
                        icon: 'bi bi-chevron-right',
                        onClick: () => openRoomType(room.slug),
                    },
                ],
                onClick: () => openRoomType(room.slug),
            })) || [],
    },
])

const hotelSections = computed<TableSection[]>(() => [
    {
        id: 'hotel-menu',
        heading: t('home.menu'),
        rows: [
            createMenuRow('hotel', t('nav.hotel'), '/property'),
            createMenuRow('services', t('nav.services'), '/services'),
            createMenuRow('policies', t('nav.policies'), '/policies'),
            createMenuRow('contact', t('nav.contact'), '/contact'),
        ],
    },
])

function createMenuRow(id: string, label: string, path: string): TableRow {
    return {
        id,
        label,
        actions: [
            {
                id: 'open',
                icon: 'bi bi-chevron-right',
                onClick: () => router.push(path),
            },
        ],
        onClick: () => router.push(path),
    }
}

function openRoomType(slug: string) {
    router.push(`/rooms/${slug}`)
}
</script>

<template>
  <main
    v-if="content"
    class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:items-start"
    :class="pageClass"
  >
    <section class="flex flex-col gap-8 p-8 lg:col-span-2">
      <Slideshow
        :images="slideshowImages"
        :variant="variant"
      />
    </section>

    <section class="flex flex-col gap-10 p-8">
            <Text
                :heading="content.heading"
                :description="content.description"
                :variant="variant"
            />

      <Table
        :sections="roomTypeSections"
        :variant="variant"
      />

      <Info
        v-for="info in content.infos"
        :key="info.id"
                :heading="info.heading"
                :text="info.text"
        :variant="variant"
        :opened="info.opened"
      />

      <Table
        :sections="hotelSections"
        :variant="variant"
      />
    </section>
  </main>
</template>