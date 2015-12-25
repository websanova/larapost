<title>{{ @$title ?: (@$post->title ?: config('larablog.site_title')) }} </title>

<meta name="keywords" content="{{ @$keywords ?: (@$post->meta->keywords ?: config('larablog.site_keywords')) }}" />
<meta name="description" content="{{ @$description ?: (@$post->meta->description ?: config('larablog.site_description')) }}" />

<meta property="og:title" content="{{ @$title ?: (@$post->title ?: config('larablog.site_title')) }}" />
<meta property="og:type" content="{{ @$type ?: 'article' }}" />
<meta property="og:url" content="{{ config('app.url') }}{{ @$slug ?: (@$post->slug ?: '/' . Request::path()) }}" />
<meta property="og:description" content="{{ @$description ?: (@$post->meta->description ?: config('larablog.site_description')) }}" />
<meta property="og:locale" content="{{ config('app.locale') }}" />
<meta property="og:site_name" content="{{ config('larablog.site_name') }}" />
<meta property="og:image" content="{{ config('app.url') }}{{ @$img ?: (@$post->meta->img ?: config('larablog.site_logo')) }}" />