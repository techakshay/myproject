@extends ('layouts.app')

@section('content')


    <div class="row">
        <div class="col">
    {!! Table::generate($headers, $data, $attributes) !!}
</div>
    </div>

    @endsection

{{--
@section("styles")
    <link href="{{ asset('css/jquery.dynatable.css') }}" rel="stylesheet" />
@endsection
@section("scripts")
    <script src="{{ asset('js/jquery.dynatable.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.dynatable').dynatable({
                table: {
                    defaultColumnIdStyle: 'trimDash'
                }
            });
        });
    </script>
@endsection--}}
