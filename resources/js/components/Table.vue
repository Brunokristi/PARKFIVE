<script setup>
import { computed } from 'vue'

const props = defineProps({
    sections: {
        type: Array,
        default: () => [],
    },
    variant: {
        type: String,
        default: 'dark',
    },
})

const emit = defineEmits(['row-action'])

const isLight = computed(() => props.variant === 'light')

const colorClass = computed(() =>
    isLight.value ? 'text-darkcolor border-darkcolor' : 'text-lightcolor border-lightcolor'
)

function handleAction(section, row, action) {
    emit('row-action', {
        section,
        row,
        action,
    })

    if (typeof action.onClick === 'function') {
        action.onClick(row, section)
    }
}
</script>

<template>
  <div class="w-full" :class="colorClass">
    <div
      v-for="(section, sectionIndex) in sections"
      :key="section.id || sectionIndex"
      class="grid grid-cols-[20%_80%] items-stretch"
    >
      <!-- Vertical heading -->
      <div class="relative flex items-center justify-center border-r" :class="colorClass">
        <div class="-rotate-90 whitespace-nowrap text-lg">
          {{ section.heading }}
        </div>
      </div>

      <!-- Rows -->
      <div class="flex flex-col">
        <div
          v-for="(row, rowIndex) in section.rows"
          :key="row.id || rowIndex"
          class="flex min-h-16 items-center justify-between border-b px-4 text-xl last:border-b-0"
          :class="colorClass"
        >
          <span>{{ row.label }}</span>

          <div class="flex items-center gap-4">
            <button
              v-for="(action, actionIndex) in row.actions || []"
              :key="action.id || actionIndex"
              type="button"
              class="cursor-pointer transition-opacity hover:opacity-70"
              :aria-label="action.label || 'Row action'"
              @click="handleAction(section, row, action)"
            >
              <i v-if="action.icon" :class="action.icon"></i>
              <span v-else>{{ action.text }}</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>