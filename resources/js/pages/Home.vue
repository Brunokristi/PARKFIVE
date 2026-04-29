<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'

import Info from '../components/Info.vue'
import Slideshow from '../components/Slideshow.vue'
import Table from '../components/Table.vue'
import Text from '../components/Text.vue'
import Map from '../components/Map.vue'
import Button from '../components/Button.vue'

const route = useRoute()
const router = useRouter()
const { t, locale } = useI18n()

type Variant = 'light' | 'dark'

interface LocalizedText {
    sk: string
    en: string
}

interface DbRoomType {
    id: string
    slug: string
    title: LocalizedText
    features: LocalizedText[]
}

interface DbHomeContent {
    heading: LocalizedText
    description: LocalizedText
    images: Array<{ src: string; alt: LocalizedText }>
    roomTypes: DbRoomType[]
    infos: Array<{
        id: string
        heading: LocalizedText
        text: LocalizedText
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

const content = ref<DbHomeContent | null>(null)

function localize(value?: LocalizedText) {
    if (!value) return ''

    return value[locale.value as keyof LocalizedText] || value.sk || ''
}

function loadMockContent() {
    content.value = {
        heading: {
            sk: 'parkFIVE',
            en: 'parkFIVE',
        },
        description: {
            sk: 'Vyberte si izbu, služby alebo si naplánujte výlet v okolí.',
            en: 'Choose a room, services, or plan a trip nearby.',
        },
        images: [
            {
                src: '/assets/image.jpg',
                alt: {
                    sk: 'Hotelová izba',
                    en: 'Hotel room',
                },
            },
            {
                src: '/assets/image2.jpg',
                alt: {
                    sk: 'Okolie hotela',
                    en: 'Hotel surroundings',
                },
            },
        ],
        roomTypes: [
            {
                id: 'standard',
                slug: 'standard',
                title: {
                    sk: 'Štandard',
                    en: 'Standard',
                },
                features: [
                    { sk: 'Wi-Fi', en: 'Wi-Fi' },
                    { sk: 'TV', en: 'TV' },
                    { sk: 'Kúpeľňa', en: 'Bathroom' },
                ],
            },
            {
                id: 'premium',
                slug: 'premium',
                title: {
                    sk: 'Premium',
                    en: 'Premium',
                },
                features: [
                    { sk: 'Wi-Fi', en: 'Wi-Fi' },
                    { sk: 'Balkón', en: 'Balcony' },
                    { sk: 'Výhľad', en: 'View' },
                ],
            },
        ],
        infos: [
            {
                id: 'parking',
                heading: {
                    sk: 'Parkovanie',
                    en: 'Parking',
                },
                text: {
                    sk: 'Parkovanie je dostupné priamo pri objekte.',
                    en: 'Parking is available directly at the property.',
                },
                opened: true,
            },
            {
                id: 'breakfast',
                heading: {
                    sk: 'Raňajky',
                    en: 'Breakfast',
                },
                text: {
                    sk: 'Raňajky sú dostupné každý deň od 7:00.',
                    en: 'Breakfast is available daily from 7:00.',
                },
            },
        ],
    }
}

watch(
    locale,
    () => {
        loadMockContent()
    },
    { immediate: true }
)

const slideshowImages = computed(() =>
    content.value?.images.map((image) => ({
        src: image.src,
        alt: localize(image.alt),
    })) || []
)

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
        :heading="localize(content.heading)"
        :description="localize(content.description)"
        :variant="variant"
      />

      <Table
        :sections="roomTypeSections"
        :variant="variant"
      />

      <Info
        v-for="info in content.infos"
        :key="info.id"
        :heading="localize(info.heading)"
        :text="localize(info.text)"
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