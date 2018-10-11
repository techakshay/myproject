<?php

namespace App\Http\Controllers;

use App\BillReturn;
use App\ReturnItem;
use Illuminate\Http\Request;

class ReturnItemController extends Controller
{
    public function single_add(Request $request){

        $bill_return_id = request("bill_return_id");
        //$bill_return_id = 36;
        $customer_id = request("customer_id");
        if(!$bill_return_id) {
            $billReturn = new BillReturn();
            $billReturn->customer_id = $customer_id;
            $billReturn->bill_date = now();
            $billReturn->save();
            $bill_return_id = $billReturn->id;
        }

        //foreach($request['items'] as $item){
        $item = $request['item'];
        $returnItem = $request['returnItem'];

        $stock_id = $returnItem['stock_id'];
        $quantity = $item['quantity'];
        //$rate = $item['stock']['mrp'];
        //$discount = $item['discount'];
        $amount = 50;//$item['amount'];
        //$gst = $item['gst'];
        $item_id = $returnItem['item_id'];
        $bill_item_id = $returnItem['id'];


        //$sale_amount = $quantity * $rate;
        //$discount_amount = $sale_amount * $discount / 100;
        //$raw_amount = $sale_amount - $discount_amount;
        //$gst_amount = $raw_amount * $item['gst'] / 100;
        //$final_amount = $raw_amount + $gst_amount;

        $save_data = compact(
            "item_id",
            "bill_return_id",
            "customer_id",
            'stock_id',
            'quantity',
            'bill_item_id',
            //'rate',
            //'discount',
            'amount'
            //"raw_amount",
            //'discount_amount',
            //'gst_amount',
            //'gst',
            //'final_amount'
        );
        $billItem = ReturnItem::create($save_data);
        $return_item_id = $billItem->id;
        //}

        return compact('bill_return_id','return_item_id');
    }

    public function single_remove(){

        $return_item_id = request("return_item_id");
        //$bill_id = 36;
        $returnItem = ReturnItem::find($return_item_id);

        $returnItem->delete();
        //}

        return compact('return_item_id');
    }
}
