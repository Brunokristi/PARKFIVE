<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { useGlobalActions } from '../composables/useGlobalActions'
import Logo from './Logo.vue'
import Table from './Table.vue'

const { t } = useI18n()

const {
    openContacts,
    openRecentProjects,
    openWorkflow,
    openPrivacyPolicy,
    openInstagram,
    openMessenger,
} = useGlobalActions()

const props = defineProps({
    variant: {
        type: String,
        default: 'dark',
    },
})

const footerSections = computed(() => [
    {
        id: 'footer-links',
        heading: 'parkFIVE',
        logo: Logo,
        rows: [
            { id: 'contact', label: t('footer.contact'), actions: [], onClick: openContacts },
            { id: 'portfolio', label: t('footer.portfolio'), actions: [], onClick: openRecentProjects },
            { id: 'workflow', label: t('footer.workflow'), actions: [], onClick: openWorkflow },
            { id: 'privacy', label: t('footer.privacy'), actions: [], onClick: openPrivacyPolicy },
            { id: 'instagram', label: t('footer.instagram'), actions: [], onClick: openInstagram },
            { id: 'facebook', label: t('footer.facebook'), actions: [], onClick: openMessenger },
        ],
    },
])
</script>

<template>
  <footer class="flex items-center w-full px-8">
      <Table
        :sections="footerSections"
        :variant="variant"
      />
  </footer>
</template>