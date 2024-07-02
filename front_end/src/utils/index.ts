export const { format: formatNumber } = Intl.NumberFormat('en-GB', {
  notation: 'compact',
  maximumFractionDigits: 1,
});


export const typeTask = {
  1: 'Feature Request',
  2: 'Design',
  3: 'QA',
  4: 'Backend'
}

export const statusTask = {
  1: 'Backlog',
  2: 'In Progress',
  3: 'Review',
  4: 'Done'
}