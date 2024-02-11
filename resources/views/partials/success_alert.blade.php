@if (session()->has('success'))
    <div class="alert alert-success">
        <div class="alert-title">
            Success!
        </div>
        @if (is_array(session()->get('success')))
            <ul class="list-unstyled">
                @foreach (session()->get('success') as $success)
                    <li>{{$success}}</li>
                @endforeach
            </ul>
        @else
            {{session()->get('success')}}
        @endif
    </div>
@endif
