<?php
    include_once("common.php");
    if(isauth())
    {
        $result = add_company();
        if($result == 1)
            echo '<span style="margin-bottom: 12px; font-weight:bold; font-size:14px;">Cég sikeresen felvéve.</span><br />A folytatáshoz zárja be ezt az űrlapot.<br />';
        else
        {
            $countries = "";
            
            $mysql = get_connection();
            $mysql->execute($sql['setutf']);
            $stmt = $mysql->prepare($sql['countries:query_short_list']);
            if($stmt->execute())
            {
                $result = $stmt->fetch_all();
                foreach ($result as $row)
                $countries .= '<option value="' . $row['country_id'] . '">' . $row['country_name'] . '</option>';
            }
        
            $template = new Template();
            $variables = array ("COUNTRY_LIST" => $countries
                                );

            $template->assign_var_array($variables);

            echo $template->compile("lang/hun/add_company");  //WARNING: Language hardcoded, no other languages needed
        }
        // include("lang/hun/add_company");
    }
?>