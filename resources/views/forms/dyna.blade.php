@extends ('layouts.app')

@section('content')
@section('dyna_styles')
    <link href="{{ asset('css/jquery.dynatable.css') }}" rel="stylesheet" />
@endsection
<div class="container">

    {!! Table::generate($headers, $data, $attributes) !!}
</div>

    @endsection
@section('dyna_scripts')
    <script src="https://s3.amazonaws.com/dynatable-docs-assets/js/jquery.dynatable.js"></script>
    <script>
        $(document).ready(function(){
            $('.dynatable').dynatable({
                table: {
                    defaultColumnIdStyle: 'trimDash'
                }
            });
        });
    </script>
@endsection