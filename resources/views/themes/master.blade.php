@extends ('larablog::themes.' . config('larablog.app.theme') . '.layout')

<!-- meta -->

@section ('meta.opensearch')
    @parent
@stop

@section ('meta.title')
    @parent
@show

@section ('meta.keywords')
    @parent
@show

@section ('meta.description')    
    @parent
@show

@section ('meta.og')
    @parent
@show

@section ('meta.files')
    @parent
@show

<!-- sidebar -->

@section ('sidebar.series')
    @parent
@stop

@section ('sidebar.popular')
    @parent
@stop

<!-- component -->

@section ('component.search')
    @parent
@stop

@section ('component.related')
    @parent
@stop

<!-- footer-nav -->

@section ('footer-nav.left')
    @parent
@stop

@section ('footer-nav.right')
    @parent
@stop

<!-- post -->

@section ('post.list')
    @parent
@stop

@section ('post.head')
    @parent
@stop

@section ('post.body')
    @parent
@stop

<!-- page -->

@section ('page.body')
    @parent
@stop

<!-- layout -->

@section ('layout.view')
    @parent
    wtf
@stop

@section ('layout.end')
    @parent
@stop