import { useProjectStore } from "~/stores/useProjectStore";

export default defineNuxtRouteMiddleware(async(to, from) => {
    const project = useProjectStore();
	if (!project.isProject) {
		return navigateTo("/project", { replace: true });
	}
})