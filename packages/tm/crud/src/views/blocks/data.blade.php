@extends($layout)

@include("tm::forms.datatable")

@section("content")
    @stack("content")
@endsection

@section("styles")
    @stack("styles")
@endsection

@section("scripts")
    @stack("scripts")
@endsection