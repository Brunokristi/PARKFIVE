<script setup lang="ts">
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';
import Text from '../components/Text.vue';
import Table from '../components/Table.vue';
import Slideshow from '../components/Slideshow.vue';

const route = useRoute();
const { t } = useI18n();

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
}

type Variant = 'light' | 'dark';

const variant = computed<Variant>(() =>
  route.meta.theme === 'light' ? 'light' : 'dark'
);

const titleClass = computed(() =>
  variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
);

const sections = computed<TableSection[]>(() => [
  {
    id: 'section-1',
    heading: t('room.table.section1.heading'),
    rows: [
      {
        id: 'row-1',
        label: t('room.table.section1.row1'),
        actions: [
          {
            id: 'count',
            text: '2',
          },
          {
            id: 'check',
            icon: 'bi bi-check-lg',
          },
        ],
        onClick: (row: TableRow) => console.log('clicked', row),
      },
      {
        id: 'row-2',
        label: t('room.table.section1.row2'),
        actions: [
          {
            id: 'count',
            text: '1',
          },
        ],
      },
      {
        id: 'row-3',
        label: t('room.table.section1.row3'),
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
    id: 'section-2',
    heading: t('room.table.section2.heading'),
    rows: [
      {
        id: 'row-1',
        label: t('room.table.section2.row1'),
        actions: [
          {
            id: 'count',
            text: '2',
          },
          {
            id: 'check',
            icon: 'bi bi-check-lg',
          },
        ],
        onClick: (row: TableRow) => console.log('clicked', row),
      },
      {
        id: 'row-2',
        label: t('room.table.section2.row2'),
        actions: [
          {
            id: 'count',
            text: '1',
          },
        ],
      },
      {
        id: 'row-3',
        label: t('room.table.section2.row3'),
        actions: [
          {
            id: 'check',
            icon: 'bi bi-check-lg',
          },
        ],
      },
    ],
  },
]);

const slideshowImages = computed(() => [
  { src: '/assets/image.jpg', alt: t('room.slideshow.project1Alt') },
  { src: '/assets/image2.jpg', alt: t('room.slideshow.project2Alt') },
]);

function handleRowAction({ section, row }: RowActionPayload) {
  console.log(section, row);
}

</script>

<template>
  <main class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:items-start">
    <section class="flex flex-col gap-4 p-4">
      <h1 class="h1" :class="titleClass">{{ t('room.subtitle') }}</h1>

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
    </section>
  </main>
</template>
