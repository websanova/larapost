@section ('post.list')
	@forelse ($posts as $k => $p)
		@if ($k > 0)
			<hr/>
		@endif

		<div class="media">
			<div class="media-left col-xs-3 col-md-2 {{ @$p->meta->img ? '' : 'hide' }}">
				<div class="row">
					<a href="{{ $p->url }}">
						<img class="thumbnail" src="{{ $p->img }}" style="width:85%; margin:0px;"/>
					</a>
				</div>
			</div>
			<div class="media-body">
				<h1 class="media-heading">
					<a href="{{ $p->url }}">{{ $p->full_title }}</a>
				</h1>

				<div class="text-muted">{{ $p->published_at->format('M d Y') }}</div>

				<p>
					@foreach ($p->tags as $t)
						<a href="{{ $t->url }}" class="label label-info">{{ $t->name }}</a>
					@endforeach

					@if ($p->serie)
						<a href="{{ $p->serie->url }}" class="label label-warning">{{ $p->serie->title }}</a>
					@endif
				</p>

				{{ $p->meta->description }}
			</div>
		</div>

	@empty
		<br/>

		No posts found.
	@endforelse

	@if ($posts->total() > $posts->perPage())
		<hr/>

		{!! $posts->appends(request()->all())->render() !!}
	@endif
@show