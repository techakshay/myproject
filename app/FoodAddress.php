<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodAddress extends Model
{
    public $guarded = [];
    public static function form(){

        $form = [
            'name' => [
                "type" => "text",
                "label" => "Name",
                "placeholder" => "",
                "text" => "",
                "value" => "",
                "required" => true
            ],
            'address' => [
                "type" => "text",
                "label" => "Address",
                "placeholder" => "",
                "text" => "",
                "value" => "",
                "required" => true
            ],

            'phone_no' => [
                "type" => "text",
                "label" => "Phone Number",
                "placeholder" => "",
                "text" => "",
                "value" => "",
                "required" => true
            ],


        ];

        return $form;
    }
}
