@section ('post.head')
    <h1><a href="{{ $post->url }}">{{ $post->full_title }}</a></h1>
    <div class="text-muted">{{ $post->published_at->format('M d Y') }}</div>

    <div>
    	@foreach ($post->tags as $t)
    		<a href="{{ $t->url }}" class="label label-info">{{ $t->name }}</a>
    	@endforeach

        @if ($post->serie)
            <a href="{{ $post->serie->url }}" class="label label-warning">{{ $post->serie->title }}</a>
        @endif
    </div>

    <br/>
@show

@section ('post.series')
    @if ($post->serie)
        <div class="callout">
            @foreach ($post->serie->posts as $p)
                <a href="{{ $p->url }}">{{ $p->title }}</a><br/>
            @endforeach
        </div>
    @endif
@show

@section ('post.buttons')
    @if (@$post && @$post->meta->buttons)
        @foreach ($post->meta->buttons as $k => $v)
            <a href="{{ $v }}" class="btn btn-primary">{{ $k }}</a>
        @endforeach

        <br/>
    @endif
@show

@section ('post.body')
    <div>{!! $post->body !!}</div>
@show

@section ('post.related')
    @include (lb_view('components.related'))
@show