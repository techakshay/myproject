<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Billing</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
          integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
</head>
<body>
<?php /*@todo Add back button */ ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
        integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
        crossorigin="anonymous"></script>
<div class="container" style="width: 100%;margin-top: 20px;">
    {{--<div class="bill-box" style="border: 1px solid black; padding: 50px 30px">--}}
    <div class="bill-box" style="border: 1px solid black; padding :10px 5px">
        <div class="row">
            <div class="col">GST No.06CTNPK0510P1ZH</div>
            <div class="col text-center">||JAI SHIYA RAM ||</div>
            <div class="col text-right">PHONE NO:9813289750</div>
        </div>
        {{--<div class="row">
            <div class="col">GST No.06555525855</div>
            <div class="col text-center"></div>
            <div class="col text-right"></div>
        </div>--}}
        <div class="row">
            <div class="col">DL NO.20B HR55-00-578 OW/H</div>
            <div class="col text-center"><h3>HARYANA</h3></div>
            <div class="col text-right">8700082363</div>
        </div>
        <div class="row">
            <div class="col-3">DL NO.21B 6655 W/H</div>
            <div class="col-6 text-center"><h3>HOMOEOPATHIC STORE</h3></div>
            <div class="col-3"></div>
        </div>
        {{--<div class="row">
            <div class="col text-center"><h3>HARYANA HOMOEOPATHIC STORE</h3></div>
        </div>--}}

        <div class="row">
            <div class="col">INV.NO: {{$bill->id}}</div>
            <div class="col-7 text-center">NEAR PNB BANK,DABRA CHOWK,DELHI ROAD,HISAR</div>
            <div class="col text-right">Date: {{$bill->bill_date}}</div>
            <hr>
        </div>

        <div class="row">
            <div class="col">CUSTOMER: {{$bill->customer->name}}</div>
            {{--<div class="col">DL.NO. {{$bill->customer->dl_no}}</div>
            <div class="col">GST NO:{{$bill->customer->gst_no}}</div>--}}
        </div>
        <div class="row">
            @if($bill->customer->dl_no)
            <div class="col">DL.NO. {{$bill->customer->dl_no}}</div>
            @endif
            @if($bill->customer->gst_no)
            <div class="col">GST NO: {{$bill->customer->gst_no}}</div>
            @endif
        </div>
        <table class="table" style="font-size: 13px;">
            <thead>
            <tr>
                <th>Sr. No.</th>
                <th>MFG</th>
                <th>QTY</th>
                <th>PRODUCT NAME & PACKING</th>
                <th>HSN CODE</th>
                <th>BATCH NO</th>
                <th>E.DT</th>
                <th>M.R.P</th>
                <th>DIS.%</th>
                <th>GST</th>
                <th>AMOUNT</th>
            </tr>
            </thead>
            <tbody>
            <?php $count = 1; ?>
            @foreach($bill->BillItems as $item)
                <tr>
                    <td>{{$count}}</td>
                    <td scope="row">{{$item->stock->items->mfg_code}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->stock->items->label}}</td>
                    <td>{{$item->stock->items->hsn_code}}</td>
                    <td>{{$item->stock->batch_no}}</td>
                    <td>{{$item->stock->exp_date}}</td>
                    <td>{{$item->stock->mrp}}</td>
                    <td>{{$item->discount}}</td>
                    <td>{{$item->stock->items->gst}}%</td>
                    <td>{{$item->amount}}</td>
                </tr>
                <?php $count++; ?>
            @endforeach

            <tr>
                <td colspan="9">Do Not Pay Without Authorised Printed Receipt</td>
                <td>Total</td>
                <td>{{$bill->total_amount}}</td>
            </tr>
            <tr>
                <td colspan="9"></td>
                <td>S.G.S.T</td>
                <td>{{$bill->sgst_amount}}</td>
            </tr>
            <tr>
                <td colspan="2">Total Items</td>
                <td>{{$bill->total_items}}</td>

                <td colspan="6"></td>
                <td>C.G.S.T</td>
                <td>{{$bill->cgst_amount}}</td>
            </tr>
            <tr>
                <td colspan="5">ALL DISPUTES SUBJECT TO HISAR JURISDICTION</td>
                <td colspan="2">CREDIT/CASH</td>
                <td colspan="3" class="text-right">INVOICE VALUE NET</td>
                <td>{{$bill->net_amount}}</td>
            </tr>
            </tbody>
        </table>
        <div class="row">
            @foreach([5,12,18,28] as $key)
                @php($item = "gst_".$key."_amount")
                @if($bill->$item)
                <div class="col-3">GST {{$key}}% {{$bill->$item}}</div>
                @endif
            @endforeach
        </div>
        <div class="row">
            <div class="col">E. & O.E.()</div>
        </div>

    </div>
</div>
<style type="text/css">
    .table td, .table th {
        padding: 0.25rem;
    }
    @page {
        size: A4;
        margin: 0;
    }
</style>
<script type="text/javascript">
    $(window).on('load', function(){
        window.print()
    });
</script>
</body>
</html>