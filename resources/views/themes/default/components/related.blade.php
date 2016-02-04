@section ('component.related')
    @if (@$related)
        <?php $count = 0; ?>

        <h2 class="page-header">Related</h2>

        <div class="row">
            @foreach (@$related as $v)
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="{{ $v->url }}" class="">
                        <img src="{{ $v->img }}" class="img-thumbnail" style="width:100%;"/>

                        <div class=" text-center">
                            <p></p>

                            {{ $v->full_title }}

                            <br/><br/>
                        </div>
                    </a>
                </div>

                @if (++$count % 2 === 0)
                    <div class="clearfix visible-xs-block"></div>
                @elseif ($count % 3 === 0)
                    <div class="clearfix visible-sm-block"></div>
                @elseif ($count % 4 === 0)
                    <div class="clearfix visible-md-block"></div>
                @elseif ($count % 6 === 0)
                    <div class="clearfix visible-lg-block"></div>
                @endif
            @endforeach
        </div>
    @endif
@show