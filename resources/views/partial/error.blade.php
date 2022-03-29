@if ($errors->{ $bag ?? 'default' }->any())
	<ul class="field mt6 list-reset">
		@foreach ($errors->{ $bag ?? 'default' }->all() as $error)
			<li class="text-sm text-re">
				{{ $error }}
			</li>
		@endforeach
	</ul>
@endif
