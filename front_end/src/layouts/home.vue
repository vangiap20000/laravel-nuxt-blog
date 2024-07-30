<template>
    <div class="leading-normal tracking-normal text-white gradient" style="font-family: 'Source Sans Pro', sans-serif;">
        <slot />
    </div>
</template>

<style lang="css">
.gradient {
	background: linear-gradient(90deg, #f9a8d4 0%, #bfdbfe 100%);
}

html {
	scroll-behavior: smooth;
}
</style>