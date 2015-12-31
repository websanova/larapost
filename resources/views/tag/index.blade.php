<h1>Tags</h1>

<br/>

<div>
	@foreach ($tags as $t)
		<a href="{{ $t->url }}" class="label label-info">{{ $t->name }} ({{ $t->posts_count }})</a>
	@endforeach
</div>