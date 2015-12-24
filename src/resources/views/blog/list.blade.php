@forelse ($posts as $k => $p)
	@if ($k > 0)
		<hr/>
	@endif

	<h1><a href="{{ $p->slug }}">{{ $p->title }}</a></h1>
	<div class="text-muted">{{ $p->published_at->format('M d Y') }}</div>
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