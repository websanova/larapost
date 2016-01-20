@section ('component.search')
    <form action="{{ route('search') }}">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search"/>
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">Go</button>
            </span>
        </div>
    </form>
@show