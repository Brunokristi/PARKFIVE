<script setup lang="ts">
import { computed, ref } from 'vue'
import { useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'

import Text from '../components/Text.vue'
import Table from '../components/Table.vue'
import Slideshow from '../components/Slideshow.vue'
import CompareTable from '../components/CompareTable.vue'

const route = useRoute()
const { t } = useI18n()

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
    onClick?: (row: TableRow) => void
}

interface TableSection {
    id: string
    heading: string
    rows: TableRow[]
}

interface RowActionPayload {
    section: Pick<TableSection, 'id' | 'heading'>
    row: Pick<TableRow, 'id' | 'label'>
}

interface RoomType {
    id: string
    label: string
    features: string[]
}

const selectedRoomTypes = ref<string[]>([])

const variant = computed<Variant>(() =>
    route.meta.theme === 'light' ? 'light' : 'dark'
)

const titleClass = computed(() =>
    variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
)

const sections = computed<TableSection[]>(() => [
    {
        id: 'section-1',
        heading: t('room.table.section1.heading'),
        rows: [
            {
                id: 'row-1',
                label: t('room.table.section1.row1'),
                actions: [
                    { id: 'count', text: '2' },
                    { id: 'check', icon: 'bi bi-check-lg' },
                ],
                onClick: (row: TableRow) => console.log('clicked', row),
            },
            {
                id: 'row-2',
                label: t('room.table.section1.row2'),
                actions: [{ id: 'count', text: '1' }],
            },
            {
                id: 'row-3',
                label: t('room.table.section1.row3'),
                actions: [{ id: 'check', icon: 'bi bi-check-lg' }],
            },
        ],
    },
    {
        id: 'section-2',
        heading: t('room.table.section2.heading'),
        rows: [
            {
                id: 'row-1',
                label: t('room.table.section2.row1'),
                actions: [
                    { id: 'count', text: '2' },
                    { id: 'check', icon: 'bi bi-check-lg' },
                ],
                onClick: (row: TableRow) => console.log('clicked', row),
            },
            {
                id: 'row-2',
                label: t('room.table.section2.row2'),
                actions: [{ id: 'count', text: '1' }],
            },
            {
                id: 'row-3',
                label: t('room.table.section2.row3'),
                actions: [{ id: 'check', icon: 'bi bi-check-lg' }],
            },
        ],
    },
])

const roomFeatures = computed(() => [
    'Wi-Fi',
    'TV',
    'Kúpeľňa',
    'Balkón',
    'Výhľad',
])

const roomTypes = computed<RoomType[]>(() => [
    {
        id: 'standard',
        label: 'Standard',
        features: ['Wi-Fi', 'TV', 'Kúpeľňa'],
    },
    {
        id: 'premium',
        label: 'Premium',
        features: ['Wi-Fi', 'TV', 'Kúpeľňa', 'Balkón'],
    },
    {
        id: 'deluxe',
        label: 'Deluxe',
        features: ['Wi-Fi', 'TV', 'Kúpeľňa', 'Balkón', 'Výhľad'],
    },
])

const roomTypeSections = computed<TableSection[]>(() => [
    {
        id: 'room-types',
        heading: 'typy izieb',
        rows: roomTypes.value.map((room) => ({
            id: room.id,
            label: room.label,
            actions: [
                {
                    id: 'selected',
                    icon: selectedRoomTypes.value.includes(room.id)
                        ? 'bi bi-check-circle-fill'
                        : 'bi bi-check-circle',
                },
            ],
            onClick: () => toggleRoomType(room),
        })),
    },
])

const comparedRooms = computed(() =>
    roomTypes.value.filter((room) => selectedRoomTypes.value.includes(room.id))
)

const slideshowImages = computed(() => [
    { src: '/assets/image.jpg', alt: t('room.slideshow.project1Alt') },
    { src: '/assets/image2.jpg', alt: t('room.slideshow.project2Alt') },
])

function toggleRoomType(room: RoomType) {
    const isSelected = selectedRoomTypes.value.includes(room.id)

    if (isSelected) {
        selectedRoomTypes.value = selectedRoomTypes.value.filter((id) => id !== room.id)
        return
    }

    if (selectedRoomTypes.value.length >= 2) {
        selectedRoomTypes.value = [selectedRoomTypes.value[1], room.id]
        return
    }

    selectedRoomTypes.value.push(room.id)
}

function handleRowAction({ section, row }: RowActionPayload) {
    console.log(section, row)
}
</script>

<template>
  <main class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:items-start">
    <section class="flex flex-col gap-4 p-4">
      <h1 class="h1" :class="titleClass">
        {{ t('room.subtitle') }}
      </h1>

      <Slideshow
        :images="slideshowImages"
        :variant="variant"
      />
    </section>

    <section class="flex flex-col gap-10 p-4 lg:col-span-2">
      <Text
        :description="t('room.description')"
        :variant="variant"
      />

      <Table
        :sections="sections"
        :variant="variant"
        @row-action="handleRowAction"
      />

      <Table
        :sections="roomTypeSections"
        :variant="variant"
      />

      <CompareTable
        v-if="comparedRooms.length === 2"
        :rooms="comparedRooms"
        :features="roomFeatures"
        :variant="variant"
      />
    </section>
  </main>
</template>