<script setup lang="ts">
import { computed, ref } from 'vue'
import { useRoute } from 'vue-router'

import ActivitySlider from '../components/activitySlider.vue'
import ItineraryTable from '../components/ItineraryTable.vue'
import Text from '../components/Text.vue'
import { useHotelPageContent } from '../composables/useHotelPageContent'

const route = useRoute()

type Variant = 'light' | 'dark'

interface DbActivity {
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
    heading: string
    description: string
    hoursPerDay: number
    activities: DbActivity[]
}

const { content } = useHotelPageContent<DbPlannerContent>('planner')
const itineraryItems = ref<Activity[]>([])

const variant = computed<Variant>(() =>
    route.meta.theme === 'light' ? 'light' : 'dark'
)

const pageClass = computed(() =>
    variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
)

const activities = computed<Activity[]>(() =>
    content.value?.activities.map((activity) => ({
        id: activity.id,
        title: activity.title,
        image: activity.image,
        mapQuery: activity.mapQuery,
        lat: activity.lat,
        lng: activity.lng,
        tags: activity.tags,
        description: activity.description,
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
                :heading="content.heading"
                :description="content.description"
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