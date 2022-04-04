<template>
	<div>
		<div class="mr-8 flex items-center">
			<button
				v-for="(color, theme) in themes"
				class="rounded-full w-4 h-4 mr-2 border"
				:class="{ 'border-blue-600': selectedTheme == theme}"
				:style="{ backgroundColor: color }"
				@click="selectedTheme = theme" >
			</button>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				themes : {
					'theme-light' : '#f5f6f9',
					'theme-dark' : ' #222'
				},
				selectedTheme : 'theme-light'
			};
		},

		watch: {
			selectedTheme() {
				document.body.className = document.body.className.replace(/theme-\w+/, this.selectedTheme); // DOM manipulation

				localStorage.setItem('theme', this.selectedTheme);
			}
		},

		created() {
			this.selectedTheme = localStorage.getItem('theme') || 'theme-light'
		}
	}
</script>
