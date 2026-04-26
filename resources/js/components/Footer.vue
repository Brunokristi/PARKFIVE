<script setup>
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { useGlobalActions } from '../composables/useGlobalActions';
import Logo from './Logo.vue';

const { t } = useI18n();

const {
    openContacts,
    openRecentProjects,
    openWorkflow,
    openPrivacyPolicy,
    openInstagram,
    openMessenger,
} = useGlobalActions();

const props = defineProps({
    variant: {
        type: String,
        default: 'dark',
    },
});

const isLight = computed(() => props.variant === 'light');

const colorClass = computed(() =>
    isLight.value ? 'text-darkcolor' : 'text-lightcolor'
);

const linkClass = computed(() => [
    'py-2 px-4 w-full transition-colors',
    isLight.value
        ? 'hover:bg-darkcolor hover:text-lightcolor'
        : 'hover:bg-lightcolor hover:text-darkcolor',
]);
</script>

<template>
  <footer class="flex items-center w-full px-4" :class="colorClass">
    <div class="w-[30%] flex justify-center items-center">
      <a href="/" :class="colorClass">
        <Logo :width="100" :height="100" />
      </a>
    </div>

    <div
      class="w-[70%] flex flex-col items-start border-l text-left divide-y text-sm"
      :class="colorClass"
    >
      <a href="#" :class="linkClass" @click.prevent="openContacts">{{ t('footer.contact') }}</a>
      <a href="#" :class="linkClass" @click.prevent="openRecentProjects">{{ t('footer.portfolio') }}</a>
      <a href="#" :class="linkClass" @click.prevent="openWorkflow">{{ t('footer.workflow') }}</a>
      <a href="#" :class="linkClass" @click.prevent="openPrivacyPolicy">{{ t('footer.privacy') }}</a>
      <a href="#" :class="linkClass" @click.prevent="openInstagram">{{ t('footer.instagram') }}</a>
      <a href="#" :class="linkClass" @click.prevent="openMessenger">{{ t('footer.facebook') }}</a>
    </div>
  </footer>
</template>