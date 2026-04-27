<script setup lang="ts">
import { ref } from 'vue';

import { useI18n } from 'vue-i18n';
const { t } = useI18n();

import Text from '../components/Text.vue';
import Table from '../components/Table.vue';
import Info from '../components/Info.vue';
import FormField from '../components/FormField.vue';


import { useGlobalActions } from '../composables/useGlobalActions';
import Slideshow from '../components/Slideshow.vue';
const { openRecentProjects } = useGlobalActions();

const title = ref('');
const review = ref('');
const photos = ref<File[]>([]);

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

</script>

<template>
  <main class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:items-start">
    <section class="flex flex-col gap-4 p-4">
      <h1 class="h1 text-lightcolor">{{ t('home.subtitle1') }}</h1>

      <Info 
        :heading="t('home.info1.heading')"
        :text="t('home.info1.text')"
        color="light"
      />

      <FormField
        v-model="title"
        label="Nadpis"
        info="Krátky názov vašej recenzie."
        :max-length="50"
        error="Toto pole je povinné."
        variant="dark"
      />

      <FormField
        v-model="review"
        type="textarea"
        label="Recenzia"
        info="Napíšte svoju skúsenosť."
        :max-length="500"
        variant="dark"
      />

      <FormField
        v-model="photos"
        type="file"
        label="Pridajte fotografie"
        info="Nahrajte fotografie priestoru."
        multiple
        file-accept="image/*"
        variant="dark"
      />

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
