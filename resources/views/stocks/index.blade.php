@extends("layouts.app")


    @include("tm::forms.datatable")

@section("content")
    <div class="container">
        @stack("content")
    </div>
@endsection

@section("styles")
    @stack("styles")
@endsection

@section("scripts")
    @stack("scripts")
@endsection