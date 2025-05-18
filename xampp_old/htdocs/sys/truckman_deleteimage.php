<?php
  include_once("common.php");
  
  if (isauth())
  {
    if (isset($_REQUEST['truckid']) && isset($_REQUEST['imageid']))
    {
      $mysql = get_connection();
      $mysql->execute($sql['setutf']);
      
      $stmt = $mysql->prepare($sql['truck_getimage']);
      $stmt->bind_params($_REQUEST['truckid'], $_REQUEST['imageid']);
      if($stmt->execute())
      {
        $img = $stmt->fetch_all();
        $filename = $img[0]['image_filename'];        
        
        $stmt = $mysql->prepare($sql['truck_deleteimage']);
        $stmt->bind_params($_REQUEST['truckid'], $_REQUEST['imageid']);
        if($stmt->execute())
        {
          truck_updated($_REQUEST['truckid']);
          unlink("../img/trucks/" . $filename);
          unlink("../img/trucks/" . str_replace(".jpg", "_max.jpg", $filename));
          $stmt = $mysql->prepare($sql['truck_updateimages']);
          $stmt->bind_params($_REQUEST['truckid'], $_REQUEST['imageid']);
          if(!$stmt->execute())
          {
            print("shit");
            return;
          }  
          
          $stmt = $mysql->prepare($sql['truck_lesserdetails']);
          $stmt->bind_params("hun", $_REQUEST['truckid']);
          $stmt->execute();
          $truck = $stmt->fetch_all();
          
          if ($truck[0]['truck_default-image'] > $_REQUEST['imageid'])
          {
            $stmt = $mysql->prepare($sql['truck_setdefaultimage']);
            $stmt->bind_params($truck[0]['truck_default-image'] - 1, $_REQUEST['truckid']);
            $stmt->execute();
          }
          else if ($truck[0]['truck_default-image'] == $_REQUEST['imageid'])
          {
            $stmt = $mysql->prepare($sql['truck_setdefaultimage']);
            $stmt->bind_params(0, $_REQUEST['truckid']);
            $stmt->execute();
          }
        }
      }
    }
    if ($_REQUEST['returnto'] == 'truckeditor')
      redirect_in_site("?page=truckman_edit&lang=hun&truckid=" . $_REQUEST['truckid']);
    else
      redirect_in_site("?page=truckman_imageeditor&lang=hun&truckid=" . $_REQUEST['truckid']);
  }
?>