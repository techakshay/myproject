@extends("layouts.app")
@section("content")
<div class="container">
    <div class="panel-body">
        <!--First table-->
        <div class="table-responsive panel">
            <table class="table table-bordered table-striped bg-secondary">

                <thead>
                <tr>

                    <th>
                        <strong>Customer Type</strong>&nbsp;
                        <label class="radio-inline">
                            <input type="radio" name="Billing[cus_type]" id="BillingCusTypeNew" value="New" checked="checked">New
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="Billing[cus_type]" id="BillingCusTypeOld" value="Old">Existing
                        </label>
                    </th>
                    <th colspan="3">
                        <div class="col-sm-12" id="searchMember">
                            <strong>Search Customer ID</strong>&nbsp;
                            <input name="Billing[member_id]" id="memberId" class="" placeholder="Type Customer ID" type="text">
                            &nbsp;
                        </div>
                    </th>

                </tr>
                <tr>
                    <th>Doctor Name</th>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Customer Contact</th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td><input name="Billing[doctor_name]" autocomplete="off" id="doctor_name" class="form-control" placeholder="Doctor Name" maxlength="200" type="text"></td>
                    <td><input name="Billing[customer_id]" autocomplete="off" required="required" value="19001705" id="customer_id" class="form-control" placeholder="Customer ID" type="text"></td>
                    <td><input name="Billing[customer_name]" autocomplete="off" id="customer_name" class="form-control" placeholder="Customer Name" maxlength="255" type="text"></td>
                    <td><input name="Billing[customer_phone]" autocomplete="off" id="customer_phone" class="form-control" placeholder="Customer Contact" maxlength="255" type="text"></td>
                </tr>


                </tbody>
            </table></div>
        <!--End first table-->
        <!--second table-->

        <div class="table-responsive panel">
            <table class="table table-bordered table-striped bg-white">
                <thead>
                <tr>
                    <th width="35%">Medicine (Batch No)</th>
                    <th width="5%">Remaining Quantity</th>
                    <th width="5%">Quantity</th>
                    <!--<th width="10%"></th>-->
                    <th width="20%">MRP</th>
                    <th width="10%">Discount (%)</th>
                    <th width="10%">Tax (%)</th>
                    <th width="15%">Total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php if(isset($query)){
                        print_r($query);
                        die;
                    } ?>
                    <td><input name="product-id" id="product-id" autocomplete="on" required="required" class="form-control" maxlength="255" type="text">
                        <select name="Billing[product_id]" class="form-control productName select2-hidden-accessible" id="products" tabindex="-1" aria-hidden="true"></select>
                        <span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 293px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-products-container"><span class="select2-selection__rendered" id="select2-products-container"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span></td>

                    <td id="rem_quantity" align="center"></td>
                    <td><input name="Billing[quantity]" disabled="disabled" autocomplete="off" id="quantity" class="form-control" type="text"></td>
                    <!--<td></td>-->
                    <td><input name="Billing[price]" readonly="readonly" autocomplete="off" required="required" id="price" class="form-control" maxlength="255" type="text"></td>
                    <td><input name="Billing[discount]" autocomplete="off" id="discount" class="form-control" maxlength="255" type="text"></td>
                    <td><input type="hidden" name="Billing[medicine_tax]" id="medicine_tax">													<input name="Billing[tax]" autocomplete="off" id="tax" class="form-control" maxlength="255" type="text"></td>
                    <td><input name="Billing[tprice]" readonly="readonly" autocomplete="off" id="tprice" class="form-control" maxlength="255" type="text"></td>
                    <td><button type="button" class="btn btn-success" id="add"><span class="fa fa-plus"></span> ADD</button></td>

                </tr>
                </tbody>

            </table></div>
        <!--End second table-->
        <div id="responsedata">


            <!--End third table-->








        </div>

    </div>
</div>
@endsection

@section("scripts")
    <script>
        $(document).ready(function () {
            $('#product-id').on('change keyup', function () {

                // Ajax Header
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });

                var itemName = $(this).val();

                $.ajax({
                    type:'GET',
                    url:'item_details',
                    data:{itemName:itemName},
                    success:function(result){
                        alert('1');
                    },
                    error:function(result){
                        alert('2');
                    }
                });
            });
        });
    </script>
@endsection

@section("styles")

@endsection