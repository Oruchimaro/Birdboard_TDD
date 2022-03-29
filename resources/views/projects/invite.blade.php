<div class="card mt-3" style="height: 200px;">
	<h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-mycolors-100 pl-4 mb-3">
		Invite a user
	</h3>

	<form method="post" class="text-right" action="{{ $project->path() . '/invitations' }}">
		@csrf

		<input
			type="email"
			name="email"
			id="email"
			class="rounded border border-gray-600 py-2 px-3"
			placeholder="Email Account"
		>

		<button class="button mt-3" type="submit">Invite</button>
	</form>


	@include('partial.error', [ 'bag' => 'invitations' ])
</div>
