<?php
  include_once("common.php");
  
  if(!loggedin() || !isauth())
    print('Please log in to use this feature.');
  else
  {
    $truckid = $_REQUEST['truckid'];

    $mysql = get_connection();    
    $mysql->execute($sql['setutf']);
    
    $stmt  = $mysql->prepare($sql['truck_getspecialoffer']);
    $stmt->bind_params($truckid);    
    if($stmt->execute())
    {
      print("<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" /><script type=\"text/javascript\" src=\"../js/datetimepicker.js\"></script></head><body>");
      $specialoffer = $stmt->fetch_all();
      if ($specialoffer[0]['truck_special-offer-active'] == 1)
      {
        $sdate = explode('-', $specialoffer[0]['truck_special-offer-start']);
        $edate = explode('-', $specialoffer[0]['truck_special-offer-end']);
        print('<div id="frmSetSpecialOffer" style="width: 240px; height:240px; background-color:#c6dddc; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px;\">
                 <span style=\"font-size:14px; font-weight:bold;\">Akció megadása: ' . $specialoffer[0]['truck_saxon-id'] . '</span>
                 <hr />
                 <form onSubmit="hs.close(this);" action="aktualis_set_special_offer.php">
                   <input type="checkbox" checked="true" name="enabled">Akció engedélyezése</input><br /><br />
                   Kezdő dátum:<br />
                   <input name="startdate" id="startdate" type="text" size="25" value="'.$sdate[2].'-'.$sdate[1].'-'.$sdate[0].'"><a href="javascript:NewCal(\'startdate\',\'ddmmyyyy\')"><img src="../img/cal.gif" width="16" height="16" border="0" alt=""></a>
                   <!--<input name="syear" type="text" style="width:60px" value="' . $sdate[0] . '"/>
                   <input name="smonth" type="text" style="width:30px" value="' . $sdate[1] . '"/>
                   <input name="sday" type="text" style="width:30px" value="' . $sdate[2] . '"/>-->
                   <br /><br />
                   Befejező dátum:<br />
                   <input name="enddate" id="enddate" type="text" size="25" value="'.$edate[2].'-'.$edate[1].'-'.$edate[0].'"><a href="javascript:NewCal(\'enddate\',\'ddmmyyyy\')"><img src="../img/cal.gif" width="16" height="16" border="0" alt=""></a>
                   <!--<input name="eyear" type="text" style="width:60px" value="' . $edate[0] . '"/>
                   <input name="emonth" type="text" style="width:30px" value="' . $edate[1] . '"/>
                   <input name="eday" type="text" style="width:30px" value="' . $edate[2] . '"/>-->
                   <br /><br />
                   Akciós ár:<br />
                   <input name="special_offer_price" type="text" style="width:100px" value="' . $specialoffer[0]['truck_special-offer-price'] . '"/>
                   <br /><br />
                   <input type="hidden" name="truckid" value="' . $truckid . '" />
                   <input type="hidden" name="menu" value="1" />
                   <input type="submit" />
                 </form>
               </div>');
      }
      else
        print('<div id="frmSetSpecialOffer" style="width: 240px; height:240px; background-color:#c6dddc; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px;\">
                 <span style=\"font-size:14px; font-weight:bold;\">Akció megadása: ' . $specialoffer[0]['truck_saxon-id'] . '</span>
                 <hr />
                 <form onSubmit="hs.close(this);" action="aktualis_set_special_offer.php">
                   <input type="checkbox" name="enabled">Akció engedélyezése</input><br /><br />
                   Kezdő dátum:<br />
                   <input name="startdate" id="startdate" type="text" size="25"><a href="javascript:NewCal(\'startdate\',\'ddmmyyyy\')"><img src="../img/cal.gif" width="16" height="16" border="0" alt=""></a>
                   <!--<input name="syear" type="text" style="width:60px" value=""/>
                   <input name="smonth" type="text" style="width:30px" value=""/>
                   <input name="sday" type="text" style="width:30px" value=""/>-->
                   <br /><br />
                   Befejező dátum:<br />
                   <input name="enddate" id="enddate" type="text" size="25"><a href="javascript:NewCal(\'enddate\',\'ddmmyyyy\')"><img src="../img/cal.gif" width="16" height="16" border="0" alt=""></a>
                   <!--<input name="eyear" type="text" style="width:60px" value=""/>
                   <input name="emonth" type="text" style="width:30px" value=""/>
                   <input name="eday" type="text" style="width:30px" value=""/>-->
                   <br /><br />
                   Akciós ár:<br />
                   <input name="special_offer_price" type="text" style="width:100px" value="' . $specialoffer[0]['truck_cost'] . '"/>
                   <br /><br />
                   <input type="hidden" name="truckid" value="' . $truckid . '" />
                   <input type="hidden" name="menu" value="1" />
                   <input type="submit" />
                 </form>
               </div>');
      print("</body></html>");
    }
        
    
  }  
?>

