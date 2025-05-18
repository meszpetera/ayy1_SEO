<?php
  include_once("common.php");

  if(!loggedin() || !isauth())
  {
    redirect_in_site("?page=$default_page&lang=$lang");
  }
  else
  {  
    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['flyer:get_flyer']);
    $stmt->bind_params($_REQUEST['id']);
    if($stmt->execute())
    {
      $flyer = $stmt->fetch_all();
      $_SESSION['flyers'] = json_decode($flyer[0]['flyer_data'], true);
      $_SESSION['flyer_id'] = $_REQUEST['id'];
      $_SESSION['flyer_title'] = $flyer[0]['flyer_title'];
    }
    $_SESSION['flyer_changed'] = false;
    redirect_in_site("?page=flyer_editor&lang=hun");
  }
?>
