<script setup lang="ts">
import { useAuthStore } from "~/stores/useAuthStore";

const auth = useAuthStore();
async function test() {
  await useApiFetch("sanctum/csrf-cookie");
	const token = useCookie('XSRF-TOKEN');
	const headers: any = {
		Accept: 'application/json',
		'X-XSRF-TOKEN': token.value,
	}

	const { data, status, error } = await useFetch('/api/test', {
    method: 'post',
    headers,
  });
  // console.log(data, error)
  if (status.value == 'success') {
    await auth.fetchUser();
    await navigateTo('/');
  }
}

definePageMeta({
	layout: 'auth',
});
</script>

<template>
  <div>
    <UButton color="emerald" variant="solid" @click="test">
			Test
		</UButton>
  </div>
</template>