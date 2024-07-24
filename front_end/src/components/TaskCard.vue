<template>
	<div class="bg-white shadow rounded px-3 pt-3 pb-5 border border-white" :idTask="task.id">
		<div class="relative  cursor-pointer bg-opacity-90 group hover:bg-opacity-100" @mouseover="hoverOver"
			@mouseout="hoverOut">
			<div class="flex justify-between relative">
				<p class="text-gray-700 font-semibold font-sans tracking-wide text-sm mr-[30px]">
					{{ task.title }}
				</p>

				<img v-if="active && task.user_id" class="w-6 h-6 rounded-full ml-3" :src="`https://avatars.githubusercontent.com/${task.user_id}?v=4`"
					alt="Avatar">

				<img v-else-if="active" class="w-6 h-6 rounded-full ml-3" src="https://avatar.iran.liara.run/public/job/farmer/female"
					alt="Avatar">

				<div class="absolute top-0 right-0  flex items-center justify-center hidden w-5 h-5 group-hover:flex">
					<UDropdown :items="[
			[
				{
					label: 'Edit',
					icon: 'i-heroicons-pencil-square-20-solid',
					click: () => edit(task),
				},
				{
					label: 'Delete',
					icon: 'i-heroicons-trash-20-solid',
					click: () => confirmDelete(),
				},
			],
		]
			" :popper="{ placement: 'bottom-start' }">
						<button class="text-gray-500 hover:bg-gray-200 hover:text-gray-700 rounded">
							<svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
								fill="currentColor">
								<path
									d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
							</svg>
						</button>
					</UDropdown>
				</div>
			</div>
			<p class="text-sm text-gray-700 dark:text-gray-400 mt-2"> {{ task.content }}</p>
		</div>
		<div class="flex mt-4 justify-between items-center">
			<div class="text-sm text-gray-600">
				<span>{{ task.date }}</span>
				<p v-if="task.user_id" class="font-semibold italic">
					{{ task.user.email }}
				</p>
			</div>
			<Badge v-if="task.type" :color="badgeColor">
				{{ getTypeTask(task.type) }}
			</Badge>
		</div>
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
						Are you sure you want to delete this task?</h3>
					<button type="button"
						@click="deleteTask(task.id)"
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
	</div>
</template>

<script setup lang="ts">
const props = defineProps({
	task: {
		type: Object,
		default: () => ({}),
	},
});

const active = ref(true);
const isOpen = ref(false);
const emit = defineEmits(['deleteTask', 'editTask']);

const getTypeTask = (type: number) => {
	return typeTask.filter(item => item.id === type)[0].name;
};

const badgeColor = computed(() => {
	const mappings = {
		'Very High': 'red',
		'High': 'orange',
		'Medium': 'teal',
		'Low': 'green',
		'default': 'green',
	};

	return mappings[getTypeTask(props.task.type)] || mappings.default;
});

const hoverOver = () => {
	active.value = false;
};

const hoverOut = () => {
	active.value = true;
};

const edit = (task: Object) => {
	emit('editTask', task);
};

const deleteTask = (id: number) => {
	emit('deleteTask', id);
	isOpen.value = false;
}

const confirmDelete = () => {
	isOpen.value = true;
};
</script>
