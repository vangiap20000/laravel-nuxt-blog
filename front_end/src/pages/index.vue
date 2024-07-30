<template>
	<!--Nav-->
	<home-header :try-now="tryNow" :user="user" />
	<!--Hero-->
	<div class="pt-24">
		<div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
			<!--Left Col-->
			<div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left">
				<p class="uppercase tracking-loose w-full">What business are you?</p>
				<h1 class="my-4 text-5xl font-bold leading-tight">
					Main Hero Message to Sell Yourself!
				</h1>
				<p class="leading-normal text-2xl mb-8">
					Organize your tasks effortlessly and boost your productivity with our intuitive Kanban board.
				</p>
				<NuxtLink :to="getStartedLink" class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg 
						focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
					Get started
				</NuxtLink>
			</div>
			<!--Right Col-->
			<div class="w-full md:w-3/5 py-6 text-center">
				<img class="w-full md:w-4/5 z-50" src="~/assets/images/pngwing-icon.png" />
			</div>
		</div>
	</div>
	<div class="relative -mt-12 lg:-mt-24">
		<svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg"
			xmlns:xlink="http://www.w3.org/1999/xlink">
			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				<g transform="translate(-2.000000, 44.000000)" fill="#FFFFFF" fill-rule="nonzero">
					<path
						d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496"
						opacity="0.100000001"></path>
					<path
						d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
						opacity="0.100000001"></path>
					<path
						d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z"
						id="Path-4" opacity="0.200000003"></path>
				</g>
				<g transform="translate(-4.000000, 76.000000)" fill="#FFFFFF" fill-rule="nonzero">
					<path
						d="M0.457,34.035 C57.086,53.198 98.208,65.809 123.822,71.865 C181.454,85.495 234.295,90.29 272.033,93.459 C311.355,96.759 396.635,95.801 461.025,91.663 C486.76,90.01 518.727,86.372 556.926,80.752 C595.747,74.596 622.372,70.008 636.799,66.991 C663.913,61.324 712.501,49.503 727.605,46.128 C780.47,34.317 818.839,22.532 856.324,15.904 C922.689,4.169 955.676,2.522 1011.185,0.432 C1060.705,1.477 1097.39,3.129 1121.236,5.387 C1161.703,9.219 1208.621,17.821 1235.4,22.304 C1285.855,30.748 1354.351,47.432 1440.886,72.354 L1441.191,104.352 L1.121,104.031 L0.457,34.035 Z">
					</path>
				</g>
			</g>
		</svg>
	</div>
	<home-started />
	<home-blog :try-now="tryNow" />
	<home-pricing :get-started-link="getStartedLink" />
	<!-- Change the colour #f8fafc to match the previous section colour -->
	<svg class="wave-top" viewBox="0 0 1439 147" version="1.1" xmlns="http://www.w3.org/2000/svg"
		xmlns:xlink="http://www.w3.org/1999/xlink">
		<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			<g transform="translate(-1.000000, -14.000000)" fill-rule="nonzero">
				<g class="wave" fill="#f8fafc">
					<path
						d="M1440,84 C1383.555,64.3 1342.555,51.3 1317,45 C1259.5,30.824 1206.707,25.526 1169,22 C1129.711,18.326 1044.426,18.475 980,22 C954.25,23.409 922.25,26.742 884,32 C845.122,37.787 818.455,42.121 804,45 C776.833,50.41 728.136,61.77 713,65 C660.023,76.309 621.544,87.729 584,94 C517.525,105.104 484.525,106.438 429,108 C379.49,106.484 342.823,104.484 319,102 C278.571,97.783 231.737,88.736 205,84 C154.629,75.076 86.296,57.743 0,32 L0,0 L1440,0 L1440,84 Z">
					</path>
				</g>
				<g transform="translate(1.000000, 15.000000)" fill="#FFFFFF">
					<g transform="translate(719.500000, 68.500000) rotate(-180.000000) translate(-719.500000, -68.500000) ">
						<path
							d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496"
							opacity="0.100000001"></path>
						<path
							d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
							opacity="0.100000001"></path>
						<path
							d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z"
							opacity="0.200000003"></path>
					</g>
				</g>
			</g>
		</g>
	</svg>
	<section class="container mx-auto text-center py-6 mb-12">
		<div class="w-full mb-4">
			<div class="h-1 mx-auto bg-white w-1/6 opacity-25 my-0 py-0 rounded-t"></div>
		</div>
		<h3 class="my-4 text-3xl leading-tight">
			Get Started with Seamless Task Management!
		</h3>
		<NuxtLink :to="getStartedLink" class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg 
				focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
			Get started!
		</NuxtLink>
	</section>
	<!--Footer-->
	<home-footer />
</template>
<script setup lang="ts">
import { useAuthStore } from "~/stores/useAuthStore";

definePageMeta({
	layout: 'home',
});

const getStartedLink = ref("/register");
const tryNow = ref("/login");
const { user } = useAuthStore();

onMounted(() => {
	let scrollpos = window.scrollY;
	let header = document.getElementById("header");
	let navcontent = document.getElementById("nav-content");
	let toToggle = document.querySelectorAll(".toggleColour");
	let navaction = document.getElementById("navAction");

	document.addEventListener('scroll', function () {
		/*Apply classes for slide in bar*/
		scrollpos = window.scrollY;

		if (scrollpos > 10) {
			header?.classList.add("bg-white");
			navaction?.classList.remove("bg-white");
			navaction?.classList.add("gradient");
			navaction?.classList.remove("text-gray-800");
			navaction?.classList.add("text-white");
			//Use to switch toggleColour colours
			for (let i = 0; i < toToggle.length; i++) {
				toToggle[i].classList.add("text-gray-800");
				toToggle[i].classList.remove("text-white");
			}
			header?.classList.add("shadow");
			navcontent?.classList.remove("bg-gray-100");
			navcontent?.classList.add("bg-white");
		} else {
			header?.classList.remove("bg-white");
			//Use to switch toggleColour colours
			for (let i = 0; i < toToggle.length; i++) {
				toToggle[i].classList.add("text-white");
				toToggle[i].classList.remove("text-gray-800");
			}

			header?.classList.remove("shadow");
			navaction?.classList.remove("gradient");
			navaction?.classList.add("bg-white");
			navaction?.classList.remove("text-white");
			navaction?.classList.add("text-gray-800");
			navcontent?.classList.remove("bg-white");
			navcontent?.classList.add("bg-gray-100");

		}

	});


	let navMenuDiv = document.getElementById("nav-content");
	let navMenu = document.getElementById("nav-toggle");
	document.onclick = check;
	function check(e: any) {
		let target = (e && e.target) || (event && event.srcElement);

		//Nav Menu
		if (!checkParent(target, navMenuDiv)) {
			// click NOT on the menu
			if (checkParent(target, navMenu)) {
				// click on the link
				if (navMenuDiv?.classList.contains("hidden")) {
					navMenuDiv?.classList.remove("hidden");
				} else {
					navMenuDiv?.classList.add("hidden");
				}
			} else {
				// click both outside link and outside menu, hide menu
				navMenuDiv?.classList.add("hidden");
			}
		}

	}

	function checkParent(t: any, elm: any) {
		while (t.parentNode) {
			if (t == elm) {
				return true;
			}
			t = t.parentNode;
		}
		return false;
	}


	// Create an Intersection Observer instance
	const observer = new IntersectionObserver((entries) => {
		entries.forEach(entry => {
			const refElement = entry.target.getAttribute("data-ref");
			const elementHeader = document.querySelector(`.${refElement}`);
			const listClass = elementHeader?.classList;
			if (entry.isIntersecting) {
				elementHeader?.classList.add('font-bold');
				if (listClass?.contains('hover:text-gray-800')) elementHeader?.classList.remove("hover:text-gray-800");
				if (listClass?.contains(' hover:text-underline')) elementHeader?.classList.remove("hover:text-underline");
			} else {
				elementHeader?.classList.add('hover:text-gray-800', 'hover:text-underline');
				if (listClass?.contains('font-bold')) elementHeader?.classList.remove("font-bold");
			}
		});
	});

	document.querySelectorAll('.item-header').forEach(element => {
		observer.observe(element);
	});

	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
		anchor.addEventListener('click', function (e) {
			e.preventDefault();
			const targetId = e.target?.getAttribute('href');
			const targetElement = document.querySelector(targetId);
			window.scrollTo({
				top: targetElement.offsetTop - 56,
				behavior: 'smooth'
			});
		});
	});

	if (user) {
		getStartedLink.value = '/task';
		tryNow.value = '/task';
	}
});
</script>