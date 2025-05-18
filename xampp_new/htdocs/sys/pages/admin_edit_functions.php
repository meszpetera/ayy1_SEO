<?php

if (!loggedin() || !isauth()) {
    redirect_in_site("?page=$default_page&lang=$lang");
} else {

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['admin_edit_function:list']);
    //$stmt->bind_params($_REQUEST['ispart']);
    if ($stmt->execute()) {
        $typelist = $stmt->fetch_all();

        $list = '<tr><td>magyar</td><td>angol</td><td>német</td></tr>';

        foreach ($typelist as $type) {
            $list .= '<tr>';
            $list .= '<td>' . '<input style="width:200px;" name="makehun' . $type['ID'] . '" value="' . $type['hunvalue'] . '" width="60" /></td>';
            $list .= '<td>' . '<input style="width:200px;" name="makeeng' . $type['ID'] . '" value="' . $type['engvalue'] . '" width="28" /></td>';
            $list .= '<td>' . '<input style="width:200px;" name="makeger' . $type['ID'] . '" value="' . $type['gervalue'] . '" width="30" /></td>';
//        $list .= '<td>' . '<input type="checkbox" name="ispart' . $type['ID'] . '" '. ($type['ispart'] == 0 ? "checked" : "") . '"/></td>';
            $list .= '</tr>';
        }
    }

    $template = new Template();
    $variables = array("LIST" => $list);
    $template->assign_var_array($variables);
    $main_content = $template->compile("sys/lang/hun/admin_edit_functions");  //WARNING: Language hardcoded, no other languages needed    
    include("sys/tpl/main.tpl");
}
?>