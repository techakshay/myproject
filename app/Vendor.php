<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends CRUDModel
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
        'city' => [
            "type" => "text",
            "label" => "City",
            "placeholder" => "",
            "text" => "",
            "value" => "",
            "required" => true
        ],
        'state' => [
            "type" => "text",
            "label" => "State",
            "placeholder" => "",
            "text" => "",
            "value" => "",
            "required" => true
        ],
        'tel' => [
            "type" => "text",
            "label" => "Telephone",
            "placeholder" => "",
            "text" => "",
            "value" => "",
            "required" => true
        ],
        /*'fax' => [
            "type" => "text",
            "label" => "Fax",
            "placeholder" => "",
            "text" => "",
            "value" => ""
        ],*/
        'email' => [
            "type" => "text",
            "label" => "Email",
            "placeholder" => "",
            "text" => "",
            "value" => ""
        ],
        /*'website' => [
            "type" => "text",
            "label" => "Website",
            "placeholder" => "",
            "text" => "",
            "value" => ""
        ],*/
        /*'cin_no' => [
            "type" => "text",
            "label" => "Cin number",
            "placeholder" => "",
            "text" => "",
            "value" => ""
        ],*/
        'gst_no' => [
            "type" => "text",
            "label" => "GST number",
            "placeholder" => "",
            "text" => "",
            "value" => "",
            "required" => true
        ],
    ];

    return $form;
}
}
