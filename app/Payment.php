<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends CRUDModel
{
    public $guarded = [];

    public static function form(){

        $form = [
            'customer_id' => [
                "type" => "select",
                "label" => "Customer",
                "options" => Customer::array_data('name'),
                "placeholder" => "",
                "value" => [],
                "required" =>"true"

            ],
            'source' => [
                "type" => "select",
                "label" => "Source",
                "options" => ['cash' => 'Cash','paytm' => 'Paytm', 'cheque' => "Cheque", "account" => "Account"],
                "text" => "",
                "placeholder" => "",
                "value" => [],
                "required" =>"true"
            ],
            'txn_id' => [
                "type" => "text",
                "label" => "Transaction ID",
                "text" => "",
                "placeholder" => "",
                "value"=>""
            ],
            'amount' => [
                "type" => "number",
                "label" => "Amount",
                "text" => "",
                "placeholder" => "",
                "value"=>"",
                 "required" =>"true"
            ],
        ];

        return $form;
    }

    public static function pending_amount($id){

        $net_amount = Bills::where('customer_id',$id)->sum('net_amount');
        /* $bill = [];
         $bill['net_amount'] = 0;
        foreach($bills as $amount){

              $bill['net_amount'] += $amount['net_amount'];

        }*/

        $customer = Customer::where('id',$id)->first();
        if($customer['pending_amount']) {
            $pending_amount = $customer['pending_amount'] + $net_amount;
            $customer->pending_amount = $pending_amount;
            $customer->save();
        }


    }


}
