@extends ('layouts.app')

@section('content')
    <div class="container">

        {{--<div class="row mt-4 mb-2">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="">All</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data</li>
                    </ol>
                </nav>
            </div>
        </div>--}}
        <div class="row">
            <div class="col">
                {!! Table::generate($headers, $data, $attributes) !!}
            </div>
        </div>
    </div>
@endsection



