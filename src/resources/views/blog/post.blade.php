@include ('larablog::header')

<div class="container">
	<h1><a href="{{ $post->slug }}">{{ $post->title }}</a></h1>
	<div class="text-muted">{{ $post->published_at->format('M d Y') }}</div>

	<br>

	<div>{!! $post->body !!}</div>
</div>

@include ('larablog::footer')