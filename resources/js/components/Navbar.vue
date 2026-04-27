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

const colorClass = computed(() =>
    props.variant === 'light' ? 'text-darkcolor' : 'text-lightcolor'
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
  <div class="sticky top-0 z-50 flex justify-between items-center p-4">
    <a href="/" :class="colorClass">
      <Logo :width="20" :height="20" />
    </a>

    <button :class="colorClass" @click="toggleMenu">
      <i class="bi bi-list cursor-pointer"></i>
    </button>
  </div>

  <!-- TELEPORT -->
  <Teleport to="body">
    <div
      v-if="isOpen"
      class="fixed inset-0 z-[999] flex flex-col bg-darkcolor backdrop-blur-sm"
      @click.self="closeMenu"
    >
      <!-- close button -->
      <div class="flex justify-end p-4 ">
        <button @click="closeMenu" :class="colorClass">
          <i class="bi bi-x-lg cursor-pointer"></i>
        </button>
      </div>

      <!-- content -->
      <div class="flex-1 flex items-center justify-center px-4">
        <div class="w-full">
          <Table :sections="sections" :variant="props.variant" />
        </div>
      </div>
    </div>
  </Teleport>
</template>