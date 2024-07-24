<template>
    <h1>hello</h1>
</template>

<script setup lang="ts">
import { useProjectStore } from "../../stores/useProjectStore.js";
useHead({
    title: 'List projects',
});

definePageMeta({
    middleware: ['auth', 'check-project']
});

const project = useProjectStore();

await project.fetchProject();
</script>