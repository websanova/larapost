@if (@$related)
    <h2>Related</h2>

    <div class="row">
        @foreach (@$related as $v)
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 text-center">
                <a href="{{ $v->url }}" class="thumbnail">
                    <img src="{{ $v->img }}" />
                
                    <div class="caption">
                        {{ $v->full_title }}
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endif