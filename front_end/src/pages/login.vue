<template>
	<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
		<a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
			<img class="w-20" src="/logo.png" alt="logo">
		</a>
		<div
			class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
			<div class="p-6 space-y-4 md:space-y-6 sm:p-8">
				<h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
					Sign in to your account
				</h1>
				<UForm :schema="RegisterValidationSchema" :state="formState" class="space-y-4 md:space-y-6" @submit="onSubmit">
					<UFormGroup label="Your email" name="email" required>
						<UInput v-model="formState.email" placeholder="name@company.com" size="lg" />
					</UFormGroup>

					<UFormGroup label="Password" name="password" required>
						<UInput v-model="formState.password" type="password" size="lg" placeholder="••••••••" />
					</UFormGroup>

					<div class="flex items-center justify-end">
						<NuxtLink to="/forgot" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">
							Forgot password?
						</NuxtLink>
					</div>

					<UButton type="submit" size="lg" color="emerald" variant="solid" block :loading="loading">
						Sign in
					</UButton>

					<p class="text-sm font-light text-gray-500 dark:text-gray-400">
						Don’t have an account yet? 
						<NuxtLink to="/register" class="font-medium text-primary-600 hover:underline dark:text-primary-500">
							Sign up
						</NuxtLink>
					</p>
				</UForm>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
import { RegisterValidationSchema } from "../schemas/Login";
import { useAuthStore } from "~/stores/useAuthStore";

definePageMeta({
	layout: 'auth',
	middleware: ['guest']
});

useHead({
	title: 'Login',
})

const formData = {
	email: "",
	password: "",
}

const formState = reactive({ ...formData });
const loading = ref(false);
const toast = useToast();
const auth = useAuthStore();

async function onSubmit(event: FormSubmitEvent<Schema>) {
	if (loading.value == true) return;
	loading.value = true;

	const { status, error } = await auth.login(event.data);

	if (status.value == 'error') {
		toast.add({
			color: 'red',
			title: 'Login fail! Email or password incorrect',
			icon: 'i-heroicons-exclamation-triangle'
		});
	} else {

		await auth.fetchUser();
		await navigateTo('/task');
	}

	loading.value = false;
}
</script>