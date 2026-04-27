<script setup lang="ts">
import { computed, ref, nextTick, onMounted } from 'vue'

type InputType = 'text' | 'email' | 'tel' | 'number' | 'password' | 'textarea' | 'file'

const props = withDefaults(defineProps<{
    label?: string
    info?: string
    type?: InputType
    modelValue?: string | number | File | File[] | null
    error?: string
    placeholder?: string
    maxLength?: number
    variant?: 'light' | 'dark'
    multiple?: boolean
    fileAccept?: string
    autofocus?: boolean
}>(), {
    type: 'text',
    modelValue: '',
    variant: 'dark',
    multiple: false,
    fileAccept: '',
    autofocus: false,
})

const emit = defineEmits<{
    'update:modelValue': [value: string | number | File | File[] | null]
}>()

const showInfo = ref(false)
const inputRef = ref<HTMLInputElement | null>(null)
const textareaRef = ref<HTMLTextAreaElement | null>(null)
const fileInput = ref<HTMLInputElement | null>(null)

const isLight = computed(() => props.variant === 'light')

const fieldClass = computed(() =>
    isLight.value
        ? 'border-darkcolor text-darkcolor placeholder:text-darkcolor placeholder:p'
        : 'border-lightcolor text-lightcolor placeholder:text-lightcolor placeholder:p'
)

const invertedClass = computed(() =>
    isLight.value
        ? 'bg-darkcolor text-lightcolor'
        : 'bg-lightcolor text-darkcolor'
)

const currentLength = computed(() => {
    if (typeof props.modelValue === 'string') return props.modelValue.length
    if (typeof props.modelValue === 'number') return String(props.modelValue).length
    return 0
})

const fileCount = computed(() => {
    if (Array.isArray(props.modelValue)) return props.modelValue.length
    return props.modelValue ? 1 : 0
})

function updateValue(value: string) {
    const nextValue = props.maxLength ? value.slice(0, props.maxLength) : value

    if (props.type === 'number') {
        emit('update:modelValue', nextValue === '' ? '' : Number(nextValue))
        return
    }

    emit('update:modelValue', nextValue)
}

function handleFileChange(event: Event) {
    const input = event.target as HTMLInputElement

    if (props.multiple) {
        const files = Array.from(input.files || [])
        emit('update:modelValue', files.length ? files : null)
        return
    }

    emit('update:modelValue', input.files?.[0] || null)
}

function resizeTextarea() {
    nextTick(() => {
        if (!textareaRef.value) return

        textareaRef.value.style.height = 'auto'
        textareaRef.value.style.height = `${textareaRef.value.scrollHeight}px`
    })
}

function focusField() {
  if (props.type === 'textarea') {
    textareaRef.value?.focus()
    return
  }

  if (['text', 'email', 'tel', 'number', 'password'].includes(props.type)) {
    inputRef.value?.focus()
  }
}

onMounted(() => {
  if (!props.autofocus) return

  nextTick(() => {
    focusField()
  })
})
</script>

<template>
  <div class="w-full mb-6">
    <div class="flex items-center gap-2">
      <label v-if="label" class="p" :class="fieldClass">
        {{ label }}
      </label>

      <div v-if="info" class="relative">
        <button
          type="button"
          class="inline-flex items-center"
          :class="fieldClass"
          @mouseenter="showInfo = true"
          @mouseleave="showInfo = false"
          @click="showInfo = !showInfo"
        >
          <i class="bi bi-info-circle h-4 w-4"></i>
        </button>

        <div
          v-if="showInfo"
          class="absolute left-0 top-full z-20 mt-2 w-50 p-2 p shadow"
          :class="invertedClass"
        >
          {{ info }}
        </div>
      </div>
    </div>

    <input
      v-if="['text', 'email', 'tel', 'number', 'password'].includes(type)"
      ref="inputRef"
      :type="type"
      :value="typeof modelValue === 'string' || typeof modelValue === 'number' ? modelValue : ''"
      :placeholder="placeholder"
      :maxlength="maxLength"
      class="w-full bg-transparent py-1.5 px-0 border-0 border-b outline-none ring-0 focus:outline-none focus:ring-0 p placeholder:p"
      :class="fieldClass"
      @input="updateValue(($event.target as HTMLInputElement).value)"
    />

    <textarea
      v-else-if="type === 'textarea'"
      ref="textareaRef"
      :value="typeof modelValue === 'string' || typeof modelValue === 'number' ? modelValue : ''"
      :placeholder="placeholder"
      :maxlength="maxLength"
      class="w-full bg-transparent py-1 px-0 border-0 border-b outline-none ring-0 focus:outline-none focus:ring-0 resize-none p placeholder:p"
      :class="fieldClass"
      rows="1"
      style="overflow: hidden;"
      @input="updateValue(($event.target as HTMLTextAreaElement).value); resizeTextarea()"
    />

    <template v-else-if="type === 'file'">
      <input
        ref="fileInput"
        type="file"
        class="hidden"
        :multiple="multiple"
        :accept="fileAccept"
        @change="handleFileChange"
      />

      <button
        type="button"
        class="flex w-full items-center justify-between bg-transparent py-1.5 px-0 border-0 border-b outline-none cursor-pointer"
        :class="fieldClass"
        @click="fileInput?.click()"
      >

        <span class="flex items-center gap-1">
          <template v-if="fileCount">
            <i v-for="n in fileCount" :key="n" class="bi bi-file-earmark"></i>
          </template>
          <i v-else class="bi bi-paperclip"></i>
        </span>
      </button>
    </template>

    <div class="flex justify-between mt-1 ">
        <div>
            <p v-if="error" class="p text-[10px]" :class="fieldClass">
            {{ error }}
            </p>
        </div>

        <div
        v-if="maxLength && type !== 'file'"
        class="p text-[10px]"
        :class="fieldClass"
        >
        {{ currentLength }} z {{ maxLength }}
        </div>
    </div>

    
  </div>
</template>