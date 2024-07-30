<template>
	<section id="pricing" class="bg-gray-100 py-8 item-header" data-ref="pricing-header">
		<div class="container mx-auto px-2 pt-4 pb-12 text-gray-800">
			<h1 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
				Pricing
			</h1>
			<div class="w-full mb-4">
				<div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
			</div>
			<div class="flex flex-col sm:flex-row justify-center pt-12 my-12 sm:my-4">
				<div v-for="item in items" :class="item.active 
						? 'flex flex-col w-5/6 lg:w-1/3 mx-auto lg:mx-0 rounded-lg bg-white mt-4 sm:-mt-6 shadow-lg z-10'
						: 'flex flex-col w-5/6 lg:w-1/4 mx-auto lg:mx-0 rounded-none lg:rounded-l-lg bg-white mt-4'
					">
					<div class="flex-1 bg-white text-gray-600 rounded-t rounded-b-none overflow-hidden shadow">
						<div class="p-8 text-3xl font-bold text-center" :class="item.active ? '' : 'border-b-4'">
							{{ item.title }}
						</div>
						<div v-if="item.active" class="h-1 w-full gradient my-0 py-0 rounded-t"></div>
						<ul class="w-full text-center text-sm">
							<li v-for="thing in item.content" class="border-b py-4">{{ thing }}</li>
						</ul>
					</div>
					<div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
						<div class="w-full pt-6 text-3xl text-gray-600 font-bold text-center">
							{{ item.pricing.price }}
							<span class="text-base">{{ item.pricing.user }}</span>
						</div>
						<div class="flex items-center justify-center">
							<NuxtLink :to="getStartedLink" class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
								Sign Up
							</NuxtLink>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>

<script setup lang="ts">
const props = defineProps({
	getStartedLink: {
		type: String,
		default: '/register',
	},
});

const items = ref([
	{
		title: 'Free',
		content: [
			"Task Boards",
			"Lists & Cards",
			"Drag & Drop"
		],
		pricing: {
			price: '£0',
			user: 'for one user',
		},
		active: false
	},
	{
		title: 'Basic',
		content: [
			"Task Boards",
			"Lists & Cards",
			"Drag & Drop",
			"Customizable Labels",
			"Team project",
			"2 user"
		],
		pricing: {
			price: '£x.99',
			user: '/ per user',
		},
		active: true
	},
	{
		title: 'Pro',
		content: [
			"All Basic Features",
			"Advanced Analytics",
			"Team Collaboration Tools",
			"Unlimited user"
		],
		pricing: {
			price: '£x.399',
			user: '/ per user',
		},
		active: false
	},
])
</script>