<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'

import Chat from '../components/Chat.vue'
import Info from '../components/Info.vue'
import Table from '../components/Table.vue'
import Map from '../components/Map.vue'
import { useHotelPageContent } from '../composables/useHotelPageContent'

const route = useRoute()

type Variant = 'light' | 'dark'

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

interface ContactItem {
    id: string
    label: string
    href?: string
}

interface DbContactContent {
    title: string
    address: string
    infos: Array<{
        id: string
        heading: string
        text: string
        opened?: boolean
    }>
    contactSections: Array<{
        id: string
        heading: string
        rows: ContactItem[]
    }>
}

const { content } = useHotelPageContent<DbContactContent>('contact')

const variant = computed<Variant>(() =>
    route.meta.theme === 'light' ? 'light' : 'dark'
)

const pageClass = computed(() =>
    variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
)

const contactSections = computed<TableSection[]>(() =>
    content.value?.contactSections.map((section) => ({
        id: section.id,
        heading: section.heading,
        rows: section.rows.map((row) => ({
            id: row.id,
            label: row.label,
            actions: [
                {
                    id: 'open',
                    icon: 'bi bi-chevron-right',
                    onClick: () => openContact(row),
                },
            ],
            onClick: () => openContact(row),
        })),
    })) || []
)

function openContact(row: ContactItem) {
    if (!row.href) return

    window.location.href = row.href
}
</script>

<template>
  <main
    v-if="content"
    class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:items-start"
    :class="pageClass"
  >
    <section class="flex flex-col gap-10 p-8">
      <h1 class="h1">
                {{ content.title }}
      </h1>

      <Chat :variant="variant" />
    </section>

    <section class="flex flex-col gap-4 p-8">
        <h1 class="h1">
            {{ content.address }}
        </h1>
      
      <div class="h-[500px] w-full border" >
          <Map
            :home-lat="48.267"
            :home-lng="19.824"
            home-name="parkFIVE"
            :variant="variant"
          />
      </div>
    </section>

    <section class="flex flex-col gap-10 p-8">
      <Info
        v-for="info in content.infos"
        :key="info.id"
                :heading="info.heading"
                :text="info.text"
        :variant="variant"
        :opened="info.opened"
      />

      <Table
        :sections="contactSections"
        :variant="variant"
      />
    </section>
  </main>
</template>