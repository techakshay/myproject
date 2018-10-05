@extends("layouts.plain")
@section("content")
    <div class="container">
        <div id="application">
            <div class="table-responsive panel">
                <table class="table table-bordered table-striped bg-white">
                    <thead>
                    <tr>
                        <th width="20%">Customer Name</th>
                        <th width="15%">Address</th>
                        <th width="10%">City</th>
                        <th width="10%">State</th>
                        <th width="10%">Telephone</th>
                        <th width="10%">Email</th>
                        <th width="10%">GST Number</th>
                        <th width="15%">Drug License Number</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" id="customer" v-if="!addCustomer" :class="{'is-invalid': !validations.customer, 'form-control': true}" :disabled="customer.disabled" v-model="customer.value"/>
                            @{{customer.name}}
                            <a href="javscript://" @click="clearCustomer()" v-if="customer.disabled">Clear</a>
                            {{--<a @click="addCustomer = 1" target="_blank" v-if="!addCustomer" class="text-right">Add New</a>--}}
                            <a href="{{route("customer.create")}}" target="_blank" class="text-right">Add New</a>
                            <input type="text" name="customer_name" v-if="addCustomer" v-model="new_customer.name" :class="{'is-invalid': validations.new_customer.name, 'form-control': true}"/>
                            <a @click="addCustomer = 0" target="_blank" v-if="addCustomer" class="text-right">Cancel</a>
                        </td>
                        <td>@{{ customer.address  }}
                            <input type="text"  name="address" :class="{'is-invalid': validations.new_customer.address, 'form-control': true}" v-if="addCustomer" v-model="new_customer.address"/></td>
                        <td>@{{ customer.city  }}
                            <input type="text" name="city" :class="{'is-invalid': validations.new_customer.city, 'form-control': true}" v-if="addCustomer" v-model="new_customer.city"/></td>
                        <td>@{{ customer.state  }}
                            <input type="text" name="state"  :class="{'is-invalid': validations.new_customer.state, 'form-control': true}" v-if="addCustomer" v-model="new_customer.state"/></td>
                        <td>@{{ customer.tel  }}
                            <input type="text"  name="telephone" :class="{'is-invalid': validations.new_customer.telephone, 'form-control': true}" v-if="addCustomer" v-model="new_customer.tel"/></td>
                        <td>@{{ customer.email  }}
                            <input type="text" name="email"  :class="{'is-invalid': validations.new_customer.email, 'form-control': true}" v-if="addCustomer" v-model="new_customer.email"/></td>
                        <td>@{{ customer.gst_no  }}
                            <input type="text" name="gst_no"  :class="{'is-invalid': validations.new_customer.gst_no, 'form-control': true}" v-if="addCustomer" v-model="new_customer.gst_no"/></td>
                        <td>
                            @{{ customer.dl_no  }}
                            <input type="text" name="dl_no"  :class="{'is-invalid': validations.new_customer.dl_no, 'form-control': true}" v-if="addCustomer" v-model="new_customer.dl_no"/></td>
                        <td v-if="addCustomer">
                            <button type="button" class="btn btn-success"  @click="createCustomer(new_customer)"><span class="fa fa-plus" ></span>Save</button>
                        </td>

                        {{--<td></td>
                        <td>@{{ customer.city  }}</td>
                        <td>@{{ customer.state  }}</td>
                        <td>@{{ customer.telephone  }}</td>
                        <td>@{{ customer.email  }}</td>
                        <td>@{{ customer.gst_no  }}</td>
                        <td>@{{ customer.gst_no  }}</td>--}}
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
                        <th width="5%">Remaining Quantity</th>
                        <th width="5%">MRP</th>
                        <th width="5%">Quantity</th>
                        <!--<th width="10%"></th>-->
                        <th width="10%">Discount (%)</th>
                        <th width="10%">Tax (%)</th>
                        <th width="15%">Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="hidden" v-model="item.stock_id" name="" id="stock_id_hidden" value="" />
                            <input type="hidden" name="" id="stock_key_hidden" />
                            <input type="text"  v-model="item.label" :title="item.label" :disabled="item.disabled" id="product_items" :class="{'form-control':true,'d-none': item.disabled}" />
                            <div v-if="item.disabled">
                                @{{ item.label }}
                                <strong>Dealer Price:</strong> @{{item.stock.dealer_price}}
                                <br>
                                <a href="javscript://" style="color: blue" @click="clearItem()">Clear</a>

                            </div>
                        </td>
                        <td>
                            <select id="stocks_field" class="form-control">
                                <option>Select Batch Number</option>
                            </select>

                        </td>
                        <td id="available">
                            @{{ item.stock.available }}
                        </td>
                        <td id="mrp_td">
                            @{{ item.stock.mrp }}
                        </td>
                        <td>
                            <input type="number" name="quantity" id="quantity" v-model="item.quantity" :max="item.stock.available" :class="{'is-invalid': item.quantity > item.stock.available, 'form-control': true}" />
                        </td>

                        <td>
                            <input type="number" name="discount" id="discount" v-model="item.discount" max="100" value="0" class="form-control"/>
                        </td>
                        <td id="gst_td">
                            @{{ item.gst }}
                        </td>
                        <td id="amount_td">
                            @{{ amount }}
                        </td>
                        <td><button type="button" class="btn btn-success" id="add" @click="addItem(item)"><span class="fa fa-plus" ></span> ADD</button></td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div v-if="items.length">
                <h2>BILL <span v-if="bill_id">ID: @{{bill_id}}</span></h2>
                <table v-if="items.length">
                    <thead>
                    <tr>
                        <th width="30%">Medicine</th>
                        <th width="20%">Batch No</th>
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
                            @{{ item.stock.batch_no }}
                        </td>
                        <td>
                            @{{ item.stock.mrp }}
                        </td>
                        <td>
                            @{{ item.quantity }}
                        </td>
                        <td>
                            @{{ item.discount }}
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
                <div class="row mt-4">
                    <div class="col-12">
                        <a v-if="bill_id" :href="print" class="btn btn-outline-success">Print</a>
                    </div>
                </div>
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
        /*const app = new Vue({
            el: '#app',
            data: {
                /!*item: {
                    stock_id: 0
                }*!/
                product: {
                    quantity: 0
                },
                stock_id: 'Hello'
            },
            methods: {
                addFind: function () {
                    this.item.push({ value: '' });
                }
            }
        });*/
        const app = new Vue({
            el: "#application",
            data: {
                _token: "{{csrf_token()}}",
                item: {
                    stock_id: '',
                    stock: {
                        quantity: "",
                        used: "",
                        available: ""
                    }
                },
                customer: "",
                new_customer: {},
                validations: {
                    customer: true,
                    new_customer: {}
                },
                bill_id: "",
                items: [],
                addCustomer: false
            },
            computed: {
                amount(){
                    item = this.item;
                    quantity = item.quantity;
                    if(!quantity){
                        return "";
                    }
                    discount = item.discount || 0;
                    gst = item.gst;

                    mrp_amount = quantity * item.stock.mrp;
                    discount_amount = mrp_amount * discount / 100;
                    raw_amount = mrp_amount - discount_amount;

                    gst_amount = raw_amount * gst / 100;
                    final_amount = raw_amount + gst_amount;

                    final_amount = Math.round(final_amount * 100)/100;
                    this.item.amount = final_amount;
                    return final_amount;
                },
                print(){
                    var route = '{{route("print", ["id" => "bill_id"])}}'
                    return route.replace("bill_id", this.bill_id);
                }
            },
            methods: {
                addNew: function(){
                   this.addCustomer = true
                },
                createCustomer: function(){
                    //this.customer._token = this._token;
                    axios.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';

                    axios.post("{{route("customer.store")}}", this.new_customer)
                        .then(function (response) {
                            app.validations.new_customer = {};
                            app.customer = response.data.customer;
                            app.customer_id = response.data.customer_id;
                            app.customer.disabled = 1;
                            app.addCustomer = 0;
                            console.log(response)
                        })
                        .catch(function (error) {
                            app.validations.new_customer = error.response.data.errors;
                        });
                },
                addItem: function (item) {

                    if(!this.customer.id){
                        this.validations.customer = false;
                        return;
                    }
                    this.validations.customer = true;

                    if(!item.quantity || item.quantity > item.stock.available){
                        return;
                    }




                    axios.post("{{route("bill.single.add")}}",
                        {
                            _token: this.token,
                            item: item,
                            bill_id: this.bill_id,
                            customer_id: this.customer.id
                        }
                    ).then(function (response) {
                        app.bill_id = response.data.bill_id
                        history.pushState(null, null, app.bill_id);
                        item.bill_item_id = response.data.bill_item_id
                        app.items.push(item);
                        //app.bill_id = response.data.bill_id
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
                    axios.post("{{route("bill.single.remove")}}",
                        {
                            _token: this.token,
                            bill_item_id: app.items[index].bill_item_id
                        }
                    ).then(function (response) {
                        //this.bill_id = response.bill_id
                        app.items.splice(index, 1);
                    });
                },
                saveBill: function (item) {
                    axios.post("{{route("bill.save")}}",
                        {
                            _token: this.token,
                            items: this.items,
                            bill_id: this.bill_id
                        }
                    ).then(function (response) {
                        app.bill_id = response.bill_id
                    });
                },
                saveCustomer: function () {
                    axios.post("{{route("bill.customer.save")}}",
                        {
                            _token: this.token,
                            bill_id: this.bill_id,
                            customer: this.customer
                        }
                    ).then(function (response) {
                        app.bill_customer_id = response.customer_id
                    });
                }
            }
        })
        app.items = @json($items);
        app.bill_id = '{{$bill_id}}';
        app.customer = @json($customer);






        function log( message ) {
            $( "<div>" ).text( message ).prependTo( "#log" );
            $( "#log" ).scrollTop( 0 );
        }

        var stocks = [];
        var selectedStock = '';
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
            source: "{{route("bill.item_data")}}",
            minLength: 2,
            select: function( event, ui ) {

                //$('#product_items').val(ui.item.value).();
                /*$('#product_items').attr("title", ui.item.value);
                $('#product_items').attr("disabled", true);*/
                app.item.label = ui.item.value;
                app.item.disabled = true;
                app.item.gst = ui.item.gst;
                stocks = ui.item.stocks;



                //$('#gst_td').html(ui.item.gst);


                //$('#product_items_hidden').val(ui.item.id);

                $("#stocks_field").html("");
                if (ui.item.stocks.length) {

                    for (i in ui.item.stocks) {
                        stock = ui.item.stocks[i];
                        $("#stocks_field").append("<option value='" + i + "'>" + stock.batch_no + "</option>")
                    }

                    if (ui.item.stocks.length > 1) {
                        $("#stocks_field").prepend("<option value=''>Select Batch Number</option>");
                        $("#stocks_field").focus();
                    } else {
                        stock_selected(0);
                        $("#quantity").focus();
                    }


                } else {
                    $("#stocks_field").html("<option value=''>Out Of Stock</option>");
                }

                //log( "Selected: " + ui.item.value + " aka " + ui.item.id );
            }
        });

        $("#stocks_field").change(function () {
            stock_selected($(this).val());
        })

        $("#quantity").change(function () {
            //update_amount();
        });

        $("#discount").change(function () {
            //update_amount();
            //$("#add").focus();
        });

        $("#add").click(function () {

        })

        function update_amount() {



            quantity = $("#quantity").val();
            discount = $("#discount").val();
            //gst = selectedStock.gst;

            amount = quantity * selectedStock.mrp;
            discount_amount = amount * discount / 100;
            net_amount = amount - discount_amount;

            gst_amount = net_amount * gst / 100;
            final_amount = net_amount + gst_amount;

            final_amount = Math.round(final_amount);

            app.item.amount = final_amount;
            /*$("#amount_td").html(final_amount);*/
        }

        function stock_selected(i)
        {
            console.log(stocks[i]);
            selectedStock = stocks[i];

            $("#stock_key_hidden").val(i);
            app.item.stock_id  = stocks[i].id;

            //$("#mrp_td").html(stocks[i].mrp);
            //$("#available").html(stocks[i].quantity - stocks[i].used);
            //$("#quantity").attr("max", stocks[i].quantity - stocks[i].used);

            app.item.stock = selectedStock;
            //app.item.stock.available = app.item.stock.quantity - app.item.stock.used;
            app.item.stock.available = app.item.stock.mt_stock_left;
        }

        $(function () {
            $("#quantity123").keydown(function () {
                // Save old value.
                $(this).data("old", $(this).val());
            });
            $("#quantity123").keyup(function () {
                // Check correct, else revert back to old value.
                if ((parseInt($(this).val()) <= $(this).attr("max") && parseInt($(this).val()) > 0))
                    ;//$("#discount").focus();
                else if($(this).val() == "")
                    ;
                else
                    $(this).val($(this).data("old"));
            });
        });


    </script>

@endsection

@section("styles")
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection