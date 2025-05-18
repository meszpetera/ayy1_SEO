<?php

if (!loggedin() && !isauth()) {
    redirect_in_site("?page=$default_page&amp;lang=$lang");
} else {
    print(" ");
    flush();
    $editable = ismain();

    if (isset($_REQUEST['adminid'])) {
        $template = new Template();

        $mysql = get_connection();
        $mysql->execute($sql['setutf']);

        $stmt = $mysql->prepare($sql['admin_admin:get']);
        $stmt->bind_params($_REQUEST['adminid']);

        if ($stmt->execute()) {
            $temp = $stmt->fetch_all();
            $variables = $temp[0];
        } else {
            $error = "nincs ilyen számú targonca";
        }
        $variables['types'] = '<option value="255"' . ((intval($variables['users_type']) == 255) ? ' selected="selected"' : '') . '>Teljes</option>';
        $variables['types'] .= '<option value="128"' . ((intval($variables['users_type']) == 128) ? ' selected="selected"' : '') . '>Korlátozott</option>';

        /*
          if (isset($_REQUEST['error'])) {
          $error = $language['truckman_add']['error'][$_REQUEST['error']];
          }
         */

        $variables["ERROR"] = $error;

        $template->assign_var_array($variables);

        $main_content = $template->compile("sys/lang/hun/admin_editform.tpl");  //WARNING: Language hardcoded, no other languages needed    
        include("sys/tpl/main.tpl");
    } else {
        $template = new Template();
        $mysql = get_connection();
        $mysql->execute($sql['setutf']);

        $stmt = $mysql->prepare($sql['admin_admin:get_all']);

        $stmt->bind_params($sort, $filter . $filterstring);

        if ($stmt->execute()) {
            $admins = $stmt->fetch_all();

            //print_r($admins);

            $list_full = '<table width="100%">';
            $i = 0;
            foreach ($admins as $admin) {
                $list = "";
                if ($i % 30 == 0) {
                    $list .= '<tr style="background-color:#fff; font-weight:bold">' .
                            '<td >belépési név</td>' .
                            '<td >Teljes név</td>' .
                            '<td >email</td>' .
                            '<td >telefon</td>' .
                            '<td >Jog.</td>' .
                            '<td >&nbsp;</td>' .
                            '</tr>';
                }
                $bgcolor = (($i % 2 == 1) ? '#77a096' : '#88BBB3');

                $list .= '<tr style="background-color:' . $bgcolor . '">' .
                        '<td>' . $admin['users_login'] . '</td>' .
                        '<td>' . $admin['users_realname'] . '</td>' .
                        '<td>' . $admin['users_email'] . '</td>' .
                        '<td>' . $admin['users_phone'] . '</td>' .
                        '<td>' . ( ($admin['users_type'] == 255) ? 'teljes' : 'korlátozott' ) . '</td>' .
                        '<td align="center"><a href="?page=admin_edit&adminid=' . $admin['users_id'] . '">szerkesztés</a></td>' .
                        '</tr>' . "\r\n";
                $i++;
                $list_full .= $list;
            }
            $list_full .= "</table>";
        }

        //$end_time3 = microtime(true);
        $variables = array(
            "LIST" => $list_full,
            "ERROR" => $error,
        );

        $template->assign_var_array($variables);

        $main_content = $template->compile("sys/lang/hun/admin_edit.tpl");  //WARNING: Language hardcoded, no other languages needed    
        //$end_time4 = microtime(true);
        include("sys/tpl/main.tpl");
        //$end_time5 = microtime(true);
    }
}
/*  print("***Execution times***" . 
  "\n***MySQL Query time: " . ($end_time - $start_time) .
  "***\n***MySQL fetch time: " . ($end_time2 - $end_time) .
  "***\n***Table generation time: " . ($end_time3 - $end_time2) .
  "***\n***Template compilation time: " . ($end_time4 - $end_time3) .
  "***\n***Sending time: " . ($end_time5 - $end_time4) . "***");
 */
?>