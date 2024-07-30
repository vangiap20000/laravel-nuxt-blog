<template>
  <div class="flex items-center flex-shrink-0 w-full h-16 px-10 bg-white bg-opacity-75">
    <NuxtLink to="/">
      <img class="w-8 h-8 text-indigo-600 stroke-current" src="~/assets/images/kanban-board-svgrepo-com.svg" alt="">
    </NuxtLink>
    <!-- <input class="flex items-center h-10 px-4 ml-10 text-sm bg-gray-200 rounded-full focus:outline-none focus:ring"
      type="search" placeholder="Search for anything…"> -->
    <div class="ml-10">
      <NuxtLink to="/task" class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700"
        activeClass="text-indigo-700">
        My board
      </NuxtLink>
      <NuxtLink to="/project" class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700"
        activeClass="text-indigo-700">
        Projects board
      </NuxtLink>
      <!-- <a class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700" href="#">Activity</a> -->
    </div>
    <UDropdown v-if="user" :items="items" :ui="{ item: { disabled: 'cursor-text select-text' } }" class="ml-auto"
      :popper="{ placement: 'bottom-start' }">
      <UAvatar :src="`https://avatars.githubusercontent.com/${user.id}?v=4`" />

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
const items = ref();

onMounted(() => {
  if (props.user) {
    items.value = [
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
  }
});
</script>