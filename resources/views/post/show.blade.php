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

@if (@$related)
    <h2>Related</h2>

    <div class="row">
        @foreach (@$related as $v)
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 text-center">
                <a href="{{ $v->url }}" class="thumbnail">
                    <img src="{{ $v->img }}" />
                
                    <div class="caption">
                        {{ $v->title }}
                    </div>
                </a>
            </div>
        @endforeach
    </div>

@endif

@foreach(config('larablog.post_footers') as $page_footer)
    @include ($page_footer)
@endforeach