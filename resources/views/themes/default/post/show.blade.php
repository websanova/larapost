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

    <br>

    @if ($post->serie)
        <ul>
            @foreach ($post->serie->posts as $p)
                <li><a href="{{ $p->url }}">{{ $p->title }}</a></li>
            @endforeach
        </ul>
    @endif
@show

@section ('post.body')
    <div>{!! $post->body !!}</div>

    @include ('larablog::themes.' . config('larablog.app.theme') . '.components.related')
@show