<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { useRoute } from '@/Composables/useRoute.ts'
</script>

<template>
    <div>
        <h1>Home</h1>

        <Link :href="useRoute('game.new')">
            New game
        </Link>
    </div>
</template>
