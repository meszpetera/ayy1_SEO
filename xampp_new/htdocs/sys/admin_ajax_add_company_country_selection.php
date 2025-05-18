<?php    
    include_once("common.php");
    
    if(isauth())
    {
        $mysql = get_connection();
        $mysql->execute($sql['setutf']);
        $stmt = $mysql->prepare($sql['countries:query_country']);
        $stmt->bind_params($_REQUEST['id']);
        if($stmt->execute())
        {
            $lol = $stmt->fetch_all();
            $lol[0]['country_phoneprefix'] = $lol[0]['country_phone-prefix'];
            echo json_encode($lol);
        }
    }    
?>