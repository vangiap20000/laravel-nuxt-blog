<template>
	<section class="bg-gray-50 dark:bg-gray-900">
		<slot />
		<UNotifications   :ui ="{position: 'top-0 bottom-auto'}" />
	</section>
</template>