<?php
/*
 * @created By Lalit
 */
function pre($value, $die = false)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    if($die){
        die;
    }
}

/*
 * @created By Lalit
 */
function split_array($array, $columns){
    return array_chunk($array, ceil(count($array)/$columns), true);
}

/*
 * @created By Lalit
 */
function title_string($string){
    return str_replace("_"," ",title_case($string));
}

function array_display($array, $remove = []){

    //pre($array,1);
    $remove = array_merge(["id", "created_at", "updated_at", "deleted_at"], $remove);
    //pre($remove,1);
    /*foreach($array as $key => $item){
        var_dump($key);
    }*/
    if(isset($array["dob_flag"]) && $array["dob_flag"]){
        //unset($array["date_of_birth"]);
        $array["date_of_birth"] = "";
    }

    foreach($remove as $key) {
        /*var_dump($key);
        var_dump(isset($array[$key]));
        var_dump(array_key_exists($key, $array));*/
        if (array_key_exists($key, $array)) {
            unset($array[$key]);
        }
    }



    $update_values = ['user_id' => [1, "Admin"]];

    foreach($update_values as $key => $value) {
        if (isset($array[$key])) {
            //$array[$value] = $array[$key];
            $array[$key] = str_replace($value[0],$value[1],$array[$key]);
        }
    }

    $update_keys = ['user_id' => "created_by"];

    foreach($update_keys as $key => $value) {
        if (isset($array[$key])) {
            $array[$value] = $array[$key];
            unset($array[$key]);
        }
    }

    return $array;
}

function array_display_keys($array, $remove = []){

    $array = array_flip($array);
    $array = array_display($array, $remove);
    $array = array_keys($array);
    return $array;
}