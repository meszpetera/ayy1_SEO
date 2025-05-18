<?php

include_once("common.php");
if (isauth()) {
    $res = 0;
    $template = new Template();
    $jelzo = false;
    $muvelet = false;
    if (isset($_REQUEST['delete_id']) and $_REQUEST['delete_id'] > 0) {
        $muvelet = true;
        $res = delete_inserttext($_REQUEST['delete_id']);
        if ($res > 0) {
            $jelzo = true;
            $variables = array(
                "SUCCES" => "A törlés megtörtént.",
                "PCIM" => "Törlés"
            );
        } else {
            $variables = array(
                "SUCCES" => "A törlés nem sikerült.",
                "PCIM" => "Törlés"
            );
        }
        $template->assign_var_array($variables);
    }

    if ((!isset($_REQUEST['delete_id']) or (int) $_REQUEST['delete_id'] == 0) and isset($_REQUEST['delete_name'])) {
        $muvelet = true;

        $data = get_text_inserttext($_REQUEST['delete_name']);
        $variables = array(
            "CIM" => $data['insert_name'],
            "TARTALOM" => $data['insert_value'],
            "DELETE_ID" => $data['insert_id'],
            "PCIM" => "Cimke törlés"
        );
        $template->assign_var_array($variables);
    }



    if (isset($_REQUEST['param'])) {
        $data = get_text_inserttext($_REQUEST['param']);
        $variables = array(
            "CIM" => $data['insert_name'],
            "TARTALOM" => $data['insert_value'],
            "DELETE_ID" => $data['insert_id'],
            "PCIM" => "Cimke törlés"
        );
        $template->assign_var_array($variables);
    }

    if (!$muvelet and !isset($_REQUEST['param'])) {
        $main_content = $template->compile("lang/hun/delete_ures_text");
    } else {
        if ($jelzo) {
            $main_content = $template->compile("lang/hun/delete_ok_text");
        } else {
            $main_content = $template->compile("lang/hun/delete_text");
        }
    }

    echo($main_content);
}
?>