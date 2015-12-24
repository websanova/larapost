@include ('larablog::header')

@foreach ($posts as $p)
	<h1><a href="{{ $p->slug }}">{{ $p->title }}</a></h1>
	<div class="text-muted">{{ $p->published_at->format('M d Y') }}</div>
	<br/>
	<div>{{ $p->meta->description }}</div>
	<hr/>
@endforeach

{!! $posts->render() !!}

@include ('larablog::footer')