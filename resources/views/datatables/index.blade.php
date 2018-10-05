@extends('layouts.master')

@section('content')
    <table class="table table-bordered table-hover" id="users-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Created By</th>
            <th>Item</th>
            <th>Dealer</th>
            <th>Batch No</th>
            <th>Invoice No</th>
            <th>Expiry Date</th>
            <th>Quantity</th>
            <th>MRP</th>
            <th>Dealer Price</th>
            <th>Breakage</th>
        </tr>
        </thead>
    </table>
@stop

@push('scripts')
    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('datatables.data') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'user', name: 'user' },
                    { data: 'item', name: 'item' },
                    { data: 'dealer', name: 'dealer' },
                    { data: 'batch_no', name: 'batch_no' },
                    { data: 'invoice_number', name: 'invoice_number' },
                    { data: 'exp_date', name: 'exp_date' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'mrp', name: 'mrp' },
                    { data: 'dealer_price', name: 'dealer_price' },
                    { data: 'breakage', name: 'breakage' }
                ]
            });
        });
    </script>
@endpush
