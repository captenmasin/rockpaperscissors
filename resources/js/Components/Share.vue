<script setup lang="ts">
import { ref } from 'vue'

const props = defineProps<{
    title?: String,
    url: String,
    description?: String
}>()

const share = async () => {
    const shareData = {
        title: props.title ?? document.title,
        text: props.description ?? 'Play:',
        url: props.url ?? window.location.href
    }

    if (navigator.share) {
        try {
            await navigator.share(shareData)
            console.log('Content shared successfully')
        } catch (err) {
            console.error('Error sharing:', err)
        }
    } else {
        copyToClipboard(props.url)
        alert('URL copied to clipboard!')
    }
}

const copyToClipboard = (text) => {
    const textArea = document.createElement('textarea')
    textArea.value = text
    document.body.appendChild(textArea)
    textArea.select()
    document.execCommand('copy')
    document.body.removeChild(textArea)
}
</script>
<template>
    <div>
        <button @click="share">
            Share
        </button>
    </div>
</template>
