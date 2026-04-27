<script setup lang="ts">
import { computed, ref, watch, onMounted, nextTick } from 'vue'
import { useRoute } from 'vue-router'
import Button from '../components/Button.vue'
import FormField from '../components/FormField.vue'

const route = useRoute()

type Variant = 'light' | 'dark'
type MessageStatus = 'delivered' | 'failed'

interface ChatMessage {
    id: string
    text: string
    from: 'user' | 'admin'
    status?: MessageStatus
}

const storageKey = 'parkfive-contact-chat'
const message = ref('')
const messages = ref<ChatMessage[]>([])
const messagesContainer = ref<HTMLElement | null>(null)

const maxLength = 500

const variant = computed<Variant>(() =>
    route.meta.theme === 'light' ? 'light' : 'dark'
)

const isLight = computed(() => variant.value === 'light')

const colorClass = computed(() =>
    isLight.value ? 'text-darkcolor border-darkcolor' : 'text-lightcolor border-lightcolor'
)

const userBubbleClass = computed(() =>
    isLight.value ? 'bg-darkcolor text-lightcolor' : 'bg-lightcolor text-darkcolor'
)

const adminBubbleClass = computed(() =>
    isLight.value ? 'bg- text-darkcolor border-darkcolor' : 'bg-darkcolor text-lightcolor border-lightcolor'
)

function createId() {
    return crypto?.randomUUID?.() || `${Date.now()}-${Math.random()}`
}

function loadMessages() {
    const savedMessages = localStorage.getItem(storageKey)

    if (savedMessages) {
        try {
            messages.value = JSON.parse(savedMessages)
        } catch {
            messages.value = []
        }
    }

    if (!messages.value.length) {
        messages.value.push({
            id: createId(),
            text: 'Dobrý deň, ako vám môžeme pomôcť?',
            from: 'admin',
            status: 'delivered',
        })
    }
}

function sendMessage() {
    const text = message.value.trim()

    if (!text) return

    messages.value.push({
        id: createId(),
        text,
        from: 'user',
        status: 'delivered',
    })

    message.value = ''

    messages.value.push({
        id: createId(),
        text: 'Ďakujeme za správu. Ozveme sa vám čo najskôr.',
        from: 'admin',
        status: 'delivered',
    })
}

  function scrollToBottom() {
    if (!messagesContainer.value) return

    messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
  }

watch(
    messages,
    (value) => {
        localStorage.setItem(storageKey, JSON.stringify(value))
    nextTick(scrollToBottom)
    },
    { deep: true }
)

watch(message, (value) => {
    if (value.length > maxLength) {
        message.value = value.slice(0, maxLength)
    }
})

onMounted(() => {
  loadMessages()
  nextTick(scrollToBottom)
})
</script>

<template>
  <main class="flex h-[70vh] flex-col" :class="colorClass">
  
  <!-- SCROLLABLE CHAT -->
  <section ref="messagesContainer" class="flex-1 overflow-y-auto">
    <div class="flex flex-col gap-6 justify-end min-h-full">
      <div
        v-for="chatMessage in messages"
        :key="chatMessage.id"
        class="flex flex-col"
        :class="chatMessage.from === 'user' ? 'items-end' : 'items-start'"
      >
        <div
          class="max-w-[75%] px-4 py-3 p"
            :class="userBubbleClass"
        >
          {{ chatMessage.text }}
        </div>

        <div
          v-if="chatMessage.from === 'user'"
          class="mt-1 text-xs opacity-80"
          :class="colorClass"
        >
          <i
            v-if="chatMessage.status === 'delivered'"
            class="bi bi-check2-all"
          ></i>
          <i
            v-else
            class="bi bi-exclamation-circle"
          ></i>
        </div>
      </div>
    </div>
  </section>

  <!-- INPUT (FIXED BOTTOM) -->
  <section class="pt-4" :class="colorClass">
    <FormField
      v-model="message"
      type="textarea"
      placeholder="Správa"
      :max-length="maxLength"
      :variant="variant"
      autofocus
    />

    <Button
      text="odoslať správu"
      :variant="variant"
      @click="sendMessage"
    />
  </section>

</main>
</template>