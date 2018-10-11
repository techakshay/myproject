<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Bills extends CRUDModel
{
    public $guarded = [];

    public static function form(){

        $form = [
            'customer_id' => [
                "type" => "select",
                "label" => "Customer",
                "options" =>  Customer::array_data("name", $extra = ["id"]),
                "text" => "<a href='/customer/create'>Add Customer</a>",
                "text-class" => "text-right d-block",
                "value" => [],
                "class" => "selectize",
                "required" => true
            ],
            'bill_date' => [
                "type" => "date",
                "label" => "Bills Date",
                "placeholder" => "Enter Bills Date",
                "text" => "",
                "value" => date("Y-m-d"),
                "required" => true
            ]

        ];

        return $form;
    }

    public function getBillDateAttribute($value){
        return Carbon::parse($value)->format("d-m-Y");
    }

    public function BillItems(){

        return $this->hasMany(BillItems::class, 'bill_id');

        }
    public function customer(){

        return $this->belongsTo(Customer::class);

    }

    public function getTotalItemsAttribute(){
        return $this->BillItems->sum("quantity");
    }

    public static function calculations($billItems){

        //return $data;

        $total_amount = $total_gst = $net_amount =0;
        $output = ['gst_5_amount' => 0, 'gst_12_amount' => 0, 'gst_18_amount' => 0, 'gst_28_amount' => 0];
        foreach ($billItems as $billItem){
            $total_amount += $billItem['raw_amount'];
            $total_gst += $billItem['gst_amount'];
            $output['gst_'.$billItem['gst'].'_amount'] += $billItem['gst_amount'];
            $net_amount += $billItem['final_amount'];
        }

        $output['total_amount'] = $total_amount;
        $output['sgst_amount'] = $output['cgst_amount'] = $total_gst / 2;
        $output['net_amount'] = round($net_amount,0);
        $output['coin_adjustment'] = round($output['net_amount'] - $net_amount,2);

        return $output;


    }

    public static function calc($data){

        $output = [];
        $output['raw_amount'] = 0;
        $output['discount_amount'] = 0;
        $output['gst_amount']=0;
        $output['total_amount']=0;
        $output['net_amount']=0;
        foreach($data as $item) {
            //$raw_amount = $item['quantity'] * $item['rate'];
            $output['raw_amount'] +=  $item['quantity'] * $item['rate'];
            $output['discount_amount'] -= round(($output['raw_amount'] * $item['discount']))/100;
            $output['total_amount'] =( $output['raw_amount'] + $output['discount_amount']) ;
            $output['gst_amount'] += round(($output['total_amount'] * ($item->stock->items->gst)))/100;
            $output['net_amount'] +=round($output['total_amount']+$output['gst_amount']);
          //  $output['total_amount']= $output['amount'] ;
          //  $output['net_amount']=

        }

        $output['cgst_amount'] = round($output['gst_amount'] / 2,2);
        $output['sgst_amount'] = round($output['gst_amount'] / 2, 2);

        return $output;


    }

    public static function verify($calc, $bill){

        foreach(['net_amount','total_amount','cgst_amount','sgst_amount'] as $item){
            if($bill[$item] != $calc[$item]){
                return "$item not matched";
                //return false;
            }
        }

        return true;

    }


    public static function profit_loss($id){

        $data = BillItems::where('bill_id',$id)->get();

        $final_profit = 0;
        foreach($data as $item) {
            $rate = $item['rate'];
            $discount = $item['discount'];
            $buy_price = $rate * $discount / 100;

            $sell_price = $item->stock->dealer_price;
            $profit = $sell_price - $buy_price;
            $final_profit += $profit;
        }
        return $final_profit;

    }
}
