<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';

import { useI18n } from 'vue-i18n';
const { t, locale } = useI18n();

import Button from '../components/Button.vue';
import GridLayout from '../components/GridLayout.vue';
import BusinessCard from '../components/BusinessCard.vue';
import Text from '../components/Text.vue';
import Table from '../components/Table.vue';


import { useGlobalActions } from '../composables/useGlobalActions';
import Slideshow from '../components/Slideshow.vue';
const { openContacts, openRecentProjects, openWorkflow, openVcard } = useGlobalActions();

const cardFront = '/assets/card_front.svg';
const cardBack = '/assets/card_back.svg';
const bgUrl = '/assets/bg.svg'
const bgUrl2 = '/assets/bg2.svg'

const sections = [
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
                ],
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
}: {
  section: { id: string; heading: string };
  row: { id: string; label: string };
  action: { id: string; text?: string; icon?: string };
}) {
    console.log(section, row, action)
}

const cards = ref<Array<{
  heading: string;
  text: string;
  image: string;
  bgColor: string;
  link: string;
}>>([]);

</script>

<template>
    <main class="flex flex-col gap-[100px]">
      <section class="gap-4 flex flex-col p-4" data-theme="light">
        <h2 class="h1 text-lightcolor">{{ t('home.subtitle1') }}</h2>
        <Text
          :heading="t('home.heading')"
          :description="t('home.description')"
        />
        <Slideshow :images="[
          { src: '/assets/image.jpg', alt: 'Project 1' },
          { src: '/assets/image2.jpg', alt: 'Project 2' },
        ]" />

        <Table
          :sections="sections"
          variant="dark"
          @row-action="handleRowAction"
        />
      </section>

      <section class="flex flex-col gap-4" data-theme="light">
        <GridLayout :cards="cards" />
        <Button :text="t('home.recentProjects')" @click="openRecentProjects"/>
      </section>

      <section class="relative overflow-hidden flex justify-center" data-theme="dark">
        <img
          :src="bgUrl2"
          alt="Dark blue and black gradient background"
          class="block max-w-none h-auto"
        />

        <div class="absolute inset-0 z-10 flex flex-col items-center justify-center text-center gap-4 p-4">
          <h2 class="h2 text-light">{{ t('home.subtitle2') }}</h2>
          <p class="p uppercase text-light">{{ t('home.description2') }}</p>
          <Button
            :text="t('home.workflow')"
            variant="light"
            @click="openWorkflow"
            class="mt-12"
          />
        </div>
      </section>

      <section class="gap-4 flex flex-col p-4" data-theme="light">
        <h2 class="h2 text-accent">{{ t('home.quote') }}</h2>
      </section>

      <section class="flex flex-col gap-6 p-4" data-theme="light">
          <Button :text="t('home.contact')" @click="openContacts" />

          <BusinessCard
              :front-src="cardFront"
              :back-src="cardBack"
          />
          <Button :text="t('home.vcard')" @click="openVcard" />
      </section>
    </main>
</template>
