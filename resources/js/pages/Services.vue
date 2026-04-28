<script setup lang="ts">
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';
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
    <section class="flex flex-col gap-4 p-8">
      <h1 class="h1" :class="titleClass">{{ t('room.subtitle') }}</h1>

      <Slideshow
        :images="slideshowImages"
        :variant="variant"
        :tags="['tag1', 'tag2']"
        description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
        buttonText="viac informácií"
      />
    </section>

    <section class="flex flex-col gap-4 p-8">
      <h1 class="h1" :class="titleClass">{{ t('room.subtitle') }}</h1>

      <Slideshow
        :images="slideshowImages"
        :variant="variant"
        :tags="['tag1', 'tag2']"
        description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
        buttonText="viac informácií"
      />
    </section>

    <section class="flex flex-col gap-4 p-8">
      <h1 class="h1" :class="titleClass">{{ t('room.subtitle') }}</h1>

      <Slideshow
        :images="slideshowImages"
        :variant="variant"
        :tags="['tag1', 'tag2']"
        description="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
        buttonText="viac informácií"
      />
    </section>
  </main>
</template>
