@extends("layouts.app")

@include("tm::forms.datatable")

@section("content")
    <table id="users-table" class="table table-condensed">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
        </thead>
    </table>
@endsection

@section("styles")
    @stack("styles")
@endsection

@section("scripts")
    @stack("scripts")
    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("stocks.basic") }}'
            });
        });
    </script>
@endsection
{{--
@extends("layouts.app")
@include("tm::forms.datatable")
@section('content')
<table id="users-table" class="table table-condensed">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Created At</th>
        <th>Updated At</th>
    </tr>
    </thead>
</table>
@endsection


@section('js')
    <script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("stocks.basic") }}'
        });
    });
    </script>
@endsection
--}}
