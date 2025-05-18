<?php

//  $main_content = file_get_contents("sys/lang/" . $lang . "/rolunk");



$mysql = get_connection();
$mysql->execute($sql['setutf']);
$stmt = $mysql->prepare($sql['pages:get']);
$stmt->bind_params($lang, 'elerhetoseg');

if ($stmt->execute()) {
    $temp = $stmt->fetch_all();
    $variables['content'] = $temp[0]['content'];
} else {
    $error = "nincs ilyen oldal";
}


$template = new Template();
$template->assign_var_array($variables);
$main_content = $template->compile("sys/lang/" . $lang . "/elerhetoseg.tpl");

include("sys/tpl/main.tpl");
?>