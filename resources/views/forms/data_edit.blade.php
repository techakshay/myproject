@extends ('layouts.app')


@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css">
@endsection

@section('content')

<div class="container">
    {{--{!! Table::generate($headers, $data, $attributes) !!}--}}
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>First name</th>
            <th>Last name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Start date</th>
            <th>Salary</th>
            <th></th>
        </tr>
        </thead>
    </table>
    {{--<table id="table_id" class="display">
        <thead>
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Row 1 Data 1</td>
            <td>Row 1 Data 2</td>
        </tr>
        <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
        </tr>
        </tbody>
    </table>--}}
</div>

@endsection
@section('scripts')
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>
    <script>
        var editor; // use a global for the submit and return data rendering in the examples

        $(document).ready(function() {
            editor = new $.fn.dataTable.Editor( {
                ajax: "../php/staff.php",
                table: "#example",
                fields: [ {
                    label: "First name:",
                    name: "first_name"
                }, {
                    label: "Last name:",
                    name: "last_name"
                }, {
                    label: "Position:",
                    name: "position"
                }, {
                    label: "Office:",
                    name: "office"
                }, {
                    label: "Extension:",
                    name: "extn"
                }, {
                    label: "Start date:",
                    name: "start_date",
                    type: "datetime"
                }, {
                    label: "Salary:",
                    name: "salary"
                }
                ],
                formOptions: {
                    bubble: {
                        title: 'Edit',
                        buttons: false
                    }
                }
            } );

            $('button.new').on( 'click', function () {
                editor
                    .title( 'Create new row' )
                    .buttons( { "label": "Add", "fn": function () { editor.submit() } } )
                    .create();
            } );

            $('#example').on( 'click', 'tbody td', function (e) {
                if ( $(this).index() < 6 ) {
                    editor.bubble( this );
                }
            } );

            $('#example').on( 'click', 'a.remove', function (e) {
                editor
                    .title( 'Delete row' )
                    .message( 'Are you sure you wish to delete this row?' )
                    .buttons( { "label": "Delete", "fn": function () { editor.submit() } } )
                    .remove( $(this).closest('tr') );
            } );

            $('#example').DataTable( {
                ajax: "../php/staff.php",
                columns: [
                    { data: "first_name" },
                    { data: "last_name" },
                    { data: "position" },
                    { data: "office" },
                    { data: "start_date" },
                    { data: "salary", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) },
                    {
                        data: null,
                        defaultContent: '<a href="#" class="remove">Delete</a>',
                        orderable: false
                    },
                ]
            } );
        } );
    </script>
@endsection