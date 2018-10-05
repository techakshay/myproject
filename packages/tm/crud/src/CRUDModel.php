<?php

namespace TM\Crud;

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
#use Faker\Generator as Faker;

class CRUDModel extends Model
{
    static public function form_2(){
        return [];
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

            if(isset($item['validations'])){
                if(isset($required_fields[$key])){
                    $required_fields[$key] .= "|";
                    $required_fields[$key] .= $item['validations'];
                } else {
                    $required_fields[$key] = $item['validations'];
                }

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

    static function form()
    {

        //$columns = DB::getSchemaBuilder()->getColumnListing('student');

        //$columns = array_flip($columns);

        $field =  [
            "type" => "text",
            "label" => "Full Name",
            "placeholder" => "",
            "text" => "",
            "value" => "",
            "required" => false
        ];
        $form = [];
            //unset($columns['id']);
            //unset($columns['created_at']);
            //unset($columns['updated_at']);


        /*foreach($columns as $key => $column){
            $field['label'] = studly_case($key);
            $form[$key] = $field;
        }*/

        $exclude = ['id', 'user_id', 'created_at', 'updated_at','deleted_at'];



        //dd($table_name);

        $table_name = str_plural(str_slug(class_basename(static::class)));

        if(env('DB_CONNECTION') == "pgsql") {
            $columns = DB::select("SELECT * FROM information_schema.COLUMNS WHERE TABLE_NAME = '" . $table_name . "'");
            dd($columns);
            foreach ($columns as $value) {

                //echo "'" . $value->Field . "' => '" . $value->Type . "|" . ( $value->Null == "NO" ? 'required' : '' ) ."', <br/>" ;

                if(in_array($value->column_name, $exclude)) continue;

                $field['label'] = studly_case($value->column_name);
                $field['required'] = $value->is_nullable == "NO" ? true : false;
                if($value->data_type == "tinyint(1)"){
                    $field['type'] = "boolean";
                }

                $form[$value->column_name] = $field;

                //var_dump($value->Type);
                //var_dump($value->Type == "tinyint(1)");

                //echo "'" . $value->Field . "' => '" . $value->Type . "|" . ( $value->Null == "NO" ? 'required' : '' ) ."', <br/>" ;
            }

        } else {
            $columns = DB::select('show columns from ' . $table_name);
            foreach ($columns as $value) {

                //echo "'" . $value->Field . "' => '" . $value->Type . "|" . ( $value->Null == "NO" ? 'required' : '' ) ."', <br/>" ;

                if(in_array($value->Field, $exclude)) continue;

                $field['label'] = studly_case($value->Field);
                $field['required'] = $value->Null == "NO" ? true : false;
                if($value->Type == "tinyint(1)"){
                    $field['type'] = "boolean";
                }

                $form[$value->Field] = $field;

                //var_dump($value->Type);
                //var_dump($value->Type == "tinyint(1)");

                //echo "'" . $value->Field . "' => '" . $value->Type . "|" . ( $value->Null == "NO" ? 'required' : '' ) ."', <br/>" ;
            }
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

            if(is_array($data[$field])) {
                $data[$field] = implode(",", $data[$field]);
            }


        }

        return $data;
    }

    public static function fillForm($form){

        /*$browser->attach('resume', __DIR__ . '/images/sample.pdf');
        $browser->press('submit');
        return;*/

        $faker = Factory::create();

        foreach ($form as $key => &$field) {
            //$key = $field['name'];
            //if ((!isset($item['value']) || !$item["value"]) && strstr($item['name'],"_confirmation") === false) {
            //$error_text = str_replace('_', ' ', $item['name']);
            /*if($item['type'] == "radio"){
                $browser->type($item['name'], "test");
            } else {
                $browser->type($item['name'], "test");
            }*/

            switch ($field['type']){
                case "radio":
                    $array = array_flip($field["options"]);
                    $value = end($array);
                    break;
                case "select":
                    $array = array_flip($field["options"]);
                    $value = end($array);
                    break;
                case "date":
                    if(strstr($key,"birth") !== false){
                        $faker->date("Y-m-d", "2015-01-01");
                    }
                    $value = date("Y-m-d");
                    break;
                case "text":
                    $value = $field['label'];
                    break;
                case "phone":
                    $value = $faker->numberBetween(70000, 99999) . $faker->numberBetween(10000, 99999);
                    break;
                case "email":
                    $value = $field['label']."@gmail.com";
                    break;
                case "boolean":
                    $value = 1;
                    break;

                case "password":
                    $value = "123456";
                    break;

                case "default":
                    $value = "default";
                    break;
            }

            $field['value'] = $value;

        }

        return $form;

    }

}