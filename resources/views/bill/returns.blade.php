@extends("layouts.plain")
@section("content")
    <div class="container">
        <div id="application">
            <div class="table-responsive panel">
                <table class="table table-bordered table-striped bg-white">
                    <thead>
                    <tr>
                        <th width="30%">Customer Name</th>
                        <th width="20%">Address</th>
                        <th width="5%">City</th>
                        <th width="5%">State</th>
                        <th width="5%">Telephone</th>
                        <th width="10%">Email</th>
                        <th width="10%">GST Number</th>
                        <th width="15%">Drug License Number</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" id="customer" :class="{'is-invalid': !validations.customer, 'form-control': true}" :disabled="customer.disabled" v-model="customer.value"/>
                            <a href="javscript://" @click="clearCustomer()" v-if="customer.disabled">Clear</a>
                            <a href="{{route("customer.create")}}" target="_blank" v-if="!customer.disabled" class="text-right">Add New</a>
                        </td>
                        <td>@{{ customer.address  }}</td>
                        <td>@{{ customer.city  }}</td>
                        <td>@{{ customer.state  }}</td>
                        <td>@{{ customer.telephone  }}</td>
                        <td>@{{ customer.email  }}</td>
                        <td>@{{ customer.gst_number  }}</td>
                        <td>@{{ customer.drug_license_number  }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive panel">
                <table class="table table-bordered table-striped bg-white">
                    <thead>
                    <tr>
                        <th width="30%">Medicine</th>
                        <th width="20%">Batch No</th>
                        <th width="5%">Quantity</th>
                        <th width="5%">MRP</th>
                        <th width="10%">Discount (%)</th>
                        <th width="5%">Return Quantity</th>
                        <th width="10%">Tax (%)</th>
                        <th width="15%">Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" name="" v-model="item.label" :title="item.label" :disabled="item.disabled" id="product_items" class="form-control" />
                            <a href="javscript://" @click="clearItem()" v-if="item.disabled">Clear</a>
                        </td>
                        <td>
                            <select class="form-control" v-model="item.stock_id" @change="stockSelected()">
                                <option value="" v-if="item.rl_bill_items" selected>Select Date</option>
                                <option v-for="stock, index in item.rl_bill_items" :value="index">@{{stock.created_at}}</option>
                            </select>

                        </td>
                        <td id="available">
                            @{{ selectedStock.quantity }}
                        </td>
                        <td id="mrp_td">
                            @{{ selectedStock.rate }}
                        </td>
                        <td>
                            @{{ item.discount }}
                        </td>
                        <td>
                            <input type="number" name="quantity" id="quantity" v-model="item.quantity" :max="selectedStock.quantity" :class="{'is-invalid': item.quantity > selectedStock.quantity, 'form-control': true}" />
                        </td>


                        <td id="gst_td">
                            @{{ item.gst }}
                        </td>
                        <td id="amount_td">
                            {{--@{{ amount }}--}}
                        </td>
                        <td><button type="button" class="btn btn-success" id="add" @click="addItem(item)"><span class="fa fa-plus" ></span> ADD</button></td>
                    </tr>
                    </tbody>
                </table>
                <h2>BIll</h2>
                <table>
                    <thead>
                    <tr>
                        <th width="30%">Medicine</th>
                        <th width="20%">Bill ID</th>
                        {{--<th width="5%">Remaining Quantity</th>--}}
                        <th width="5%">MRP</th>
                        <th width="10%">Quantity</th>
                        <!--<th width="10%"></th>-->
                        <th width="10%">Discount (%)</th>
                        <th width="10%">Tax (%)</th>
                        <th width="15%">Total</th>

                    </tr>
                    </thead>
                    <tr v-for="item, index in items">
                        <td>
                            @{{ item.label }}
                        </td>
                        <td>
                            @{{ item.selectedStock.batch_number }}
                        </td>
                        <td>
                            @{{ item.selectedStock.mrp }}
                        </td>
                        <td>
                            @{{ item.quantity }}
                        </td>
                        <td>
                            @{{ item.selectedStock.discount }}
                        </td>
                        <td>
                            @{{ item.gst }}
                        </td>
                        <td>
                            @{{ item.amount }}
                        </td>
                        <td><button @click="removeItem(index)">X</button></td>
                    </tr>
                </table>
            </div>

            {{--<button @click="saveBill(item)">Save</button>--}}

            {{--<pre> @{{ $data }}</pre>--}}
        </div>
        {{--<div id="application">
            <pre> @{{ $data }}</pre>
            <ul>
                <li v-for="product in products">
                    @{{ product }}
                </li>
            </ul>
        </div>--}}
        {{--<div id="">
            <table>
                <tr>
                    <td v-for="item in items">
                        @{{ item.label }}
                    </td>
                </tr>
            </table>
        </div>--}}
        {{--<button @click="addFind">
            New Find
        </button>--}}
    </div>
@endsection

@section("scripts")
    <script src="https://unpkg.com/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        const app = new Vue({
            el: "#application",
            data: {
                _token: "{{csrf_token()}}",
                item: {
                    stock_id: "",
                    stocks: {

                    }
                },
                customer: "",
                validations: {customer: true},
                bill_return_id: "",
                items: []
            },
            computed: {
                selectedStock: {
                    // getter
                    get: function () {
                        if(this.item.stock_id || this.item.stock_id === 0) {
                            return this.item.rl_bill_items[this.item.stock_id];
                        } else {
                            return {}
                        }
                        //return this.firstName + ' ' + this.lastName
                    },

                }
            },
            methods: {
                addItem: function (item) {

                    if(!this.customer.id){
                        $("#customer").focus();
                        this.validations.customer = false;
                        return;
                    }
                    this.validations.customer = true;

                    if(!item.quantity || item.quantity > this.selectedStock.quantity){
                        //$("#product_items").focus();
                        return;
                    }




                    axios.post("{{route("bill.return.single.add")}}",
                        {
                            _token: this.token,
                            item: item,
                            returnItem: this.selectedStock,
                            bill_return_id: this.bill_return_id,
                            customer_id: this.customer.id
                        }
                    ).then(function (response) {
                        app.bill_return_id = response.data.bill_return_id
                        history.pushState(null, null, "/bill/return/"+app.bill_return_id);
                        item.return_item_id = response.data.return_item_id
                        app.items.push(item);
                        //app.bill_return_id = response.data.bill_return_id
                    });

                    this.item = {
                        stock_id: '',
                        stock: {
                            quantity: "",
                            used: "",
                            available: ""
                        }
                    };
                },
                stockSelected: function(){
                    this.item.selectedStock = this.selectedStock;
                },
                clearItem: function(){
                    this.item = {
                        stock_id: '',
                        stock: {
                            quantity: "",
                            used: "",
                            available: ""
                        }
                    };
                },
                clearCustomer: function(){
                    this.customer = '';
                },
                removeItem: function (index) {
                    axios.post("{{route("bill.return.single.remove")}}",
                        {
                            _token: this.token,
                            return_item_id: app.items[index].return_item_id
                        }
                    ).then(function (response) {
                        //this.bill_return_id = response.bill_return_id
                        app.items.splice(index, 1);
                    });
                },
                saveBill: function (item) {
                    axios.post("{{route("bill.save")}}",
                        {
                            _token: this.token,
                            items: this.items,
                            bill_return_id: this.bill_return_id
                        }
                    ).then(function (response) {
                        app.bill_return_id = response.bill_return_id
                    });
                },
                saveCustomer: function () {
                    axios.post("{{route("bill.customer.save")}}",
                        {
                            _token: this.token,
                            bill_return_id: this.bill_return_id,
                            customer: this.customer
                        }
                    ).then(function (response) {
                        app.bill_customer_id = response.customer_id
                    });
                }
            }
        })
        app.items = @json($items);
        app.bill_return_id = '{{$bill_return_id}}';
        app.customer = @json($customer);






        function log( message ) {
            $( "<div>" ).text( message ).prependTo( "#log" );
            $( "#log" ).scrollTop( 0 );
        }

        var stocks = [];
        var gst = 0;
        $("#customer").autocomplete({
            source: "{{route("customer.autocomplete")}}",
            minLength: 2,
            select: function( event, ui ) {
                app.customer = ui.item;
                app.customer.disabled = true;
                app.validations.customer = true;
            }
        });
        $( "#product_items" ).autocomplete({
            source: function(request, response) {
                $.getJSON("{{route("bill.item_data_return")}}", { customer_id: app.customer.id, term: request.term },
                    response);
            },
            /*source: "{{route("bill.item_data")}}",*/
            minLength: 2,
            select: function( event, ui ) {

                //$('#product_items').val(ui.item.value).();
                /*$('#product_items').attr("title", ui.item.value);
                $('#product_items').attr("disabled", true);*/
                console.log(ui);
                app.item = ui.item;
                app.item.disabled = true;
                stocks = ui.item.rl_bill_items;




            }
        });

    </script>

@endsection

@section("styles")
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection