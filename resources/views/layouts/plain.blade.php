<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/selectize.bootstrap3.css') }}" rel="stylesheet" />
    @yield('dyna_styles')
    @yield('styles')
    <link rel="stylesheet" href="{{ asset("css/jquery-confirm.css") }}">
    <style>
        .bg-danger {
            background-color: #dc3545!important;
        }
        .text-white{
            color: #fff!important;
        }
        input.ng-invalid.ng-not-empty {
            color: #dc3545!important;
            border: 1px solid #dc3545;

        }
        .table-hover>tbody>tr:hover{
            background-color: #bae2f9;
        }

        .dataTable>tbody>tr:hover{
            background-color: #ccc;
        }
        .table-hover.bill>tbody>tr:hover{
            background-color: #dcdcdc;
        }
        .selectize-dropdown .active {
            background-color: rgba(17, 17, 17, 0.2) !important;
        }
        .selectize-dropdown-content .option:hover{
            background-color: none !important;
        }

    </style>
</head>
<body>
@include("blocks.navbar")
@yield("content")
<script
        src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
        crossorigin="anonymous"></script>
{{--<script src="{{ asset('js/app.js') }}"></script>--}}

{{--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
<script src="{{ asset("js/jquery-confirm.js") }}"></script>
<script>
    function error_message(title, content) {
        $.confirm({
            title: title, //'Encountered an error!',
            content: content, //'Something went downhill, this may be serious',
            type: 'red',
            typeAnimated: true,
            buttons: {
                close: {
                    text: 'Close',
                    btnClass: 'btn-red',
                    action: function () {
                    }
                },


            }
        });
    }
    function success_message(title, content) {
        $.confirm({
            title: title, //'Encountered an error!',
            content: content, //'Something went downhill, this may be serious',
            type: 'green',
            typeAnimated: true,
            buttons: {
                close: {
                    text: 'Close',
                    btnClass: 'btn-green',
                    action: function () {
                    }
                },


            }
        });
    }
</script>
@yield("scripts")

</body>
</html>