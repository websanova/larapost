@section ('post.head')
    <h1 class="first">
        <a href="{{ $post->url }}">{{ $post->full_title }}</a>
    </h1>
    <div class="text-muted">{{ $post->published_at->format('M d Y') }}</div>

    <p>
    	@foreach ($post->tags as $t)
    		<a href="{{ $t->url }}" class="label label-info">{{ $t->name }}</a>
    	@endforeach

        @if ($post->serie)
            <a href="{{ $post->serie->url }}" class="label label-warning">{{ $post->serie->title }}</a>
        @endif
    </p>
    <p class="lead"></p>
@show

@section ('post.series')
    @if (@$post->serie)
        <ul>
            @foreach ($post->serie->posts as $p)
                <li><a href="{{ $p->url }}">{{ $p->title }}</a></li>
            @endforeach
        </ul>
        <p class="lead"></p>
    @endif
@show

@section ('post.buttons')
    @include (lb_view('components.buttons'))
@show

@section ('post.body')
    <div>{!! $post->body !!}</div>
@show

@section ('post.related')
    @include (lb_view('components.related'))
@show