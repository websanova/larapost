<title>{{ @$title ?: (@$post->title ?: config('larablog.meta.title')) }} </title>

<meta name="keywords" content="{{ @$keywords ?: (@$post->meta->keywords ?: config('larablog.meta.keywords')) }}" />
<meta name="description" content="{{ @$description ?: (@$post->meta->description ?: config('larablog.meta.description')) }}" />

<meta property="og:title" content="{{ @$title ?: (@$post->title ?: config('larablog.meta.title')) }}" />
<meta property="og:type" content="{{ @$type ?: 'article' }}" />
<meta property="og:url" content="{{ url() }}{{ @$slug ?: (@$post->slug ?: '/' . Request::path()) }}" />
<meta property="og:description" content="{{ @$description ?: (@$post->meta->description ?: config('larablog.meta.description')) }}" />
<meta property="og:locale" content="{{ config('app.locale') }}" />
<meta property="og:site_name" content="{{ config('larablog.site_name') }}" />
<meta property="og:image" content="{{ url() }}{{ @$img ?: (@$post->meta->img ?: config('larablog.meta.logo')) }}" />