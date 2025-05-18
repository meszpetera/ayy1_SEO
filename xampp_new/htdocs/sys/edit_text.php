<?php

include_once("common.php");
if (isauth()) {

    $res = 0;
    $muvelet = false;
    if (isset($_REQUEST['insert_id']) and $_REQUEST['insert_id']>0) {
        $muvelet=true;
        $res = update_inserttext($_REQUEST['insert_id'], $_REQUEST['insert_name'], $_REQUEST['insert_value']);
        if ($res > 0) {
            $data = get_inserttext_id($_REQUEST['insert_id']);
            $variables = array(
                "CIM" => $data['insert_name'],
                "TARTALOM" => $data['insert_value'],
                "INSERT_ID" => $data['insert_id'],
                "SUCCES" => "A szerkesztés sikeres.",
                "PCIM" => "Beszúrandó szerkesztés"
            );
        }
    }
    
    if ((!isset($_REQUEST['insert_id']) or (int)$_REQUEST['insert_id']==0) and isset($_REQUEST['insert_name']) and isset($_REQUEST['insert_value'])) {
        $muvelet = true;
        
        $data = get_text_inserttext($_REQUEST['insert_name']);
        if (empty($data)) {
            //insert mehet
            $res = insert_inserttext($_REQUEST['insert_name'], $_REQUEST['insert_value']);
            if ($res > 0) {
                $data = get_inserttext_id($res);
                $variables = array(
                    "CIM" => $data['insert_name'],
                    "TARTALOM" => $data['insert_value'],
                    "INSERT_ID" => $data['insert_id'],
                    "SUCCES" => "A szerkesztés sikeres.",
                    "PCIM" => "Új beszúrás készítés"
                );
            }
        } else {
            //update
            $res = update_inserttext($data['insert_id'], $_REQUEST['insert_name'], $_REQUEST['insert_value']);
            if ($res > 0) {
                $data = get_inserttext_id($data['insert_id']);
                $variables = array(
                    "CIM" => $data['insert_name'],
                    "TARTALOM" => $data['insert_value'],
                    "INSERT_ID" => $data['insert_id'],
                    "SUCCES" => "A szerkesztés sikeres.",
                    "PCIM" => "Beszúrandó szerkesztés"
                );
            }
        }
    }
    if ($muvelet) {

        $template = new Template();
        if ($res == 0) {
            $variables = array(
                "CIM" => $_REQUEST['insert_name'],
                "TARTALOM" => $_REQUEST['insert_value'],
                "SUCCES" => "A szerkesztés nem sikerült."
            );
        }
        $template->assign_var_array($variables);
        $main_content = $template->compile("lang/hun/edit_text");

        echo($main_content);
    } else {
        $template = new Template();

        if (isset($_REQUEST['tip'])) {
            if ($_REQUEST['tip'] == 1) {


                $variables = array(
                    "PCIM" => "Új beszúrás készítés"
                );
            } else {
                //ha nincs param, akkor nem szerkesztés
                if (!isset($_REQUEST['param'])) {
                    $variables = array(
                        "PCIM" => "Új beszúrás készítés(nem választott)"
                    );
                } else {
                    //kiszedem az id-t
                    $data = get_text_inserttext($_REQUEST['param']);
                    //print_r($data);
                    $variables = array(
                        "CIM" => $data['insert_name'],
                        "TARTALOM" => $data['insert_value'],
                        "INSERT_ID" => $data['insert_id'],
                        "PCIM" => "Beszúrandó szerkesztés"
                    );
                }
            }
            $template->assign_var_array($variables);
        }

        $main_content = $template->compile("lang/hun/edit_text");

        echo($main_content);
    }
}
?>