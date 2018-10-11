<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stocks extends CRUDModel
{

    use SoftDeletes;

    public $guarded = [];

    public function rl_bill_items(){
        return $this->hasMany(BillItems::class,'stock_id');
    }

    public static function form(){
    
        $form = [
            'invoice_number' => [
                "type" => "text",
                "label" => "Invoice Number",
                "placeholder" => "",
                "text" => "<a href='/reset/invoice-number'>Reset</a>",
                "value" => "",
                "required" => true
            ],
           'item_id' => [
               "type" => "autocomplete-item",
               "label" => "Item",
               //"options" => [],
               "text" => "<a href='javascript://' id='product_items_clear'>Clear Item</a> <a href='/items/create'>Add Item</a>",
               "text-class" => "text-right d-block",
               "value" => "",
               "required" => "true",
               "class" => "",
               "id" => "product_items",
               "placeholder" => ""
           ],
            'vendor_id' => [
                "type" => "select",
                "label" => "Company",
                "options" => Vendor::array_data(),
                "text" => "<a href='/vendor/create'>Add Vendor</a>",
                "text-class" => "text-right d-block",
                "value" => [],
                "required" => "true",
                "class" => "selectize"
            ],
            'batch_no' => [
                "type" => "text",
                "label" => "Batch No",
                "placeholder" => "",
                "text" => "",
                "value" => "",
                "required" => true,
            ],
            'exp_date' => [
                "type" => "date",
                "label" => "Expiry Date",
                "placeholder"=>"",
                "text" => "<input type='hidden' name='exp_date' class='no_expiry_field' value='2050-12-31' disabled><a href='javascript://' class='no-expiry-link'>No Expiry</a>",
                "value" => "",
                "required" => "true",
                "div-class" => "no_field"
            ],
            'quantity' => [
                "type" => "text",
                "label" => "Quantity",
                "placeholder" => "",
                "text" => "",
                "value" => "",
                 "required" => true
            ],
            'mrp' => [
                "type" => "number",
                "label" => "MRP",
                "placeholder" => "",
                "text" => "",
                "value" => "",
                "required" => true
            ],

            'dealer_price' => [
                "type" => "number",
                "label" => "Dealer Price",
                "placeholder" => "",
                "text" => "",
                "value" => "",
                "required" => true
            ],
            'breakage' => [
                "type" => "text",
                "label" => "Breakage",
                "placeholder" => "",
                "text" => "",
                "value" => 0,
                "required" => false
            ],
            'min_stock' => [
                "type" => "text",
                "label" => "Minimum Stock",
                "placeholder" => "",
                "text" => "",
                "value" => 0,
                "required" => false,
                "id" => "min_stock"
            ],

        ];

    
        return $form;
    }

    public function item(){

        return $this->belongsTo(Item::class);

    }

    public function items(){

        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function vendors(){

        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function vendor(){

        return $this->belongsTo(Vendor::class);
    }

    static function array_data($name = "name", $extra = [], $conditions = []){

        $data = static::select('*')->get();
        $new_data = ["" => "Select"];
        foreach($data as $item){
            $new_data[$item->id] = $item->item->product_name;
        }
        return $new_data;

    }

    public function getTotalAttribute(){
        return $total = $this->dealer_price * $this->quantity;
    }

    public function getStocksTotalAttribute(){
        $invoice_number = $this->invoice_number;
        $invoice_data = Stocks::where('invoice_number',$invoice_number)->get();
        $total = 0;
        foreach($invoice_data as $invoice_item){
            $total += $invoice_item->total;
        }
        return $total;
    }

    public function getStocksQuantityAttribute(){
        $invoice_number = $this->invoice_number;
        $invoice_data = Stocks::where('invoice_number',$invoice_number)->get();
        $total = 0;
        foreach($invoice_data as $invoice_item){
            $total += $invoice_item->quantity;
        }
        return $total;
    }

    public function scopeLastStock($query, $name, $color, $size){
        //return $this->quantity - $this->rl_bill_items->sum('quantity');
        return $query->where("name", $name)->where('color', $color)->where('size', $size)->latest();

    }

    public function getTotalAddedAttribute(){
        $invoice_number = $this->invoice_number;
        $stocks_count = Stocks::where('invoice_number',$invoice_number)->count();
        return $stocks_count;
    }

    static function object_data($name = "name"){
        /*   $users = $this->users;*/

        /*$company_id = auth()->user()->company_id;

        if ($company_id == 3) {

            $data = static::select('name', 'id')->get();
        } else {
            $data = static::select('name', 'id')->where('id', $company_id)->get();
        }*/

        $data = static::select('*')->get();
        $new_data[] = ["id" => "", "name" => "Select"];
        foreach($data as $item){
            $array = [
                "code" => $item->id,
                "name" => $item->item->product_name,
                "available" => $item->item->available,
                "mrp" => $item->mrp,
                "gst" => $item->item->gst,
                "dealer_price" => $item->dealer_price
            ];
            $new_data[] = $array;
        }

        return $new_data;

    }

    public function update_stocks($one_data)
    {
        $stock = Stocks::where("id", $one_data['stock_id'])->get()->first();
        $available = $stock->item->available - $one_data['quantity'];


        Item::where('id', $stock->item->id)->update(['available' => $available]);
    }

    public static function add_stocks_deprecated($data){
        $stock = Stocks::where("item_id",$data['item_id'])->get()->first();
        //$available = $stock->item_id->available - $data['quantity'];
        $available = $stock->item->available + $data['quantity'];
        Item::where('id', $stock->item->id)->update(['available' => $available]);
    }
}
