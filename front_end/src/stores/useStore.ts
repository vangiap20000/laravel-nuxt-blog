import { defineStore } from "pinia";


export const useStore = defineStore('base', () => {
	const isPending = ref(false);

	async function setPending(value :boolean) {
		isPending.value = value
	}

	return { isPending, setPending }
});