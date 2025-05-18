<?php

include_once('common.php');

if (!loggedin() || !isauth()) {
    redirect_in_site("?page=$default_page&lang=$lang");
} else {
    $mysql = get_connection();
    $mysql->execute($sql['setutf']);

    $toenable = "";
    $IDs = array();

    foreach ($_REQUEST as $key => $value) {
        if (mb_substr($key, 0, 4) == 'make') {
            $key = mb_substr($key, 4);
            $lng = mb_substr($key, 0, 3);
            $key = mb_substr($key, 3);

            //print("key: $key; lng: $lng<br/>");

            if ($value == "") {
                //delete
                $stmt = $mysql->prepare($sql['admin_edit_make:delete']);
                $stmt->bind_params($lng, $key);
                //print('deleting ' . $lng . '::' . $key . '<br />');
                if (!$stmt->execute())
                    print('deleting failed @ "' . $key . '":"' . $value . '"<br />');
            } else {
                //update or insert
                if ($key[0] == 'X') {
                    //insert new
                    if (!isset($IDs[$key])) {
                        $stmt = $mysql->prepare($sql['admin_edit_make:insertNoID']);
                        $stmt->bind_params($lng, $value);
                        //print($_REQUEST['ispart']);
                        if ($stmt->execute()) {
                            $stmt = $mysql->prepare("SELECT LAST_INSERT_ID() as `id`");
                            if ($stmt->execute()) {
                                $typelist = $stmt->fetch_all();
                                $IDs[$key] = $typelist[0]['id'];
                            }
                        }
                    } else {
                        $stmt = $mysql->prepare($sql['admin_edit_make:insert']);
                        $stmt->bind_params($lng, $IDs[$key], $value);
                        $stmt->execute();
                    }

                    //print('creating ' . $lng . '::' . $key . ' as ' . $value . '<br />');
                } else {
                    //update or insert
                    $stmt = $mysql->prepare($sql['admin_edit_make:query']);
                    $stmt->bind_params($lng, $key);
                    if ($stmt->execute()) {
                        $typelist = $stmt->fetch_all();
                        if ($typelist[0]['result'] == 1) {
                            //update
                            $stmt = $mysql->prepare($sql['admin_edit_make:update']);
                            $stmt->bind_params($lng, $value, $key);
//                                print('updating ' . $lng . '::' . $key . ' to ' . $value . '<br />');
                            if (!$stmt->execute())
                                print('updating failed @ "' . $key . '":"' . $value . '"<br />');
                        }
                        else {
                            //insert
                            $stmt = $mysql->prepare($sql['admin_edit_make:insert']);
                            $stmt->bind_params($lng, $key, $value);
                            $stmt->execute();
                        }
                    }
                }
            }
        } else if (mb_substr($key, 0, 6) == 'ispart') {
            $id = mb_substr($key, 6);
            $toenable .= ($toenable != "" ? "," : "") . "'$id'";
        }
    }

    /*
      foreach($available_langs as $value)
      {
      $stmt = $mysql->prepare($sql['admin_edit_make:update_ispart_enable']);
      $stmt->bind_params($value, $toenable);
      $stmt->execute();
      $stmt = $mysql->prepare($sql['admin_edit_make:update_ispart_disable']);
      $stmt->bind_params($value, $toenable);
      $stmt->execute();
      } */

    redirect_in_site("?page=admin_edit_make&lang=$lang");
}
?>