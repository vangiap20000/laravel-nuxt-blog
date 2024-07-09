import { joinURL } from 'ufo';

export default defineEventHandler(async (event) => {
  const proxyUrl = useRuntimeConfig().public.apiBase;
  const target = joinURL(proxyUrl, event.path);
  return target;
});
