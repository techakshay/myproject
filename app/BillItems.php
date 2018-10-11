<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\Resource\Item;

class BillItems extends CRUDModel
{
    public $guarded = [];

    public function stock(){

        return $this->hasOne(Stocks::class, 'id', 'stock_id');


    }

    public function item(){

        return $this->belongsTo(Item::class);


    }

    public function getLabelAttribute(){
        return $this->product_name." ".$this->potency." ".$this->packing;
    }
    
    public static function form(){
    
        $form = [
            'bill_id' => [
                "type" => "hidden",
                "label" => "",
                "placeholder" => "",
                "value" => request('bill')

            ],
            'amount' => [
                "type" => "hidden",
                "value" => "200",
                "label" => "",
                "placeholder" => "",

            ],
            'stock_id' => [
                "type" => "select",
                "label" => "Stock",
                "options" => Stocks::array_data('id'),
                "text" => "",
                "value" => [],
                "class" => "selectize"
            ],
            'quantity' => [
                "type" => "number",
                "label" => "Quantity",
                "placeholder" => "",
                "text" => "",
                "value" => ""
            ],
            'rate' => [
                "type" => "number",
                "label" => "Rate",
                "placeholder" => "Rate",
                "text" => "",
                "value" => ""
            ],
            'discount' => [
                "type" => "number",
                "label" => "Discount",
                "placeholder" => "Discount",
                "text" => "",
                "value" => ""
            ]
        ];
    
        return $form;
    }

    /*public static function form(){

        $form = [
            'customer_id' => [
                "type" => "select",
                "label" => "Customer",
                "options" => [1, 2],
                "text" => "",
                "value" => "1"
            ],
            'bill_date' => [
                "type" => "date",
                "label" => "Bills Date",
                "placeholder" => "Enter Bills Date",
                "text" => "",
                "value" => date("Y-m-d")
            ]

        ];

        return $form;
    }*/

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

    static public function customer_purchases($customer_id){

        $customer_bill_items = static::where("customer_id", $customer_id)->latest()->get();

        //$customer_data = Billitems::where("customer_id", 3)->latest()->get();
        $stock_data = [];
        foreach($customer_bill_items as $item){
            if(!isset($new_data[$item['stock_id']])){
                $stock_data[$item['stock_id']]= $item;
            }
        }

        return $stock_data;

    }

}
