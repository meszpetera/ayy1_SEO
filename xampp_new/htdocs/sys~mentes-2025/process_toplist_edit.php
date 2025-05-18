<?php

include_once("common.php");
if (isauth() && isset($_POST['list']) && intval($_POST['list']) > 0) {

    $list = intval($_POST['list']);

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);

    $mysql->execute('DELETE FROM `trucks_toplist` WHERE list_number = ' . $list . ';');

    foreach (explode(',', $_REQUEST['toplist']) as $k => $id) {
        $id = trim($id);
        if ($id != '') {
            $mysql->execute('INSERT INTO `trucks_toplist` ( `list_number`, `truck_saxon-id`, `truck_order`) VALUES ( ' . $list . ', "' . $id . '", ' . $k . ' ) ;');
        }
    }

    redirect_in_site("?page=toplist_edit&list={$list}&save=1");
}
?>