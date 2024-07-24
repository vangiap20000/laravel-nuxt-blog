import { useProjectStore } from "../stores/useProjectStore.js";

export default defineNuxtPlugin(async (nuxtApp) => {
    const { name }= useRoute();
    if (name === 'project-id') {
        await loadProject();
    }

    return {
        provide: {
            loadProject: async(id: Number) => {
                await loadProject(id);
            }
        }
    }
});

const loadProject = async(id?: Number|null) => {
    const project = useProjectStore();
    await project.fetchProject(id);
} 