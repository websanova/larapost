@section ('post.head')
    <h1 class="first">
        {{ $post->title }}
    </h1>
@show

@section ('post.body')
    <div>{!! $post->body !!}</div>
@show

@section ('post.related')
    @include (larablog_view('components.related'))
@show