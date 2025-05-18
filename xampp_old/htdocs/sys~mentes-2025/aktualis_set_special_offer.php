<?php
    include_once("common.php");

    if(!loggedin() || !isauth())
        print('Please log in to use this feature.');
    else
    {
        $mysql = get_connection();    
        $mysql->execute($sql['setutf']);
        $startdate = explode("-", $_REQUEST['startdate']);
        $enddate = explode("-", $_REQUEST['enddate']);
        $sday = $startdate[0];
        $smonth = $startdate[1];
        $syear = $startdate[2];
        $eday = $enddate[0];
        $emonth = $enddate[1];
        $eyear = $enddate[2];
        // echo($syear . '-' . $smonth . '-' . $sday);
        // exit();
        $stmt  = $mysql->prepare($sql['truck_setspecialoffer']);
        $stmt->bind_params($_REQUEST['truckid'], 
                   $_REQUEST['enabled'] == 'on' ? 1 : 0,
                   $syear . '-' . $smonth . '-' . $sday, 
                   $eyear . '-' . $emonth . '-' . $eday,
                   $_REQUEST['special_offer_price']);
                   
        if (isset($_REQUEST['menu']))
        {
            if ($stmt->execute())
                redirect_in_site('sys/admin_aktualis_truck_menu.php?result=200&id=' . $_REQUEST['truckid']);
            else
                redirect_in_site('sys/admin_aktualis_truck_menu.php?result=201&id=' . $_REQUEST['truckid']);
        }
        else
        {
            print("<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" /><script type=\"text/javascript\" src=\"../js/datetimepicker.js\"></script></head><body>");
            if ($stmt->execute())
                print("Az akciós ár sikeresen be lett állítva."); 
            else
                print("Az akció mentése nem sikerült.");

            print("</body></html>");  
        }
    }  
?>