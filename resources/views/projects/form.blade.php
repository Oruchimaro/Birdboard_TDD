@csrf

<div class="field mb-6">
	<label for="title" class="label text-sm mb-2 block">Title</label>

	<div class="control">
		<input
			type="text"
			class="input bg-transparent border border-grey-300 rounded p-2 text-xs w-full"
			name="title"
			id="title"
			placeholder="My next awesome project"
			value="{{$project->title}}"
			required
		>
	</div>
</div>

<div class="field mb-6">
	<label class="label text-sm mb-2 block" for="description">Description</label>

	<div class="control">
		<textarea
			name="description"
			id="description"
			class="textarea bg-transparent border border-gray-300 rounded p-2 text-xs w-full"
			rows="10"
			placeholder="I should start learning piano."
			required>{{$project->description}}</textarea>
	</div>
</div>

<div class="form-group pb-4">
	<small id="emailHelp" class="form-text text-muted">Title and Description are required.</small>
</div>

<div class="field">
	<div class="control">
		<button class="is-link mr-2 button" type="submit">{{$buttonText}}</button>

		<a href="{{$project->path()}}" class="is-link mr-2 bg-red-600">Cancel</a>
	</div>
</div>

@if ($errors->any())
<div style="margin-top: 40px; margin-left:5px; color:red; font-weight:700;">
		@foreach ($errors->all() as $error)
			<li class="text-sm text-red-700">{{$error}}</li>
		@endforeach
</div>
@endif
