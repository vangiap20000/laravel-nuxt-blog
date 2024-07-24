<template>
	<article class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
		<div class="flex justify-between items-center mb-5 text-gray-500">
			<span v-if="project.days_since_created" class="text-sm">{{ project.days_since_created }} days ago</span>
			<span v-else class="text-sm">Today</span>
			<UDropdown :items="[
				[
					{
						label: 'Edit',
						icon: 'i-heroicons-pencil-square-20-solid',
						click: () => edit(project),
					},
					{
						label: 'Delete',
						icon: 'i-heroicons-trash-20-solid',
						click: () => isOpen = true,
					},
				],
			]
				" :popper="{ placement: 'bottom-start' }">
				<button
					class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
					<img class="mr-1 w-3 h-3" src="~/assets/images/setting.svg" alt="icon">
					Actions
				</button>
			</UDropdown>
		</div>
		<h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
			{{ project.name }}
		</h2>
		<p class="mb-5 font-light text-gray-500 dark:text-gray-400">
			{{ project.about }}
		</p>
		<div class="flex justify-between items-center">
			<div class="flex -space-x-4 rtl:space-x-reverse">
				<img v-for="(user) in project.users.slice(0, 3)" :key="user.id"
					class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
					:src="`https://avatars.githubusercontent.com/${user.pivot.user_id}?v=4`" alt="">
				<a v-if="project.users.length > 3"
					class="flex items-center justify-center w-10 h-10 text-xs font-medium text-white bg-gray-700 border-2 border-white rounded-full hover:bg-gray-600 dark:border-gray-800"
					href="#">
					+{{ project.users.length - 3 }}
				</a>
			</div>
			<NuxtLink :to="`project/${project.id}`" class="inline-flex items-center font-medium text-primary-600 dark:text-primary-500 hover:underline">
				See details
				<svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd"
						d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
						clip-rule="evenodd"></path>
				</svg>
			</NuxtLink>
		</div>
	</article>
	<UModal v-model="isOpen" :overlay="false">
		<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
			<button type="button"
				class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
				@click="isOpen = false">
				<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
				</svg>
				<span class="sr-only">Close modal</span>
			</button>
			<div class="p-4 md:p-5 text-center">
				<svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
					xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
				</svg>
				<h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
					Are you sure you want to delete this project?</h3>
				<button type="button" @click="deleteProject(project.id)"
					class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
					Yes, I'm sure
				</button>
				<button @click="isOpen = false"
					class="px-3 py-2 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
					No, cancel
				</button>
			</div>
		</div>
	</UModal>
</template>

<script setup lang="ts">
const props = defineProps({
	project: {
		type: Object,
		default: {},
	},
});

const isOpen = ref(false);
const emit = defineEmits(['deleteProject', 'editProject']);

const edit = (project: Object) => {
	emit('editProject', project);
}

const deleteProject = (id: number) => {
	emit('deleteProject', id);
	isOpen.value = false;
}
</script>