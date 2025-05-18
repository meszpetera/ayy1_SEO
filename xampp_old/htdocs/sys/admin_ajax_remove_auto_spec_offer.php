<?php
    include_once('common.php');

    if(!loggedin() || !isauth())
    {
        redirect_in_site("?page=$default_page&lang=$lang");
    }
    else
    {  
        removeAutoSpecOffer($_REQUEST['truckid']);
        redirect_in_site("?page=admin_edit_auto_spec_offer&lang=$lang");
    }
 ?>