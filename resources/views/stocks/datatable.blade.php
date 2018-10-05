


    <table class="table table-bordered table-hover" id="users-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Style</th>
            <th>Size</th>
            <th>Color</th>
            <th>Available</th>
            <th>Updated At</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Id</th>
            <th>Style</th>
            <th>Size</th>
            <th>Color</th>
            <th>Available</th>
            <th>Updated At</th>
        </tr>
        </tfoot>
    </table>

@push('styles')

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

@endpush

@push('scripts')
    <!-- DataTables -->
    {{--<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>--}}
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <!-- Bootstrap JavaScript -->

@endpush