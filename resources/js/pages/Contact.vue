<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'

import Chat from '../components/Chat.vue'
import Info from '../components/Info.vue'
import Table from '../components/Table.vue'

const route = useRoute()
const { locale } = useI18n()

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

interface ContactItem {
    id: string
    label: string
    href?: string
}

interface DbContactContent {
    title: LocalizedText
    infos: Array<{
        id: string
        heading: LocalizedText
        text: LocalizedText
        opened?: boolean
    }>
    contactSections: Array<{
        id: string
        heading: LocalizedText
        rows: ContactItem[]
    }>
}

const content = ref<DbContactContent | null>(null)

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
            sk: 'Kontakt',
            en: 'Contact',
        },
        infos: [
            {
                id: 'reception',
                heading: {
                    sk: 'Recepcia',
                    en: 'Reception',
                },
                text: {
                    sk: 'Radi vám pomôžeme s rezerváciou alebo otázkami k pobytu.',
                    en: 'We are happy to help with your reservation or stay-related questions.',
                },
                opened: true,
            },
            {
                id: 'arrival',
                heading: {
                    sk: 'Príchod',
                    en: 'Arrival',
                },
                text: {
                    sk: 'Check-in je možný od 14:00. V prípade skoršieho príchodu nás kontaktujte.',
                    en: 'Check-in is available from 14:00. Contact us for earlier arrival.',
                },
            },
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
            },
        ],
        contactSections: [
            {
                id: 'phone',
                heading: {
                    sk: 'telefón',
                    en: 'phone',
                },
                rows: [
                    {
                        id: 'phone-1',
                        label: '+421 123 456 789',
                        href: 'tel:+421123456789',
                    },
                    {
                        id: 'phone-2',
                        label: '+421 987 654 321',
                        href: 'tel:+421987654321',
                    },
                ],
            },
            {
                id: 'email',
                heading: {
                    sk: 'email',
                    en: 'email',
                },
                rows: [
                    {
                        id: 'email-1',
                        label: 'hello@parkfive.sk',
                        href: 'mailto:hello@parkfive.sk',
                    },
                ],
            },
        ],
    }
}

watch(locale, loadMockContent, { immediate: true })

const contactSections = computed<TableSection[]>(() =>
    content.value?.contactSections.map((section) => ({
        id: section.id,
        heading: localize(section.heading),
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
        {{ localize(content.title) }}
      </h1>

      <Chat :variant="variant" />
    </section>

    <section class="flex flex-col gap-4 p-8">
      <Info
        v-for="info in content.infos"
        :key="info.id"
        :heading="localize(info.heading)"
        :text="localize(info.text)"
        :variant="variant"
        :opened="info.opened"
      />
    </section>

    <section class="flex flex-col gap-10 p-8">
      <Table
        :sections="contactSections"
        :variant="variant"
      />
    </section>
  </main>
</template>