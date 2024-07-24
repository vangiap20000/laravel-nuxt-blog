import { defineStore } from "pinia";
import { useApiFetch } from "~/composables/useApiFetch";

type Project = {
    id: number;
    name: string;
}

export const useProjectStore = defineStore('project', () => {
    const project = ref<Project | null>(null)
    const isProject = computed(() => !!project.value)

    async function fetchProject() {
        const { params } = useRoute();
        const { data, status } = await useApiFetch(`api/projects/${params.id}`);
        if (status.value == 'success') {
            project.value = data.value as Project;
        }
    }

    return { project, isProject, fetchProject }
})