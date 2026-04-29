import { ref, watch } from 'vue'
import { useI18n } from 'vue-i18n'

export function useHotelPageContent<T>(pageKey: string) {
    const { locale } = useI18n()
    const content = ref<T | null>(null)

    async function load() {
        const response = await fetch(`/api/hotel/pages/${pageKey}?locale=${locale.value}`)

        if (!response.ok) {
            throw new Error(`Failed to load ${pageKey} content`)
        }

        const payload = await response.json()
        content.value = payload.content as T
    }

    watch(locale, () => {
        load().catch((error) => console.error(error))
    }, { immediate: true })

    return {
        content,
        load,
    }
}