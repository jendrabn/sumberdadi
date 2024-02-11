@if (session()->has('warning'))
    <div class="alert alert-warning">
        <div class="alert-title">
            Warning!
        </div>
        @if (is_array(session()->get('warning')))
            <ul class="list-unstyled">
                @foreach (session()->get('warning') as $warning)
                    <li>{{$warning}}</li>
                @endforeach
            </ul>
        @else
            {{session()->get('warning')}}
        @endif
    </div>
@endif
