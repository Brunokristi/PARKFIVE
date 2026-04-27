<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';

import { useI18n } from 'vue-i18n';
const { t, locale } = useI18n();

import Button from '../components/Button.vue';
import GridLayout from '../components/GridLayout.vue';
import Tag from '../components/Tag.vue';
import Text from '../components/Text.vue';
import Table from '../components/Table.vue';


import { useGlobalActions } from '../composables/useGlobalActions';
import Slideshow from '../components/Slideshow.vue';
const { openContacts, openRecentProjects, openWorkflow, openVcard } = useGlobalActions();

const cardFront = '/assets/card_front.svg';
const cardBack = '/assets/card_back.svg';
const bgUrl = '/assets/bg.svg'
const bgUrl2 = '/assets/bg2.svg'

interface RowAction {
  id: string;
  text?: string;
  icon?: string;
}

interface TableRow {
  id: string;
  label: string;
  actions: RowAction[];
  onClick?: (row: TableRow) => void;
}

interface TableSection {
  id: string;
  heading: string;
  rows: TableRow[];
}

interface RowActionPayload {
  section: Pick<TableSection, 'id' | 'heading'>;
  row: Pick<TableRow, 'id' | 'label'>;
  action: RowAction;
}

interface GridCard {
  heading: string;
  text: string;
  image: string;
  bgColor: string;
  link: string;
}

const sections: TableSection[] = [
    {
        id: 'section-1',
        heading: 'spálňa 1',
        rows: [
            {
                id: 'row-1',
                label: 'Fiľakovský hrad',
                actions: [
                    {
                        id: 'count',
                        text: '2',
                    },
                    {
                      id: 'check',
                      icon: 'bi bi-check-lg',
                    }
                ],
                onClick: (row: TableRow) => console.log('clicked', row),
            },
            {
                id: 'row-2',
                label: 'Fiľakovský hrad',
                actions: [
                    {
                        id: 'count',
                        text: '1',
                    },
                ],
            },
            {
                id: 'row-3',
                label: 'Fiľakovský hrad',
                actions: [
                    {
                        id: 'check',
                        icon: 'bi bi-check-lg',
                    },
                ],
            },
        ],
    },
    {
        id: 'section-1',
        heading: 'spálňa 1',
        rows: [
            {
                id: 'row-1',
                label: 'Fiľakovský hrad',
                actions: [
                    {
                        id: 'count',
                        text: '2',
                    },
                    {
                      id: 'check',
                      icon: 'bi bi-check-lg',
                    }
                ],
                onClick: (row: TableRow) => console.log('clicked', row),
            },
            {
                id: 'row-2',
                label: 'Fiľakovský hrad',
                actions: [
                    {
                        id: 'count',
                        text: '1',
                    },
                ],
            },
            {
                id: 'row-3',
                label: 'Fiľakovský hrad',
                actions: [
                    {
                        id: 'check',
                        icon: 'bi bi-check-lg',
                    },
                ],
            },
        ],
    },
]

function handleRowAction({
  section,
  row,
  action,
}: RowActionPayload) {
    console.log(section, row, action)
}

const cards = ref<GridCard[]>([]);

</script>

<template>
  <main class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:items-start">
    <section class="flex flex-col gap-4 p-4">
      <h1 class="h1 text-lightcolor">{{ t('home.subtitle1') }}</h1>

      <Slideshow
        :images="[
          { src: '/assets/image.jpg', alt: 'Project 1' },
          { src: '/assets/image2.jpg', alt: 'Project 2' },
        ]"
        heading="Fiľakovský hrad"
        :tags="['branding', 'web', 'identity']"
        description="Short project description goes here."
        button-text="view project"
        @button-click="openRecentProjects"
      />
    </section>

    <section class="flex flex-col gap-10 p-4 lg:col-span-2">
      <Text
        :heading="t('home.heading')"
        :description="t('home.description')"
      />

      <Table
        :sections="sections"
        variant="dark"
        @row-action="handleRowAction"
      />
    </section>
  </main>
</template>
