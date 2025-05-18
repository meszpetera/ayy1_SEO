<?php

function add_offer_request($userid, $addto = -1)
{
  global $sql;
  $mysql = get_connection();
    $mysql->execute($sql['setutf']);
  if($mysql)
  {
    $trucks = "";
    if($_SESSION['basket'] != "")
      $trucks = implode(';', $_SESSION['basket']);
    if($addto < 0)
    {
      $stmt = $mysql->prepare($sql['add_offer_request']);
      $stmt->bind_params($userid, -1, $trucks, $_REQUEST['comment']);
    }
    else
    {
      $stmt = $mysql->prepare($sql['get_offer_request:id']);
      $stmt->bind_params($addto);
      if($stmt->execute())
      {
        if($stmt->num_rows() == 1)
        {
          $result = $stmt->fetch_row();
          $stmt2 = $mysql->prepare($sql['offer_request:update']);
          $trucks = $result['offer_trucks'] == "" ? $trucks : $result['offer_trucks'].";".$trucks;
          $stmt2->bind_params($addto, $trucks);
          if($stmt2->execute())
          {
            unset($_SESSION['basket']);
            return true;
          }
          else
          {
            return false;
          }
        }
        else
          return false;
      }
      else
      {
        return false;
      }
    }
    if($stmt->execute())
    {
      unset($_SESSION['basket']);
      return true;        
    }
    else
      return false;
  }
  else
    return false;
} 


/**
 * 
 * return values:
 * -1 if truck is alerady in basket
 * +1 if truck added to basket
 */
function add_truck_to_basket($truck_id)
{
  if (!isset($_SESSION['basket']))
  {
    $_SESSION['basket'] = array();
  }
  
  $c = count($_SESSION['basket']);
  for ($i = 0; $i < $c; $i++)
  {
    if ($_SESSION['basket'][$i] == $truck_id)
      return -1;
  }
  $_SESSION['basket'][$c] = $truck_id;
  return 1;
}

function remove_truck_from_basket($id)
{
  $c = array_search($id, $_SESSION['basket']);
  
  if($c >= 0)
  {
    array_splice($_SESSION['basket'],$c,1);
  }
}

function list_basket()
{
  global $sql;
  global $lang;
  global $language;
  
  $mysql = get_connection();    
  $mysql->execute($sql['setutf']);
     
  $result = "";
  
  $c = count($_SESSION['basket']);  
  for ($i = 0; $i < $c; $i++)
  {
    $stmt  = $mysql->prepare($sql['truck_lesserdetails']);    
    $stmt->bind_params($lang, $_SESSION['basket'][$i]);    
    if($stmt->execute())
    {
      $id = $_SESSION['basket'][$i];
      $truckdetails = $stmt->fetch_all();
      $result .= '<div id="basketitem' . $id . '" class="BasketItem"><strong>' . $truckdetails[0]['truck_saxon-id'] . '</strong> ' . 
                 $truckdetails[0]['truck_make'] . ' ' . 
                 $truckdetails[0]['truck_model'] . ' ' . 
                 '<span style="color:#666">' . $truckdetails[0]['truck_type'] . '</span> ' .  
                 '<span style="color:#009">' . (special_offer_active($truckdetails[0]) ? '<span style="text-decoration: line-through;">' . $truckdetails[0]['truck_cost'] . ' &euro;</span> <span style="color:#f00;font-weight:bold;">' . $truckdetails[0]['truck_special-offer-price'] . ' &euro;</span>': $truckdetails[0]['truck_cost'] . " &euro;") . '</span> ' . 
                 '<img id="basket_item_' . $id . '" src="img/aktualis/remove.gif" ' . 
                 'onmousemove="change_image(\'basket_item_' . $id . '\',\'img/aktualis/remove_h.gif\');" ' .
                 'onmouseout="change_image(\'basket_item_' . $id . '\',\'img/aktualis/remove.gif\');" ' .
                 'onclick="remove_truck_from_basket(' . $id . ')"' .
                 'alt="' . $_SESSION['basket'][$i] . '" style="cursor:pointer;cursor:hand;"/></div>';
    }
  }
  
  if ($result == "")
    $result = $language['aktualis-basketempty'];
  
  return $result;
}

function list_basket_footer()
{
  global $sql;
  global $lang;
  global $language;

  $c = count($_SESSION['basket']);
  if ($c != 0)
  {
    $basketmenu = '<a href="#" onClick="clear_all();">' . $language['aktualis_basket:remove_all'] . '</a>';
    if (isauth())
    {
      if (isset($_REQUEST['offer_request']))
        $basketmenu .= '<strong><a href="#" onClick="add_trucks_from_basket();" style="margin-left:10px">' . $language['aktualis_basket:offer_request_add'] . '</a></strong>';
      else if (isset($_REQUEST['auto_spec_offer']))
        $basketmenu .= '<strong><a href="#" onClick="add_trucks_from_basket();" style="margin-left:10px">' . $language['aktualis_basket:auto_spec_offer'] . '</a></strong>';
      else if (isset($_REQUEST['flyer_page']))
        $basketmenu .= '<strong><a href="#" onClick="add_trucks_to_flyer_from_basket();" style="margin-left:10px">' . $language['aktualis_basket:flyer_add'] . '</a></strong>';
      else
        $basketmenu .= '<strong><a href="#" onClick="show_finalize_request();" style="margin-left:10px">' . $language['aktualis_basket:finalize_request'] . '</a></strong>' . 
                       '<a href="sys/sticker_createpdf.php" style="margin-left:10px">' . $language['aktualis_basket:print_sticker'] . '</a>';
    }
    else
      $basketmenu .= '<strong><a href="#" onClick="show_finalize_request();" style="margin-left:10px">' . $language['aktualis_basket:finalize_request'] . '</a></strong>';
  }
  else
  {
    if (isauth())
    {
      if (isset($_REQUEST['offer_request']));
      else if (isset($_REQUEST['flyer_page']));
      else if (isset($_REQUEST['auto_spec_offer']));
      else
        $basketmenu .= '<strong><a href="#" onClick="show_finalize_request();" style="margin-left:10px">' . $language['aktualis_basket:finalize_request'] . '</a></strong>' . 
                       '<a href="sys/sticker_createpdf.php" style="margin-left:10px">' . $language['aktualis_basket:print_sticker'] . '</a>';
    }
    else
      $basketmenu .= '<strong><a href="#" onClick="show_finalize_request();">' . $language['aktualis_basket:finalize_request'] . '</a></strong>';
  }

  return $basketmenu;
}

function basket_get_last_item()
{
  global $sql;
  global $lang;
  global $language;
  
  $mysql = get_connection();    
  $mysql->execute($sql['setutf']);
     
  $result = "";
  
  $i = count($_SESSION['basket']) -1;  

  $stmt  = $mysql->prepare($sql['truck_lesserdetails']);    
  $stmt->bind_params($lang, $_SESSION['basket'][$i]);    
  if($stmt->execute())
  {
    $id = $_SESSION['basket'][$i];
    $truckdetails = $stmt->fetch_all();
    $result .= '<div id="basketitem' . $id . '" class="BasketItem"><strong>' . $truckdetails[0]['truck_saxon-id'] . '</strong> ' . 
               $truckdetails[0]['truck_make'] . ' ' . 
               $truckdetails[0]['truck_model'] . ' ' . 
               '<span style="color:#666">' . $truckdetails[0]['truck_type'] . '</span> ' . 
               '<span style="color:#009">' . $truckdetails[0]['truck_cost'] . ' &euro;</span> ' . 
               '<img id="basket_item_' . $id . '" src="img/aktualis/remove.gif" ' . 
               'onmousemove="change_image(\'basket_item_' . $id . '\',\'img/aktualis/remove_h.gif\');" ' .
               'onmouseout="change_image(\'basket_item_' . $id . '\',\'img/aktualis/remove.gif\');" ' .
               'onclick="remove_truck_from_basket(' . $id . ')"' .
               'alt="' . $_SESSION['basket'][$i] . '" /></div>';
  }

  return $result;
}

function get_basket_summary()
{
  global $sql;
  global $lang;
  
  $mysql = get_connection();    
  $mysql->execute($sql['setutf']);
     
  $result = array();
  
  $c = count($_SESSION['basket']);  
  for ($i = 0; $i < $c; $i++)
  {
    $stmt  = $mysql->prepare($sql['truck_lesserdetails']);    
    $stmt->bind_params($lang, $_SESSION['basket'][$i]);    
    
    if($stmt->execute())
    {
      $truckdetails = $stmt->fetch_all();      
      $result[$i]['saxon-id'] = $truckdetails[0]['truck_saxon-id'];
      $result[$i]['make'] = $truckdetails[0]['truck_make'];
      $result[$i]['model'] = $truckdetails[0]['truck_model'];
      $result[$i]['type'] = $truckdetails[0]['truck_type'];     
      $result[$i]['cost'] = (special_offer_active($truckdetails[0]) ? '<span style="text-decoration: line-through;">' . $truckdetails[0]['truck_cost'] . ' &euro;</span><br /><span style="color:#f00;font-weight:bold;">' . $truckdetails[0]['truck_special-offer-price'] . ' &euro;</span>': $truckdetails[0]['truck_cost'] . " &euro;");
      $result[$i]['cost-int'] = (special_offer_active($truckdetails[0]) ? $truckdetails[0]['truck_special-offer-price'] : $truckdetails[0]['truck_cost']);      
    }
  }

  return $result;
}

function clear_basket()
{
  unset($_SESSION['basket']);
}

function recurse_copy($src,$dst) 
{ 
  $dir = opendir($src); 
  @mkdir($dst); 
  while(false !== ( $file = readdir($dir)) ) 
  { 
    if (( $file != '.' ) && ( $file != '..' )) 
    { 
      if ( is_dir($src . '/' . $file) ) 
      { 
        recurse_copy($src . '/' . $file,$dst . '/' . $file); 
      } 
      else 
      { 
        copy($src . '/' . $file,$dst . '/' . $file); 
      } 
    } 
  } 
  closedir($dir); 
} 
  
?>