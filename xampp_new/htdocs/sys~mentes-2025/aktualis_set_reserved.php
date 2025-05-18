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
        $stmt  = $mysql->prepare($sql['truck_set-reserve']);
        $stmt->bind_params($_REQUEST['truckid'], 
        $_REQUEST['enabled'] == 'on' ? 1 : 0,
        $syear . '-' . $smonth . '-' . $sday, 
        $eyear . '-' . $emonth . '-' . $eday);
        
        if (isset($_REQUEST['menu']))
        {
            if ($stmt->execute())
                redirect_in_site('sys/admin_aktualis_truck_menu.php?result=300');
            else
                redirect_in_site('sys/admin_aktualis_truck_menu.php?result=301');
        }
        else
        {
            print("<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" /><script type=\"text/javascript\" src=\"../js/datetimepicker.js\"></script></head><body>");
            if ($stmt->execute())
            print("A foglalás sikeresen be lett állítva.");
            else
            print("A foglalás mentése nem sikerült.");

            print("</body></html>");  
        }
    }  
?>