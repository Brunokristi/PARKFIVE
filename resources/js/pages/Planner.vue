<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'

import ActivitySlider from '../components/ActivitySlider.vue'
import ItineraryTable from '../components/ItineraryTable.vue'
import Text from '../components/Text.vue'

const route = useRoute()
const { locale } = useI18n()

type Variant = 'light' | 'dark'
type LocalizedText = Record<string, string>

interface DbActivity {
    id: string
    title: LocalizedText
    image: string
    mapQuery?: string
    lat?: number
    lng?: number
    tags: LocalizedText[]
    description: LocalizedText
    durationHours: number
}

interface Activity {
    id: string
    title: string
    image: string
    mapQuery?: string
    lat?: number
    lng?: number
    tags: string[]
    description: string
    durationHours: number
}

interface PlannedActivity extends Activity {
    itineraryIndex: number
}

interface PlannedDay {
    day: number
    usedHours: number
    items: PlannedActivity[]
}

interface DbPlannerContent {
    heading: LocalizedText
    description: LocalizedText
    hoursPerDay: number
    activities: DbActivity[]
}

const content = ref<DbPlannerContent | null>(null)
const itineraryItems = ref<Activity[]>([])

const variant = computed<Variant>(() =>
    route.meta.theme === 'light' ? 'light' : 'dark'
)

const pageClass = computed(() =>
    variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
)

function localize(value?: LocalizedText) {
    if (!value) return ''

    return value[locale.value] || value.sk || Object.values(value)[0] || ''
}

function loadMockContent() {
    content.value = {
        heading: {
            sk: 'Plánovač',
            en: 'Planner',
        },
        description: {
            sk: 'Plánujte svoj výlet jednoducho a efektívne. Presúvajte aktivity, pridávajte ich do itinerára a sledujte, koľko času vám zostáva do naplánovania.',
            en: 'Plan your trip easily and efficiently. Move activities, add them to your itinerary, and keep track of your planned time.',
        },
        hoursPerDay: 8,
        activities: [
            {
                id: 'castle',
                title: {
                    sk: 'Fiľakovský hrad',
                    en: 'Fiľakovo Castle',
                },
                image: '/assets/image.jpg',
                lat: 48.267,
                lng: 19.824,
                tags: [
                    { sk: 'hrad', en: 'castle' },
                    { sk: 'výhľad', en: 'view' },
                ],
                description: {
                    sk: 'Historická dominanta mesta s výhľadom na okolie.',
                    en: 'A historic landmark with views of the surrounding area.',
                },
                durationHours: 2,
            },
            {
                id: 'viewpoint',
                title: {
                    sk: 'Haličský zámok',
                    en: 'Halič Castle',
                },
                image: '/assets/image.jpg',
                lat: 48.262,
                lng: 19.724,
                tags: [
                    { sk: 'zámok', en: 'chateau' },
                    { sk: 'výlet', en: 'trip' },
                ],
                description: {
                    sk: 'Zámok vhodný na krátky výlet v okolí.',
                    en: 'A chateau suitable for a short trip nearby.',
                },
                durationHours: 1.5,
            },
        ],
    }
}

watch(locale, loadMockContent, { immediate: true })

const activities = computed<Activity[]>(() =>
    content.value?.activities.map((activity) => ({
        id: activity.id,
        title: localize(activity.title),
        image: activity.image,
        mapQuery: activity.mapQuery,
        lat: activity.lat,
        lng: activity.lng,
        tags: activity.tags.map((tag) => localize(tag)),
        description: localize(activity.description),
        durationHours: activity.durationHours,
    })) || []
)

const hoursPerDay = computed(() => content.value?.hoursPerDay || 8)

const totalPlannedHours = computed(() =>
    itineraryItems.value.reduce((sum, item) => sum + item.durationHours, 0)
)

const plannedDays = computed<PlannedDay[]>(() => {
    const days: PlannedDay[] = []

    if (!itineraryItems.value.length) return days

    let currentDay: PlannedDay = {
        day: 1,
        usedHours: 0,
        items: [],
    }

    itineraryItems.value.forEach((activity, itineraryIndex) => {
        const wouldOverflow =
            currentDay.items.length > 0 &&
            currentDay.usedHours + activity.durationHours > hoursPerDay.value

        if (wouldOverflow) {
            days.push(currentDay)

            currentDay = {
                day: currentDay.day + 1,
                usedHours: 0,
                items: [],
            }
        }

        currentDay.items.push({
            ...activity,
            itineraryIndex,
        })

        currentDay.usedHours += activity.durationHours
    })

    if (currentDay.items.length) {
        days.push(currentDay)
    }

    return days
})

function addActivity(activity: Activity) {
    if (itineraryItems.value.some((item) => item.id === activity.id)) return

    itineraryItems.value.push(activity)
}

function removeActivity(activity: Activity) {
    itineraryItems.value = itineraryItems.value.filter((item) => item.id !== activity.id)
}

function moveActivityUp(index: number) {
    if (index <= 0) return

    const items = [...itineraryItems.value]
    const current = items[index]

    items[index] = items[index - 1]
    items[index - 1] = current

    itineraryItems.value = items
}

function moveActivityDown(index: number) {
    if (index >= itineraryItems.value.length - 1) return

    const items = [...itineraryItems.value]
    const current = items[index]

    items[index] = items[index + 1]
    items[index + 1] = current

    itineraryItems.value = items
}

function openActivity(activity: Activity) {
    console.log('open activity', activity)
}
</script>

<template>
  <main
    v-if="content"
    class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:items-start"
    :class="pageClass"
  >
    <section class="flex flex-col gap-10 p-8">
      <ActivitySlider
        :activities="activities"
        :variant="variant"
        @select-activity="addActivity"
        @more-info="openActivity"
      />
    </section>

    <section class="flex flex-col gap-10 p-8 lg:col-span-2">
      <Text
        :heading="localize(content.heading)"
        :description="localize(content.description)"
        :variant="variant"
      />

      <ItineraryTable
        :days="plannedDays"
        :variant="variant"
        @remove="removeActivity"
        @move-up="moveActivityUp"
        @move-down="moveActivityDown"
      />
    </section>
  </main>
</template>