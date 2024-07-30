<template>
	<section id="blog" class="bg-white border-b py-8 item-header" data-ref="blog-header">
		<div class="container mx-auto flex flex-wrap pt-4 pb-12">
			<h1 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
				Explore Kanban Features
			</h1>
			<div class="w-full mb-4">
				<div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
			</div>
			<div v-for="item in items" class="w-full md:w-1/3 p-6 flex flex-col flex-grow flex-shrink">
				<div class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden shadow">
					<a href="#" class="flex flex-wrap no-underline hover:no-underline">
						<p class="w-full text-gray-600 text-xs md:text-sm px-6">
							GETTING STARTED
						</p>
						<div class="w-full font-bold text-xl text-gray-800 px-6">
							{{ item.title }}
						</div>
						<p class="text-gray-800 text-base px-6 mb-5">
							{{ item.content }}
						</p>
					</a>
				</div>
				<div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
					<div class="flex items-center justify-start">
						<NuxtLink :to="item.link"
							class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
							Try now
						</NuxtLink>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>

<script setup lang="ts">
const props = defineProps({
	tryNow: {
		type: String,
		default: '/login',
	},
});

const items = useState();

onMounted(() => {
	setTimeout(() => {
		items.value = [
			{
				title: 'Effortless Task Management',
				content: 'Begin your journey with our Kanban board. Effortlessly set up your boards, lists, and tasks to stay organized and focused.',
				link: props.tryNow
			},
			{
				title: 'Boost Your Productivity',
				content: 'Explore how to effectively manage your projects and tasks with our comprehensive Kanban board features.',
				link: props.tryNow
			},
			{
				title: 'Master Your Workflow',
				content: 'Master task management with our intuitive interface and powerful tools designed to keep your projects on track.',
				link: props.tryNow
			},
		];
	}, 500);
});
</script>