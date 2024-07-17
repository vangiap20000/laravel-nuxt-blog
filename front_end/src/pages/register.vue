<template>
	<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
		<a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
			<img class="w-20" src="/logo.png" alt="logo">
		</a>
		<div
			class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
			<div class="p-6 space-y-4 md:space-y-6 sm:p-8">
				<h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
					Create an account
				</h1>
				<UForm :schema="RegisterValidationSchema" :state="formState" class="space-y-4 md:space-y-6"
					@submit="onSubmit">
					<UFormGroup label="Name" name="name" required>
						<UInput v-model="formState.name" placeholder="your name" size="lg" />
					</UFormGroup>

					<UFormGroup label="Email" name="email" required>
						<UInput v-model="formState.email" placeholder="name@company.com" size="lg" />
					</UFormGroup>

					<UFormGroup label="Password" name="password" required>
						<UInput v-model="formState.password" type="password" size="lg" placeholder="••••••••" />
					</UFormGroup>

					<UFormGroup label="Confirm password" name="password_confirmation" required>
						<UInput v-model="formState.password_confirmation" type="password" size="lg"
							placeholder="••••••••" />
					</UFormGroup>

					<div class="flex items-start">
						<UCheckbox v-model="formState.confirm" />
						<div class="ml-3 text-sm">
							<label for="terms" class="font-light text-gray-500 dark:text-gray-300">I accept the <a
									class="font-medium text-primary-600 hover:underline dark:text-primary-500" href="#">
									Terms and Conditions</a></label>
						</div>
					</div>

					<UButton type="submit" size="lg" color="emerald" variant="solid" block
						:disabled="!formState.confirm" :loading="loading">
						Create an account
					</UButton>

					<p class="text-sm font-light text-gray-500 dark:text-gray-400">
						Already have an account?
						<NuxtLink to="/login"
							class="font-medium text-primary-600 hover:underline dark:text-primary-500">
							Login here
						</NuxtLink>
					</p>
				</UForm>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
import { RegisterValidationSchema } from "../schemas/Register";
import { useAuthStore } from "~/stores/useAuthStore";

definePageMeta({
	layout: 'auth',
	middleware: ['guest']
});

useHead({
	title: 'Register',
})

const formData = {
	name: "",
	email: "",
	password: "",
	password_confirmation: "",
	confirm: false,
}
const formState = reactive({ ...formData });
const loading = ref(false);
const toast = useToast();
const auth = useAuthStore();

async function onSubmit(event: FormSubmitEvent<Schema>) {
	if (loading.value == true) return;
	loading.value = true;
	const { data } = event;

	const { error } = await auth.register(data);

	if (error.value) {
		const messageError = error.value.data.message;
		toast.add({
			color: 'red',
			title: messageError,
			icon: 'i-heroicons-exclamation-triangle'
		});
	} else {
		await auth.login({
			email: data.email,
			password: data.password
		});
		await auth.fetchUser();
		await navigateTo('/');
	}

	loading.value = false;
}
</script>