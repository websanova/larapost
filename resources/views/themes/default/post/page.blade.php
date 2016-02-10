@section ('page.head')
    <h1 class="first">{{ $post->title }}</h1>
@show

@section ('page.body')
    <div>{!! $post->body !!}</div>
@show