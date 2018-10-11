<?php
include('config.php');

//Select query
$data = "select*from table_name";
$data = query_data_single($data);

$data = query_data($data);

//Insert query
$data = $_POST;
insert_data('table_name', $data);


//Update
$query = "Update table_name set field where condition";
$query = "Update users set name='abc' where id =2";
update_query($query);
?>