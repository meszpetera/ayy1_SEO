<?php
  include_once("common.php");

  if(isset($_REQUEST['id']))
  {
    if(isset($_REQUEST['site'])) //direkt site a js miatt, de amugyse nagyon fog kelleni
      $site = $_REQUEST['site'];
    else
      $site = "all";    
          
    $promo = get_next_promo($site, $_REQUEST['id']);
    echo $promo['small_link'].';'.$promo['big_link'].';'.$promo['promo_id'];
  }
?>