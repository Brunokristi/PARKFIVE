<script setup lang="ts">
import { computed, ref } from 'vue'
import { useRoute } from 'vue-router'

import ItineraryTable from '../components/ItineraryTable.vue'
import ActivitySlider from '../components/ActivitySlider.vue'

const route = useRoute()

type Variant = 'light' | 'dark'

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

interface PlannedDay {
  day: number
  usedHours: number
  items: PlannedActivity[]
}

interface PlannedActivity extends Activity {
  itineraryIndex: number
}

const HOURS_PER_DAY = 8

const variant = computed<Variant>(() =>
    route.meta.theme === 'light' ? 'light' : 'dark'
)

const titleClass = computed(() =>
    variant.value === 'light' ? 'text-darkcolor' : 'text-lightcolor'
)

const activities = ref<Activity[]>([
    {
        id: 'castle',
        title: 'Fiľakovský hrad',
        image: '/assets/image.jpg',
        mapQuery: 'Fiľakovský hrad',
        tags: ['Biela Labuť', 'reštaurácia'],
        description: 'Lorem ipsum dolor sit amet.',
      durationHours: 3,
    },
    {
        id: 'restaurant',
        title: 'Reštaurácia',
        image: '/assets/image2.jpg',
        tags: ['obed', 'večera'],
        description: 'Aenean eu purus feugiat nisl hendrerit malesuada.',
      durationHours: 2,
    },
    {
        id: 'walk',
        title: 'Prechádzka mestom',
        image: '/assets/image3.jpg',
        tags: ['prechádzka', 'centrum'],
        description: 'Krátka aktivita vhodná na popoludnie.',
      durationHours: 4,
    },
])

const itineraryItems = ref<Activity[]>([])

  const totalPlannedHours = computed(() =>
    itineraryItems.value.reduce((sum, item) => sum + item.durationHours, 0)
  )

  const totalDaysNeeded = computed(() => {
    if (!itineraryItems.value.length) return 0

    return Math.ceil(totalPlannedHours.value / HOURS_PER_DAY)
  })

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
        currentDay.usedHours + activity.durationHours > HOURS_PER_DAY

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
  <main class="grid grid-cols-1 gap-10 lg:grid-cols-3 lg:items-start">
    <section class="flex flex-col gap-4 p-4">
      <h1 class="h1" :class="titleClass">
        Itinerár
      </h1>

      <ActivitySlider
        :activities="activities"
        :variant="variant"
        @select-activity="addActivity"
        @more-info="openActivity"
      />
    </section>

    <section class="flex flex-col gap-10 p-4 lg:col-span-2">
      <div :class="titleClass">
        <h2 class="h2">
          Vybrané aktivity
        </h2>

        <p class="p">
          Vyberte aktivity zo slidera. Itinerár sa naplánuje automaticky na dni po 8 hodinách.
        </p>
      </div>

      <div class="p" :class="titleClass">
        <p>
          Celkový čas: {{ totalPlannedHours }} h
        </p>
        <p>
          Potrebný počet dní: {{ totalDaysNeeded }}
        </p>
      </div>

      <ItineraryTable
        :days="plannedDays"
        :hours-per-day="HOURS_PER_DAY"
        :variant="variant"
        @remove="removeActivity"
        @move-up="moveActivityUp"
        @move-down="moveActivityDown"
      />

    </section>
  </main>
</template>