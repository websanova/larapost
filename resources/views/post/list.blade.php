@forelse ($posts as $k => $p)
	@if ($k > 0)
		<hr/>
	@endif

	<h1><a href="{{ $p->url }}">{{ $p->title }}</a></h1>

	<div class="text-muted">{{ $p->published_at->format('M d Y') }}</div>
	
	<div>
		@foreach ($p->tags as $t)
			<a href="{{ $t->url }}" class="label label-info">{{ $t->name }}</a>
		@endforeach
	</div>
	<br/>

	<div>{{ $p->meta->description }}</div>
@empty
	<br/>

	No posts yet.
@endforelse

@if ($posts->total() > $posts->perPage())
	<hr/>

	{!! $posts->render() !!}
@endif