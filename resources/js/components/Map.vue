<script setup lang="ts">
import { computed, onMounted, ref, watch } from 'vue'

const props = defineProps<{
    lat: number
    lng: number
    name?: string
    homeLat?: number
    homeLng?: number
    homeName?: string
    variant?: 'light' | 'dark'
    apiKey?: string
}>()

const mapEl = ref<HTMLElement | null>(null)
const isTooltipOpen = ref(false)
const tooltipTitle = ref('')
const tooltipLat = ref(0)
const tooltipLng = ref(0)

let map: any = null
let marker: any = null
let homeMarker: any = null

const isLight = computed(() => props.variant === 'light')

const mapsUrl = computed(() =>
    `https://www.google.com/maps/search/?api=1&query=${tooltipLat.value},${tooltipLng.value}`
)

const tooltipClass = computed(() =>
    isLight.value
        ? 'bg-darkcolor text-lightcolor border-darkcolor'
        : 'bg-lightcolor text-darkcolor border-lightcolor'
)

function getProjectColor(name: string, fallback: string) {
    const root = getComputedStyle(document.documentElement)

    return (
        root.getPropertyValue(`--color-${name}`).trim() ||
        root.getPropertyValue(`--${name}`).trim() ||
        fallback
    )
}

function hexToRgb(hex: string) {
    const clean = hex.replace('#', '')

    if (clean.length !== 6) {
        return { r: 0, g: 0, b: 0 }
    }

    const value = parseInt(clean, 16)

    return {
        r: (value >> 16) & 255,
        g: (value >> 8) & 255,
        b: value & 255,
    }
}

function rgbToHex(r: number, g: number, b: number) {
    return `#${[r, g, b]
        .map((value) =>
            Math.max(0, Math.min(255, Math.round(value)))
                .toString(16)
                .padStart(2, '0')
        )
        .join('')}`
}

function mixColors(colorA: string, colorB: string, amount: number) {
    const a = hexToRgb(colorA)
    const b = hexToRgb(colorB)

    return rgbToHex(
        a.r + (b.r - a.r) * amount,
        a.g + (b.g - a.g) * amount,
        a.b + (b.b - a.b) * amount
    )
}

const colors = computed(() => {
    const lightcolor = getProjectColor('lightcolor', '#')
    const darkcolor = getProjectColor('darkcolor', '#')

    const background = isLight.value ? lightcolor : darkcolor
    const foreground = isLight.value ? darkcolor : lightcolor

    return {
        background,
        foreground,
        road: mixColors(background, foreground, 0.12),
        roadStrong: mixColors(background, foreground, 0.2),
        water: mixColors(background, foreground, 0.08),
        label: mixColors(background, foreground, 0.55),
        labelStroke: background,
    }
})

const mapStyles = computed<any[]>(() => {
    const c = colors.value

    return [
        {
            elementType: 'geometry',
            stylers: [{ color: c.background }],
        },
        {
            elementType: 'labels.icon',
            stylers: [{ visibility: 'off' }],
        },
        {
            elementType: 'labels.text.fill',
            stylers: [{ color: c.label }],
        },
        {
            elementType: 'labels.text.stroke',
            stylers: [{ color: c.labelStroke }],
        },
        {
            featureType: 'landscape',
            elementType: 'geometry',
            stylers: [{ color: c.background }],
        },
        {
            featureType: 'landscape.man_made',
            elementType: 'geometry',
            stylers: [{ color: c.background }],
        },
        {
            featureType: 'road',
            elementType: 'geometry',
            stylers: [{ color: c.road }],
        },
        {
            featureType: 'road',
            elementType: 'geometry.stroke',
            stylers: [{ color: c.background }],
        },
        {
            featureType: 'road.highway',
            elementType: 'geometry',
            stylers: [{ color: c.roadStrong }],
        },
        {
            featureType: 'road.highway',
            elementType: 'geometry.stroke',
            stylers: [{ color: c.background }],
        },
        {
            featureType: 'water',
            elementType: 'geometry',
            stylers: [{ color: c.water }],
        },
        {
            featureType: 'poi',
            stylers: [{ visibility: 'off' }],
        },
        {
            featureType: 'transit',
            stylers: [{ visibility: 'off' }],
        },
        {
            featureType: 'administrative',
            elementType: 'geometry',
            stylers: [{ color: c.roadStrong }],
        },
    ]
})

function createMarkerIcon() {
    const c = colors.value

    const svg = `
        <svg width="28" height="28" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M4.14645 0.146447C4.24021 0.0526784 4.36739 0 4.5 0H11.5C11.7761 0 12 0.223858 12 0.5C12 1.17938 11.6581 1.67405 11.3536 1.97855C11.2281 2.10398 11.1036 2.20305 11 2.27658V6.70807C11.0246 6.72292 11.0505 6.7388 11.0775 6.75569C11.2807 6.88271 11.5538 7.0702 11.8293 7.31121C12.3591 7.77485 13 8.52678 13 9.5C13 9.77614 12.7761 10 12.5 10H8.5V14.5C8.5 14.7761 8.27614 16 8 16C7.72386 16 7.5 14.7761 7.5 14.5V10H3.5C3.22386 10 3 9.77614 3 9.5C3 8.52678 3.64087 7.77485 4.17075 7.31121C4.44619 7.0702 4.71927 6.88271 4.9225 6.75569C4.94953 6.7388 4.97541 6.72292 5 6.70807V2.27658C4.89642 2.20305 4.77188 2.10398 4.64645 1.97855C4.34195 1.67405 4 1.17938 4 0.5C4 0.367392 4.05268 0.240215 4.14645 0.146447Z"
                fill="${c.foreground}"
                stroke="${c.background}"
                stroke-width="0.7"
            />
        </svg>
    `

    return {
        url: `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(svg)}`,
        scaledSize: new (window as any).google.maps.Size(24, 24),
        anchor: new (window as any).google.maps.Point(12, 24),
    }
}

function createHomeMarkerIcon() {
    const c = colors.value

    const svg = `
        <svg width="20" height="35" viewBox="0 0 87 155" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M84.2938 0H26.9051L13.7395 64.0835C17.4191 61.7948 24.7109 58.0021 34.5007 57.2828C38.0115 57.0212 56.9835 55.648 67.7186 69.1186C74.1664 77.1945 74.2001 86.2839 74.1664 88.9976C74.1326 91.9402 73.795 103.122 64.5116 111.721C57.4224 118.26 49.1517 119.568 46.181 119.895C46.2147 117.377 46.2147 114.893 46.2485 112.375C49.0166 113.258 51.8186 114.141 54.5867 115.056C56.5447 115.121 58.3001 114.042 58.9415 112.375C59.7179 110.446 58.8402 108.125 56.8148 107.046C53.3377 105.803 49.8606 104.561 46.3835 103.318C46.2147 99.166 46.0122 95.0136 45.8434 90.8613C45.6071 88.7033 43.6829 87.0359 41.4211 87.0686C39.1931 87.1012 37.3026 88.7687 37.1001 90.9266C37.0663 91.7767 37.0326 92.6595 36.9988 93.5096C33.7243 95.9618 30.4835 98.414 27.209 100.866C26.0612 102.468 26.1287 104.593 27.3778 105.999C28.7956 107.601 31.395 107.896 33.2854 106.555C34.6357 105.542 35.9861 104.561 37.3364 103.547C37.3364 109.073 37.3364 114.566 37.3364 120.091C34.7032 119.764 28.2555 118.653 22.2465 113.748C15.0898 107.928 13.1319 100.506 12.5917 98.1197C8.40575 98.1197 4.186 98.1197 0 98.1197C1.18153 104.463 3.54459 109.073 5.26625 111.852C12.7605 124.015 24.7446 128.559 28.2217 129.834C31.8001 131.142 34.9396 131.796 37.0663 132.123C36.965 138.564 36.83 144.973 36.7287 151.414C37.2013 153.67 39.3619 155.206 41.5561 154.977C43.5479 154.781 45.202 153.277 45.5396 151.25C45.6071 144.874 45.6746 138.466 45.7084 132.09C49.9281 131.633 62.081 129.802 72.6135 120.157C74.8078 118.162 87.8046 105.869 86.9607 86.6762C85.9479 63.6258 65.8957 51.8226 64.6129 51.1033C50.2995 43.0275 35.9861 45.3489 32.2052 46.1009C34.2306 35.0825 36.2899 24.0967 38.3154 13.0783L83.8887 12.4244L84.2938 0Z"
                fill="${c.foreground}"
                stroke="${c.background}"
                stroke-width="0.7"
            />
        </svg>
    `

    return {
        url: `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(svg)}`,
        scaledSize: new (window as any).google.maps.Size(20, 20),
        anchor: new (window as any).google.maps.Point(10, 35),
    }
}

function openTooltip(title: string, lat: number, lng: number) {
    tooltipTitle.value = title
    tooltipLat.value = lat
    tooltipLng.value = lng
    isTooltipOpen.value = true
}

function createMarkers(center: { lat: number; lng: number }) {
    marker = new (window as any).google.maps.Marker({
        position: center,
        map,
        icon: createMarkerIcon(),
        animation: (window as any).google.maps.Animation.DROP,
    })

    marker.addListener('mouseover', () => {
        openTooltip(props.name || 'Miesto', props.lat, props.lng)
    })

    marker.addListener('click', () => {
        openTooltip(props.name || 'Miesto', props.lat, props.lng)
    })

    if (props.homeLat === undefined || props.homeLng === undefined) return

    homeMarker = new (window as any).google.maps.Marker({
        position: {
            lat: props.homeLat,
            lng: props.homeLng,
        },
        map,
        icon: createHomeMarkerIcon(),
    })

    homeMarker.addListener('mouseover', () => {
        openTooltip(props.homeName || 'Naša adresa', props.homeLat!, props.homeLng!)
    })

    homeMarker.addListener('click', () => {
        openTooltip(props.homeName || 'Naša adresa', props.homeLat!, props.homeLng!)
    })
}

function initMap() {
    if (!mapEl.value || !(window as any).google?.maps) return

    const center = {
        lat: props.lat,
        lng: props.lng,
    }

    map = new (window as any).google.maps.Map(mapEl.value, {
        center,
        zoom: 10,
        styles: mapStyles.value,
        disableDefaultUI: true,
        zoomControl: false,
        clickableIcons: false,
        gestureHandling: 'greedy',
        keyboardShortcuts: true,
        backgroundColor: colors.value.background,
    })

    createMarkers(center)
}

function loadScript(src: string) {
    return new Promise<void>((resolve, reject) => {
        if ((window as any).google?.maps) {
            resolve()
            return
        }

        const existingScript = document.querySelector(
            'script[src^="https://maps.googleapis.com/maps/api/js"]'
        )

        if (existingScript) {
            existingScript.addEventListener('load', () => resolve())
            existingScript.addEventListener('error', () => reject())
            return
        }

        const script = document.createElement('script')
        script.src = src
        script.async = true
        script.defer = true
        script.onload = () => resolve()
        script.onerror = () => reject(new Error('Failed to load Google Maps script'))

        document.head.appendChild(script)
    })
}

async function ensureGoogleMaps() {
    if ((window as any).google?.maps) return

    const env: any = (import.meta as any).env || {}
    const key =
        props.apiKey ||
        env.VITE_GOOGLE_MAPS_API_KEY ||
        env.GOOGLE_MAPS_API_KEY

    if (!key) {
        console.warn('ProjectMap: missing Google Maps API key')
        return
    }

    await loadScript(`https://maps.googleapis.com/maps/api/js?key=${key}`)
}

watch(
    () => [
        props.lat,
        props.lng,
        props.name,
        props.homeLat,
        props.homeLng,
        props.homeName,
        props.variant,
    ],
    () => {
        if (!map || !marker) return

        const center = {
            lat: props.lat,
            lng: props.lng,
        }

        map.setCenter(center)
        map.setOptions({
            styles: mapStyles.value,
            backgroundColor: colors.value.background,
        })

        marker.setPosition(center)
        marker.setIcon(createMarkerIcon())
        marker.setAnimation(null)

        setTimeout(() => {
            marker?.setAnimation((window as any).google.maps.Animation.DROP)
        }, 0)

        if (props.homeLat !== undefined && props.homeLng !== undefined) {
            const homeCenter = {
                lat: props.homeLat,
                lng: props.homeLng,
            }

            if (!homeMarker) {
                homeMarker = new (window as any).google.maps.Marker({
                    position: homeCenter,
                    map,
                    icon: createHomeMarkerIcon(),
                    animation: (window as any).google.maps.Animation.DROP,
                })

                homeMarker.addListener('mouseover', () => {
                    openTooltip(props.homeName || 'Naša adresa', props.homeLat!, props.homeLng!)
                })

                homeMarker.addListener('click', () => {
                    openTooltip(props.homeName || 'Naša adresa', props.homeLat!, props.homeLng!)
                })
            } else {
                homeMarker.setPosition(homeCenter)
                homeMarker.setIcon(createHomeMarkerIcon())
            }
        } else if (homeMarker) {
            homeMarker.setMap(null)
            homeMarker = null
        }

        isTooltipOpen.value = false
    }
)

onMounted(async () => {
    try {
        await ensureGoogleMaps()
        initMap()
    } catch (error) {
        console.error('ProjectMap: failed to initialize map', error)
    }
})
</script>

<template>
  <div
    class="relative h-full w-full overflow-hidden"
    :style="{ backgroundColor: colors.background }"
  >
    <div ref="mapEl" class="h-full w-full"></div>

    <div
      v-if="isTooltipOpen"
      class="absolute left-1/2 top-1/2 z-20 min-w-40 -translate-x-1/2 -translate-y-[120%] border px-3 py-2"
      :class="tooltipClass"
    >
      <button
        type="button"
        class="absolute right-1 top-1 cursor-pointer"
        aria-label="Close map tooltip"
        @click="isTooltipOpen = false"
      >
        <i class="bi bi-x"></i>
      </button>

      <div class="p pr-5">
        {{ tooltipTitle || 'Miesto' }}
      </div>

      <a
        class="p underline"
        :href="mapsUrl"
        target="_blank"
        rel="noopener noreferrer"
      >
        zobraziť v mapách
      </a>
    </div>
  </div>
</template>