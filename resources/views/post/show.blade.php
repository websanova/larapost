@foreach(config('larablog.post_headers') as $post_header)
    @include ($post_header)
@endforeach

<h1><a href="{{ $post->url }}">{{ $post->title }}</a></h1>

<div class="text-muted">{{ $post->published_at->format('M d Y') }}</div>

<div>
	@foreach ($post->tags as $t)
		<a href="{{ $t->url }}" class="label label-info">{{ $t->name }}</a>
	@endforeach
</div>

<br>

<div>{!! $post->body !!}</div>

@include ('larablog::layout.related')

@foreach(config('larablog.post_footers') as $page_footer)
    @include ($page_footer)
@endforeach