<?php

if (!loggedin() && !isauth()) {
    redirect_in_site("?page=$default_page&amp;lang=$lang");
} else {
    print(" ");
    flush();
    $editable = ismain();
		if (isset($_REQUEST['__saxon_id']) && is_string($_REQUEST['__saxon_id']) && $_REQUEST['__saxon_id'] != "") {
				// exit($_REQUEST['__saxon_id']);
				if ($_REQUEST['__saxon_id']=='_-____'){}
				else{
						$__saxon_id = search_saxonid($_REQUEST['__saxon_id']);
				}
		}
		$__ispart = $_REQUEST['__ispart'];
		$__make = $_REQUEST['__make'];
		$__type = $_REQUEST['__type'];
		$__function = $_REQUEST['__function'];
		$__status = $_REQUEST['__status'];
		$__terstatus = $_REQUEST['__terstatus'];
		$__fuel = $_REQUEST['__fuel'];
		$__maxload = $_REQUEST['__maxload'];
		$__cost = $_REQUEST['__cost'];
		$__location = $_REQUEST['__location'];
		$__akcios = $_REQUEST['__akcios'];
		if(isset($_POST['word'])) { $__saxon_id = $_POST['word']; }
		
    //if (isset($_POST['word'])) {
        
        $mysql = get_connection();
        $mysql->execute($sql['setutf']);
    
    //if ($__ispart==2) echo $__ispart.'---';
    $query = "AND truck_public = 1 ";

    if ($__akcios != "") {
        //print("***".$__saxon_id."***");
        $qry = "`truck_id` IN ('" . str_replace(";", "','", $__akcios) . "')";
        $query = "AND " . $qry;
    }

    $jelzo=true;
    if ($__saxon_id != "") {
        //print("***".$__saxon_id."***");
        $qry = "`truck_saxon-id` IN ('" . str_replace(";", "','", $__saxon_id) . "') and `truck_saxon-id` IS NOT NULL";
        $query = "AND " . $qry;
        $jelzo=false;
    }

    if ($__make != "") {
        $qry = "truck_make IN ('" . str_replace(";", "','", $__make) . "')";
            $query .= " AND " . $qry;
    }

    if ($__function != "") {
        $qry = "truck_function IN ('" . str_replace(";", "','", $__function) . "')";
            $query .= " AND " . $qry;
    }

    if ($__model != "") {
        $qry = "truck_model IN ('" . str_replace(";", "','", $__model) . "')";
            $query .= " AND " . $qry;
    }
    if ($__type != "") {
        $qry = "truck_type IN ('" . str_replace(";", "','", $__type) . "')";
            $query .= " AND " . $qry;
    }

    if ($__fuel != "") {
        $qry = "truck_fuel IN ('" . str_replace(";", "','", $__fuel) . "')";
            $query .= " AND " . $qry;
    }

    if ($__maxload != "") {
        $maxloadarray = explode(';', $__maxload);
        $qry = "";
        foreach ($maxloadarray as $maxload) {
            if ($maxload != "") {
                $bounds = explode('-', $maxload);
                $qry_ = "`truck_max-load` BETWEEN " . $bounds[0] . " AND " . $bounds[1] . " ";
                if ($qry == "")
                    $qry = $qry_; else
                    $qry .= " OR " . $qry_;
            }
        }
        if ($qry != "")
            $query .= " AND " . $qry;
    }

    if ($__status != "") {
        $qry = "truck_status IN ('" . str_replace(";", "','", $__status) . "')";
            $query .= " AND " . $qry;
    }

    if ($__terstatus != "") {
    	// print_r($__terstatus);
				$qry = false;
				if(is_array($__terstatus) AND count($__terstatus)>0) {
					$qry = '('; $n=0;
					foreach($__terstatus AS $StatusID) {
						if($n>0) { $qry .= ' OR '; }
						$qry .= ' `truck_product_status` = "'.($StatusID).'" ';
						$n++;
					}
					$qry .= ')';
				} else if(!is_array($__terstatus) AND $__terstatus>=0) {
					$qry .= ' `truck_product_status` = "'.($__terstatus).'" ';
				}
				if($qry) {
        if ($query == "") {
					$query = "WHERE " . $qry;
        } else {
					$query .= " AND " . $qry;
				}
			}
    }

    if ($__cost != "") {
        $maxloadarray = explode(';', $__cost);
        $qry = "";
        foreach ($maxloadarray as $maxload) {
            if ($maxload != "") {
                $bounds = explode('-', $maxload);
                $qry_ = "`truck_cost` BETWEEN " . $bounds[0] . " AND " . $bounds[1] . " ";
                if ($qry == "")
                    $qry = $qry_; else
                    $qry .= " OR " . $qry_;
            }
        }
        if ($qry != "")
            $query .= " AND " . $qry;
    }


    if ($__location != "") {
        $depos = explode(";", $__location);
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
            $query .= " AND " . $qry;
    }
    //fodarab e
    //exit($__ispart);
    if ($jelzo AND is_numeric($__ispart)){
        $qry = "`truck_ispart` = '$__ispart'";
				if ($qry != "")
            $query .= " AND " . $qry;
    }

if(isauth()) {
    $qry = "truck_state IN ('A', 'B', 'S')";
} else {
    $qry = "truck_state IN ('A', 'B')";
}
            $query .= " AND " . $qry;


        $stmt = $mysql->prepare($sql['toplist:search']);
        //$stmt->bind_params("hun", '%' . $_POST['word'] . '%');
				//print($query);
				$stmt->bind_params("hun", $query, 100);
				$basket = isset($_SESSION['basket']) && $_SESSION['basket'] != "" ? $_SESSION['basket'] : array();
        $_outList = '
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
</script>';
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

                    $id = $result[$i]['truck_saxon-id'];

                    if ($result[$i]['truck_default-image'] == "") {
                        $img_exists = false;
                        $img = ""; //"img/aktualis/truck.jpg";
                    } else {
                        $img = $result[$i]['truck_default-image'];

                        if (!is_file($_SERVER["DOCUMENT_ROOT"].'/img/trucks/' . $img)) {
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
                    $_outList .= "<li id=\"$id\" class=\"$class\" style=\"width:440px;background-size:100% 100%;\">";  //onselect attr. kiv�ve, FARM, 08-08-14
                    if ($img_exists == false) {
												$img="/img/image_missing.png";
                        $_outList .= "<img src=\"$img\" style=\"float: left; margin:5px;margin-right: 8px; width: 50px; height: 50px;\" alt=\"".htmlspecialchars($result[$i]['truck_type'].' '.$result[$i]['truck_make'])."\" title=\"".htmlspecialchars($result[$i]['truck_type'].' '.$result[$i]['truck_make'])."\"/>";
                    } else {
                        $_outList .= "<a href=\"img/trucks/$img\" class=\"highslide\" onclick=\"return hs.expand(this);\" border=\"0\">";
                        $_outList .= "<img src=\"$img_t\" style=\"float: left; margin:5px;margin-right: 8px; width: 50px; height: 50px;\" alt=\"".htmlspecialchars($result[$i]['truck_type'].' '.$result[$i]['truck_make'])."\" title=\"".htmlspecialchars($result[$i]['truck_type'].' '.$result[$i]['truck_make'])."\"/></a>";
												$img_missing = false;
                    }
                    $_outList .= "<table style=\"position:relative;top:2px;line-height:1.4;height:50px;border-collapse:collapse;\">";
                    $_outList .= "<tr><td style=\"width:197px;border-right:1px solid #8fbcb9;\"><strong>" . $result[$i]['truck_saxon-id'] . "</strong>&nbsp;&nbsp;";

                    if (isauth()) {
                        //$_outList .= "<a class=\"detail_btn\" href=\"sys/aktualis_ajax_truck_details.php?lang=$lang&amp;id=" . $result[$i]['truck_id'] . "\" onclick=\"return hs.htmlExpand(this, {align: 'center', objectType: 'iframe', width: 780, height: 700});\">" . $language['details'] . "</a>";
                    }


                    if ($ispart == 1) {
                        $make = $result[$i]['truck_make'] . " " . $result[$i]['truck_fuel'];
                        if (strlen(iconv("UTF-8", "ISO-8859-2", $make)) > 33) {
                   					$make = iconv("UTF-8", "ISO-8859-2", $make);
                            $make = mb_substr($make, 0, 30);
                   					$make = iconv("ISO-8859-2", "UTF-8", $make);
                            $make .= "...";
                        }
                        $_outList .= "<br />" . $make . "<br/>" . $result[$i]['truck_model'];
                    } else {
                        $make = $result[$i]['truck_make'] . " " . $result[$i]['truck_model'];
                        if (strlen(iconv("UTF-8", "ISO-8859-2", $make)) > 24) {
                   					$make = iconv("UTF-8", "ISO-8859-2", $make);
                            $make = mb_substr($make, 0, 21);
                   					$make = iconv("ISO-8859-2", "UTF-8", $make);
                            $make .= "...";
                        }
                        $_outList .= "<br />" . $make . "<br/>" . $result[$i]['truck_fuel'];
                    }
/*
                    if ($ispart == 1) {
                        $make = $result[$i]['truck_make'] . " " . $result[$i]['truck_fuel_name'];
                        if (strlen($make) > 33) {
                            $make = mb_substr($make, 0, 30);
                            $make .= "...";
                        }
                        $_outList .= "<br />" . $make . "<br/>" . $result[$i]['truck_model'];
                    } else {
                        $make = $result[$i]['truck_make'] . " " . $result[$i]['truck_model'];
                        if (strlen($make) > 24) {
                            $make = mb_substr($make, 0, 21);
                            $make .= "...";
                        }
                        $_outList .= "<br />" . $make . "<br/>" . $result[$i]['truck_fuel_name'];
                    }
*/
										if (isauth()) {
											$today = getdate();
											$today = $today['year'] . '-' . $today['mon'] . '-' . $today['mday'];
											$strtotime_today = strtotime($today);
											$strtotime20090301 = strtotime('2009-03-01');
											$msg = "";
											//$msg .= '<b>Publikus:</b> <input type="checkbox" class="public" id="id_' . $result[$i]['truck_id'] . '" ' . ((intval($result[$i]['truck_public']) == 1) ? 'checked="checked"' : '' ) . ' readonly="readonly" disabled="disabled" /> ';
											if (intval($result[$i]['truck_public']) == 1)
													$msg .= '<img class="public" id="id_'.$result[$i]['truck_id'].'" src="/img/publikus.png" alt="true" style="cursor:pointer;" />';
											else
													$msg .= '<img class="public" id="id_'.$result[$i]['truck_id'].'" src="/img/nem_publikus.png" alt="false" style="cursor:pointer;" />';

											//if ((!is_file('img/trucks/' . ($result[$i]['truck_image']))) || ($result[$i]['truck_imagecount'] == 0))
											if ($img_missing)
													$msg .= '<img src="img/image_missing.png" alt="nincs kép" title="nincs kép"/>';
											else
													$msg .= '<img src="img/spacer.png" />';

											//n/a
											if ($result[$i]['truck_make'] == "n/a" ||
															$result[$i]['truck_type'] == "n/a" ||
															$result[$i]['truck_fuel_name'] == "n/a" ||
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
										
											$_outList .= "</td><td style=\"padding:5px;width:60px;border-right:1px solid #8fbcb9;\">".$msg;
											
											$_outList .= '<a onclick="return false" href="javascript:void(0);" class="move"><br/>mozgat</a>';
											$_outList .= "</td>";
										} else {
											$_outList .= "</td><td style=\"padding:5px;width:60px;border-right:1px solid #8fbcb9;\">" . $result[$i]['truck_type'] . "<br/>" . $result[$i]['truck_fuel_name'] . "<br />" . $result[$i]['truck_status']."<br/></td>";
										}
                    $_outList .= "<td style=\"width:70px;padding:5px;\">";
                    if (in_array($result[$i]['truck_id'], $basket)) {
                        //$_outList .= "<a href=\"#\" class=\"truck_to_basket\" style=\"display:none;\" onclick=\"Droppable_OnDrop($('$id'));return false;\">" . $language['aktualis_basket:add'] . "</a>" . "<span class=\"truck_in_basket\">" . $language['aktualis_basket:in'] . " </span>";
                    } else if ($class == "dListItemOffer") {
                        $_outList .= "<span class=\"offering_text\">" . $language['aktualis_basket:offering'] . " </span>";
                    } else if ($result[$i]['truck_state'] == 'B') {
                        $_outList .= "<span class=\"truck_reserved_text\">" . $language['aktualis_basket:reserved'] . " </span>";
										}
                    if (isauth()) {
										if (strtotime($result[$i]['truck_date']) < strtotime('2009-03-01'))
											$datemodified = $language['truckman_edit:notedited'];
										else
											$datemodified = $result[$i]['truck_date'];
                        $_outList .= $datemodified.'<br />
													<!--a href="sys/admin_aktualis_truck_menu.php?id=' . $result[$i]['truck_id'] . '" class="highslide" onclick="return hs.htmlExpand(this, {objectType: \'iframe\', width: 260, height: 260, preserveContent: false });" border="0">m&#369;veletek</a><br /--> ' .
                        '<a href="?page=truckman_edit&amp;lang=hun&amp;truckid=' . $result[$i]['truck_id'] . '" target="_blank" style="margin-right:10px">' . $language['truckman_edit:edit'] . '</a><br/>';
											$_outList .= '<a href="javascript:void(0);" class="add">hozzáad</a>';
											$_outList .= '<a href="javascript:void(0);" class="remove">elvesz</a>';
                    } else {
												$_outList .= $result[$i]['truck_max-height'] . " mm<br />" .
																		$result[$i]['truck_max-load'] . " kg<br />";
                        //$_outList .= "<a class=\"detail_btn\" href=\"sys/aktualis_ajax_truck_details.php?lang=$lang&amp;id=" . $result[$i]['truck_id'] . "\" onclick=\"return hs.htmlExpand(this, {align: 'center', objectType: 'iframe', width: 780, height: 780});\">" . $language['details'] . "</a>";
                    }

                    $_outList .= "</td><td style=\"width:150px;text-align:right;padding:5px;\">".((isauth())?('<b>Ár:</b> '):(''))."<strong>" . (special_offer_active($result[$i]) ? '<span style="text-decoration: line-through;">' . $result[$i]['truck_cost'] . ' &euro;</span>'.((isauth())?(' '):('<br/>')).'<span style="color:#f00">' . $result[$i]['truck_special-offer-price'] . ' &euro;</span>' : $result[$i]['truck_cost'] . " &euro;") . "".((isauth())?('<br/><b>V.Ár:</b> ' . $result[$i]['truck_reseller_price'] . ' &euro;'):(''))."</strong><br />";
                    if ((!in_array($result[$i]['truck_id'], $basket) && !in_array($result[$i]['truck_id'], $prevrequested_trucks) && loggedin() && ($result[$i]['truck_state'] != 'B')) || isauth())
                        //$_outList .= "<a href=\"#\" class=\"truck_to_basket\" onclick=\"Droppable_OnDrop($('$id'));return false;\">" . $language['aktualis_basket:add'] . "</a>" . "<span style=\"display:none;\" class=\"truck_in_basket\">" . $language['aktualis_basket:in'] . " </span>";
                    $_outList .= "</td></tr>";
                    $_outList .= "</table>";
                    $_outList .= "</li>";
                }
            }
        }
				
				echo $_outList;
				
        /*
        if ($stmt->execute()) {
            $truck = $stmt->fetch_all();
            foreach ($truck as $v) {
                echo '<li id="' . $v['truck_saxon-id'] . '">'
                . '<a class="img" href="img/trucks/' . $v['truck_default-image'] . '" onclick="return hs.htmlExpand(this, {align: \'center\', objectType: \'iframe\', width: 340, height: 520});"><img src="img/trucks/' . get_truck_thumbnail($v['truck_default-image']) . '" width="80" height="60"/></a>'
                . '<div class="name">' . ' <a href="javascript:void(0);" class="add">hozzáad</a> <a href="javascript:void(0);" class="remove">elvesz</a> <a onclick="return false" href="javascript:void(0);" class="move">mozgat</a><br/>' . $v['truck_saxon-id'] . ' ' . $v['truck_model'] . '</div>'
                . '</li>' . "\n\r";
            }
        }
				*/
        
    //}
    
}
?>