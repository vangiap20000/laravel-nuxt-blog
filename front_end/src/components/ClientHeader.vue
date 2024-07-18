<template>
  <div class="flex items-center flex-shrink-0 w-full h-16 px-10 bg-white bg-opacity-75">
    <svg class="w-8 h-8 text-indigo-600 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none"
      viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
    </svg>
    <!-- <input class="flex items-center h-10 px-4 ml-10 text-sm bg-gray-200 rounded-full focus:outline-none focus:ring"
      type="search" placeholder="Search for anything…"> -->
    <div class="ml-10">
      <NuxtLink to="/" class="mx-2 text-sm font-semibold text-indigo-700">
        My board
      </NuxtLink>
      <NuxtLink to="/test" class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700">
        Projects board
      </NuxtLink>
      <a class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700" href="#">Activity</a>
    </div>
    <UDropdown :items="items" :ui="{ item: { disabled: 'cursor-text select-text' } }" class="ml-auto"
      :popper="{ placement: 'bottom-start' }">
      <UAvatar :src="`https://avatars.githubusercontent.com/${idImage}?v=4`" />

      <template #account="{ item }">
        <div class="text-left">
          <p>
            Signed in as
          </p>
          <p class="truncate font-medium text-gray-900 dark:text-white">
            {{ item.label }}
          </p>
        </div>
      </template>

      <template #item="{ item }">
        <span class="truncate">{{ item.label }}</span>

        <UIcon :name="item.icon" class="flex-shrink-0 h-4 w-4 text-gray-400 dark:text-gray-500 ms-auto" />
      </template>
    </UDropdown>
  </div>
</template>
<script setup lang="ts">
const props = defineProps({
  user: {
    type: Object,
    default: () => ({}),
  },
});
const emit = defineEmits(['confirm']);
const idImage = ref(1);

const items = [
  [{
    label: props.user.email,
    slot: 'account',
    disabled: true
  }],
  [{
    label: 'Sign out',
    icon: 'i-heroicons-arrow-left-on-rectangle',
    click: () => {
      emit('confirm');
    }
  }]
];

onMounted(() => {
  if (props.user) {
    idImage.value = props.user.id
  }
});

</script>