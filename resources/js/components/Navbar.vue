<script setup>
import { computed, ref } from 'vue'
import Logo from './Logo.vue'
import Table from './Table.vue'

const props = defineProps({
    variant: {
        type: String,
        default: 'dark',
    },
})

const isOpen = ref(false)

/* main header still respects page variant */
const isLight = computed(() => props.variant === 'light')

const colorClass = computed(() =>
    isLight.value ? 'text-darkcolor' : 'text-lightcolor'
)

/* force teleport to always use dark theme */
const overlayVariant = 'dark'

const overlayClass = computed(() =>
    overlayVariant === 'dark'
        ? 'bg-darkcolor text-lightcolor'
        : 'bg-lightcolor text-darkcolor'
)

const sections = [
    {
        id: 'menu',
        heading: 'menu',
        rows: [
            { label: 'Home', onClick: () => (window.location.href = '/') },
            { label: 'Portfolio', onClick: () => console.log('go portfolio') },
            { label: 'Contact', onClick: () => console.log('go contact') },
        ],
    },
]

function toggleMenu() {
    isOpen.value = !isOpen.value
}

function closeMenu() {
    isOpen.value = false
}
</script>

<template>
  <!-- HEADER -->
  <div class="sticky top-0 z-50 flex justify-between items-center px-8 py-4" :class="colorClass">
    <a href="/" :class="colorClass">
      <Logo :width="20" :height="20" />
    </a>

    <button :class="colorClass" @click="toggleMenu">
      <i class="bi bi-list cursor-pointer"></i>
    </button>
  </div>

  <!-- TELEPORT MENU -->
  <Teleport to="body">
    <div
      v-if="isOpen"
      class="fixed inset-0 z-[999] flex flex-col backdrop-blur-sm"
      :class="overlayClass"
      @click.self="closeMenu"
    >
      <!-- CLOSE BUTTON -->
      <div class="flex justify-end p-8">
        <button @click="closeMenu" class="text-lightcolor">
          <i class="bi bi-x-lg cursor-pointer"></i>
        </button>
      </div>

      <!-- CONTENT -->
      <div class="flex-1 flex items-center justify-center px-4">
        <div class="w-full">
          <Table
            :sections="sections"
            variant="dark"
          />
        </div>
      </div>
    </div>
  </Teleport>
</template>