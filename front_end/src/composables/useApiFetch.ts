import type { UseFetchOptions } from 'nuxt/app'
import { useRequestHeaders } from "nuxt/app";

export function useApiFetch<T>(path: string, options: UseFetchOptions<T> = {}) {
	let headers: any = {
		Accept: 'application/json',
		referer: process.env.URL_FRONTEND || "http://localhost:3000",
	}

	const token = useCookie('XSRF-TOKEN');

	if (token.value) {
		headers['X-XSRF-TOKEN'] = token.value as string;
	}

	if (process.server) {
		headers = {
			...headers,
			...useRequestHeaders(["cookie"]),
		}
	}

	return useFetch(useRuntimeConfig().public.apiBase + path, {
		credentials: "include",
		watch: false,
		...options,
		headers: {
			...headers,
			...options?.headers
		}
	});
}