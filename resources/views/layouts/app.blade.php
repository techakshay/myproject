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
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ"
          crossorigin="anonymous">--}}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet" />--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/selectize.bootstrap3.css') }}" rel="stylesheet" />


    @yield('dyna_styles')
    @yield('styles')
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
    <div id="app">

        @include("blocks.navbar")

        <div class="container">
        @if($flash_success = session('success'))
            <div id="flash-message" class="alert alert-success">
                {!! $flash_success !!}

            </div>
        @endif

        <div id="flash-success-box" class="alert alert-success d-none"></div>
        <div id="flash-error-box" class="alert alert-dander d-none"></div>

        @if($flash_error = session('error'))
            <div class="alert alert-danger">
                {{$flash_error}}
            </div>
        @endif
        </div>

        @yield('content')

    </div>

    <!-- Data Table Scripts -->

    <!-- Scripts -->
    {{--<script src="{{ asset('js/app.js') }}"></script>--}}
    <script src="{{ asset('js/selectize.js') }}"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    @yield('dyna_scripts')
    <script>
        $.widget( "custom.catcomplete", $.ui.autocomplete, {
            _create: function() {
                this._super();
                this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
            },
            _renderMenu: function( ul, items ) {

                var that = this,
                    currentCategory = "";
                $.each( items, function( index, item ) {
                    var li;
                    if ( item.category != currentCategory ) {
                        ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                        currentCategory = item.category;
                    }
                    li = that._renderItemData( ul, item );
                    if ( item.category ) {
                        li.attr( "aria-label", item.category + " : " + item.label);
                    }

                });
            }

        });
        /*var data = [
            { label: "anders", category: "" },
            { label: "andreas", category: "" },
            { label: "antal", category: "" },
            { label: "annhhx10", category: "Products" },
            { label: "annk K12", category: "Products" },
            { label: "annttop C13", category: "Products" },
            { label: "anders andersson", category: "People" },
            { label: "andreas andersson", category: "People" },
            { label: "andreas johnson", category: "People" }
        ];*/

        $( "#search-bar" ).catcomplete({
            delay: 0,
            source: "/search-ajax",
            select: function( event, ui ) {
                window.location.href = "/task/"+ ui.item.id
                return false;
            },
            minLength: 2
        });
        $('.selectize').selectize({
            create: false,
            sortField: 'text'
        });
    </script>
    <!--yield scripts-->
    @yield('scripts')
    <!--yield scripts-->
</body>
</html>
