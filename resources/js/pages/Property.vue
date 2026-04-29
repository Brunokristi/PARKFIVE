<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'

import CompareTable from '../components/CompareTable.vue'
import Slideshow from '../components/Slideshow.vue'
import Table from '../components/Table.vue'
import Text from '../components/Text.vue'

const route = useRoute()
const router = useRouter()
const { t, locale } = useI18n()

type Variant = 'light' | 'dark'
type LocalizedText = Record<string, string>

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

interface DbRoomType {
    id: string
    slug: string
    title: LocalizedText
    features: string[]
}

interface DbPropertySection {
    id: string
    heading: LocalizedText
    rows: Array<{
        id: string
        label: LocalizedText
        count?: number
        checked?: boolean
    }>
}

interface DbPropertyContent {
    subtitle: LocalizedText
    description: LocalizedText
    compareHeading: LocalizedText
    compareDescription: LocalizedText
    images: Array<{
        src: string
        alt: LocalizedText
    }>
    sections: DbPropertySection[]
    roomFeatures: string[]
    roomTypes: DbRoomType[]
}

const selectedRoomTypes = ref<string[]>([])
const content = ref<DbPropertyContent | null>(null)

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
        subtitle: {},
        description: {},
        compareHeading: {},
        compareDescription: {},
        images: [
            {
                src: '/assets/image.jpg',
                alt: {
                    sk: t('property.images.alt1.sk'),
                    en: t('property.images.alt1.en'),
                },
            },
            {
                src: '/assets/image2.jpg',
                alt: {
                    sk: t('property.images.alt2.sk'),
                    en: t('property.images.alt2.en'),
                },
            },
        ],
        sections: [
            {
                id: 'amenities',
                heading: {
                    sk: t('property.sections.amenities.heading.sk'),
                    en: t('property.sections.amenities.heading.en'),
                },
                rows: [
                    {
                        id: 'wifi',
                        label: {
                            sk: t('property.sections.amenities.rows.wifi.sk'),
                            en: t('property.sections.amenities.rows.wifi.en'),
                        },
                        checked: true,
                    },
                    {
                        id: 'parking',
                        label: {
                            sk: t('property.sections.amenities.rows.parking.sk'),
                            en: t('property.sections.amenities.rows.parking.en'),
                        },
                        count: 12,
                    },
                    {
                        id: 'breakfast',
                        label: {
                            sk: t('property.sections.amenities.rows.breakfast.sk'),
                            en: t('property.sections.amenities.rows.breakfast.en'),
                        },
                        checked: true,
                    },
                ],
            },
            {
                id: 'services',
                heading: {
                    sk: t('property.sections.services.heading.sk'),
                    en: t('property.sections.services.heading.en'),
                },
                rows: [
                    {
                        id: 'reception',
                        label: {
                            sk: t('property.sections.services.rows.reception.sk'),
                            en: t('property.sections.services.rows.reception.en'),
                        },
                        checked: true,
                    },
                    {
                        id: 'cleaning',
                        label: {
                            sk: t('property.sections.services.rows.cleaning.sk'),
                            en: t('property.sections.services.rows.cleaning.en'),
                        },
                        checked: true,
                    },
                    {
                        id: 'pets',
                        label: {
                            sk: t('property.sections.services.rows.pets.sk'),
                            en: t('property.sections.services.rows.pets.en'),
                        },
                    },
                ],
            },
        ],
        roomFeatures: [
            t('property.roomFeatures.wifi'),
            t('property.roomFeatures.tv'),
            t('property.roomFeatures.bathroom'),
            t('property.roomFeatures.balcony'),
            t('property.roomFeatures.view'),
        ],
        roomTypes: [
            {
                id: 'standard',
                slug: 'standard',
                title: {
                    sk: t('property.roomTypes.standard.sk'),
                    en: t('property.roomTypes.standard.en'),
                },
                features: ['Wi-Fi', 'TV', 'Kúpeľňa'],
            },
            {
                id: 'premium',
                slug: 'premium',
                title: {
                    sk: t('property.roomTypes.premium.sk'),
                    en: t('property.roomTypes.premium.en'),
                },
                features: ['Wi-Fi', 'TV', 'Kúpeľňa', 'Balkón'],
            },
            {
                id: 'deluxe',
                slug: 'deluxe',
                title: {
                    sk: t('property.roomTypes.deluxe.sk'),
                    en: t('property.roomTypes.deluxe.en'),
                },
                features: ['Wi-Fi', 'TV', 'Kúpeľňa', 'Balkón', 'Výhľad'],
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

const propertySections = computed<TableSection[]>(() =>
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
                        id: 'compare',
                        icon: selectedRoomTypes.value.includes(room.id)
                            ? 'bi bi-check-circle-fill'
                            : 'bi bi-check-circle',
                        onClick: () => toggleRoomType(room),
                    },
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

const comparedRooms = computed(() =>
    content.value?.roomTypes.filter((room) =>
        selectedRoomTypes.value.includes(room.id)
    ) || []
)

const roomFeatures = computed(() => content.value?.roomFeatures || [])

function toggleRoomType(room: DbRoomType) {
    if (selectedRoomTypes.value.includes(room.id)) {
        selectedRoomTypes.value = selectedRoomTypes.value.filter((id) => id !== room.id)
        return
    }

    if (selectedRoomTypes.value.length >= 2) {
        selectedRoomTypes.value = [selectedRoomTypes.value[1], room.id]
        return
    }

    selectedRoomTypes.value.push(room.id)
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
    <section class="flex flex-col gap-4 p-8">
            <h1 class="h1">
                {{ t('property.subtitle') }}
            </h1>

      <Slideshow
        :images="slideshowImages"
        :variant="variant"
      />
    </section>

    <section class="flex flex-col gap-10 p-8 lg:col-span-2">
            <Text
                :description="t('property.description')"
                :variant="variant"
            />

      <Table
        :sections="propertySections"
        :variant="variant"
      />

            <Text
                :heading="t('property.compareHeading')"
                :description="t('property.compareDescription')"
                :variant="variant"
            />

      <Table
        :sections="roomTypeSections"
        :variant="variant"
      />

      <CompareTable
        v-if="comparedRooms.length === 2"
        :rooms="comparedRooms.map((room) => ({
          id: room.id,
          label: localize(room.title),
          features: room.features
        }))"
        :features="roomFeatures"
        :variant="variant"
      />
    </section>
  </main>
</template>