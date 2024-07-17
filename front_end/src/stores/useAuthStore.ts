import { defineStore } from "pinia";
import { useApiFetch } from "~/composables/useApiFetch";

type User = {
    id: number;
    name: string;
    email: string;
}

type Credentials = {
    email: string;
    password: string;
}

type RegistrationInfo = {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
}

type ResetPasswordInfo = {
    email: string
}

export const useAuthStore = defineStore('auth', () => {
    const user = ref<User | null>(null)
    const isLoggedIn = computed(() => !!user.value)

    async function logout() {
        const { status } = await useApiFetch("api/logout", { method: "POST" });
        if (status.value !== 'error') {
            user.value = null;
            navigateTo("/login");
        }
    }

    async function fetchUser() {
        const { data, error } = await useApiFetch("api/user");
        user.value = data.value as User;
    }

    async function login(credentials: Credentials) {
        await useApiFetch("sanctum/csrf-cookie");

        const login = await useApiFetch("api/login", {
            method: "POST",
            body: credentials,
        });

        return login;
    }

    async function register(info: RegistrationInfo) {
        await useApiFetch("sanctum/csrf-cookie");

        const register = await useApiFetch("api/register", {
            method: "POST",
            body: info,
        });

        return register;
    }

    async function resetPassword(info: ResetPasswordInfo) {
        await useApiFetch("sanctum/csrf-cookie");

        const register = await useApiFetch("api/reset-password", {
            method: "POST",
            body: info,
        });

        return register;
    }

    return { user, login, isLoggedIn, fetchUser, logout, register, resetPassword }
})