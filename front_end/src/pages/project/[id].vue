<template>
	<h2 class="py-8 px-4 text-3xl text-center lg:text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
		{{ project.project?.name }}
	</h2>
	<div class="flex justify-center">
		<div class="min-h-screen flex overflow-x-scroll py-12">
			<div v-for="column in columns" :key="column.title"
				class="bg-gray-100 rounded-lg px-3 py-3 column-width rounded mr-4">
				<div class="flex items-center flex-shrink-0 h-10 px-2">
					<p class="text-gray-700 font-semibold font-sans tracking-wide text-sm">
						{{ column.title }}
					</p>
					<span
						class="flex items-center justify-center w-5 h-5 ml-2 text-sm font-semibold text-indigo-500 bg-white rounded bg-opacity-30">
						{{ column.tasks.length }}
					</span>
					<button
						class="flex items-center justify-center w-6 h-6 ml-auto text-indigo-500 rounded hover:bg-indigo-500 hover:text-indigo-100"
						@click="openModal(column.title)">
						<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
						</svg>
					</button>
				</div>
				<draggable :list="column.tasks" :animation="200" class="min-h-52" ghost-class="ghost-card" group="tasks"
					@end="moveTask" :statusId="findStatusByName(status, column.title).id">
					<task-card v-for="(task) in column.tasks" :key="task.id" :task="task" class="mt-3 cursor-move"
						@deleteTask="deleteTask" @editTask="editTask" />
				</draggable>
			</div>
		</div>
	</div>
	<UModal v-model="isOpen" prevent-close>
		<UCard :ui="{ ring: '', divide: 'divide-y divide-gray-100 dark:divide-gray-800' }">
			<template #header>
				<div class="flex items-center justify-between">
					<h3 class="text-xl font-medium text-gray-900 dark:text-white">
						{{ idTaskEdit ? 'Edit task' : 'Create new task' }}
					</h3>
					<UButton color="gray" variant="ghost" icon="i-heroicons-x-mark-20-solid" class="-my-1"
						@click="isOpen = false" />
				</div>
			</template>

			<UForm :schema="RegisterValidationSchema" :state="formState" class="space-y-4" @submit="onSubmit">
				<UFormGroup label="Title" name="title" size="lg">
					<UInput v-model="formState.title" placeholder="Title" />
				</UFormGroup>

				<UFormGroup label="Type" name="type" size="lg">
					<USelectMenu v-model="formState.type" :options="typeTask" placeholder="Select type" value-attribute="id"
						option-attribute="name" />
				</UFormGroup>

				<UFormGroup label="Status" name="status" size="lg">
					<USelectMenu v-model="formState.status" :options="status" placeholder="Select status" value-attribute="id"
						option-attribute="name" />
				</UFormGroup>

				<UFormGroup label="Content" name="content" size="lg">
					<UTextarea v-model="formState.content" placeholder="Content" />
				</UFormGroup>

				<div class="flex">
					<UButton type="submit" size="lg" :loading="loading">
						Submit
					</UButton>
					<UButton color="white" variant="solid" size="lg" type="button" class="ml-2" @click="closeModal">
						Cancel
					</UButton>
				</div>
			</UForm>
		</UCard>
	</UModal>
</template>

<script setup lang="ts">
import { useProjectStore } from "../../stores/useProjectStore.js";
import { VueDraggableNext as draggable } from 'vue-draggable-next';
import { RegisterValidationSchema } from '../../schemas/AddEditTask';
import { useStore } from "../../stores/useStore";
const project = useProjectStore();

useHead({
	title: project.project?.name,
});

definePageMeta({
	middleware: ['auth', 'check-project']
});

const toast = useToast();
const isOpen = ref(false);
const columns = useState();
const { data: status, error } = await useApiFetch('api/tasks/status');
const formData = {
	title: "",
	type: "",
	status: "",
	content: "",
	id_task: "",
}
const formState = reactive({ ...formData });
const { setPending } = useStore();
const loading = ref(false);
const { params } = useRoute();
const idProject = params.id;

const openModal = (statusValue: string) => {
	const statusId = findStatusByName(status.value, statusValue);
	isOpen.value = true;
	resetForm();
	formState.status = statusId.id;
};

const closeModal = () => {
	isOpen.value = false;
	resetForm();
};

const editTask = async (task: any) => {
	isOpen.value = true;
	formState.status = task.status.id;
	formState.title = task.title;
	formState.type = task.type;
	formState.content = task.content;
	formState.id_task = task.id;
}

const resetForm = () => {
	Object.assign(formState, formData);
}

async function getColumns() {
	setPending(true);
	const { data: tasks, error } = await useApiFetch(`api/projects-task/${idProject}/`);

	if (!Object.keys(tasks.value).length) {
		columns.value = columnMaster(status);
		setPending(false);
		return;
	}

	const arrayTask = [];
	for (const [key, value] of Object.entries(status.value)) {
		const taskItem = tasks.value[value.id];
		arrayTask.push({ title: value.name, tasks: taskItem ?? [] });
	}
	columns.value = arrayTask;
	setPending(false);
}

async function onSubmit(event: FormSubmitEvent<Schema>) {
	loading.value = true;
	await useApiFetch("sanctum/csrf-cookie");
	let data = { ...event.data };
	delete data['id_task'];

	if (formState.id_task) {
		await update(data);
	} else {
		await store(data);
	}

	loading.value = false;
}

async function store(data: Object) {
	setPending(true);

	const { status } = await useApiFetch(`api/projects-task/${idProject}/`, {
		method: 'post',
		body: data,
	});

	if (status.value == 'success') {
		toast.add({
			title: 'Create new task success',
			icon: 'i-heroicons-check-badge'
		})
		closeModal();
		await getColumns();
	} else {
		toast.add({
			color: 'red',
			title: 'Create new task error',
			icon: 'i-heroicons-exclamation-triangle'
		});

		setPending(false);
	}
}

async function update(data: Object) {
	setPending(true);

	const { status } = await useApiFetch(`api/projects-task/${idProject}/${formState.id_task}`, {
		method: 'put',
		body: data,
	})

	if (status.value == 'success') {
		toast.add({
			title: 'Update task success',
			icon: 'i-heroicons-check-badge'
		})
		closeModal();
		await getColumns();
	} else {
		toast.add({
			color: 'red',
			title: 'Update task error',
			icon: 'i-heroicons-exclamation-triangle'
		});

		setPending(false);
	}
}

async function deleteTask(id: number) {
	await useApiFetch("sanctum/csrf-cookie");
	const { status } = await useApiFetch(`api/projects-task/${idProject}/${id}`, {
		method: 'delete',
	});

	if (status.value == 'success') {
		toast.add({
			title: 'Delete task success',
			icon: 'i-heroicons-check-badge'
		})
		await getColumns();
	} else {
		toast.add({
			color: 'red',
			title: 'Delete task error',
			icon: 'i-heroicons-exclamation-triangle'
		});
	}
}

async function moveTask(evt: any) {
	await useApiFetch("sanctum/csrf-cookie");

	const data = {
		id: evt.item.getAttribute('idTask'),
		from_status: evt.from.getAttribute('statusId'),
		to_status: evt.to.getAttribute('statusId'),
		new_order: evt.newIndex + 1,
		old_order: evt.oldIndex + 1
	}

	const { status } = await useApiFetch(`api/projects-task/${idProject}/move`, {
		method: 'post',
		body: data
	});

	if (status.value == 'success') {
		await getColumns();
	} else {
		toast.add({
			color: 'red',
			title: 'Move task fail!',
			icon: 'i-heroicons-exclamation-triangle'
		});
	}
}

onMounted(() => {
	setTimeout(async () => {
		await getColumns();
	}, 500);
});

onUnmounted(() => {
	columns.value = [];
})
</script>

<style lang="css" scoped>
.column-width {
	min-width: 320px;
	width: 320px;
}

/* Unfortunately @apply cannot be setup in codesandbox,
  but you'd use "@apply border opacity-50 border-blue-500 bg-gray-200" here */
.ghost-card {
	opacity: 0.5;
	background: #F7FAFC;
	border: 1px solid #4299e1;
}
</style>