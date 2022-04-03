<template>
	<div>
		<div class="mr-8 flex items-center">
			<button class="rounded-full w-4 h-4 mr-2 border border-blue-300" @click="selectedTheme = 'light'" ></button>
			<button class="rounded-full w-4 h-4 mr-2 border border-blue-300" @click="selectedTheme = 'dark'" ></button>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				selectedTheme : 'light'
			};
		},

		watch: {
			selectedTheme() {
				alert('CHANGED')
			}
		}
	}
</script>
