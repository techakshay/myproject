<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends CRUDModel
{
    public $guarded = [];

    public $appends = ["label"];

    public function getLabelAttribute(){
        return $this->product_name." ".$this->potency." ".$this->packing." ".$this->mfg_code;
    }

    public function getMtLabelWithoutMfgAttribute(){
        return $this->product_name." ".$this->potency." ".$this->packing;
    }

    public function stocks(){
        return $this->hasMany(Stocks::class, "item_id");
    }

    public function rl_bill_items(){
        return $this->hasMany(BillItems::class,'item_id');
    }

    public function scopeStock($query, $name, $color, $size){
        //return $this->quantity - $this->rl_bill_items->sum('quantity');
        return $query->where("name", $name)->where('color', $color)->where('size', $size)->latest();

    }

    public static function form(){

        $form = [
            'product_name' => [
                "type" => "text",
                "label" => "Product Name",
                "placeholder" => "",
                "text" => "",
                "value" => "",
                "required" => true
            ],

            'potency' => [
                "type" => "text",
                "label" => "Potency",
                "placeholder" => "",
                "text" => "",
                "value" => ""
            ],
            'packing' => [
                "type" => "text",
                "label" => "Packing",
                "placeholder" => "",
                "text" => "",
                "value" => "",
                "required" => true
            ],
            'hsn_code' => [
                "type" => "text",
                "label" => "HSN Code",
                "placeholder" => "",
                "text" => "",
                "value" => "",
                "required" => true
            ],
            'mfg_code' => [
                "type" => "text",
                "label" => "MFG Code",
                "placeholder" => "",
                "text" => "",
                "value" => "",
                "required" => true
            ],
            'gst' => [
                "type" => "select",
                "label" => "GST",
                "options" => [5 => 5, 12 => 12 ,18 => 18 ,28 => 28],
                "text" => "",
                "text-class" => "text-right d-block",
                "value" => 5,
                "required" => "true",
                "class" => "selectize"
            ],
            'min_stock' => [
                "type" => "number",
                "label" => "Minimum Stock",
                "placeholder" => "",
                "text" => "",
                "value" => 0,
                "required" => true
            ],

        ];
    
        return $form;
    }

    public static function stock_verify($id){

        $stock_data = Stocks::where('item_id',$id)->get();
        $stock_quantity = 0;
        $stock_id = [];
        foreach($stock_data as $stock) {
            $quant = $stock['quantity'];
            $stock_id[] = $stock['id'];
            $stock_quantity += $quant;
        }
        $bill_data = BillItems::whereIn('stock_id',$stock_id)->get();
        $bill_quantity = 0;
        foreach($bill_data as $bill) {
            $quantity = $bill['quantity'];
            $bill_quantity += $quantity;
        }
        $available_quantity = $stock_quantity - $bill_quantity;
        $items = Item::where('id',$id)->get();
        $item_available = $items[0]['available'];
        if($available_quantity == $item_available)
        {
            $msg = "Quantity Matched";
        }
        else
        {
            $msg = "Quantity Not Matched";
        }
        return $msg;
    }

    public static function stocks_verify(){

        $has_available_but_no_stocks = Item::where("available", "!=", 0)->doesntHave("stocks")->count();

        /*$has_stocks_but_no_availability = Items::where("available", 0)->has("stocks")->count();

        if($has_stocks_but_no_availability) {
            foreach (Items::where("available", 0)->has("stocks")->get() as $item) {
                $stock_quantity = $item->stocks->sum("quantity");
                $sold_quantity = $item->rl_bill_items->sum("quantity");
                $available_quantity = $stock_quantity - $sold_quantity;
                if ($item->available != $available_quantity) {
                    $failed[] = $item->id;
                    $item->available = $available_quantity;
                    $item->save();
                } else {
                    $has_stocks_but_no_availability -= 1;
                }
            }
        }*/

        //$items = Items::where("available", "!=", 0)->has("stocks")->get();
        $items = Item::has("stocks")->get();
        $failed = [];
        foreach($items as $item){
            $stock_quantity = $item->stocks->sum("quantity");
            $sold_quantity = $item->rl_bill_items->sum("quantity");
            $available_quantity = $stock_quantity - $sold_quantity;
            if($item->available != $available_quantity){
                $failed[] = $item->id;
                $item->available = $available_quantity;
                $item->save();
            }
        }

        $stock_mismatch = count($failed);

        return compact("stock_mismatch", "has_stocks_but_no_availability", "has_available_but_no_stocks");

    }

    public static function remove_available($item_id, $quantity){
        $item = Item::find($item_id);
        $item->available -= $quantity;
        $item->save();
    }

    public static function add_available($item_id, $quantity){
        $item = Item::find($item_id);
        $item->available += $quantity;
        $item->save();
    }
}
