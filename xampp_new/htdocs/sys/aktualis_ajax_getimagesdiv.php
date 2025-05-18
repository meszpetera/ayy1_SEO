<?php
//aktualis_ajax_getimagesdiv.php
  if (isset($imageidoverride))
  {
    $imageid = $imageidoverride;
    $truckid = $truck[0]['truck_id'];
  }
  else
  {
    $imageid = $_REQUEST['id'];
    $truckid = $_REQUEST['truckid'];
    include_once("common.php"); 
  }
    
  $imagecount = get_image_count($truckid) - 1;
  
  $img = "../img/trucks/" . get_truck_image($truckid, $imageid);
  if (!is_file($img)) 
    print ("<img src=\"../img/aktualis/truck_big.jpg\" style=\"width: 320px;\" />");  
  else
  {
    print ("<img src=\"" . $img . "\" style=\"width: 320px;\" />");  
    print ("<div class=\"dPrevImage\">" . ( ($imageid > 0) ? "<a href=\"#\" onclick=\"setimage(" . ($imageid - 1) . ", " . $truckid . ");\">" . $language['truck-details_prev-image'] . "</a>" : "&nbsp;"  ) . "</div>");
    print ("<div class=\"dImageID\">" . ($imageid + 1) . ".</div>");
    print ("<div class=\"dNextImage\">" . ( ($imageid < $imagecount) ? "<a href=\"#\" onclick=\"setimage(" . ($imageid + 1) . ", " . $truckid . ");\">" . $language['truck-details_next-image'] . "</a>" : "&nbsp;"  ) . "</div>");
  }
  
?>