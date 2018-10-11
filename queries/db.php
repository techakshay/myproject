<?php
function insert_data($table, $post_data)
{

    global $conn;
    $sql = "INSERT INTO $table (" . implode(",", array_keys($post_data)) . ") values('" . implode("','", $post_data) . "')";
    $conn->query($sql);

    if ($conn->error) {
//echo $conn->error;
//echo $conn->errno;
        if (SHOW_SQL_ERRORS) {
            var_dump($post_data);
            $error = $conn->error;
        } else {
            if ($conn->errno == 1062) {
                $error = "Duplicate Entry!";
            } else {
                $error = "Something went wrong!";
            }
        }
        $_SESSION['error_message'] = $error;
        return false;
    }

    return $conn->insert_id;
}

function db_query($query)
{
    global $conn;

    $result = $conn->query($query);

    if ($conn->error) {
        die($conn->error);
    }

    return $result;

}

function query_data_single($query)
{
    global $conn;
    $result = $conn->query($query);
    if ($conn->error) {
        die($conn->error);
    }
    $prev_count = 0;
    $data = [];
    if ($result->num_rows) {

        $data = $result->fetch_assoc();
    }
    return $data;
}

function query_data($query)
{
    global $conn;

    $result = $conn->query($query);

    if ($conn->error) {
        echo $conn->error;
        die($conn->error);
    }

    $prev_count = 0;
    $data = [];
    if ($result->num_rows) {

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        };

    } else {
        //echo "no data found";
    }

    return $data;
}

function update_data($table, $fields, $where)
{

    foreach ($fields as $key => $value) {
        //$value = implode(",",$value);
        $update_params[] = $key . "='" . $value . "'";
    }
    foreach ($where as $key => $value) {
        //$value = is_array($value) ? implode(",",$value) : $value;
        $where_params[] = $key . "='" . $value . "'";
    }

    $fields_query = implode(",", $update_params);
    $where_query = implode(",", $where_params);

//print_r($update_params);
    $sql = "UPDATE  $table SET " . $fields_query . " WHERE " . $where_query;

    db_query($sql);
}

function delete_all($table){
    //$sql = "DELETE FROM $table";
    $sql = "TRUNCATE TABLE $table;";

    db_query($sql);
}


?>