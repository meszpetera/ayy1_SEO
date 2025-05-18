<?php
function generate_select_simple_search_toplist($filterlist, $name, $default, $width, $td, $defaultvalue = '') {
    $sellist = "";
    if ($td){
        $sellist .= "<td colspan=\"2\">\n";
    }
    $sellist .= "<div style=\"display:inline;padding:0px;margin:0px;width:" . $width . "px;\" id=\"Hack-$name\">" . $default . "</div>\n<br />\n<div style=\"display:inline;padding:0px;margin:0px;width:" . $width . "px;\" id=\"IEHack-$name\">\n<select style=\"margin:5px;margin-top:0px;margin-bottom:0px;width:" . $width . "px;\" id=\"$name\">\n";

    if ($defaultvalue == ''){
        $sellist .= "<option value=\"\"  selected>$default</option>\n";
    }
    foreach ($filterlist as $filteritem) {
        if (isset($filteritem['ID'])){
            $sellist .= "<option value=\"" . $filteritem['ID'] . '"' . (($defaultvalue == $filteritem['ID']) ? ' selected ' : '') . '>' . $filteritem['value'] . "</option>\n";
        }
        else{
            $sellist .="";
        }
    }
    $sellist .= "</select>\n</div>\n";
    if ($td){
        $sellist .= "</td>\n";
    }
    return $sellist;
}

function get_simple_search_toplist() {
    global $language;


    $result = "<table border=\"0\" style=\"width:100%;font-weight:bold;border-collapse:collapse;\">";

    //0. sor gyorskereső
    $result .= "<tr>";
     
    //$filterlist = get_filter_list("saxon-id", $_REQUEST['__saxonid']);
    $result .= "<td colspan=4 style=\"text-align:center;\">" . $language['quicksearch'] . "<br /><input class=\"iLoginInput\" type=\"text\" id=\"saxonsearch\" value=\"".$_REQUEST['saxonsearch']."\" style=\"margin:5px;margin-top:0px;margin-bottom:0px;width:180px;\" /> <input type=\"button\" value=\"OK\" id=\"doSearch\" /></td>";
    $result .= "</tr>";
   
    
    //1.sor
    $result .= "<tr>";
    $result .= '<td colspan="2">' . $language['parttruck'] . "<br />
            \r\n<!-- __ispart -->
            <select id=\"ispart_s\" style=\"margin:0px 5px; width: 215px;\">
							<option value=\"+\">" . $language['parttruckall'] . "</option>" .
            "<option value=\"" . $language['aktualis:ispart'][0]['ID'] . "\" " . ((isset($_REQUEST['__ispart']) && $_REQUEST['__ispart'] == $language['aktualis:ispart'][0]['ID'] ) ? 'selected="selected"' : '') . ">" . $language['aktualis:ispart'][0]['value'] . "</option>" .
            "<option value=\"" . $language['aktualis:ispart'][1]['ID'] . "\" " . ((isset($_REQUEST['__ispart']) && $_REQUEST['__ispart'] == $language['aktualis:ispart'][1]['ID'] ) ? 'selected="selected"' : '') . ">" . $language['aktualis:ispart'][1]['value'] . "</option>" .
            "<option value=\"" . $language['aktualis:ispart'][2]['ID'] . "\" " . ((isset($_REQUEST['__ispart']) && $_REQUEST['__ispart'] == $language['aktualis:ispart'][2]['ID'] ) ? 'selected="selected"' : '') . ">" . $language['aktualis:ispart'][2]['value'] . "</option>" .
            "<option value=\"" . $language['aktualis:ispart'][3]['ID'] . "\" " . ((isset($_REQUEST['__ispart']) && $_REQUEST['__ispart'] == $language['aktualis:ispart'][3]['ID'] ) ? 'selected="selected"' : '') . ">" . $language['aktualis:ispart'][3]['value'] . "</option>" .
            "<option value=\"" . $language['aktualis:ispart'][4]['ID'] . "\" " . ((isset($_REQUEST['__ispart']) && $_REQUEST['__ispart'] == $language['aktualis:ispart'][4]['ID'] ) ? 'selected="selected"' : '') . ">" . $language['aktualis:ispart'][4]['value'] . "</option>" .
            "<option value=\"" . $language['aktualis:ispart'][5]['ID'] . "\" " . ((isset($_REQUEST['__ispart']) && $_REQUEST['__ispart'] == $language['aktualis:ispart'][5]['ID'] ) ? 'selected="selected"' : '') . ">" . $language['aktualis:ispart'][5]['value'] . "</option>" .
            "<option value=\"" . $language['aktualis:ispart'][6]['ID'] . "\" " . ((isset($_REQUEST['__ispart']) && $_REQUEST['__ispart'] == $language['aktualis:ispart'][6]['ID'] ) ? 'selected="selected"' : '') . ">" . $language['aktualis:ispart'][6]['value'] . "</option>" .
            "<option value=\"" . $language['aktualis:ispart'][7]['ID'] . "\" " . ((isset($_REQUEST['__ispart']) && $_REQUEST['__ispart'] == $language['aktualis:ispart'][7]['ID'] ) ? 'selected="selected"' : '') . ">" . $language['aktualis:ispart'][7]['value'] . "</option>" .
            "<option value=\"" . $language['aktualis:ispart'][8]['ID'] . "\" " . ((isset($_REQUEST['__ispart']) && $_REQUEST['__ispart'] == $language['aktualis:ispart'][8]['ID'] ) ? 'selected="selected"' : '') . ">" . $language['aktualis:ispart'][8]['value'] . "</option>" .
            "<option value=\"" . $language['aktualis:ispart'][9]['ID'] . "\" " . ((isset($_REQUEST['__ispart']) && $_REQUEST['__ispart'] == $language['aktualis:ispart'][9]['ID'] ) ? 'selected="selected"' : '') . ">" . $language['aktualis:ispart'][9]['value'] . "</option>" .
            "</select></td>";

    $filterlist = get_filter_list("fuel", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search_toplist($filterlist, "fuel_s", $language['fuel'], 215, true, $_REQUEST['__fuel']);

    $result .= "</tr>";



    //2.sor
    $result .= '<tr>';

    $result .= "\r\n".'<!-- __make -->';
    $filterlist = get_filter_list("make", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search_toplist($filterlist, "make_s", $language['make'], 215, true, $_REQUEST['__make']);
 
    $result .= "\r\n".'<!-- __maxload -->';
    $filterlist = get_filter_list("max-load", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search_toplist($filterlist, "max-load_s", $language['max-load'], 215, true, $_REQUEST['__maxload']);

    $result .= "</tr>";



    //3.sor
    $result .= '<tr>';
    $result .= "\r\n".'<!-- __type -->';
    $filterlist = get_filter_list("type", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search_toplist($filterlist, "type_s", $language['type'], 215, true, $_REQUEST['__type']);

    $result .= "\r\n".'<!-- __cost -->';
    $filterlist = get_filter_list("cost", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search_toplist($filterlist, "cost_s", $language['cost'], 215, true, $_REQUEST['__cost']);
    $result .= "</tr>";

    //4.sor
    $result .= '<tr>';
    $result .= "\r\n".'<!-- __function -->';
    $filterlist = get_filter_list("function", $_REQUEST['__ispart']);
    
    $result .= generate_select_simple_search_toplist($filterlist, "function_s", $language['function'], 215, true, $_REQUEST['__function']);

    $result .= "\r\n".'<!-- __location -->';
    $filterlist = get_filter_list("location", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search_toplist($filterlist, "location_s", $language['location'], 215, true, $_REQUEST['__location']);
    $result .= "</tr>";

    //5.sor
    $result .= '<tr>';
    $result .= "\r\n".'<!-- __status -->';
    $filterlist = get_filter_list("status", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search_toplist($filterlist, "status_s", $language['status'], 215, true, $_REQUEST['__status']);
    //$result .= "\r\n".'<!-- __saxonid -->';
    
    //$filterlist = get_filter_list("saxon-id", $_REQUEST['__saxonid']);
    //$result .= "<td style=\"width:215px;\">" . generate_select_simple_search_toplist($filterlist, "saxon-id_s", $language['saxon-id'], 215, false, $_REQUEST['__saxonid']) .
    //        "</td>";
    
    $result .= "\r\n".'<!-- __akcios -->';
    $filterlist = get_filter_list("akcios", $_REQUEST['__ispart']);
    $result .= generate_select_simple_search_toplist($filterlist, "akcios_s", $language['akcios'],215, true, $_REQUEST['__akcios']) ;
            
    
    //$result .= "<td style=\"text-align:left;\"></td>";
    $result .= "</tr>";



    $result .= "</table>";

    return $result;
}











if (!loggedin() && !isauth()) {
    redirect_in_site("?page=$default_page&amp;lang=$lang");
} else {
    print(" ");
    flush();
    $editable = ismain();



    $template = new Template();

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);

    $variables = array('all' => '');
		$variables['get_simple_search_toplist'] = get_simple_search_toplist();

    /*
    $allTrucks = '';
    $stmt = $mysql->prepare($sql['toplist:get_all']);
    $stmt->bind_params("hun", $_GET['list']);
    if ($stmt->execute()) {
        $truck = $stmt->fetch_all();
        foreach ($truck as $v) {
            $variables['all'] .= '<li id="' . $v['truck_saxon-id'] . '">'
                    . '<a class="img" href="img/trucks/' . $v['truck_default-image'] . '" onclick="return hs.htmlExpand(this, {align: \'center\', objectType: \'iframe\', width: 340, height: 520});"><img src="img/trucks/' .  get_truck_thumbnail($v['truck_default-image']) .  '" width="80" height="60"/></a>'
                    . '<div class="name">' . ' <a href="javascript:void(0);" class="add">hozzáad</a> <a href="javascript:void(0);" class="remove">elvesz</a> <a onclick="return false" href="javascript:void(0);" class="move">mozgat</a><br/>' . $v['truck_saxon-id'] . ' ' . $v['truck_model'] . '</div>'
                    . '</li>' . "\n\r";
        }
        //array_push($variables, $allTrucks);
    }
    */
		
		
    $stmt = $mysql->prepare($sql['toplist:get']);
    $stmt->bind_params("hun", $_GET['list']);
		
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
				
				$variables['top'] = $_outList;
		/*
    if ($stmt->execute()) {
        $truck = $stmt->fetch_all();
        if ($truck[0] !== FALSE) {
            foreach ($truck as $v) {
                $variables['top'] .= '<li id="' . $v['truck_saxon-id'] . '" class="' . (($v['truck_state'] != 'A') ? 'error' : '') . '" >'
                        . '<a class="img" href="img/trucks/' . $v['truck_default-image'] . '" onclick="return hs.htmlExpand(this, {align: \'center\', objectType: \'iframe\', width: 340, height: 520});"><img src="img/trucks/' .  get_truck_thumbnail($v['truck_default-image']) .  '" width="80" height="60"/></a>'
                        . '<div class="name">' . ' <a href="javascript:void(0);" class="add">hozzáad</a> <a href="javascript:void(0);" class="remove">elvesz</a> <a onclick="return false" href="javascript:void(0);" class="move">mozgat</a><br/>' . $v['truck_saxon-id'] . ' ' . $v['truck_model'] . '</div>'
                        . '</li>' . "\n\r";
            }
        }
        //array_push($variables, $topTrucks);
    }
		
		*/

    if ($_REQUEST['save']) {
        $variables['ERROR'] = 'VÁLTOZÁSOKAT ELMENTETTÜK!';
    }
    $variables['list'] = $_GET['list'];
    $template->assign_var_array($variables);

    $main_content = $template->compile("sys/lang/hun/toplist_edit.tpl");  //WARNING: Language hardcoded, no other languages needed    
    include("sys/tpl/main.tpl");
}
/*  print("***Execution times***" . 
  "\n***MySQL Query time: " . ($end_time - $start_time) .
  "***\n***MySQL fetch time: " . ($end_time2 - $end_time) .
  "***\n***Table generation time: " . ($end_time3 - $end_time2) .
  "***\n***Template compilation time: " . ($end_time4 - $end_time3) .
  "***\n***Sending time: " . ($end_time5 - $end_time4) . "***");
 */
?>