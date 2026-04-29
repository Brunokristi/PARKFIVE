import { ref } from 'vue'

const toastVisible = ref(false)
const toastHeading = ref('')
const toastText = ref('')

export function useToast() {
    function show(heading: string, text: string) {
        toastHeading.value = heading
        toastText.value = text
        toastVisible.value = true
    }

    function hide() {
        toastVisible.value = false
    }

    return {
        toastVisible,
        toastHeading,
        toastText,
        show,
        hide,
    }
}

export default useToast
