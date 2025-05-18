<?php
  include_once("common.php");
  
  if (isauth())
  {
    if (isset($_REQUEST['truckid']) && isset($_REQUEST['imageid']))
    {
      $mysql = get_connection();
      $mysql->execute($sql['setutf']);
      
      $stmt = $mysql->prepare($sql['truck_setdefaultimage']);
      $stmt->bind_params($_REQUEST['imageid'], $_REQUEST['truckid']);
      if ($stmt->execute())
        truck_updated($_REQUEST['truckid']);      
    }
    if ($_REQUEST['returnto'] == 'truckeditor')
      redirect_in_site("?page=truckman_edit&lang=hun&truckid=" . $_REQUEST['truckid']);
    else
      redirect_in_site("?page=truckman_imageeditor&lang=hun&truckid=" . $_REQUEST['truckid']);
  }
?>