@extends('layouts.app')

@section('content')

	<header class="flex items-center mb-3 py-4">
		<div class="flex justify-between w-full items-end">
			<p class="text-gray-600 text-sm font-normal ">
				<a href="/projects" class="text-grey text-sm font-normal no-underline">My Projects </a> / {{ $project->title }}
			</p>

			<div class="flex items-center mr-2">
				@foreach ($project->members as $member)
					<img
						src="{{ gravatar_url($member->email) }}"
						alt="{{$member->name}}'s avatar"
						class="w-8 rounded mr-2"
					>
				@endforeach

				<img
					src="{{ gravatar_url($project->owner->email) }}"
					alt="{{$project->owner->name}}'s avatar"
					class=" border-4 border-green-600 w-8 rounded"
				>

				<a class="text-gray-600 button ml-4" href="{{ $project->path() . '/edit' }}">Edit Project</a>
			</div>
		</div>
	</header>



	<main>
		<div class="lg:flex -mx-3">


			<div class="w-3/4 px-3">

				<div class="mb-8">
					<h2 class="text-grey-500 font-normal text-lg mb-3">Tasks</h2>
					{{-- Tasks --}}
					@foreach($project->tasks as $task)
						<div class="card mb-3">
							<form action="{{ $task->path() }}" method="post">
								@method('PATCH')
								@csrf
								<div class="flex">
									<input type="text" name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-grey' : '' }} ">
									<input type="checkbox" name="completed" id="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }} >
								</div>
							</form>
						</div>
					@endforeach

					<div class="card mb-3">
						<form action="{{ $project->path().'/tasks'}}" method="post">
							@csrf
							<input type="text" name="body" id="body" placeholder="Add New Task..." class="w-full">
						</form>
					</div>
				</div>

				<div>
					<h2 class="text-grey-500 font-normal mb-3">General Notes</h2>

					{{-- General Notes --}}
					<form action="{{ $project->path() }}" method="post">
						@csrf
						@method('PATCH')

						<textarea
							name="notes"
							class="card w-full"
							style="min-height: 200px;">{{ $project->notes }}
						</textarea>

						<button class="button submit mt-3 text-xl" type="submit">Save</button>
					</form>
				</div>

			</div>




			<div class="w-1/4 px-3">
				@include('projects.card')

				@include('projects.activity.activity_card')
			</div>



		</div>
	</main>



@endsection
