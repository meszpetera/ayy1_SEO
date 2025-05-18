<?php
    include_once("common.php");
  
    if(!loggedin() || !isauth())
        print('Please log in to use this feature.');
    else
    {
        $mysql = get_connection();    

        $stmt = $mysql->prepare($sql['offer_requests_edit:remove_saxon_id']);    
        $stmt->bind_params($_REQUEST['offerid'], $_REQUEST['truckid']);    
        if($stmt->execute())
        {
        }

        print('done');
    }
?>