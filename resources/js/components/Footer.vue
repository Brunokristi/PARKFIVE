<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'

import Logo from './Logo.vue'
import Table from './Table.vue'

const props = defineProps({
    variant: {
        type: String,
        default: 'dark',
    },
})

const router = useRouter()
const { t } = useI18n()

const footerSections = computed(() => [
    {
        id: 'footer-links',
        heading: 'parkFIVE',
        logo: Logo,
        rows: [
            createLink('home', t('nav.home'), '/'),
            createLink('hotel', t('nav.hotel'), '/property'),
            createLink('services', t('nav.services'), '/services'),
            createLink('planner', t('nav.planner'), '/planner'),
            createLink('contact', t('nav.contact'), '/contact'),
            createLink('privacy', t('nav.privacy'), '/privacy-policy'),
            createCookieLink(),
        ],
    },
])

function createLink(id, label, path) {
    return {
        id,
        label,
        actions: [
            {
                id: 'open',
                icon: 'bi bi-chevron-right',
                onClick: () => router.push(path),
            },
        ],
        onClick: () => router.push(path),
    }
}

function createCookieLink() {
    return {
        id: 'cookies',
        label: t('footer.cookies'),
        actions: [
            {
                id: 'open',
                icon: 'bi bi-chevron-right',
                onClick: openCookieSettings,
            },
        ],
        onClick: openCookieSettings,
    }
}

function openCookieSettings() {
    window.dispatchEvent(new Event('open-cookie-consent'))
}
</script>

<template>
  <footer class="w-full px-8">
    <Table
      :sections="footerSections"
      :variant="variant"
    />
  </footer>
</template>