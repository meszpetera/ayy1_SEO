<?php
function get_flyer_cell($cell, $cellid)
{
  if (!isset($cell) || ($cell['saxon-id'] == ""))
    return "&nbsp;";
  else if ($cellid != -1)
  {
    return '<img src="img/trucks/' . get_truck_default_image($cell['id']) . '" style="width:120px; height:90px" /><br />' . 
           $cell['saxon-id'] . ' <img id="cell_img_' . $cellid . '" src="img/flyer/cancel.png" onClick="remove_truck_from_cell(' . $cellid . ');"' .
           'alt="cella kiürítése" style="cursor:pointer;cursor:hand;"/> ' . 
           '<a href="?page=truckman_edit&lang=hun&truckid=' . $cell['id'] . '&retaddr=' . $_REQUEST['page'] . '&pageid=' . $_REQUEST['pageid'] . '"><img id="cell_img_' . $cellid . '" src="img/flyer/edit.png" ' .
           'onclick="edit_truck(' . $cellid . ')"' .
           'alt="cella kiürítése" style="border-style:none;cursor:pointer;cursor:hand;"/></a>';
  }
  else
    return '<img src="img/trucks/' . get_truck_default_image($cell['id']) . '" style="width:120px; height:90px" /><br />' . 
           $cell['saxon-id'];
}

function get_flyer_table($flyer, $editing = false)
{
  if ($flyer['pagetype'] == 0)
    return get_flyer_table_0($flyer, $editing);
  else if ($flyer['pagetype'] == 1)
    return get_flyer_table_1($flyer, $editing);
}

function get_flyer_table_0($flyer, $editing = false)
{
  return '<table style="border:1px solid #000; margin-right:10px;" cellspacing="0">
  <tr>
    <td style="width:240px; height:40px; border:1px solid #000; padding-left:4px;" colspan="4"><strong>Saxon Zrt.</strong><br />fejléc</td>
  </tr>
  <tr>
    <td id="cell_0" style="width:120px; height:100px; border:1px solid #000; text-align:center;" colspan="2">' . get_flyer_cell($flyer['trucks'][0], ($editing ? 0 : -1)) . '</td>
    <td id="cell_1" style="width:120px; height:100px; border:1px solid #000; text-align:center;" colspan="2">' . get_flyer_cell($flyer['trucks'][1], ($editing ? 1 : -1)) . '</td>
  </tr>
  <tr>
    <td id="cell_2" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][2], ($editing ? 2 : -1)) . '</td>
    <td id="cell_3" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][3], ($editing ? 3 : -1)) . '</td>
    <td id="cell_4" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][4], ($editing ? 4 : -1)) . '</td>
    <td id="cell_5" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][5], ($editing ? 5 : -1)) . '</td>
  </tr>
  <tr>
    <td id="cell_6" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][6], ($editing ? 6 : -1)) . '</td>
    <td id="cell_7" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][7], ($editing ? 7 : -1)) . '</td>
    <td id="cell_8" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][8], ($editing ? 8 : -1)) . '</td>
    <td id="cell_9" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][9], ($editing ? 9 : -1)) . '</td>
  </tr>
  <tr>
    <td id="cell_10" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][10], ($editing ? 10 : -1)) . '</td>
    <td id="cell_11" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][11], ($editing ? 11 : -1)) . '</td>
    <td id="cell_12" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][12], ($editing ? 12 : -1)) . '</td>
    <td id="cell_13" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][13], ($editing ? 13 : -1)) . '</td>
  </tr>
</table>';
}

function get_flyer_table_1($flyer, $editing = false)
{
  return '<table style="border:1px solid #000" cellspacing="0">
  <tr>
    <td style="width:240px; height:40px; border:1px solid #000; padding-left:4px;" colspan="4"><strong>Saxon Zrt.</strong><br />fejléc</td>
  </tr>
  <tr>
    <td id="cell_0" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][0], ($editing ? 0 : -1)) . '</td>
    <td id="cell_1" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][1], ($editing ? 1 : -1)) . '</td>
    <td id="cell_2" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][2], ($editing ? 2 : -1)) . '</td>
    <td id="cell_3" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][3], ($editing ? 3 : -1)) . '</td>
  </tr>
  <tr>
    <td id="cell_4" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][4], ($editing ? 4 : -1)) . '</td>
    <td id="cell_5" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][5], ($editing ? 5 : -1)) . '</td>
    <td id="cell_6" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][6], ($editing ? 6 : -1)) . '</td>
    <td id="cell_7" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][7], ($editing ? 7 : -1)) . '</td>
  </tr>
  <tr>
    <td id="cell_8" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][8], ($editing ? 8 : -1)) . '</td>
    <td id="cell_9" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][9], ($editing ? 9 : -1)) . '</td>
    <td id="cell_10" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][10], ($editing ? 10 : -1)) . '</td>
    <td id="cell_11" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][11], ($editing ? 11 : -1)) . '</td>
  </tr>
  <tr>
    <td id="cell_12" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][12], ($editing ? 12 : -1)) . '</td>
    <td id="cell_13" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][13], ($editing ? 13 : -1)) . '</td>
    <td id="cell_14" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][14], ($editing ? 14 : -1)) . '</td>
    <td id="cell_15" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][15], ($editing ? 15 : -1)) . '</td>
  </tr>
  <tr>
    <td id="cell_16" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][16], ($editing ? 16 : -1)) . '</td>
    <td id="cell_17" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][17], ($editing ? 17 : -1)) . '</td>
    <td id="cell_18" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][18], ($editing ? 18 : -1)) . '</td>
    <td id="cell_19" style="width:60px; height:64px; border:1px solid #000; text-align:center;">' . get_flyer_cell($flyer['trucks'][19], ($editing ? 19 : -1)) . '</td>
  </tr>
</table>';
}

function list_flyer_trucks()
{
  global $sql;
  global $lang;
  global $language;
  
  $mysql = get_connection();    
  $mysql->execute($sql['setutf']);
     
  $result = "";
  
  $c = count($_SESSION['flyers']['trucks']);
  foreach($_SESSION['flyers']['trucks'] as $truckid => $saxonid)
  //for ($i = 0; $i < $c; $i++)
  {
    $stmt  = $mysql->prepare($sql['truck_lesserdetails']);    
    $stmt->bind_params($lang, $truckid);    
    if($stmt->execute())
    {
      $truckdetails = $stmt->fetch_all();
      $result .= '<div id="' . $truckid . '" style="cursor:move;"><strong>' . $truckdetails[0]['truck_saxon-id'] . '</strong> ' . 
                 $truckdetails[0]['truck_make'] . ' ' . 
                 $truckdetails[0]['truck_model'] . '<br />' . 
                 '<span style="color:#666">' . $truckdetails[0]['truck_type'] . '</span> ' .  
                 '<span style="color:#009">' . $truckdetails[0]['truck_cost'] . ' &euro;</span> ' . 
                 '<img id="basket_item_' . $truckid . '" src="img/aktualis/remove.gif" ' . 
                 'onmousemove="change_image(\'basket_item_' . $truckid . '\',\'img/aktualis/remove_h.gif\');" ' .
                 'onmouseout="change_image(\'basket_item_' . $truckid . '\',\'img/aktualis/remove.gif\');" ' .
                 'onclick="remove_truck_from_flyer(' . $truckid . ')"' .
                 'alt="' . $saxonid . '" style="cursor:pointer;cursor:hand;"/></div><br />';
    }
  }
  
  if ($result == "")
    $result = "nincs kiválasztva egy targonca sem.";
  
  return $result;
}

function lowercase($str)
{
  return mb_strtolower($str, 'ISO-8859-2');
}
?>