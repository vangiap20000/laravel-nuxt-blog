import { joinURL } from 'ufo';
import { sendProxy } from "h3";

export const { format: formatNumber } = Intl.NumberFormat('en-GB', {
  notation: 'compact',
  maximumFractionDigits: 1,
});

export const typeTask = [
  {
    id: 1,
    name: 'Feature Request',
  },
  {
    id: 2,
    name: 'Design',
  },
  {
    id: 3,
    name: 'QA',
  },
  {
    id: 4,
    name: 'Backend',
  },
];

export const statusTask = {
  1: 'Backlog',
  2: 'In Progress',
  3: 'Review',
  4: 'Done',
  5: 'Reject',
};

export const requestApi = async (event: any) => {

  const proxyUrl = useRuntimeConfig().public.apiBase;

  const target = joinURL(proxyUrl, event.path);

  return await proxyRequest(event, target);
};

export const columnMaster = (data: any) => {
  const result = [];
  for (const [key, value] of Object.entries(data.value)) {
    result.push({ title: value.name, tasks: [] });
  }

  return result;
}