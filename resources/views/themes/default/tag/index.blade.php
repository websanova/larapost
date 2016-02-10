<h1 class="media-heading">Tags</h1>

<br/>

<div>
   @forelse ($tags as $t)
       <a href="{{ $t->url }}" class="label label-info">{{ $t->name }} ({{ $t->posts_count }})</a>
   @empty
       No tag(s) found.
   @endforelse
</div>