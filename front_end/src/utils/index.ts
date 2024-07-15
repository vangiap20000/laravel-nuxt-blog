import { joinURL } from 'ufo';

export const { format: formatNumber } = Intl.NumberFormat('en-GB', {
  notation: 'compact',
  maximumFractionDigits: 1,
});

export const typeTask = [
  {
    id: 1,
    name: 'Low',
  },
  {
    id: 2,
    name: 'Medium',
  },
  {
    id: 3,
    name: 'High',
  },
  {
    id: 4,
    name: 'Very High',
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

export const findStatusByName = (status :object | any, name: string) => {
  return status.find((element: any) => element.name == name);
}