<?php

if (!loggedin() && !isauth()) {
    redirect_in_site("?page=$default_page&amp;lang=$lang");
} else {
    print(" ");
    flush();
    $editable = ismain();

    if (isset($_REQUEST['pageid'])) {
        $template = new Template();

        $mysql = get_connection();
        $mysql->execute($sql['setutf']);

        $stmt = $mysql->prepare($sql['admin_pages:get']);
        $stmt->bind_params($_REQUEST['pageid']);

        if ($stmt->execute()) {
            $temp = $stmt->fetch_all();
            $variables = $temp[0];
        } else {
            $error = "nincs ilyen oldal";
        }

        /*
          if (isset($_REQUEST['error'])) {
          $error = $language['truckman_add']['error'][$_REQUEST['error']];
          }
         */

        $variables["ERROR"] = $error;

        $template->assign_var_array($variables);

        $main_content = $template->compile("sys/lang/hun/admin_pages_form.tpl");  //WARNING: Language hardcoded, no other languages needed    
        include("sys/tpl/main.tpl");
    } else {
        $template = new Template();
        $mysql = get_connection();
        $mysql->execute($sql['setutf']);

        $stmt = $mysql->prepare($sql['admin_pages:get_all']);

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
                            '<td >HUN</td>' .
                            '<td >ENG</td>' .
                            '<td >&nbsp;</td>' .
                            '</tr>';
                }
                $bgcolor = (($i % 2 == 1) ? '#77a096' : '#88BBB3');

                $list .= '<tr style="background-color:' . $bgcolor . '">' .
                        '<td>' . $admin['page_title_hun'] . '</td>' .
                        '<td>' . $admin['page_title_eng'] . '</td>' .
                        '<td align="center"><a href="?page=admin_pages&pageid=' . $admin['page_id'] . '">szerkesztés</a></td>' .
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

        $main_content = $template->compile("sys/lang/hun/admin_pages.tpl");  //WARNING: Language hardcoded, no other languages needed    
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