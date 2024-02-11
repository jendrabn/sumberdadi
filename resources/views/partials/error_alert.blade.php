@if ($errors->isNotEmpty())
    <div class="alert alert-danger">
        <div class="alert-title">
            Error!
        </div>
        <ul class="list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
