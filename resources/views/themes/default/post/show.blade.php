@section ('post.head')
    <h1><a href="{{ $post->url }}">{{ $post->full_title }}</a></h1>
    <div class="text-muted">{{ $post->published_at->format('M d Y') }}</div>

    <p>
    	@foreach ($post->tags as $t)
    		<a href="{{ $t->url }}" class="label label-info">{{ $t->name }}</a>
    	@endforeach

        @if ($post->serie)
            <a href="{{ $post->serie->url }}" class="label label-warning">{{ $post->serie->title }}</a>
        @endif
    </p>
@show

@section ('post.series')
    @if (@$post->serie)
        <p class="lead"></p>

        <ul>
            @foreach ($post->serie->posts as $p)
                <li><a href="{{ $p->url }}">{{ $p->title }}</a></li>
            @endforeach
        </ul>
    @endif
@show

@section ('post.buttons')
    @if (@$post && @$post->meta->buttons)
        <p class="lead"></p>

        <div>
            @foreach ($post->meta->buttons as $v)
                <a href="{{ @$v->link }}" class="btn btn-primary">
                    @if (@$v->icon)
                        <li class="fa fa-{{ $v->icon }}"></li>
                    @endif

                    {{ @$v->text }}
                </a>
            @endforeach
        </div>
    @endif
@show

@section ('post.body')
    <div>{!! $post->body !!}</div>
@show

@section ('post.related')
    @include (lb_view('components.related'))
@show