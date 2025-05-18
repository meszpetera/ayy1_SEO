<?php
    if(!loggedin() || !isauth())
    {
        redirect_in_site("?page=$default_page&lang=$lang");
    }
    else
    {  
        $arr = getAutoSpecOfferTrucks();
        $list = '<table>';
        foreach ($arr as $key => $value)
        {
            $list .= '<tr><td>' . $value['truck_saxon-id'] . '</td><td><a href="sys/admin_ajax_remove_auto_spec_offer.php?truckid=' . $value['truck_id'] . '">elt&aacute;vol&iacute;t&aacute;s</a></td></tr>';
        }

        $list .= '</table>';


        $template = new Template();    
        $variables = array("LIST" => $list);
        $template->assign_var_array($variables);
        $main_content = $template->compile("sys/lang/hun/admin_edit_auto_spec_offer");  //WARNING: Language hardcoded, no other languages needed    
        include("sys/tpl/main.tpl");
    }
 ?>