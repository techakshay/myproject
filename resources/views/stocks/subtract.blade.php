@extends("layouts.plain")
@section("content")
    <style>
        @media (max-width: 990px) {
            .w-sm-50{width: 50%}
            .data{display: flex;}
            .data tr{
                display: inline-grid;
            }
            .data thead th{padding: 26px 55px 25px 55px;
                width: 100%;}
            .data thead th:nth-last-child(1){display: none; }
            .data tbody td:nth-last-child(1){background: #fff;border: none}
        }

    </style>
    <div class="container">
        <div id="application">
            <div class="table-responsive-lg panel mx-auto">
                <table class="table table-bordered table-striped bg-white data">
                    <thead>
                    <tr>
                        <th width="30%">Style</th>
                        <th width="20%">Color</th>
                        <th width="20%">Size</th>
                        <th width="5%">Quantity</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <input type="text"  v-model="item.name" :title="item.style" :disabled="item.disabled" :class="{'form-control':true,'d-none': item.disabled}" />
                        </td>
                        <td>
                            <input type="text"  v-model="item.color" :disabled="item.disabled" :class="{'form-control':true,'d-none': item.disabled}" />
                        </td>
                        <td>
                            <input type="text"  v-model="item.size" :title="item.color" :disabled="item.disabled" :class="{'form-control':true,'d-none': item.disabled}" />
                        </td>
                        <td>
                            <input type="text"  v-model="item.quantity" :disabled="item.disabled" :class="{'form-control':true,'d-none': item.disabled}" />
                        </td>

                        <td><button type="button" class="btn btn-success" id="add" @click="addItem(item)"><span class="fa fa-plus" ></span> SUBTRACT</button></td>
                    </tr>
                    </tbody>
                </table>

            </div>
            @include("stocks.datatable")



        </div>

    </div>
@endsection

@section("scripts")
    <script src="https://unpkg.com/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    @stack("scripts")
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
        var dataTable;
        $(function() {
            dataTable = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('stock.data') !!}',
                order: [[ 5, "desc" ]],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'size', name: 'size' },
                    { data: 'color', name: 'color' },
                    { data: 'stock', name: 'stock' },
                    { data: 'updated_at', name: 'updated_at' },
                ],
                responsive: true,

                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
            });
        });

        const app = new Vue({
            el: "#application",
            data: {
                _token: "{{csrf_token()}}",
                item: {},
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
            created(){
                this.item.name = "";
                this.item.color = "";
                this.item.size = "";
                this.item.quantity = "";
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
                addItem: function (item) {


                    if(!item.name || !item.color || !item.size || !item.quantity){
                        return;
                    }


                    axios.post("{{route("bill.single.subtract")}}",
                        {
                            _token: this.token,
                            item: item,
                            bill_id: this.bill_id,
                            customer_id: this.customer.id
                        }
                    ).then(function (response) {
                        dataTable.draw();
                        app.item = {}
                        success_message("Success!", "Stock Updated Successfully")
                    }).catch(function (error) {
                        //app.item = {}
                        error_message("Error!", error.response.data.message)
                    });


                },
                clearItem: function(){
                    this.item = {}
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
                }
            }
        })

    </script>

@endsection

@section("styles")
    @stack("styles")
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection