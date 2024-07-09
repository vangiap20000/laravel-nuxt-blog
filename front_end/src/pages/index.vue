<template>
	<div id="app">
		<div class="flex justify-center">
			<div class="min-h-screen flex overflow-x-scroll py-12">
				<div v-if="pending" class="fixed w-full h-full bg-[#ffffff]/50 top-0 left-0 z-[60]">
					<div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
						<svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-600"
							viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
								fill="currentColor" />
							<path
								d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
								fill="currentFill" />
						</svg>
					</div>
				</div>
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
					<draggable :list="column.tasks" :animation="200" ghost-class="ghost-card" group="tasks" @change="onMoveCallback">
						<task-card v-for="(task) in column.tasks" :key="task.id" :task="task" class="mt-3 cursor-move"
							@deleteTask="deleteTask" @editTask="editTask" />
					</draggable>
				</div>
			</div>
		</div>
		<UModal v-model="isOpen">
			<UCard :ui="{ ring: '', divide: 'divide-y divide-gray-100 dark:divide-gray-800' }">
				<template #header>
					<h3 class="text-xl font-semibold text-gray-900 dark:text-white">
						{{ idTaskEdit ? 'Edit task' : 'Create new task' }}
					</h3>
				</template>

				<UForm :schema="RegisterValidationSchema" :state="formState" class="space-y-4"
					@submit="(event: any) => idTaskEdit ? onSubmitEdit(event) : onSubmit(event)">
					<UFormGroup label="Title" name="title">
						<UInput v-model="formState.title" placeholder="Title" />
					</UFormGroup>

					<UFormGroup label="Type" name="type">
						<USelectMenu v-model="formState.type" :options="typeTask" placeholder="Select type" value-attribute="id"
							option-attribute="name" />
					</UFormGroup>

					<UFormGroup label="Status" name="status">
						<USelectMenu v-model="formState.status" :options="status" placeholder="Select status" value-attribute="id"
							option-attribute="name" />
					</UFormGroup>

					<UFormGroup label="Content" name="content">
						<UTextarea v-model="formState.content" placeholder="Content" />
					</UFormGroup>

					<div>
						<UButton type="submit" size="md" :disabled="pending">
							Submit
						</UButton>
						<UButton color="white" variant="solid" size="md" type="button" class="ml-2" @click="closeModal">
							Cancel
						</UButton>
					</div>
				</UForm>
			</UCard>
		</UModal>
	</div>
</template>

<script setup lang="ts">
import { VueDraggableNext as draggable} from 'vue-draggable-next';
import { RegisterValidationSchema } from '../schemas/AddEditTask';

const toast = useToast();
const isOpen = ref(false);
const pending = ref(false);
const idTaskEdit = ref(null);
const columns = useState();
const { data: status, error } = await useFetch('/api/tasks/status', { server: false });

const formState = reactive({
	title: undefined,
	type: undefined,
	status: undefined,
	content: undefined,
});

const openModal = (statusValue: number) => {
	const statusId = status.value.find((element: any) => element.name == statusValue);
	isOpen.value = true;
	formState.status = statusId.id;
	formState.title = undefined;
	formState.type = undefined;
	formState.content = undefined;
	idTaskEdit.value = null;
};

const closeModal = () => {
	isOpen.value = false;
};

const editTask = async (task: any) => {
	isOpen.value = true;
	formState.status = task.status.id;
	formState.title = task.title;
	formState.type = task.type;
	formState.content = task.content;
	idTaskEdit.value = task.id;
}

async function getColumns() {
	pending.value = true;
	const { data: tasks, error } = await useFetch('/api/tasks/', { server: false });

	if (!Object.keys(tasks.value).length) {
		columns.value = columnMaster(status);
		pending.value = false;
		return;
	}

	const arrayTask = [];
	for (const [key, value] of Object.entries(status.value)) {
		const taskItem = tasks.value[value.id];
		arrayTask.push({ title: value.name, tasks: taskItem ?? [] });
	}
	columns.value = arrayTask;
	pending.value = false;
}

async function onSubmit(event: FormSubmitEvent<Schema>) {
	pending.value = true;
	closeModal();

	const { data: responseData, status } = await useFetch('/api/tasks/', {
		method: 'post',
		body: event.data,
		server: false
	})

	if (status.value == 'success') {
		toast.add({
			title: 'Create new task success',
			icon: 'i-heroicons-check-badge'
		})
		await getColumns();
	} else {
		toast.add({
			color: 'red',
			title: 'Create new task error',
			icon: 'i-heroicons-exclamation-triangle'
		})
	}
}

async function onSubmitEdit(event: FormSubmitEvent<Schema>) {
	pending.value = true;
	closeModal();
	const { data: responseData, status } = await useFetch(`/api/tasks/${idTaskEdit.value}`, {
		method: 'put',
		body: event.data,
		server: false
	})

	if (status.value == 'success') {
		toast.add({
			title: 'Update task success',
			icon: 'i-heroicons-check-badge'
		})
		await getColumns();
	} else {
		toast.add({
			color: 'red',
			title: 'Update task error',
			icon: 'i-heroicons-exclamation-triangle'
		})
	}
}

async function deleteTask(id: number) {
	const { data: responseData, status, error } = await useFetch(`/api/tasks/${id}`, {
		method: 'delete',
		server: false
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
		})
	}
}

async function onMoveCallback(event :any) {
	console.log(event.moved)
}

async function cloneAction(item :any) {
  console.log("cloned", item);
}

onMounted(() => {
	setTimeout(async () => {
		await getColumns();
	}, 500);
});
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