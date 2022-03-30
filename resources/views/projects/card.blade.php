<div class="card" style="height: 200px;">
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-mycolors-100 pl-4 mb-3">
        <a class="no-underline text-black" href="{{ $project->path() }}"> {{ $project->title }} </a>
    </h3>
    <div class="text-cgrey-200"> {{ \Illuminate\Support\Str::limit($project->description,100) }} </div>

	<footer >
		<form method="post" class="text-right" action="{{ $project->path() }}">
			@method('DELETE')
			@csrf

			@can ('manage', $project)
				<button class="button delete mt-3" type="submit">Delete</button>
			@endcan
		</form>
	</footer>
</div>
