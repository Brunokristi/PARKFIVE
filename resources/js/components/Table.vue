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
    isLight.value
        ? 'text-darkcolor border-darkcolor'
        : 'text-lightcolor border-lightcolor'
)

function handleRowClick(section, row) {
    if (!row.onClick) return

    emit('row-action', { section, row })
    row.onClick(row, section)
}
</script>

<template>
    <div class="w-full" :class="colorClass">
        <div
            v-for="(section, sectionIndex) in sections"
            :key="section.id || sectionIndex"
        >
            <!-- SECTION -->
            <div class="grid grid-cols-[20%_80%] items-stretch">
            
            <!-- LEFT: heading -->
            <div class="flex items-center justify-center border-r" :class="colorClass">
                <div class="-rotate-90 md:rotate-0 flex items-center gap-4 whitespace-nowrap md:pr-8">
                <component
                    v-if="section.logo && typeof section.logo !== 'string'"
                    :is="section.logo"
                    class="h-6 w-auto"
                />
                <img
                    v-else-if="section.logo"
                    :src="section.logo"
                    alt=""
                    class="h-6 w-auto"
                />
                <div class="h2 md:text-right">
                    {{ section.heading }}
                </div>
                </div>
            </div>

            <!-- RIGHT: rows -->
            <div class="flex flex-col">
                <div
                v-for="(row, rowIndex) in section.rows"
                :key="row.id || rowIndex"
                class="flex items-center border-b px-4 py-2 p last:border-b-0"
                :class="[
                    colorClass,
                    row.onClick ? 'cursor-pointer transition-opacity hover:bg-lightcolor hover:text-darkcolor' : ''
                ]"
                role="button"
                :tabindex="row.onClick ? 0 : undefined"
                @click="handleRowClick(section, row)"
                @keydown.enter="handleRowClick(section, row)"
                @keydown.space.prevent="handleRowClick(section, row)"
                >
                <span class="flex-1">{{ row.label }}</span>

                <div
                    v-if="row.actions && row.actions.length"
                    class="flex items-center justify-center w-20 shrink-0"
                    >
                    <div class="flex items-center gap-3">
                        <button
                        v-for="(action, actionIndex) in row.actions"
                        :key="action.id || actionIndex"
                        type="button"
                        class="cursor-pointer transition-opacity hover:opacity-70"
                        @click.stop="action.onClick?.()"
                        >
                        <i v-if="action.icon" :class="action.icon"></i>
                        <span v-else>{{ action.text }}</span>
                        </button>
                    </div>
                    </div>
                </div>
            </div>
            </div>

            <!-- FULL-WIDTH DIVIDER -->
            <div
            v-if="sectionIndex !== sections.length - 1"
            class="w-full border-t"
            :class="colorClass"
            ></div>
        </div>
    </div>
</template>