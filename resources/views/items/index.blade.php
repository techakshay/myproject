@extends('layouts.app')

@section('content')
    <div class="container">
    <table class="table table-bordered table-hover" id="users-table">
        <thead>
        <tr>
            {{--<th>Id</th>--}}
            <th>Item</th>
            <th>HSN</th>
            <th>MFG</th>
            {{--<th>GST</th>--}}
            <th>Available</th>
            <th>Min Stock</th>
            <th>Requirement</th>
        </tr>
        </thead>
    </table>
    </div>
@stop

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/datatables.min.css"/>
@endsection

@section('scripts')
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- DataTables -->
    {{--<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>--}}

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/datatables.min.js"></script>


    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('items.out_of_stock.data') !!}',
                dom: 'Blfrtip',
                buttons: [
                    'pdf', 'csv'
                ],
                columns: [
                    /*{ data: 'id', name: 'id' },*/
                    { data: 'product_name', name: 'product_name' },
                    { data: 'hsn_code', name: 'hsn_code' },
                    { data: 'mfg_code', name: 'mfg_code' },
                    /*{ data: 'gst', name: 'gst' },*/
                    { data: 'available', name: 'available' },
                    { data: 'min_stock', name: 'min_stock' },
                    { data: 'required', name: 'required' }
                ]
            });
        });
    </script>
@endsection
