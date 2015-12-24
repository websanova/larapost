@include ('larablog::header')

<h3>Search results for "{{ Input::get('q') }}".</h3>

<br/>

@include ('larablog::blog.list')

@include ('larablog::footer')