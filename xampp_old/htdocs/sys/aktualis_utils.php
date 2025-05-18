<?php

function special_offer_active($truck) {
    //print_r($truck);
    if ($truck['truck_special-offer-active'] == 1) {
        $start = str_replace('-', '', $truck['truck_special-offer-start']);
        $end = str_replace('-', '', $truck['truck_special-offer-end']);
        $today = date("Ymd");

        return ($start <= $today) && ($today <= $end);
    }
    else
        return false;
}

function reserve_active($truck) {
    if ($truck['truck_reserved'] == 1) {
        $start = str_replace('-', '', $truck['truck_reserve-start']);
        $end = str_replace('-', '', $truck['truck_reserve-end']);
        $today = date("Ymd");

        return ($start <= $today) && ($today <= $end);
    }
    else
        return false;
}

function get_filter_list($fieldname, $ispart = 0) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();

    $result = array();

    $mysql->execute($sql['setutf']);

    /************************************/

     /*$stmt = $mysql->prepare($sql['aktualis-filter_base']);
     if ($stmt->execute())
         $result = $stmt->fetch_all();*/
    /************************************/


    if ($fieldname == "make") {
        $stmt = $mysql->prepare($sql['aktualis-filter_make']);

        //$stmt->bind_params($ispart);

        if ($stmt->execute())
            $result = $stmt->fetch_all();
    }
    else if ($fieldname == "function" AND isauth()) {
    		if(strtolower($ispart) != "all") {
        	$stmt = $mysql->prepare($sql['aktualis-filter_functions-all']);
      	} else {
	        $stmt = $mysql->prepare($sql['aktualis-filter_functions-admin']);
	        //$stmt->bind_params($lang, $ispart);
	        //$stmt->bind_params($ispart);
      	}
        if ($stmt->execute())
            $result = $stmt->fetch_all();
    }
    else if ($fieldname == "function") {
    		if(strtolower($ispart) != "all") {
        	$stmt = $mysql->prepare($sql['aktualis-filter_functions-all']);
      	} else {
        	$stmt = $mysql->prepare($sql['aktualis-filter_functions']);
        	$stmt->bind_params($lang, $ispart);
      	}

        //$stmt->bind_params($ispart);

        if ($stmt->execute())
            $result = $stmt->fetch_all();
    }
    else if ($fieldname == "akcios") {
        //echo $ispart."--";
        $stmt = $mysql->prepare($sql['aktualis-filter_akcios_termekek']);
        $stmt->bind_params($lang, $ispart);

        //$stmt->bind_params($ispart);
        //echo $sql['aktualis-filter_akcios_termekek'];
        if ($stmt->execute())
            $result = $stmt->fetch_all();
    }
    else if ($fieldname == "model") {
        $stmt = $mysql->prepare($sql['aktualis-filter_model']);
        $stmt->bind_params($ispart);

        if ($stmt->execute())
            $result = $stmt->fetch_all();
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]['ID'] = $result[$i]['value'];
        }
    } else if ($fieldname == "fuel") {
        $stmt = $mysql->prepare($sql['aktualis-filter_fuel']);
        $stmt->bind_params($lang);

        if ($stmt->execute())
            $result = $stmt->fetch_all();
    }
    else if ($fieldname == "saxon-id") {
        $stmt = $mysql->prepare($sql['aktualis-filter_saxon-id']);
        $stmt->bind_params($ispart);

        if ($stmt->execute())
            $result = $stmt->fetch_all();
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]['ID'] = $result[$i]['value'];
        }
    } else if ($fieldname == "status") {
        $stmt = $mysql->prepare($sql['aktualis-filter_status'.((isauth())?(''):('_list'))]);
        $stmt->bind_params($lang);

        if ($stmt->execute())
            $result = $stmt->fetch_all();
    }
    else if ($fieldname == "type") {
    		if(strtolower($ispart) == "all") {
        	$stmt = $mysql->prepare($sql['aktualis-filter_type-all']);
      	} else {
        	$stmt = $mysql->prepare($sql['aktualis-filter_type']);
        	$stmt->bind_params($lang, $ispart);
      	}

        if ($stmt->execute())
            $result = $stmt->fetch_all();
    }
    else if ($fieldname == "location") {
        $stmt = $mysql->prepare($sql['aktualis-filter_location']);
        $stmt->bind_params($lang);

        if ($stmt->execute()) {
            $result = array();
            $locations = $stmt->fetch_all();
            foreach ($locations as $item) {
                if ($item['subdepot'] == 0) {
                    $newresult['ID'] = $item['depot'] . "/0";
                    $newresult['value'] = $item['value'];
                    $result[] = $newresult;
                    foreach ($locations as $subitem) {
                        if ($subitem['subdepot'] != 0 && $subitem['depot'] == $item['depot']) {
                            $newresult['ID'] = $item['depot'] . "/" . $subitem['subdepot'];
                            $newresult['value'] = $item['value'] . " " . $subitem['value'];
                            $result[] = $newresult;
                        }
                    }
                }
            }
        }
    } else if ($fieldname == "max-load") {
        /*
          $result[0]['ID'] = "0-950";
          $result[0]['value'] = "0-950 kg";
          $result[1]['ID'] = "1000-1950";
          $result[1]['value'] = "1000-1950 kg";
          $result[2]['ID'] = "2000-3450";
          $result[2]['value'] = "2000-3450 kg";
          $result[3]['ID'] = "3500-4950";
          $result[3]['value'] = "3500-4950 kg";
          $result[4]['ID'] = "5000-500000";
          $result[4]['value'] = "5000 kg " . $language['above'];
         */
        $result[0]['ID'] = "0-1200";
        $result[0]['value'] = "0-1200 kg";

        $result[1]['ID'] = "1000-1999";
        $result[1]['value'] = "1000-1999 kg";

        $result[2]['ID'] = "1200-1600";
        $result[2]['value'] = "1200-1600 kg";

        $result[3]['ID'] = "2000-2999";
        $result[3]['value'] = "2000-2999 kg";

        $result[4]['ID'] = "2000-3499";
        $result[4]['value'] = "2000-3499 kg";

        $result[5]['ID'] = "3000-3499";
        $result[5]['value'] = "3000-3499 kg";

        $result[6]['ID'] = "3500-4999";
        $result[6]['value'] = "3500-4999 kg";

        $result[7]['ID'] = "5000-9000";
        $result[7]['value'] = "5000-9000 kg";

        $result[8]['ID'] = "8000-15000";
        $result[8]['value'] = "8000-15000 kg";

        //$result[9]['ID'] = "9000-12000";
        //$result[9]['value'] = "9000-12000 kg";

        $result[9]['ID'] = "15000-9999999";
        $result[9]['value'] = "15000 kg " . $language['above'];
    } else if ($fieldname == "max-height") {
        $stmt = $mysql->prepare($sql['aktualis-filter_max-height']);
        $stmt->bind_params($lang);

        if ($stmt->execute())
            $result = $stmt->fetch_all();
    }
    else if ($fieldname == "cost") {
        $result[0]['ID'] = "1-1000";
        $result[0]['value'] = "1-1000 &euro;";
        $result[1]['ID'] = "1000-2499";
        $result[1]['value'] = "1000-2499 &euro;";
        $result[2]['ID'] = "2500-3999";
        $result[2]['value'] = "2500-3999 &euro;";
        $result[3]['ID'] = "3500-5499";
        $result[3]['value'] = "3500-5499 &euro;";
        $result[4]['ID'] = "5500-7499";
        $result[4]['value'] = "5500-7499 &euro;";
        $result[5]['ID'] = "7500-9999";
        $result[5]['value'] = "7500-9999 &euro;";
        $result[6]['ID'] = "10000-14999";
        $result[6]['value'] = "10000-14999 &euro;";
        //$result[7]['ID'] = "16000-19999";
        //$result[7]['value'] = "16000-19999 &euro;";
        $result[7]['ID'] = "15000-500000";
        $result[7]['value'] = "15000 &euro; " . $language['above'];
    } else if ($fieldname == "public") {
        $result[0]['ID'] = 0;
        $result[0]['value'] = "Nem";
        $result[1]['ID'] = 1;
        $result[1]['value'] = "Igen";
    }


        /*$stmt = $mysql->prepare($sql['aktualis-filter_location_bovitett']);
        $stmt->bind_params($lang);

        if ($stmt->execute()) {
            $result = array();
            $locations = $stmt->fetch_all();
            foreach ($locations as $item) {
                if (!($item['depot'] == 3 && $item['subdepot'] == 0)) {
                    $newresult['ID'] = $item['depot'] . "/0";
                    $newresult['value'] = $item['value'];
                    $result[] = $newresult;
                    foreach ($locations as $subitem) {
                        if ($subitem['subdepot'] != 0 && $subitem['depot'] == $item['depot']) {
                            $newresult['ID'] = $item['depot'] . "/" . $subitem['subdepot'];
                            $newresult['value'] = $item['value'] . " " . $subitem['value'];
                            $result[] = $newresult;
                        }
                    }
                }
            }
        } */


    // echo $result;
   
    return $result;
}

///átír
function get_filtered_list($akcios, $saxon_id, $make, $model, $fuel, $max_load, $status, $cost, $location, $offset, $maxshow, $type, $ispart = 0, $function, $terstatus=false) {
    global $sql;
    global $lang;
    global $language;

    $mode =  $_REQUEST['mode'];

    // echo '<div>Mode:'.$mode.'</div';
    
    //if ($ispart==2) echo $ispart.'---';
    
    /*echo '
    <script>alert('.$mode.')</script>';*/
    
    
    if (!isauth()) {
        $qry = " AND !(`truck_depot`='3' AND `truck_sub-depot`='0')"; 
        $query = "WHERE truck_public = 1 AND `trucks`.truck_product_status<2 " .$qry;
    }
        
    if ($akcios != "") {
        //print("***".$saxon_id."***");
        $qry = "`truck_id` IN ('" . str_replace(";", "','", $akcios) . "')";
        $query = "WHERE " . $qry;
    }

    $jelzo = true;
    if ($saxon_id != "") {
        //print("***".$saxon_id."***");
        $qry = "`truck_saxon-id` IN ('" . str_replace(";", "','", $saxon_id) . "') and `truck_saxon-id` IS NOT NULL";
        $query = "WHERE " . $qry;
        $jelzo = false;
    }

    if ($make != "") {
        $qry = "truck_make IN ('" . str_replace(";", "','", $make) . "')";
        if ($query == "")
            $query = "WHERE " . $qry;
        else
            $query .= " AND " . $qry;
    }

    if ($function != "") {
        $qry = "truck_function IN ('" . str_replace(";", "','", $function) . "')";
        if ($query == "")
            $query = "WHERE " . $qry;
        else
            $query .= " AND " . $qry;
    }

    if ($model != "") {
        $qry = "truck_model IN ('" . str_replace(";", "','", $model) . "')";
        if ($query == "")
            $query = "WHERE " . $qry;
        else
            $query .= " AND " . $qry;
    }
    if ($type != "") {
        $qry = "truck_type IN ('" . str_replace(";", "','", $type) . "')";
        if ($query == "")
            $query = "WHERE " . $qry;
        else
            $query .= " AND " . $qry;
    }

    if ($fuel != "") {
        $qry = "truck_fuel IN ('" . str_replace(";", "','", $fuel) . "')";
        if ($query == "")
            $query = "WHERE " . $qry;
        else
            $query .= " AND " . $qry;
    }

    if ($max_load != "") {
        $maxloadarray = explode(';', $max_load);
        $qry = "";
        foreach ($maxloadarray as $maxload) {
            if ($maxload != "") {
                $bounds = explode('-', $maxload);
                $qry_ = "`truck_max-load` BETWEEN " . $bounds[0] . " AND " . $bounds[1] . " ";
                if ($qry == "")
                    $qry = $qry_;
                else
                    $qry .= " OR " . $qry_;
            }
        }
        if ($query == "")
            $query = "WHERE " . $qry;
        else if ($qry != "")
            $query .= " AND " . $qry;
    }

    if ($status != "") {
        $qry = "truck_status IN ('" . str_replace(";", "','", $status) . "')";
        if ($query == "")
            $query = "WHERE " . $qry;
        else
            $query .= " AND " . $qry;
    }
if(isauth()) {
    if ($terstatus != "" OR count($terstatus)>0) {
			$qry = false;
			if(is_array($terstatus) AND count($terstatus)>0) {
				$qry = '('; $n=0;
				foreach($terstatus AS $StatusID) {
					if($n>0) { $qry .= ' OR '; }
					$qry .= ' `truck_product_status` = "'.($StatusID).'" ';
					$n++;
				}
				$qry .= ')';
			} else if(!is_array($terstatus) AND $terstatus>=0) {
				$qry .= ' `truck_product_status` = "'.($terstatus).'" ';
			}
			
			// $qry .= ' `truck_product_status` != "4" ';
      
      
      if($qry) {
				if ($query == "") {
					$query = "WHERE " . $qry;
				} else {
					$query .= " AND " . $qry;
				}
			}
    }
}

    if ($cost != "") {
        $maxloadarray = explode(';', $cost);
        $qry = "";
        foreach ($maxloadarray as $maxload) {
            if ($maxload != "") {
                $bounds = explode('-', $maxload);
                $qry_ = "`truck_cost` BETWEEN " . $bounds[0] . " AND " . $bounds[1] . " ";
                if ($qry == "")
                    $qry = $qry_;
                else
                    $qry .= " OR " . $qry_;
            }
        }
        if ($query == "")
            $query = "WHERE " . $qry;
        else if ($qry != "")
            $query .= " AND " . $qry;
    }


    if ($location != "") {
        $depos = explode(";", $location);
        $qry = "";
        foreach ($depos as $depo) {
            if ($depo != "") {
                $search = explode("/", $depo);
                if ($qry != "")
                    $qry .= " OR ";

                $qry .= "(`truck_depot` =" . $search[0] . ($search[1] != 0 ? (" AND `truck_sub-depot` =" . $search[1]) : "") . ")";
            }
        }
        //  exit($search_d . "<br />". $search_sd);
        //$qry = "truck_depot IN ('" . $search_d. "')". "AND truck_sub-depot IN ('" . $search_sd. "')";
        
        if ($query == "")
            $query = "WHERE " . $qry;
        else
            $query .= " AND " . $qry;
    }
    
    //fodarab e
    //exit($ispart);
    if ($jelzo AND is_numeric($ispart)) {
        $qry = "`truck_ispart` = $ispart";
        if ($query == "")
            $query = "WHERE " . $qry;
        else if ($qry != "")
            $query .= " AND " . $qry;
    }
if(isauth()) {
    $qry = "truck_state IN ('A', 'B', 'S')";
} else {
    $qry = "truck_state IN ('A', 'B') AND truck_public = 1 AND `trucks`.truck_product_status<2 AND !(`truck_depot`='3' AND `truck_sub-depot`='0') ";
}
    if ($query == "")
        $query = "WHERE " . $qry;
    else
        $query .= " AND " . $qry;

//echo $query;
    /* DAVID
      /*FARM @ 08-06-26: basket support: do not show items already in basket
      if (isset($_SESSION['basket']) && (count($_SESSION['basket']) > 0))
      {
      $basketexclude = "truck_id NOT IN (" . implode(",", $_SESSION['basket']) . ")";
      if ($query == "") $query = "WHERE " . $basketexclude; else $query .= " AND " . $basketexclude;
      }
      /*end
     */
    /*
      $szar = $query;
      $list[3] = $szar;
      return $list; */
    $limit = " LIMIT " . $offset . ", $maxshow";
    //  exit($query);
    $mysql = get_connection();
    $mysql->execute($sql['setutf']);

    $stmt_c = $mysql->prepare($sql['trucks_filteredlist_count']);
		// print($sql['trucks_filteredlist_count'].' | '.$query);
    //echo $query;
    $stmt_c->bind_params($query);
    if ($stmt_c->execute()) {
        $result_c = $stmt_c->fetch_all();
        //if($ispart>1)
        // print($query . " " . $limit);
        // print($query . " " . $limit);

        $stmt = $mysql->prepare($sql['trucks_filteredlist']);
        $stmt->bind_params($lang, $query, $limit);
        $list[0] = $result_c[0]['COUNT(*)'];
        $list[1] = $maxshow;
        $list[2] = floor(($list[0] / $maxshow) + 1);
        $list[3] = '
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("img.public").click( function(){
		var xVal = jQuery(this).attr("alt");
		var xId = jQuery(this).attr("id");
		if(xVal=="true") {
			jQuery(this).attr("src","/img/nem_publikus.png");
			jQuery(this).attr("alt","false");
			var rVal = false;
		} else {
			jQuery(this).attr("src","/img/publikus.png");
			jQuery(this).attr("alt","true");
			var rVal = true;
		}
		jQuery.ajax({
			type: "POST",
			url: "/sys/process_truck_public.php",
			data: { value: rVal, id: xId }
		});
	});
});
</script>

<script src="/js/hmtl-print.js"></script>
<iframe id="printf" name="printf" src="/blank.html" style="display:none;"></iframe>
';
        $list[4] = array();
        $basket = isset($_SESSION['basket']) && $_SESSION['basket'] != "" ? $_SESSION['basket'] : array();

        if ($stmt->execute()) {
            $result = $stmt->fetch_all();
            if ($stmt->num_rows() > 0) {
                $prevrequested_trucks = "";
                if (loggedin()) {
                    $stmt = $mysql->prepare($sql['get_offer_request_trucks:user']);
                    $stmt->bind_params($_SESSION['users_id']);
                    if ($stmt->execute()) {
                        $offers = $stmt->fetch_all();
                        foreach ($offers as $offer) {
                            $prevrequested_trucks .= $offer['offer_trucks'];
                        }
                        $prevrequested_trucks = explode(";", $prevrequested_trucks);
                        // print_r($prevrequested_trucks);
                        // exit();
                    }
                    else
                        $prevrequested_trucks = array();
                }
                else
                    $prevrequested_trucks = array();

                for ($i = 0; $i < count($result); $i++) {
                    $id = "listitem_" . $result[$i]['truck_id'];

                    if ($result[$i]['truck_default-image'] == "") {
                        $img_exists = false;
                        $img = ""; //"img/aktualis/truck.jpg";
                    } else {
                        $img = $result[$i]['truck_default-image'];

                        if (!is_file($_SERVER["DOCUMENT_ROOT"] . '/img/trucks/' . $img)) {
                            $img = ""; //"img/aktualis/truck.jpg";
                            $img_exists = false;
                        } else {
                            $img_exists = true;
                            $img_t = 'img/trucks/' . get_truck_thumbnail($img);
                        }
                    }



                    $img_missing = true;
                    $class = ((!in_array($result[$i]['truck_id'], $basket) && !in_array($result[$i]['truck_id'], $prevrequested_trucks)) || isauth()) ? "dListItem" : "dListItemAdded";
                    $class = (in_array($result[$i]['truck_id'], $prevrequested_trucks) && !isauth()) ? "dListItemOffer" : $class;
                    $list[3] .= "<div id=\"$id\" class=\"$class truck-".($result[$i]['truck_saxon-id'])."\">";  //onselect attr. kiv�ve, FARM, 08-08-14
                    if ($img_exists == false) {
                        $img = "/img/image_missing.png";
                        $list[3] .= "<img src=\"$img\" style=\"float: left; margin:5px;margin-right: 8px; width: 50px; height: 50px;\" alt=\"" . htmlspecialchars($result[$i]['truck_type'] . ' ' . $result[$i]['truck_make']) . "\" title=\"" . htmlspecialchars($result[$i]['truck_type'] . ' ' . $result[$i]['truck_make']) . "\"/>";
                    } else {
                        $list[3] .= "<a href=\"img/trucks/$img\" class=\"highslide ".(($result[$i]['truck_default-image_label'])?('image-label'):(''))."\" onclick=\"return hs.expand(this);\" border=\"0\">";
                        $list[3] .= "<img src=\"$img_t\" style=\"float: left; margin:5px;margin-right: 8px; width: 50px; height: 50px;\" alt=\"" . htmlspecialchars($result[$i]['truck_type'] . ' ' . $result[$i]['truck_make']) . "\" title=\"" . htmlspecialchars($result[$i]['truck_type'] . ' ' . $result[$i]['truck_make']) . "\"/></a>".(($result[$i]['truck_default-image_label'])?('<div class="highslide-caption"><span class="caption">'.($result[$i]['truck_default-image_label']).'</span></div>'):(''))."";
                        $img_missing = false;
                    }
                    $list[3] .= "<table style=\"position:relative;top:2px;line-height:1.4;height:50px;border-collapse:collapse;\">";
                    $list[3] .= "<tr><td style=\"width:197px;border-right:1px solid #8fbcb9;\"><strong>" . $result[$i]['truck_saxon-id'] . "</strong>&nbsp;&nbsp;";

                    if (isauth()) {
                        $list[3] .= "<a class=\"detail_btn\" href=\"sys/aktualis_ajax_truck_details.php?lang=$lang&amp;id=" . $result[$i]['truck_id'] . "&amp;".(date('Ymd'))."\" ".((is_mobile())?('target="_blank"'):("onclick=\"return hs.htmlExpand(this, {align: 'center', objectType: 'iframe', width: 780, height: 700});\"")).">" . $language['details'] . "</a>";
                    }

                    if ($ispart == 1) {
                        $make = $result[$i]['truck_make'] . " " . $result[$i]['truck_fuel'];
                        if (strlen(iconv("UTF-8", "ISO-8859-2", $make)) > 33) {
                   					$make = iconv("UTF-8", "ISO-8859-2", $make);
                            $make = mb_substr($make, 0, 30);
                   					$make = iconv("ISO-8859-2", "UTF-8", $make);
                            $make .= "...";
                        }
                        $list[3] .= "<br />" . $make . "<br/>" . $result[$i]['truck_model'];
                    } else {
                        $make = $result[$i]['truck_make'] . " " . $result[$i]['truck_model'];
                        if (strlen(iconv("UTF-8", "ISO-8859-2", $make)) > 24) {
                   					$make = iconv("UTF-8", "ISO-8859-2", $make);
                            $make = mb_substr($make, 0, 21);
                   					$make = iconv("ISO-8859-2", "UTF-8", $make);
                            $make .= "...";
                        }
                        $list[3] .= "<br />" . $make . "<br/>" . $result[$i]['truck_fuel'];
                    }

                    if (isauth()) {
                        $today = getdate();
                        $today = $today['year'] . '-' . $today['mon'] . '-' . $today['mday'];
                        $strtotime_today = strtotime($today);
                        $strtotime20090301 = strtotime('2009-03-01');
                        $msg = "";
                        //$msg .= '<b>Publikus:</b> <input type="checkbox" class="public" id="id_' . $result[$i]['truck_id'] . '" ' . ((intval($result[$i]['truck_public']) == 1) ? 'checked="checked"' : '' ) . ' readonly="readonly" disabled="disabled" /> ';
                        if (intval($result[$i]['truck_public']) == 1)
                            $msg .= '<img class="public" id="id_' . $result[$i]['truck_id'] . '" src="/img/publikus.png" alt="true" style="cursor:pointer;" />';
                        else
                            $msg .= '<img class="public" id="id_' . $result[$i]['truck_id'] . '" src="/img/nem_publikus.png" alt="false" style="cursor:pointer;" />';

                        //if ((!is_file('img/trucks/' . ($result[$i]['truck_image']))) || ($result[$i]['truck_imagecount'] == 0))
                        if ($img_missing)
                            $msg .= '<img src="img/image_missing.png" alt="nincs kép" title="nincs kép"/>';
                        else
                            $msg .= '<img src="img/spacer.png" />';

                        //n/a
                        if ($result[$i]['truck_make'] == "n/a" ||
                                $result[$i]['truck_type'] == "n/a" ||
                                $result[$i]['truck_fuel'] == "n/a" ||
                                $result[$i]['truck_depot'] == 0) {
                            $msg .= '<img src="img/image_incomplete.png" alt="hiányzó adatok" title="hiányzó adatok"/>';
                        }
                        else
                            $msg .= '<img src="img/spacer.png" />';


                        //foglalt-e : átmeneti foglalás
                        if ((strtotime($result[$i]['truck_reserve-start']) < $strtotime_today) && ($strtotime_today < strtotime($result[$i]['truck_reserve-end'])) && ($result[$i]['truck_reserved'] == '1'))
                            $msg .= '<img src="img/emblem-readonly.png" alt="Foglalt" title="Foglalt"/>';
                        else
                            $msg .= '<img src="img/spacer.png" />';

                        //módosított-e
                        if (strtotime($result[$i]['truck_date']) < $strtotime20090301)
                            $datemodified = $language['truckman_edit:notedited'];
                        else
                            $datemodified = $result[$i]['truck_date'];


                        if ($result[$i]['truck_state'] == 'B')
                        //foglalt-e : folytonos foglalás
                            $msg .= '<img src="img/emblem-readonly.png" />';
														
                            $msg .= ' ('.$_ENV['terstatus'][$result[$i]['truck_product_status']].') ';
                    				$msg = iconv("ISO-8859-2", "UTF-8", iconv("UTF-8", "ISO-8859-2", $msg));

                        $list[3] .= "</td><td style=\"padding:5px;width:250px;border-right:1px solid #8fbcb9;\">" . $msg . "</td>";
                    } else {
                        $list[3] .= "</td><td style=\"padding:5px;width:250px;border-right:1px solid #8fbcb9;\">" . $result[$i]['truck_type'] . "<br/>" . $result[$i]['truck_fuel'] . "<br />" . $result[$i]['truck_status'] . "<br/></td>";
                    }
                    $list[3] .= "<td style=\"width:160px;padding:5px;\">";
                    if (in_array($result[$i]['truck_id'], $basket))
                        $list[3] .= "<a href=\"#\" class=\"truck_to_basket\" style=\"display:none;\" onclick=\"Droppable_OnDrop($('$id'));return false;\">" . $language['aktualis_basket:add'] . "</a>" . "<span class=\"truck_in_basket\">" . $language['aktualis_basket:in'] . " </span>";
                    else if ($class == "dListItemOffer")
                        $list[3] .= "<span class=\"offering_text\">" . $language['aktualis_basket:offering'] . " </span>";
                    else if ($result[$i]['truck_state'] == 'B')
                        $list[3] .= "<span class=\"truck_reserved_text\">" . $language['aktualis_basket:reserved'] . " </span>";
                    if (isauth()) {
                        // $list[3] .= '<a href="sys/aktualis_ajax_set_special_offer.php?truckid=' . $result[$i]['truck_id'] . '" class="highslide" onclick="return hs.htmlExpand(this, {objectType: \'iframe\', width: 260, height: 260, preserveContent: false });" border="0">' . $language['aktualis_basket:set_special_offer'] . '</a> ';
                        // $list[3] .= '<a href="sys/aktualis_ajax_set_reserved.php?truckid=' . $result[$i]['truck_id'] . '" class="highslide" onclick="return hs.htmlExpand(this, {objectType: \'iframe\', width: 260, height: 260, preserveContent: false });" border="0">' . $language['aktualis_basket:set_reserved'] . '</a><br /> ';
                        /* $list[3] .= "<b>Ár:</b> " . (special_offer_active($result[$i]) ? '<span style="text-decoration: line-through;">' . $result[$i]['truck_cost'] . '</span> <span style="color:#f00;font-weight:bold;margin-left:10px">' . $result[$i]['truck_special-offer-price'] . '</span> ' : $result[$i]['truck_cost']) . "<br />" .
                          "<b>V.Ár:</b> " . $result[$i]['truck_reseller_price'] . "<br />"; */
                        if (strtotime($result[$i]['truck_date']) < strtotime('2009-03-01'))
                            $datemodified = $language['truckman_edit:notedited'];
                        else
                            $datemodified = $result[$i]['truck_date'];
                        $list[3] .= $datemodified . '<br />
													<a href="sys/admin_aktualis_truck_menu.php?id=' . $result[$i]['truck_id'] . '" class="highslide" onclick="return hs.htmlExpand(this, {objectType: \'iframe\', width: 260, height: 260, preserveContent: false });" border="0">m&#369;veletek</a><br /> ' .
                                '<a href="?page=truckman_edit&amp;lang=hun&amp;truckid=' . $result[$i]['truck_id'] . '&mode=' . $mode . '" target="_blank" style="margin-right:10px">' . $language['truckman_edit:'.(($_REQUEST['mode'])?($_REQUEST['mode']):('edit'))] . '</a>';
                        $result[$i]['truck_max_height'] = $result[$i]['truck_max-height'];
                        $result[$i]['truck_max_load'] = $result[$i]['truck_max-load'];
                        $list[3] .= '<img src="/img/qr.png" alt="" style="max-height:24px;vertical-align:baseline;cursor:pointer;position:absolute;top:15px;right:100px;" onclick=\'printTruckQR(`'.($result[$i]['truck_saxon-id']).'`,'.(json_encode($result[$i],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)).');\' />';
                    } else {
                        $list[3] .= $result[$i]['truck_max-height'] . " mm<br />" .
                                $result[$i]['truck_max-load'] . " kg<br />";
                        $list[3] .= "<a class=\"detail_btn\" href=\"sys/aktualis_ajax_truck_details.php?lang=$lang&amp;id=" . $result[$i]['truck_id'] . "&amp;".(date('Ymd'))."\" ".((is_mobile())?('target="_blank"'):("onclick=\"return hs.htmlExpand(this, {align: 'center', objectType: 'iframe', width: 780, height: 780});\"")).">" . $language['details'] . "</a>";
                        $result[$i]['truck_max_height'] = $result[$i]['truck_max-height'];
                        $result[$i]['truck_max_load'] = $result[$i]['truck_max-load'];
                        $list[3] .= '<img src="/img/qr.png" alt="" style="max-height:24px;vertical-align:baseline;cursor:pointer;position:absolute;top:15px;right:100px;" onclick=\'printTruckQR(`'.($result[$i]['truck_saxon-id']).'`,'.(json_encode($result[$i],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)).');\' />';
                    }

                    $list[3] .= "</td><td style=\"width:150px;text-align:right;padding:5px;\">" . ((isauth()) ? ('<b>Ár:</b> ') : ('')) . "<strong>" . (special_offer_active($result[$i]) ? '<span style="text-decoration: line-through;">' . $result[$i]['truck_cost'] . ' &euro;</span>' . ((isauth()) ? (' ') : ('<br/>')) . '<span style="color:#f00">' . $result[$i]['truck_special-offer-price'] . ' &euro;</span>' : $result[$i]['truck_cost'] . " &euro;") . "" . ((isauth()) ? ('<br/><b>V.Ár:</b> ' . $result[$i]['truck_reseller_price'] . ' &euro;') : ('')) . "</strong><br />";
                    if ((!in_array($result[$i]['truck_id'], $basket) && !in_array($result[$i]['truck_id'], $prevrequested_trucks) && loggedin() && ($result[$i]['truck_state'] != 'B')) || isauth())
                        $list[3] .= "<a href=\"#\" class=\"truck_to_basket\" onclick=\"Droppable_OnDrop($('$id'));return false;\">" . $language['aktualis_basket:add'] . "</a>" . "<span style=\"display:none;\" class=\"truck_in_basket\">" . $language['aktualis_basket:in'] . " </span>";
                    $list[3] .= "</td></tr>";
                    $list[3] .= "</table>";
                    /* $list[3] .= "<strong>" . $result[$i]['truck_saxon-id'] . "</strong> <br />" . $make . "<br /><br />";
                      if($class=="dListItemOffer")
                      $list[3] .= "<span class=\"offering_text\">" .$language['aktualis_basket:offering'] . " </span><br />";
                      $list[3] .= $result[$i]['truck_cost'] . " &euro;<br /><a href=\"#\" onclick=\"iBox.showURL('sys/aktualis_ajax_truck_details.php?id=";
                      $list[3] .= $result[$i]['truck_id'] . "', '', {width:700});return false;\">" . $language['details'] . "</a>";
                      if(!in_array($result[$i]['truck_id'], $basket) && !in_array($result[$i]['truck_id'],$prevrequested_trucks) && loggedin())
                      $list[3] .= " | <a href=\"#\" onclick=\"Droppable_OnDrop(this.parentNode);\">".$language['aktualis_basket:add']."</a>"; */
                    $list[3] .= "</div>";
                }
            }
        }
        else {
            $list = 0;
        }
    } else {
        $list = 0;
    }
    // $list[3] = '"' . $szar . '"';
    // print($list[3]); exit();
    $list[3] = str_replace(Array('Õ','Ũ','õ','ũ'), Array('Ő','Ű','ő','ű'), $list[3]);
    // $list[3] = iconv("ISO-8859-2", "UTF-8", iconv("UTF-8", "ISO-8859-2", $list[3]));
    return $list;
}

function get_truck_details($id, $l = -1) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();

    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['truck_details']);

    if ($l == -1)
        $stmt->bind_params($lang, $id);
    else
        $stmt->bind_params($l, $id);
    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result;
    }
}

function get_truck_details_public($id, $l = -1) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();

    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['truck_details_public']);

    if ($l == -1){
        $stmt->bind_params($lang, $id);
    }else{
        $stmt->bind_params($l, $id);
	}
    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result;
    }
}

function get_truck_image($id, $imageid) {
    global $sql;

    $mysql = get_connection();
    //$mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['truck_getimage']);
    $stmt->bind_params($id, $imageid);

    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result[0]['image_filename'];
    }
}

function get_truck_label($id, $imageid) {
    global $sql;

    $mysql = get_connection();
    //$mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['truck_getimage_label']);
    $stmt->bind_params($id, $imageid);

    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return (($result[0]['image_illustration'])?(($result[0]['image_illustration']==1)?('A kép illusztráció'):($result[0]['image_illustration'])):(''));
    }
}

//WARNING: this one needs the filename, not the id!
function get_truck_thumbnail($img) {
    $path = $_SERVER["DOCUMENT_ROOT"] . "/img/trucks/";
    $img_t = str_replace('.jpg', '_t.jpg', $img);

    if (is_file($path . $img_t))
        return $img_t;
    else if (is_file($path . $img)) {
        error_reporting(0);

        //create 50px wide thumbnail
        $width = 80;
        $q = 90;
        $im_s = imagecreatefromjpeg($path . $img);
        $x_s = imagesx($im_s);
        $y_s = imagesy($im_s);
        $y1 = intval($y_s / ($x_s / $width));
        $x1 = intval($x_s / ($y_s / $y1));
        $im_d = ImageCreateTrueColor($x1, $y1);
        imagecopyresampled($im_d, $im_s, 0, 0, 0, 0, $x1, $y1, $x_s, $y_s);
        imagejpeg($im_d, $path . $img_t, $q);

        return $img_t;
        error_reporting(1);
    }
    else
        return "";
}

function get_truck_default_image($id) {
    global $sql;

    $mysql = get_connection();
    //$mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['truck_getdefaultimage']);
    $stmt->bind_params($id);

    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result[0]['image_filename'];
    }
}

function get_pdf($id) {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['truck_get_pdf']);
    $stmt->bind_params($id);

    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result[0]['offer_pdf'];
    }
}

function get_pdf_truck($id) {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['truck_get_pdf_truck']);
    $stmt->bind_params($id);

    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result[0];
    }
}

function get_text_inserttext($name) {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['get_text_inserttext']);
    $stmt->bind_params($name);

    if ($stmt->execute()) {
        //echo $stmt->last_query();
        $result = $stmt->fetch_all();
        return $result[0];
    }
}

function delete_inserttext($id) {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['delete_inserttext']);
    $stmt->bind_params($id);
    //$stmt->last_query();
    if ($stmt->execute()) {
        return 1;
    }
    else return 0;
}


function get_inserttext_id($id) {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['get_inserttext_id']);
    $stmt->bind_params($id);

    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result[0];
    }
    
}

function update_inserttext($insert_id, $insert_name, $insert_value) {
    global $sql;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);
    if ((int)$insert_id>0 and strlen(trim($insert_name))>0 and strlen(trim($insert_value))>0){
        $stmt = $mysql->prepare($sql['update_inserttext']);
        $stmt->bind_params($insert_id, $insert_name, $insert_value);
        if ($stmt->execute()) {
            return 1;
        }
        else{
            return 0;
        }
    }else{
        return 0;
    }
}

function insert_inserttext($insert_name, $insert_value) {
    global $sql;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);
    if (strlen(trim($insert_name))>0 and strlen(trim($insert_value))>0){
        
        $stmt = $mysql->prepare($sql['insert_inserttext']);
        $stmt->bind_params($insert_name, $insert_value);
        if ($stmt->execute()) {
            return $stmt->insert_id();
        }
        else{
            return 0;
        }
    }else{
        
        return 0;
    }
}



function get_image_count($id) {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['truck_getimagecount']);
    $stmt->bind_params($id);

    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result[0]['COUNT(*)'];
    }
}

function generate_page_links($count, $maxshow, $offset) {
    global $language;
    $pages = ceil(($count / $maxshow));
    $active = floor($offset / $maxshow);
    $result = array();
    $result[0] = /* "***".$count . "***" . */"<div style=\"height:22px;float:left;width:813px;text-align:center;padding-top:2px;\">";
    $prev = -1;
    $cont = false;
    $_req = Array();

    //print_r($_REQUEST);

    if ($_REQUEST['lang']) {
        $_req[] = 'lang=' . $_REQUEST['lang'];
    } else {
        $_req[] = 'lang=hun';
    }
    if ($_REQUEST['page']) {
        $_req[] = 'page=' . $_REQUEST['page'];
    } else {
        $_req[] = 'page=aktualis';
    }
    if (isSet($_REQUEST['ispart']) AND $_REQUEST['ispart'] != "") {
        $_req[] = '__ispart=' . $_REQUEST['ispart'];
    } elseif (isSet($_REQUEST['__ispart']) AND $_REQUEST['__ispart'] != "") {
        $_req[] = '__ispart=' . $_REQUEST['__ispart'];
    }
    if ($_REQUEST['cost']) {
        $_req[] = '__cost=' . $_REQUEST['cost'];
    } elseif ($_REQUEST['__cost']) {
        $_req[] = '__cost=' . $_REQUEST['__cost'];
    }
    if ($_REQUEST['location']) {
        $_req[] = '__location=' . $_REQUEST['location'];
    } elseif ($_REQUEST['__location']) {
        $_req[] = '__location=' . $_REQUEST['__location'];
    }
    if ($_REQUEST['status']) {
        $_req[] = '__status=' . $_REQUEST['status'];
    } elseif ($_REQUEST['__status']) {
        $_req[] = '__status=' . $_REQUEST['__status'];
    }
    if ($_REQUEST['terstatus']) {
        $_req[] = '__terstatus=' . $_REQUEST['terstatus'];
    } elseif ($_REQUEST['__terstatus']) {
        $_req[] = '__terstatus=' . $_REQUEST['__terstatus'];
    }
    if ($_REQUEST['maxload']) {
        $_req[] = '__maxload=' . $_REQUEST['maxload'];
    } elseif ($_REQUEST['__maxload']) {
        $_req[] = '__maxload=' . $_REQUEST['__maxload'];
    }
    if ($_REQUEST['type']) {
        $_req[] = '__type=' . $_REQUEST['type'];
    } elseif ($_REQUEST['__type']) {
        $_req[] = '__type=' . $_REQUEST['__type'];
    }
    if ($_REQUEST['fuel']) {
        $_req[] = '__fuel=' . $_REQUEST['fuel'];
    } elseif ($_REQUEST['__fuel']) {
        $_req[] = '__fuel=' . $_REQUEST['__fuel'];
    }
    if ($_REQUEST['function']) {
        $_req[] = '__function=' . $_REQUEST['function'];
    } elseif ($_REQUEST['__function']) {
        $_req[] = '__function=' . $_REQUEST['__function'];
    }
    if ($_REQUEST['make']) {
        $_req[] = '__make=' . $_REQUEST['make'];
    } elseif ($_REQUEST['__make']) {
        $_req[] = '__make=' . $_REQUEST['__make'];
    }

    if ($_REQUEST['saxonid']) {
        $_req[] = '__saxonid=' . $_REQUEST['saxonid'];
    } elseif ($_REQUEST['__saxonid']) {
        $_req[] = '__saxonid=' . $_REQUEST['__saxonid'];
    }

    if ($_REQUEST['akcios']) {
        $_req[] = '__akcios=' . $_REQUEST['akcios'];
    } elseif ($_REQUEST['__akcios']) {
        $_req[] = '__akcios=' . $_REQUEST['__akcios'];
    }

    if ($_REQUEST['saxonsearch']) {
        $_req[] = '__saxonsearch=' . $_REQUEST['saxonsearch'];
    } elseif ($_REQUEST['__saxonsearch']) {
        $_req[] = '__saxonsearch=' . $_REQUEST['__saxonsearch'];
    }

    $_url = ((is_array($_req) && count($_req) > 0) ? ('&' . join("&", $_req)) : (''));
    for ($i = 0; $i < $pages; $i++) {
        if ($prev != $i - 1 && !$cont) {
            $result[0] .= " ... |";
            $cont = true;
        }
        if (($i >= 0 && $i < 3) || ($i >= $active && $i < $active + 3) || ($i >= $pages - 3 && $i < $pages)) {
            $from = $i > 0 ? $maxshow * $i : 0;
            $num = $i + 1;
            if ($active == $i) {
                $result[0] .= "<span style=\"margin-left:3px;\">$num</span>";
                if ($active > 0) {
                    $back = $from - $maxshow;

                    $result[0] = "<div style=\"float:left;\"><a href=\"?__offset=" . ($back) . ($_url) . "\" onclick=\"load_from_offset($back); return false;\"><img alt=\"" . $language['prev_page'] . "\" title=\"" . $language['prev_page'] . "\" src=\"img/aktualis/previous.gif\" style=\"border:none;\" /></a></div>" . $result[0];
                } else {
                    $result[0] = "<div style=\"float:left;\"><img alt=\"" . $language['prev_page'] . "\" title=\"" . $language['prev_page'] . "\" src=\"img/aktualis/previous_d.gif\" style=\"border:none;\" /></div>" . $result[0];
                }
            } else {
                $result[0] .= "<span style=\"margin-left:3px;\"><a href=\"?__offset=" . ($from) . ($_url) . "\" onclick=\"load_from_offset('$from'); return false;\" id=\"up_page_" . $num . "\">$num</a></span>";
            }
            $result[0].= $i < $pages - 1 ? " | " : "";
            $cont = false;
            $prev = $i;
        }
    }
    $result[0] .= "</div>";
    if (($active != $i) && ($active + 1 < $pages)) {
        $from = $active > 0 ? $maxshow * $active : 0;
        $forward = $from + $maxshow;
        $result[0] .= "<div style=\"float:left;\"><a href=\"?__offset=" . ($forward) . ($_url) . "\" onclick=\"load_from_offset($forward); return false;\"><img alt=\"" . $language['next_page'] . "\" title=\"" . $language['next_page'] . "\" src=\"img/aktualis/next.gif\" style=\"border:none;\" /></a></div>";
    } else if (($active + 1 >= $pages)) {
        $result[0] .= "<div style=\"float:left;\"><img alt=\"" . $language['next_page'] . "\" title=\"" . $language['next_page'] . "\" src=\"img/aktualis/next_d.gif\" style=\"border:none;\" /></div>";
    }
    $result[0] .= "<br />";
    $result[1] = $result[0];
    return $result;
}

function generate_select_simple_search($filterlist, $name, $default, $width, $td, $defaultvalue = '') {
    $sellist = "";
    if ($td) {
        $sellist .= "<td colspan=\"2\">\n";
    }
    $sellist .= "<div style=\"display:inline;padding:0px;margin:0px;width:" . $width . "px;\" id=\"Hack-$name\">" . $default . "</div>\n<br />\n<div style=\"display:inline;padding:0px;margin:0px;width:" . $width . "px;\" id=\"IEHack-$name\">\n<select style=\"margin:5px;margin-top:0px;margin-bottom:0px;width:" . $width . "px;\" onchange=\"filters_changed(1)\" id=\"$name\">\n";

    if ($defaultvalue == '') {
        $sellist .= "<option value=\"\"  selected>$default</option>\n";
    }
    foreach ($filterlist as $filteritem) {
        if (isset($filteritem['ID'])) {
            $sellist .= "<option value=\"" . $filteritem['ID'] . '"' . (($defaultvalue == $filteritem['ID']) ? ' selected ' : '') . '>' . $filteritem['value'] . "</option>\n";
        } else {
            $sellist .="";
        }
    }
    $sellist .= "</select>\n</div>\n";
    if ($td) {
        $sellist .= "</td>\n";
    }
    return $sellist;
}

function generate_minmax_simple_search($filterlist, $name, $default, $width, $td, $defaultvalue = '', $ext='') {
		$f = $filterlist;
		$bounds = explode('-', $defaultvalue);
		$curMin = isSet($bounds[0])?($bounds[0]):('');
		$curMax = isSet($bounds[1])?($bounds[1]):('');
		$min = isset($f['min'])?$f['min']:0;
		$max = isset($f['max'])?$f['max']:99999999;
		$stp = isset($f['step'])?$f['step']:1;
		$pref = str_replace('-','_',$name);
    $sellist = "";
    if ($td) { $sellist .= "<td colspan=\"2\">\n"; }
    $sellist .= "<div style=\"display:inline;padding:0px;margin:0px;width:" . $width . "px;\" id=\"Hack-$name\">" . $default . "</div>\n<br />\n<div style=\"display:inline;padding:0px;margin:0px;width:" . $width . "px;\" id=\"IEHack-$name\">\n";
    // $sellist .= "<select style=\"margin:5px;margin-top:0px;margin-bottom:0px;width:" . $width . "px;\" onchange=\"filters_changed(1)\" id=\"$name\">\n";
    $sellist .= "<script>var {$pref}tout = setTimeout(function(){},0);</script>\n";
    $onchange = " let min = jQuery('#{$name}-min').val(); let max = jQuery('#{$name}-max').val(); if(parseFloat(min)>parseFloat(max) && max!=='') { let a = min; min = max; max = a; } let cur = (min>0 || max>0)?((min>{$min})?(min):('{$min}'))+'-'+((max>{$min})?(max):('{$max}')):(''); jQuery('#{$name}').val(cur); clearTimeout({$pref}tout); {$pref}tout = setTimeout(function(){ if(jQuery('#{$name}').val()!=jQuery('#{$name}').attr('old')) { jQuery('#{$name}').change(); jQuery('#{$name}').attr('old',jQuery('#{$name}').val()); } },1500); ";
    $sellist .= "<input style=\"visibility: hidden; position: absolute; z-index: -1;\" type=\"text\" onchange=\"filters_changed(1)\" id=\"{$name}\" value=\"{$defaultvalue}\" old=\"{$defaultvalue}\" />\n";
    $sellist .= "<div style=\"display: flex; gap: 5px; flex-direction: row; flex-wrap: nowrap; align-items: center; margin: 5px; margin-top: 0px; margin-bottom: 0px; width: " . $width . "px;\">\n";
    $sellist .= "<input type=\"number\" onchange=\"{$onchange}\" onkeyup=\"{$onchange}\" id=\"{$name}-min\" value=\"{$curMin}\" min=\"{$min}\" max=\"{$max}\" step=\"{$stp}\" style=\"width:50%;\" /> -\n";
    $sellist .= "<input type=\"number\" onchange=\"{$onchange}\" onkeyup=\"{$onchange}\" id=\"{$name}-max\" value=\"{$curMax}\" min=\"{$min}\" max=\"{$max}\" step=\"{$stp}\" style=\"width:50%;\" /> ".(($ext)?("<span style=\"min-width: 3ch;\">{$ext}</span>"):(""))."\n";
    $sellist .= "</div>\n";

    $sellist .= "</div>\n";
    if ($td) { $sellist .= "</td>\n"; }
    return $sellist;
}

function get_simple_search() {
    global $language;

    $mode =  $_REQUEST['mode'];

    $result = "<table border=\"0\" style=\"width:100%;font-weight:bold;border-collapse:collapse;\">";

    //0. sor gyorskereső
    $result .= "<tr>";

    //$filterlist = get_filter_list("saxon-id", $_REQUEST['__saxonid']);
    $result .= "<td colspan=4 style=\"text-align:center;\">" . $language['quicksearch'] . "<br /><input class=\"iLoginInput\" onkeyup=\"doMask();\" onkeypress=\"filters_changed(1)\" type=\"text\" id=\"saxonsearch\" value=\"" . $_REQUEST['saxonsearch'] . "\" style=\"margin:5px;margin-top:0px;margin-bottom:0px;width:180px;\" /></td>";
    $result .= "</tr>";

		/*if (!loggedin()) {
    } */

    //1.sor
    $result .= "<tr>";
    $result .= '<td colspan="2">' . $language['parttruck'] . "<br />
            \r\n<!-- __ispart -->
            <select onchange=\"ispart_changed(0)\" id=\"ispart_s\" style=\"margin:0px 5px; width: 400px;\">
							<option value=\"+\">" . $language['parttruckall'] . "</option>";

    foreach($language['aktualis:ispart-sort'] AS $val) {
    	$result .= "<option value=\"".($language['aktualis:ispart'][$val]['ID'])."\" " . ((isset($_REQUEST['__ispart']) && $_REQUEST['__ispart'] == $language['aktualis:ispart'][$val]['ID'] ) ? 'selected="selected"' : '') . " >".($language['aktualis:ispart'][$val]['value'])."</option>";
    }
    $result .= "</select></td>";

    $filterlist = get_filter_list("fuel", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search($filterlist, "fuel_s", $language['fuel'], 400, true, $_REQUEST['__fuel']);

    $result .= "</tr>";

    //2.sor
    $result .= '<tr>';

    $result .= "\r\n" . '<!-- __make -->';
    $filterlist = get_filter_list("make", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search($filterlist, "make_s", $language['make'], 400, true, $_REQUEST['__make']);

    $result .= "\r\n" . '<!-- __maxload -->';
    $filterlist = get_filter_list("max-load", $_REQUEST['__ispart']);
    // $result .= generate_select_simple_search($filterlist, "max-load_s", $language['max-load'], 400, true, $_REQUEST['__maxload']);
    $result .= generate_minmax_simple_search(Array('min'=>0,'max'=>900000,'step'=>100), "max-load_s", $language['max-load'], 400, true, $_REQUEST['__maxload'], 'kg');

    $result .= "</tr>";



    //3.sor
    $result .= '<tr>';
    $result .= "\r\n" . '<!-- __type -->';
    $filterlist = get_filter_list("type", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search($filterlist, "type_s", $language['type'], 400, true, $_REQUEST['__type']);

    $result .= "\r\n" . '<!-- __cost -->';
    $filterlist = get_filter_list("cost", $_REQUEST['__ispart']);
    // $result .= generate_select_simple_search($filterlist, "cost_s", $language['cost'], 400, true, $_REQUEST['__cost']);
    $result .= generate_minmax_simple_search(Array('min'=>0,'max'=>900000,'step'=>100), "cost_s", $language['cost'], 400, true, $_REQUEST['__cost'], '&euro;');
    $result .= "</tr>";

    //4.sor
    $result .= '<tr>';
    $result .= "\r\n" . '<!-- __function -->';
    $filterlist = get_filter_list("function", $_REQUEST['__ispart']);

    $result .= generate_select_simple_search($filterlist, "function_s", $language['function'], 400, true, $_REQUEST['__function']);

    $result .= "\r\n" . '<!-- __location -->';
    $filterlist = get_filter_list("location", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search($filterlist, "location_s", $language['location'], 400, true, $_REQUEST['__location']);
    $result .= "</tr>";

    //5.sor
    $result .= '<tr>';
    $result .= "\r\n" . '<!-- __status -->';
    $filterlist = get_filter_list("status", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search($filterlist, "status_s", $language['status'], 400, true, $_REQUEST['__status']);
    //$result .= "\r\n".'<!-- __saxonid -->';
    //$filterlist = get_filter_list("saxon-id", $_REQUEST['__saxonid']);
    //$result .= "<td style=\"width:200px;\">" . generate_select_simple_search($filterlist, "saxon-id_s", $language['saxon-id'], 200, false, $_REQUEST['__saxonid']) .
    //        "</td>";

    $result .= "\r\n" . '<!-- __akcios -->';
    $filterlist = get_filter_list("akcios", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search($filterlist, "akcios_s", $language['akcios'], 400, true, $_REQUEST['__akcios']);
    
    //$result .= "<td style=\"text-align:left;\"></td>";
    $result .= "</tr>";
		
		if (loggedin() OR isauth()) {

       if ($mode==''){
          $result .= '
    				<tr>
    					<td style="width: 120px; height: 40px;">Termék státusz:</td>
    					<td colspan="3" id="terstatus">
    						<input type="checkbox" id="terstatus_0" value="0" '.((in_array(0,$_REQUEST['__terstatus']))?('checked'):('')).' onchange="get_list()" /> <label for="terstatus_0">'.($_ENV['terstatus'][0]).'</label>,
    						<input type="checkbox" id="terstatus_1" value="1" '.((in_array(0,$_REQUEST['__terstatus']))?('checked'):('')).' onchange="get_list()" /> <label for="terstatus_1">'.($_ENV['terstatus'][1]).'</label>,
    						<input type="checkbox" id="terstatus_2" value="2" '.((in_array(0,$_REQUEST['__terstatus']))?('checked'):('')).' onchange="get_list()" /> <label for="terstatus_2">'.($_ENV['terstatus'][2]).'</label>,
    						<input type="checkbox" id="terstatus_3" value="3" '.((in_array(0,$_REQUEST['__terstatus']))?('checked'):('')).' onchange="get_list()" /> <label for="terstatus_3">'.($_ENV['terstatus'][3]).'</label>,
    						<input type="checkbox" id="terstatus_4" value="4" '.((in_array(0,$_REQUEST['__terstatus']))?('checked'):('')).' onchange="get_list()" /> <label for="terstatus_4">'.($_ENV['terstatus'][4]).'</label>,
    						<input type="checkbox" id="terstatus_5" value="5" '.((in_array(0,$_REQUEST['__terstatus']))?('checked'):('')).' onchange="get_list()" /> <label for="terstatus_5">'.($_ENV['terstatus'][5]).'</label>
    						<input type="checkbox" id="terstatus_6" value="6" '.((in_array(0,$_REQUEST['__terstatus']))?('checked'):('')).' onchange="get_list()" /> <label for="terstatus_6">'.($_ENV['terstatus'][6]).'</label>
    					</td>
    				</tr>'; }
       else {
            
            switch ($mode){
              case 'beszer':
                   $ts1 = 'checked';
                   $di0=$di2=$di3=$di4=$di5=$di6 = 'disabled';
                   $bs0=$bs2=$bs3=$bs4=$bs5=$bs6 = 'style="color: gray;"';
                   break;
              case 'eladas':
                   $ts0 = 'checked';
                   $di1=$di2=$di3=$di4=$di5=$di6 = 'disabled';
                   $bs1=$bs2=$bs3=$bs4=$bs5=$bs6 = 'style="color: gray;"';
                   break;
              case 'rakmoz':
                   $ts0 = 'checked';
                   $di1=$di2=$di3=$di4=$di5=$di6 = 'disabled';
                   $bs1=$bs2=$bs3=$bs4=$bs5=$bs6 = 'style="color: gray;"';
                   break;
              default :
              }
          $result .= '
    				<tr>
    					<td style="width: 120px; height: 40px;">Termék státusz:</td>
    					<td colspan="3" id="terstatus">
    						<input type="checkbox" id="terstatus_0" value="0" '.$ts0.' onchange="get_list()" '.$di0.'/> <label '.$bs0.' for="terstatus_0">'.($_ENV['terstatus'][0]).'</label>,
    						<input type="checkbox" id="terstatus_1" value="1" '.$ts1.' onchange="get_list()" '.$di1.'/> <label '.$bs1.' for="terstatus_1">'.($_ENV['terstatus'][1]).'</label>,
    						<input type="checkbox" id="terstatus_2" value="2" '.$ts2.' onchange="get_list()" '.$di2.'/> <label '.$bs2.' for="terstatus_2">'.($_ENV['terstatus'][2]).'</label>,
    						<input type="checkbox" id="terstatus_3" value="3" '.$ts3.' onchange="get_list()" '.$di3.'/> <label '.$bs3.' for="terstatus_3">'.($_ENV['terstatus'][3]).'</label>,
    						<input type="checkbox" id="terstatus_4" value="4" '.$ts4.' onchange="get_list()" '.$di4.'/> <label '.$bs4.' for="terstatus_4">'.($_ENV['terstatus'][4]).'</label>,
    						<input type="checkbox" id="terstatus_5" value="5" '.$ts5.' onchange="get_list()" '.$di5.'/> <label '.$bs5.' for="terstatus_5">'.($_ENV['terstatus'][5]).'</label>,
    						<input type="checkbox" id="terstatus_6" value="6" '.$ts6.' onchange="get_list()" '.$di6.'/> <label '.$bs6.' for="terstatus_6">'.($_ENV['terstatus'][6]).'</label>
    					</td>
    				</tr>'; 
        }
		}


    $result .= "</table>";
    
    return $result;
}

function search_saxonid($text) {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    if (isauth()){
       $stmt = $mysql->prepare($sql['truck_search_saxonid']);
    }
    else {
       $stmt = $mysql->prepare($sql['truck_search_saxonid_bovitett']);
    }
    $stmt->bind_params($text);

    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        $data = "";
        foreach ($result as $stuff) {
            $data .= $stuff['truck_saxon-id'] . ";";
        }
        return $data;
    }
}

?>