<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CRUDModel extends Model
{
    static public function form(){
        return [];
    }

    public function user(){

        return $this->belongsTo(User::class);

    }



    static function array_data($name = "name", $extra = [], $conditions = []){

        //dd($conditions['where']);

        /*   $users = $this->users;*/

        /*$company_id = auth()->user()->company_id;

        if ($company_id == 3) {

            $data = static::select('name', 'id')->get();
        } else {
            $data = static::select('name', 'id')->where('id', $company_id)->get();
        }*/

        $cols = ["id", $name];
        if(count($extra)){
            $cols = array_merge($cols, $extra);
        }
        $data = static::select($cols);

        if(isset($conditions['where'])) {
            foreach ($conditions['where'] as $key => $val) {
                $data = $data->where($key, $val);
            }
        }
            $data = $data->get();
        //$data = $data->count();dd($data);

        $new_data = ["" => "Select"];
        foreach($data as $item){
            $extra_text = "";
            if(count($extra)){
                foreach($extra as $key){
                    $extra_text .= " - ".$item->$key;
                }
            }
            $new_data[$item->id] = $item->$name . $extra_text;
        }

        return $new_data;

    }

    static function required_fields(){
        $form = static::form();
        $required_fields = [];
        foreach($form as $key => $item){

            if(isset($item['required']) && $item['required']){
                $required_fields[$key] = "required";
            }
        }

        return $required_fields;
    }

    public static function edit_form($data){

        $form['fields'] = static::form();
        foreach($form['fields'] as $key => &$item){
            $item['value'] = $data->$key;
        }

        return $form;
    }
    static function object_data($name = "name"){
        /*   $users = $this->users;*/

        /*$company_id = auth()->user()->company_id;

        if ($company_id == 3) {

            $data = static::select('name', 'id')->get();
        } else {
            $data = static::select('name', 'id')->where('id', $company_id)->get();
        }*/

        $data = static::select('id','name')->get();
        /*$new_data[] = ["id" => "", "name" => "Select"];
        foreach($data as $item){
            $new_data[] = ["id" => $item->id, "name" => $item->name];
        }*/

        return $data;

    }

    static function multi_fields(){
        $fields = static::form();
        $multi = [];
        foreach($fields as $key => $field){
            if($field['type'] == "multi"){
                $multi[] = $key;
            }

        }

        return $multi;
    }

    static function correct_data($data){
        $fields = static::multi_fields();

        foreach($fields as $key => $field){

            $data[$field] =  implode(",", $data[$field]);


        }

        return $data;
    }

}