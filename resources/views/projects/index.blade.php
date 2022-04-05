@extends('layouts.app')

@section('content')

	<header class="flex items-center mb-3 py-4">
		<div class="flex justify-between w-full items-end">
			<h2 class="text-gray-600 text-sm font-normal ">My Projects</h2>
			<a class="text-gray-600 button" href="/projects/create">New Project</a>
		</div>
	</header>

	<main class="lg:flex lg:flex-wrap -mx-3">
		@forelse ($projects as $project)
			<div class="lg:w-1/3 px-3 pb-6">
				@include('projects.card')
			</div>
		@empty
			<div> No projects yet </div>
		@endforelse
	</main>


	<modal name="create-project" classes="p-10 bg-card rounded-lg" height="auto">
		<h1 class="font-normal mb-16 text-center text-2xl">Let's start something new!</h1>

		<div class="flex">

			{{-- leftside --}}
			<div class="flex-1 mr-4">
				<div class="mb-4">
					<label for="title" class=" mb-2 text-sm block">Title</label>
					<input
						for="title"
						type="text"
						id="title"
						class="border border-muted-light p-2 text-ms block w-full"
					>
				</div>
				<div class="mb-4">
					<label for="description" class=" mb-2 text-sm block">Description</label>
					<textarea
						for="description"
						id="description"
						class="border border-muted-light p-2 text-ms block w-full"
						rows="7"
					></textarea>
				</div>
			</div>

			{{-- right side  --}}
			<div class="flex-1 ml-4">
				<div class="mb-4">
					<label class=" mb-2 text-sm block">Need some tasks?</label>
					<input
						type="text"
						id="title"
						class="border border-muted-light p-2 text-ms block w-full"
						placeholder="Task 1"
					>
				</div>

				<button class="mr-2 text-xs text-green-500"> + Add New Task Field...</button>
			</div>
		</div>

		<footer class="flex justify-end">
			<button class="mr-4 text-xs text-blue-500">Create Project</button>
			<button class="text-xs text-red-400">Cancel</button>
		</footer>
	</modal>

	<a href="" @click.prevent="$modal.show('create-project')">Show modal</a>
@endsection
