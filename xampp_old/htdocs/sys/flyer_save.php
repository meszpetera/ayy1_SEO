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
    
    if (isset($_SESSION['flyer_id']))
    {
      $stmt = $mysql->prepare($sql['flyer:save']);
      $stmt->bind_params($_SESSION['flyer_id'], $_SESSION['flyer_title'], json_encode($_SESSION['flyers']));
      $stmt->execute();
    }
    else
    {
      $stmt = $mysql->prepare($sql['flyer:save_as']);
      $stmt->bind_params($_SESSION['flyer_title'], json_encode($_SESSION['flyers']));
      $stmt->execute();
      
      $stmt = $mysql->prepare($sql['flyer:saved_id']);
      $stmt->execute();
      $flyerid = $stmt->fetch_all();
      $_SESSION['flyer_id'] = $flyerid[0]['id'];

    }
    $_SESSION['flyer_changed'] = false;
    
    if ($_SESSION['flyer_title'] != "")
    {
      $savetofile = 1;
      include('flyer_createpdf.php');
      $_REQUEST['flyer_lang'] = 'hun';
      include('flyer_createpdf.php');
      $savetofile = 0;
    }
//    redirect_in_site("?page=flyer_editor&lang=hun");
    redirect_in_site("saved_flyers/" . $_SESSION['flyer_title']);
  }
?>
