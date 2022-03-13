<div class="card mt-3">
	<ul class="text-xs text-cyan-300">
		@foreach ($project->activity as $activity)
			<li class="{{ $loop->last ? '' : 'mb-2' }}">
				@include ("projects.activity.{$activity->description}")
			 <span class="text-muted text-cgrey-200">{{ $activity->created_at->diffForHumans(null,true) }}</span>
			</li>
		@endforeach
	</ul>
</div>
