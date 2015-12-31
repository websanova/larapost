<h1><a href="{{ $post->url }}">{{ $post->title }}</a></h1>

<div class="text-muted">{{ $post->published_at->format('M d Y') }}</div>

<div>
	@foreach ($post->tags as $t)
		<a href="{{ $t->url }}" class="label label-info">{{ $t->name }}</a>
	@endforeach
</div>

<br>

@foreach(config('larablog.page_headers') as $page_header)
    @include($page_header);
@endforeach

<div>{!! $post->body !!}</div>

@foreach(config('larablog.page_footers') as $page_footer)
    @include($page_footer);
@endforeach