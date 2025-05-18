<?php
    if (isauth())
    {
        if (isset($_REQUEST['truckid1']) && isset($_REQUEST['truckid2']) && isset($_REQUEST['truckid3']) && isset($_REQUEST['truckid4']))
        {
            setFeatured($_REQUEST['truckid1'], $_REQUEST['truckid2'], $_REQUEST['truckid3'], $_REQUEST['truckid4']);
        }
        else if (isset($_REQUEST['truckid']))
        {
            pushFeatured($_REQUEST['truckid']);
            redirect_in_site('sys/admin_aktualis_truck_menu.php?result=400');
        }

        $featured = getFeatured();
        $mysql = get_connection();

        $SAXONID_LIST_1 = '<option value="">' . $language['truck-details_saxon-id'] . '</option>';
        $SAXONID_LIST_2 = '<option value="">' . $language['truck-details_saxon-id'] . '</option>';
        $SAXONID_LIST_3 = '<option value="">' . $language['truck-details_saxon-id'] . '</option>';
        $SAXONID_LIST_4 = '<option value="">' . $language['truck-details_saxon-id'] . '</option>';

        $stmt = $mysql->prepare($sql['daily_offer:query_saxonID_list']);
        if($stmt->execute())
        {
            $result = $stmt->fetch_all();
            foreach ($result as $row)
            {
                $SAXONID_LIST_1 .= '<option value="' . $row['truck_id'] . '"' . (($row['truck_id'] == $featured[0]) ? ' selected' : '') . '>' . $row['truck_saxon-id'] . '</option>';
                $SAXONID_LIST_2 .= '<option value="' . $row['truck_id'] . '"' . (($row['truck_id'] == $featured[1]) ? ' selected' : '') . '>' . $row['truck_saxon-id'] . '</option>';
                $SAXONID_LIST_3 .= '<option value="' . $row['truck_id'] . '"' . (($row['truck_id'] == $featured[2]) ? ' selected' : '') . '>' . $row['truck_saxon-id'] . '</option>';
                $SAXONID_LIST_4 .= '<option value="' . $row['truck_id'] . '"' . (($row['truck_id'] == $featured[3]) ? ' selected' : '') . '>' . $row['truck_saxon-id'] . '</option>';
            }
        }

        $template = new Template();
        $variables = array ("SAXONID_LIST_1" => $SAXONID_LIST_1,
                            "SAXONID_LIST_2" => $SAXONID_LIST_2,
                            "SAXONID_LIST_3" => $SAXONID_LIST_3,
                            "SAXONID_LIST_4" => $SAXONID_LIST_4
                            );

        $template->assign_var_array($variables);
        $main_content = $template->compile("sys/lang/" . $lang . "/admin_select_featured");

        include("sys/tpl/main.tpl");
    }
?>