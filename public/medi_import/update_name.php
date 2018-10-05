<?php
define('DB_NAME', 'billing');
require_once('../../queries/config.php');
set_time_limit(0);
$import_db = 1;
$create_csv = 1;
$clear_prev_data = 1;

/*
 * Get Data From CSV
 * ITEM.csv
 * COMPANY.csv
 */
$company_list = company_list("full_names.csv");
$item_list = readCSV("new_item_list5.csv");


if($clear_prev_data){
    clear_prev_data();
}

convert_csv_file($item_list, $company_list, "new_item_list6.csv");
/*
 * Functions
 */
function convert_csv_file($item_list, $company_list, $output_file)
{

    global $create_csv, $import_db;

    $fp = fopen($output_file, 'w');
    //$someJSON = json_encode($item_list);
    $count = 0;
    //$final_array = [];
    foreach ($item_list as &$fields) {

        if($count == 0){
            $count++;
            continue;
        }

        $id = $fields[0];
        $product_name = $fields[1];
        $potency = $fields[2];
        $packing = $fields[3];
        $company = $fields[4];
        $short_name = $fields[5];
        $hsn_code = $fields[6];

        if ($count != 0) {
            $product_name = $company_list[$product_name];
        }

        //if($count < 100){
        /*   foreach (range(1, 5) as $key) {
               $name = str_replace("  ", " ", $name);
           }

           $array = explode(" ", $name);
           $packing = array_pop($array);
           $potency = array_pop($array);

           $product_name = implode(" ", $array);

           if ($count === 0) {
               $product_name = "Name";
               $potency = "Potency";
               $packing = "Packing";
           }*/

        $api_error = 0;
        if (!$product_name) {
            $api_error = 1;
        }

        $mfg_code = $company;
        $created_at = $updated_at = date("Y-m-d H:i:s");

        if ($create_csv) {
            fputcsv($fp, compact('id', 'product_name', 'potency', 'packing', 'company', 'short_name', 'hsn_code'));
        }

        if ($import_db) {
            $post_data = compact('product_name', 'potency', 'packing', 'hsn_code', 'mfg_code', 'short_name', 'api_error', 'created_at', 'updated_at');
            insert_data('items', $post_data);
        }

        $count++;
    }
}


function readCSV($filename){
    $file_handle = fopen($filename, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
    return $line_of_text;
}

function company_list($filename){

    $company_list_data = readCSV($filename);
    $output = [];
    foreach ($company_list_data as $company){
        if(!isset($company[1]))
        {
            $output[$company[0]] = $company[0];
        }
        else {
            $output[$company[0]] = $company[1];
        }
    }
    return $output;
}

function clear_prev_data(){
    delete_all('items');
}

?>