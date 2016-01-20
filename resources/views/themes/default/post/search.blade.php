<h3>Search results for "{{ request('q') }}".</h3>

<br/>

@include ('larablog::themes.' . config('larablog.app.theme') . '.post.list')