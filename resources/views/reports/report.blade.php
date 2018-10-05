@extends("layouts.app")
@section("content")
    <div class="container">
        <p>&nbsp;</p>
        <div class="row">
            @php($count=1)
            @php($sub_count=1)
            @foreach($data as $key => $sub_array)
            <div class="col-4">
                <h4>Table Count Box {{$count}}</h4>
                <ul class="list-group">
                    @foreach($sub_array as $key => $value)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$sub_count}}. {{title_case($key)}}
                            <span class="badge badge-primary badge-pill">{{$value}}</span>
                        </li>
                        @php($sub_count++)
                    @endforeach
                </ul>
            </div>
                @php($count++)
            @endforeach
        </div>
    </div>

@endsection
