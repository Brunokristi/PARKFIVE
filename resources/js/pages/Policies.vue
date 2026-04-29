<script setup lang="ts">
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';
import Table from '../components/Table.vue';
import { useHotelPageContent } from '../composables/useHotelPageContent';

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

const { content } = useHotelPageContent<{ sections: TableSection[] }>('policies');

const sections = computed<TableSection[]>(() => content.value?.sections || []);

function handleRowAction({ section, row }: RowActionPayload) {
  console.log(section, row);
}

</script>

<template>
  <main class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:items-start">
    <section class="flex flex-col gap-4 p-8">
      <h1 class="h1" :class="titleClass">{{ t('policies.title') }}</h1>
    </section>

    <section class="flex flex-col gap-10 p-8 lg:col-span-2">
      <Table
        :sections="sections"
        :variant="variant"
        @row-action="handleRowAction"
      />

      <Table
        :sections="sections"
        :variant="variant"
        @row-action="handleRowAction"
      />

      <Table
        :sections="sections"
        :variant="variant"
        @row-action="handleRowAction"
      />
    </section>
  </main>
</template>
