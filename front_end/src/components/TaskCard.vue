<template>
	<div class="bg-white shadow rounded px-3 pt-3 pb-5 border border-white">
		<div @mouseover="hoverOver" @mouseout="hoverOut"
			class="relative flex justify-between relative cursor-pointer bg-opacity-90 group hover:bg-opacity-100">
			<p class="text-gray-700 font-semibold font-sans tracking-wide text-sm mr-[30px]">{{ task.title }}</p>

			<img v-if="active" class="w-6 h-6 rounded-full ml-3" src="https://randomuser.me/api/portraits/women/48.jpg"
				alt="Avatar">

			<div class="absolute top-0 right-0  flex items-center justify-center hidden w-5 h-5 group-hover:flex">
				<UDropdown :items="[
					[
						{
							label: 'Edit',
							icon: 'i-heroicons-pencil-square-20-solid',
							click: () => edit(task.id)
						},
						{
							label: 'Delete',
							icon: 'i-heroicons-trash-20-solid',
							click: () => deleteTask(task.id)
						}
					]
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
		<div class="flex mt-4 justify-between items-center">
			<span class="text-sm text-gray-600">{{ task.date }}</span>
			<Badge v-if="task.type" :color="badgeColor">{{ typeTask[task.type] }}</Badge>
		</div>
	</div>
</template>
<script setup lang="ts">
const props = defineProps({
	task: {
		type: Object,
		default: () => ({})
	}
})

const active = ref(true)

const badgeColor = computed(() => {
	const mappings = {
		Design: "red",
		"Feature Request": "teal",
		Backend: "orange",
		QA: "green",
		default: "orange"
	};
	return mappings[typeTask[props.task.type]] || mappings.default;
})

const hoverOver = () => {
	active.value = false;
}

const hoverOut = () => {
	active.value = true;
}

const edit = (id) => {

}

const deleteTask = (id) => {

}
</script>