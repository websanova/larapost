@section ('component.buttons')
    @if (@$post && @$post->buttons)
        <div>
            @foreach ($post->meta->buttons as $v)
                <a href="{{ @$v->link }}" class="btn btn-primary">
                    @if (@$v->icon)
                        <li class="fa fa-{{ $v->icon }}"></li>
                    @endif

                    {{ @$v->text }}
                </a>
            @endforeach
        </div>

        <p class="lead"></p>
    @endif
@show