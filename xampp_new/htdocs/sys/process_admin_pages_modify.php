<?php

include_once("common.php");
if (isauth()) {

    //print_r($_REQUEST);


    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    if (isset($_REQUEST['save'])) {
        if (intval($_REQUEST['pageid']) > 0) {
            $stmt = $mysql->prepare($sql['admin_pages:update']);
            $stmt->bind_params($_REQUEST['pageid'], $_REQUEST['page_content_hun'], $_REQUEST['page_content_eng']);
            $stmt->execute();
        } 
        redirect_in_site("?page=admin_pages&error=0&pageid=" . $_REQUEST['pageid']);
    } 
}
?>