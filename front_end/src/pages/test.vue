<script setup lang="ts">
const { data, error } = await useFetch('/api/tasks/', { server: false });
</script>

<template>
  <pre>{{  error  }}</pre>
  <pre>{{ data }}</pre>
</template>