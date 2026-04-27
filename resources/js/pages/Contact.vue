<script setup lang="ts">
import { computed, ref } from 'vue'
import { useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'

import Table from '../components/Table.vue'
import FormField from '../components/FormField.vue'
import Info from '../components/Info.vue'
import Chat from '../components/Chat.vue'

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

const title = ref('')
const email = ref('')
const phone = ref('')
const message = ref('')
const files = ref<File | File[] | null>(null)

const variant = computed<Variant>(() =>
    route.meta.theme === 'light' ? 'light' : 'dark'
)

const titleClass = computed(() =>
    variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
)

const sections = computed<TableSection[]>(() => [
    {
        id: 'section-1',
        heading: "telefón",
        rows: [
            {
                id: 'row-1',
                label: "+421 123 456 789",
                actions: [
                    { id: 'check', icon: 'bi bi-chevron-right' },
                ],
                onClick: (row: TableRow) => console.log('clicked', row),
            },
            {
                id: 'row-2',
                label: "+421 123 456 789",
                actions: [
                    { id: 'check', icon: 'bi bi-chevron-right' },
                ],
                onClick: (row: TableRow) => console.log('clicked', row),
            },
        ],
    },
])

function handleRowAction({ section, row }: RowActionPayload) {
    console.log(section, row)
}
</script>

<template>
  <main class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:items-start">
    <section class="flex flex-col gap-10 p-4">
      <h1 class="h1" :class="titleClass">
        {{ t('room.subtitle') }}
      </h1>

      <Chat />
    </section>

    <section class="flex flex-col gap-4 p-4">
      <Info
        :heading="t('home.info1.heading')"
        :text="t('home.info1.text')"
        :variant="variant"
        :opened="true"
      />

      <Info
        :heading="t('home.info1.heading')"
        :text="t('home.info1.text')"
        :variant="variant"
        :opened="true"
      />

      <Info
        :heading="t('home.info1.heading')"
        :text="t('home.info1.text')"
        :variant="variant"
      />

      <Info
        :heading="t('home.info1.heading')"
        :text="t('home.info1.text')"
        :variant="variant"
      />

      <Info
        :heading="t('home.info1.heading')"
        :text="t('home.info1.text')"
        :variant="variant"
      />

      <Info
        :heading="t('home.info1.heading')"
        :text="t('home.info1.text')"
        :variant="variant"
      />
    </section>

    <section class="flex flex-col gap-10 p-4">
      <Table
        :sections="sections"
        :variant="variant"
        @row-action="handleRowAction"
      />
    </section>
  </main>
</template>