@extends ('layouts.app')

@section('content')
    <div class="container">

        <div class="col-sm-12 blog-main" >
            <div class="loader">
                <img src="/images/medicine.gif">
            </div>
            <div class="bill-create-box" ng-app="myApp" style="display: none;" ng-controller="myCtrl" data-ng-init="init()">
                <form method="POST" action="/bill-items-all">

                    {{csrf_field()}}

                    <input type="hidden" name="bill_id" value="{{$bill_id}}">
                    {{--
                    <select name="{{$stock_field['name']}}" class="form-control @if(isset($stock_field['class'])){{$stock_field['class']}}@endif" id="@if(isset($stock_field['id'])){{$stock_field['id']}}@endif">
                        @foreach($stock_field['options'] as $value => $label)
                            <option @if($stock_field['value'] == $value) selected @endif value="{{$value}}">{{$label}}</option>
                        @endforeach
                    </select>--}}
                    <table class="table table-hover bill">
                        <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Stock ID</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Discount</th>
                            <th>GST</th>
                            <th>Amount</th>
                        </tr>
                        </thead>

                        <tbody>

                       {{-- <% items %>--}}
                       {{--<% stock_data %>--}}

                        <tr ng-repeat="item in items" ng-class="item.stock_id.code > 0 ? 'item-selected' : ''">
                            <td scope="row"><% $index+1 %></td>
                            <td>
                                <ui-select ng-model="item.stock_id" theme="selectize" style="width: 300px;"
                                           title="Choose Item">
                                    <ui-select-match placeholder="Select or search a item in the list..."><%
                                        $select.selected.name %>
                                    </ui-select-match>
                                    <ui-select-choices repeat="country in countries | filter: $select.search">
                                        <span ng-bind-html="country.name | highlight: $select.search"></span>
                                        <small ng-bind-html="country.code | highlight: $select.search"></small>
                                    </ui-select-choices>
                                </ui-select>
                                {{--<p><% item.stock_id %></p>--}}
                                {{--<p><% item %></p>--}}

                                <p>
                                    Available: <% item.stock_id.available %>
                                    MRP: <% item.stock_id.mrp %>
                                    Dealer Price: <% item.stock_id.dealer_price %>
                                </p>


                            </td>

                            <td>
                                <input type="number" ng-required="item.stock_id.code || $index == 0"
                                       class="form-control" max="<% item.stock_id.available %>" ng-model="item.quantity"
                                       name="quantity[]" aria-describedby="helpId" placeholder="" value="<% stock_data[item.stock_id.code].quantity %>"></td>
                            <td>
                                <input type="number" ng-required="item.stock_id.code" class="form-control" value="<% stock_data[item.stock_id.code].rate %>"step="0.50" min="<% item.stock_id.dealer_price %>" max="<% item.stock_id.mrp %>" ng-model="item.rate" name="rate[]" aria-describedby="helpId" placeholder="">
                            </td>
                            <td>
                                <input type="number" class="form-control" max="100" ng-model="item.discount" value="<% stock_data[item.stock_id.code].discount %>" name="discount[]" aria-describedby="helpId" placeholder="">
                            </td>
                            <td> <% item.stock_id.gst %>
                                <input type="hidden" value="<% item.stock_id.gst %>" name="gst[]">
                                <input type="hidden" value="<% item.stock_id.code %>" name="stock_id[]">
                            </td>
                            <td>Amount: <% famountb(item) %><input type="hidden" value="<% item.amount %>" name="amount[]"></td>
                            <td>Amount: <% item.amount1 %></td>
                            <td>
                                <a name="" ng-click="add()" id="" class="btn btn-primary" href="#" role="button">+</a>
                            </td>
                            <td>
                                <a name="" ng-click="remove($index)" id="" class="btn btn-primary" href="#"
                                   role="button" ng-hide="$index == 0">-</a>
                            </td>
                            {{--<td><% item.gst_val %></td>--}}
                        </tr>

                        </tbody>

                    </table>

                    <input type="hidden" value="<% onlyamount() %>" name="total_amount"><% onlyamount() %><br>
                    CGST:<input type="hidden" value="<% cgst() %>" name="cgst_amount"><% cgst() %><br>
                    SGST: <input type="hidden" value="<% cgst() %>" name="sgst_amount"> <% cgst() %><br>
                    Total Amount:<% bill_data.net_amount %><br>
                    <input type="hidden" value="{{ $customer_id }}" name="customer_id">
                    <input type="hidden" value="<% total_items() %>" name="total_items">
                    Total Items:<% total_items() %>
                    <!-- @todo Run ng-repeat here -->
                    <input type="hidden" ng-repeat="">

                    <input type="hidden" value="<% bill_data.gst5 %>" name="gst_5_amount">
                    <input type="hidden" value="<% bill_data.gst12 %>" name="gst_12_amount">
                    <input type="hidden" value="<% bill_data.gst18 %>" name="gst_18_amount">
                    <input type="hidden" value="<% bill_data.gst28 %>" name="gst_28_amount">
                    <input type="hidden" value="<% bill_data.net_amount %>" name="net_amount">
                    <input type="hidden" value="<% bill_data.coin_adjustment %>" name="coin_adjustment">
                    {{--<% bill_data %>--}}
                    <input type="submit"/>

                </form>


            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-sanitize.js"></script>
            <script src="/js/select.js"></script>
            <link rel="stylesheet" href="/css/select.css">
            <script>
                var app = angular.module("myApp", ['ngSanitize', 'ui.select'], function ($interpolateProvider) {
                    $interpolateProvider.startSymbol('<%');
                    $interpolateProvider.endSymbol('%>');
                });



                app.controller("myCtrl", function ($scope) {
                    /*$scope.records = [
                        "Alfreds Futterkiste",
                        "Berglunds snabbköp",
                        "Centro comercial Moctezuma",
                        "Ernst Handel",
                        "Ernst Handel1",
                        "Ernst Handel2",
                    ]*/

                    $scope.init = function () {
                        // check if there is query in url
                        // and fire search in case its value is not empty
                        jQuery(".loader").hide(function(){
                            jQuery(".bill-create-box").show();
                        });
                    };

                    $scope.$watch($scope.items,
                        function() {
                            for(item in $scope.items) {
                                $scope.famountb(item);
                            }
                        }
                    );

                    $scope.parseInt = parseInt;

                    $scope.add = function () {
                        var object_book = {
                            "id": 1,
                            "stock_id": {"code": 0,"available": 0, "mrp": 0, "gst": 0,"dealer_price":0 },
                            "quantity": "",
                            "rate": "",
                            "discount": "",
                            "gst": "",
                            "amount": "",
                            "amount1" : 0
                        };
                        //var push_object = object_book;
                        //push_object.id = $scope.items.length;
                        object_book.id = $scope.items.length;
                        $scope.items.push(object_book);
                    }
                    $scope.remove = function (index) {
                        $scope.items.splice(index, 1);
                    }



                    $scope.items = [
                        {
                            "stock_id": {"code": 0, "available": 0, "mrp": 0, "gst": 0,"dealer_price":0 },
                            "quantity": "",
                            "rate": "",
                            "discount": "",
                            "gst": "",
                            "amount": 0,
                            "amount1" : 0,
                        }/*,
                        {
                            "stock_id": "",
                            "quantity": "",
                            "rate": "",
                            "discount": "",
                            "gst": "",
                            "amount": ""
                        },
                        {
                            "stock_id": "",
                            "quantity": "",
                            "rate": "",
                            "discount": "",
                            "gst": "",
                            "amount": ""
                        },
                        {
                            "stock_id": "",
                            "quantity": "",
                            "rate": "",
                            "discount": "",
                            "gst": "",
                            "amount": ""
                        },
                        {
                            "stock_id": "",
                            "quantity": "",
                            "rate": "",
                            "discount": "",
                            "gst": "",
                            "amount": ""
                        }*/
                    ];

                    $scope.cgst = 0;
                    $scope.bill_data = {gst5: 0, gst12: 0, gst18: 0, gst28: 0, net_amount: 0, coin_adjustment: 0};

                    $scope.country = {};
                    $scope.countries = JSON.parse('<?php echo addslashes(json_encode($stock_field['options'])); ?>');
                    $scope.stock_data = JSON.parse('<?php echo addslashes(json_encode($stock_data)); ?>');


                    /*@todo trigger this on angular ready */
                    /*$scope.items.push(object);
                    $scope.items.push(object);
                    $scope.items.push(object);
                    $scope.items.push(object);
                    $scope.items.push(object);*/

                    $scope.famountb = function (item) {
                        var output = 0;

                        //console.log(item.rate);
                        //console.log(item);
                        if (item.quantity && item.rate) {
                            output = item.quantity * item.rate;
                            item.amount1 = output;
                        }

                        if (item.discount) {

                            var discount = Math.round(output * item.discount) / 100;
                            output = output - discount;
                            item.amount1 = output;
                        }

                        var gst = 0;
                        if (item.stock_id && item.stock_id.gst) {

                            gst = Math.round(output * item.stock_id.gst) / 100;
                            output = output + gst;
                        }



                        item.gst_val = gst;

                        output = Math.round(output * 100) / 100;
                        item.amount = output;


                        return output;
                    }


                    $scope.cgst = function () {
                        var output = 0;
                        var items = $scope.items;

                        var gst5,gst12,gst18,gst28,net_amount,coin_adjustment;
                        gst5 = gst12 = gst18 = gst28 = net_amount = coin_adjustment = 0;

                        for (i in items) {

                            if (typeof items[i].gst_val != "undefined") {
                                output += items[i].gst_val;
                                if(!items[i].stock_id.code) continue;

                                <!-- @todo Change to else if -->
                                if(items[i].stock_id.gst == 5) {
                                    gst5 += items[i].gst_val;
                                } else if(items[i].stock_id.gst == 12) {
                                    gst12 += items[i].gst_val;
                                } else if(items[i].stock_id.gst == 18) {
                                    gst18 += items[i].gst_val;
                                } else if(items[i].stock_id.gst == 28) {
                                    gst28 += items[i].gst_val;
                                }

                                /*Net Amount*/
                                net_amount += items[i].amount;

                            }

                        }

                        $scope.bill_data.gst5 = gst5;
                        $scope.bill_data.gst12 = gst12;
                        $scope.bill_data.gst18 = gst18;
                        $scope.bill_data.gst28 = gst28;

                        net_amount = Math.round(net_amount * 100) / 100;
                        $scope.bill_data.before_adjust_amount = net_amount;
                        $scope.bill_data.net_amount = Math.round(net_amount);

                        $scope.bill_data.coin_adjustment = $scope.bill_data.net_amount - $scope.bill_data.before_adjust_amount;
                        //item.cgst = output;

                        output = output / 2;
                        return output;
                    }

                    /*$scope.tamount = function () {

                        var output = 0;
                        var items = $scope.items;


                        for (i in items) {
                            output += items[i].amount;

                        }
                        return output;
                    }*/

                    <!-- @todo Shift to cgst amount -->
                    $scope.onlyamount = function () {

                        var output = 0;
                        var items = $scope.items;


                        for (i in items) {
                            output += items[i].amount1;

                        }
                        return output;
                    }
                    $scope.total_items = function () {

                        var output = 0;
                        var items = $scope.items;


                        for (i in items) {
                            output += items[i].quantity;

                        }
                        return output;
                    }

                });
            </script>
        </div>
    </div>
@endsection