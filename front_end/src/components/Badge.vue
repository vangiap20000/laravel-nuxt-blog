<template>
  <UBadge
    :ui="{ rounded: 'rounded-full' }"
    :color="color"
    variant="subtle"
  >
    <span
      class="w-2 h-2 rounded-full mr-1"
      :class="`bg-${color}-500 bg-${color}-600`"
    />
    <span>
      <slot />
    </span>
  </UBadge>
</template>

<script setup lang="ts">
const props = defineProps({
  color: {
    type: String,
    default: 'teal',
  },
});
</script>
