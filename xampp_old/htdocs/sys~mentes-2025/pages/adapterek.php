<?php

$promo = get_next_promo("all"); //egyelõre direkt all és nem $active_page
//echo($promo);
///exit();
$template = new Template();
$variables = array(
    "finished" => $language['finishedjobs'],
    "zoom" => $language['clicktozoom'],
    "imagelink" => $promo['big_link'],
    "defaultpic" => $promo['small_link'],
    "defaultid" => $promo['promo_id']
);

$mysql = get_connection();
$mysql->execute($sql['setutf']);
$stmt = $mysql->prepare($sql['pages:get']);
$stmt->bind_params($lang, 'adapterek');

if ($stmt->execute()) {
    $temp = $stmt->fetch_all();
    $variables['content'] = $temp[0]['content'];
} else {
    $error = "nincs ilyen oldal";
}
$template->assign_var_array($variables);

$main_content = $template->compile("sys/lang/" . $lang . "/adapterek.tpl");

include("sys/tpl/main.tpl");
?>