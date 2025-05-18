<?php
    
    include_once("common.php");
    if(isauth())
    {
        $countries = "";
        
        $mysql = get_connection();
        $mysql->execute($sql['setutf']);
        $stmt = $mysql->prepare($sql['companies:query_similar']);
        $stmt->bind_params($_REQUEST['searchstring']);
        if($stmt->execute())
        {
            $result = $stmt->fetch_all();
            foreach ($result as $row)
                $countries .= $row['company_name'] . '<br />';
        }
        echo $countries;
    }    
?>