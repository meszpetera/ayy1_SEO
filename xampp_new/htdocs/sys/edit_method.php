<?php
//fizetési mód
include_once("common.php");

if (isauth()) {

    $res = 0;
    $muvelet = false;
    if (isset($_REQUEST['ID']) and $_REQUEST['ID']>0) {
        $muvelet=true;
        $res = update_method($_REQUEST['ID'], $_REQUEST['Name']);
        if ($res > 0) {
            $data = get_method_id($_REQUEST['ID']);
            $variables = array(
                "NAME" => $data['Name'],
                "ID" => $data['ID'],
                "SUCCES" => "A szerkesztés sikeres.",
                "PCIM" => "Beszúrandó szerkesztés"
            );
        }
    }
    
    if ((!isset($_REQUEST['ID']) or (int)$_REQUEST['ID']==0) and isset($_REQUEST['Name']) ) {
        $muvelet = true;
        
        $data = get_text_method($_REQUEST['Name']);
        if (empty($data)) {
            //insert mehet
            $res = insert_method($_REQUEST['Name']);
            if ($res > 0) {
                $data = get_method_id($res);
                $variables = array(
                    "NAME" => $data['Name'],
                    "ID" => $data['ID'],
                    "SUCCES" => "A szerkesztés sikeres.",
                    "PCIM" => "Új beszúrás készítés"
                );
            }
        } else {
            //update
            $res = update_method($data['ID'], $_REQUEST['Name']);
            if ($res > 0) {
                $data = get_method_id($data['ID']);
                $variables = array(
                    "NAME" => $data['Name'],
                    "ID" => $data['ID'],
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
                "NAME" => $_REQUEST['Name'],
                "SUCCES" => "A szerkesztés nem sikerült."
            );
        }
        $template->assign_var_array($variables);
        $main_content = $template->compile("lang/hun/edit_method");

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
                     $data = get_method_id($_REQUEST['param']);
                    //print_r($data);
                    $variables = array(
                        "NAME" => $data['Name'],
                        "ID" => $data['ID'],
                        "PCIM" => "Beszúrandó szerkesztés"
                    );
                }
            }
            $template->assign_var_array($variables);
        }

        $main_content = $template->compile("lang/hun/edit_method");

        echo($main_content);
    }
}
?>