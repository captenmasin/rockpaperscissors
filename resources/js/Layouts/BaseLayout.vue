<script setup lang="ts">
import Navbar from '@/Components/Navbar.vue'
import InertiaSeoHead from '../../../vendor/captenmasin/inertia-seo/resources/js/InertiaSeoHead.vue'
</script>

<template>
    <div>
        <InertiaSeoHead />
        <Navbar />
        <slot />
    </div>
</template>
