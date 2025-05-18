<?php

include_once("common.php");
if (isauth()) {
    $temp = explode('_', $_POST['id']);

    $id = $temp[1];
    $value = ( $_POST['value'] == 'true' ) ? 1 : 0;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['truck_set_public']);
    $stmt->bind_params($value, $id);
    $stmt->execute();

    //print_r($_POST);
}
?>