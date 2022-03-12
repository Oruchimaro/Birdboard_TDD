@extends('layouts.app')

@section('content')
<div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">

	<h1 class="font-normal mb-10 text-center">Edit a Project</h1>

	<form
		action="{{ route('projects.update', $project) }}"
		method="post"
	>
		@method('PATCH')

		@include('projects.form', [
			'buttonText' => 'Update Project'
			])
	</form>
</div>
@endsection
