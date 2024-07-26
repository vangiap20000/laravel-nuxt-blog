<template>
	<div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
		<div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
			<h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
				List your projects
			</h2>
			<UButton icon="i-heroicons-plus-circle" size="lg" color="fuchsia" variant="solid" label="Create project"
				@click="openModal" />
		</div>
		<div class="grid gap-8 lg:grid-cols-2">
			<article-project v-for="(project, index) in projects" :key="index" :project="project"
				@deleteProject="deleteProject" @editProject="editProject" />
		</div>
		<UModal v-model="isOpen" prevent-close>
			<UCard :ui="{ ring: '', divide: 'divide-y divide-gray-100 dark:divide-gray-800' }">
				<template #header>
					<div class="flex items-center justify-between">
						<h3 class="text-xl font-medium text-gray-900 dark:text-white">
							{{ formState.project_id ? 'Edit project' : 'Create new project' }}
						</h3>
						<UButton color="gray" variant="ghost" icon="i-heroicons-x-mark-20-solid" class="-my-1"
							@click="isOpen = false" />
					</div>
				</template>
				<UForm class="space-y-4" :schema="RegisterValidationSchema" :state="formState" @submit="onSubmit">
					<UFormGroup label="Name project" name="name" size="lg" required>
						<UInput v-model="formState.name" placeholder="Name project" />
					</UFormGroup>

					<UFormGroup label="Description project" name="about" size="lg" required>
						<UTextarea v-model="formState.about" placeholder="Description project" />
					</UFormGroup>

					<UFormGroup label="Select member" name="users" required size="lg">
						<USelectMenu v-model="formState.users" :options="users" multiple searchable value-attribute="id"
							option-attribute="name">
							<template #label>
								<span v-if="formState.users.length" class="truncate">{{ getUserName(formState.users)
									}}</span>
								<span v-else>Select member</span>
							</template>
						</USelectMenu>
					</UFormGroup>

					<div class="gap-2 flex">
						<UButton type="submit" label="Submit" size="lg" :loading="loading" />
						<UButton color="white" variant="solid" size="lg" @click="closeModal">Cancel</UButton>
					</div>
				</UForm>
			</UCard>
		</UModal>
	</div>
</template>
<script setup lang="ts">
import { RegisterValidationSchema } from '../../schemas/AddEditProject';
import { useStore } from "../../stores/useStore";
import { useAuthStore } from "~/stores/useAuthStore";

useHead({
	title: 'List projects',
});

definePageMeta({
	middleware: ['auth']
});

const auth = useAuthStore();
const toast = useToast();
const isOpen = ref(false);
const loading = ref(false);
const { data: users } = await useApiFetch('api/users');
const { setPending } = useStore();
const projects = useState();

const formData = {
	name: "",
	about: "",
	users: [],
	project_id: null,
}
const formState = reactive({ ...formData });

const getUserName = (userId: any) => {
	let name: any = [];
	userId.forEach((id: number) => {
		const finUser = users.value.find((user: any) => user.id === id);
		name.push(finUser.name);
	});

	return name.join(', ');
}

const resetForm = () => {
	Object.assign(formState, formData);
}

const openModal = () => {
	isOpen.value = true;
	resetForm();
}

const closeModal = () => {
	isOpen.value = false;
	resetForm();
}

const editProject = (project: any) => {
	formState.name = project.name;
	formState.about = project.about;
	formState.users = getUserSelect(project.users);
	formState.project_id = project.id;
	isOpen.value = true;
}

const getUserSelect = (users: Object) => {
	let userArray = [];
	for (const [key, value] of Object.entries(users)) {
		let userId = value.pivot.user_id;
		if (userId === auth.user.id) {
			continue;
		}
		userArray.push(userId);
	}

	return userArray;
}

async function getProjects() {
	setPending(true);

	const { data } = useApiFetch('api/projects');
	projects.value = data;

	setPending(false);
}

async function onSubmit(event: FormSubmitEvent<Schema>) {
	loading.value = true;
	await useApiFetch("sanctum/csrf-cookie");
	let data = { ...event.data };
	delete data['project_id'];
	
	if (formState.project_id) {
		await update(data);
	} else {
		await store(data);
	}

	loading.value = false;
}

async function store(data: Object) {
	const { status } = await useApiFetch('api/projects', {
		method: 'post',
		body: data,
	});

	if (status.value == 'success') {
		toast.add({
			title: 'Create new project success',
			icon: 'i-heroicons-check-badge'
		})
		closeModal();
		getProjects();
	} else {
		toast.add({
			color: 'red',
			title: 'Create new project error',
			icon: 'i-heroicons-exclamation-triangle'
		});
	}
}

async function update(data: Object) {
	const { status } = await useApiFetch(`api/projects/${formState.project_id}`, {
		method: 'put',
		body: data,
	});

	if (status.value == 'success') {
		toast.add({
			title: 'Update project success',
			icon: 'i-heroicons-check-badge'
		})
		closeModal();
		getProjects();
	} else {
		toast.add({
			color: 'red',
			title: 'Update project error',
			icon: 'i-heroicons-exclamation-triangle'
		});
	}
}


async function deleteProject(id: number) {
	await useApiFetch("sanctum/csrf-cookie");

	const { status } = await useApiFetch(`api/projects/${id}`, {
		method: 'delete',
		server: false,
	});

	if (status.value == 'success') {
		toast.add({
			title: 'Delete project success',
			icon: 'i-heroicons-check-badge'
		})
		await getProjects();
	} else {
		toast.add({
			color: 'red',
			title: 'Delete project error',
			icon: 'i-heroicons-exclamation-triangle'
		});
	}
}


onMounted(() => {
	setTimeout(async () => {
		await getProjects();
	}, 500);
});
</script>