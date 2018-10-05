<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TM\Crud\CRUDModel;

class Food extends CRUDModel
{
    public $guarded = [];
    public static function form(){

        $form = [
            'food_name' => [
                "type" => "text",
                "label" => "Food Name",
                "placeholder" => "",
                "text" => "",
                "value" => "",
                "required" => true
            ],
            'area' => [
                "type" => "text",
                "label" => "Area",
                "placeholder" => "",
                "text" => "",
                "value" => "",
                "required" => true
            ],

            'Quantity' => [
                "type" => "text",
                "label" => "Quantity",
                "placeholder" => "",
                "text" => "",
                "value" => ""
            ],


        ];

        return $form;
    }
}

