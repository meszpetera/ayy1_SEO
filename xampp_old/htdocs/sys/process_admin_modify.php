<?php

include_once("common.php");
if (isauth()) {

    //print_r($_REQUEST);


    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    if (isset($_REQUEST['save'])) {
        if (intval($_REQUEST['adminid']) > 0) {
            $stmt = $mysql->prepare($sql['admin_admin:update']);
            $stmt->bind_params($_REQUEST['adminid'], $_REQUEST['users_login'], $_REQUEST['users_realname'], $_REQUEST['users_email'], $_REQUEST['users_phone'], $_REQUEST['users_type']);
            $stmt->execute();
        } else {
            $stmt = $mysql->prepare($sql['admin_admin:insert']);
            $stmt->bind_params($_REQUEST['adminid'], $_REQUEST['users_login'], $_REQUEST['users_realname'], $_REQUEST['users_email'], $_REQUEST['users_phone'], $_REQUEST['users_type']);
            $stmt->execute();
            $_REQUEST['adminid'] = $stmt->insert_id();
        }
        if ($_REQUEST['new_password'] != '') {
            $stmt = $mysql->prepare($sql['admin_admin:update_password']);
            $stmt->bind_params($_REQUEST['adminid'], $_REQUEST['new_password']);
            $stmt->execute();
        }
        redirect_in_site("?page=admin_edit&error=0&adminid=" . $_REQUEST['adminid']);
    } elseif (isset($_REQUEST['delete'])) {
        $stmt = $mysql->prepare($sql['admin_admin:delete']);
        $stmt->bind_params($_REQUEST['adminid']);
        $stmt->execute();
        redirect_in_site("?page=admin_edit&error=0");
    }
}
?>