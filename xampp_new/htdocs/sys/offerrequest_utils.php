<?php

function get_offer_request_list() {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['get_offer_request:all']);

    if ($stmt->execute()) {
        if ($stmt->num_rows() == 0)
            $result = array();
        else
            $result = $stmt->fetch_all();
    }

    return $result;
}

function get_offer_request_list_search($filter) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['get_offer_request:search']);
    $stmt->bind_params($filter);

    if ($stmt->execute()) {
        if ($stmt->num_rows() == 0)
            $result = array();
        else
            $result = $stmt->fetch_all();
    }

    return $result;
}

function get_offer_request_list_clerk($owner) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['get_offer_request:clerk']);
    $stmt->bind_params($owner);

    if ($stmt->execute()) {
        if ($stmt->num_rows() == 0)
            $result = array();
        else
            $result = $stmt->fetch_all();
    }
    return $result;
}

function get_offer_request_list_wip() {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['get_offer_request:wip']);

    if ($stmt->execute()) {
        if ($stmt->num_rows() == 0)
            $result = array();
        else
            $result = $stmt->fetch_all();
    }
    return $result;
}

function get_offer_request_list_customer($owner) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['get_offer_request:customer']);
    $stmt->bind_params($owner);

    if ($stmt->execute()) {
        if ($stmt->num_rows() == 0)
            $result = array();
        else
            $result = $stmt->fetch_all();
    }
    return $result;
}

function get_offer_request_list_status($status) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['get_offer_request:status']);
    $stmt->bind_params($status);

    if ($stmt->execute()) {
        if ($stmt->num_rows() == 0)
            $result = array();
        else
            $result = $stmt->fetch_all();
    }

    return $result;
}

function print_offer_list() {
    global $sql;
    global $lang;
    global $language;

    if ($_SESSION['users_type'] == 255) {
        $list = get_offer_request_list();
    } else if ($_SESSION['users_type'] == 128) {
        $list = get_offer_request_list_clerk($_SESSION['users_id']);
    }

    return print_offer_set($list);
}

function get_offerrequest_menu($clerkid, $status, $offerid) {
    global $language;

    if ($_SESSION['users_type'] == 255) {
        $menu = "";
        if ($status == 0) //not processed
            $menu = '<input type="submit" onClick="offerrequest_take(' . $offerid . ');" value="' . $language['offer_request:take'] . '" />';
        else if ($status == 1) //wip
            $menu = '<a href="sys/offerrequest_createpdf.php?offerid=' . $offerid . '" target="blank">megtekintés</a><br /><br />' .
                    '<a href="?page=offer_requests_edit&lang=hun&tmp=4&request=' . $offerid . '">' . $language['offer_request:edit'] . '</a><br />' .
                    '<a href="" onclick="set_offer_done(' . $offerid . ');">' . $language['offer_request:close'] . '</a>';
        else if ($status == 2) { //closed
            $menu = '<a href="sys/offerrequest_createpdf.php?offerid=' . $offerid . '" target="blank">megtekintés</a><br /><br />' .
                    '<a href="?page=offer_requests_edit&lang=hun&tmp=5&request=' . $offerid . '">' . $language['offer_request:edit'] . '</a><br />' .
                    '<a href="#" onclick="offer_request_approve(' . $offerid . ');">' . $language['offer_request:approve'] . '</a>';
        } else if ($status == 4) { //approved
            $menu = '<a href="sys/offerrequest_createpdf.php?offerid=' . $offerid . '">' . $language['offer_request:download'] . '</a><br />' .
                    '<a href="sys/email_sender_options.php?offerid='.$offerid.'" 
            class="highslide" onclick="return hs.htmlExpand(this, {objectType: \'iframe\', align: \'center\', width: 400, height: 250}, 
            {onClosed: function(){window.location.reload();}});" border="0">
            küldés emailben
        </a>                  
<!--<a href="sys/offerrequest_createpdf.php?offerid=' . $offerid . '&sendEmail">küldés emailben</a>-->
    <br /><br />' .
                    '<a href="?page=new_offer&lang=hun&step=intro&copySourceID=' . $offerid . '" class="highslide" onclick="return hs.htmlExpand(this, {objectType: \'iframe\', align: \'center\', width:\'740\', height:\'600\'}, {onClosed: function(){window.location.reload();}});" style="margin-left:10px">másolat készítése</a><br /><br />';
//              '<a href="sys/offerrequest_createderivative.php?offerid='.$offerid.'">másolat készítése</a>'; 
        }
        return $menu;
    } else if ((($_SESSION['users_type'] == 128) && ($_SESSION['users_id'] == $clerkid)) || ($clerkid == -1)) {
        $menu = "";
        if ($status == 0) //not processed
            $menu = '<input type="submit" onClick="offerrequest_take(' . $offerid . ');" value="' . $language['offer_request:take'] . '" />';
        else if ($status == 1) //wip
            $menu = '<a href="?page=offer_requests_edit&lang=hun&tmp=6&request=' . $offerid . '">' . $language['offer_request:edit'] . '</a><br />' .
                    '<a href=""  onclick="set_offer_done(' . $offerid . ');">' . $language['offer_request:close'] . '</a>';
        else if ($status == 2) //closed
            $menu = '<a href="">' . $language['offer_request:view'] . '</a>';
        else if ($status == 4) { //approved
            $menu = '<a href="sys/offerrequest_createpdf.php?offerid=' . $offerid . '">' . $language['offer_request:download'] . '</a>';
        }
        return $menu;
    }
}

function print_offer_set($list) {
    global $sql;
    global $lang;
    global $language;

    if (count($list) > 0) {
        $mysql = get_connection();
        $mysql->execute($sql['setutf']);
        $result = "<table style=\"width:860px;border:0px;border-collapse:collapse;\">";


        $i = 0;
        foreach ($list as $item) {
            $i++;
            /* if($item['offer_changed'] == 1 && isauth())
              $color = ($i % 2) ? 'background-color:#BA8787;' : 'background-color:#9E7676;';
              else */
            $color = ($i % 2) ? 'background-color:#88bbb3;' : 'background-color:#77a096;';
            $result .= '<tr style="' . $color . 'width:840px;">';
            if ($item['offer_company_name'] == '')
                $item['offer_company_name'] = $item['users_realname'];

            if ("***" . $item['offer_date-closed'] . "***" != "***0000-00-00 00:00:00***") {
                $offerID_Fancy = substr($item['offer_date-closed'], 2, 2) . str_pad($item['offer_id'], 4, '0', STR_PAD_LEFT);
            } else {
                $offerID_Fancy = date("y") . str_pad($item['offer_id'], 4, '0', STR_PAD_LEFT);
            }


            $result .= '
                <td style="width:40px;padding:3px;">' . $offerID_Fancy /* date("y") . str_pad($item['offer_id'], 4, '0', STR_PAD_LEFT) */ . '.</td>' .
                    '<td style="width:400px;padding:3px;">' . $language['offer_request:user'] . ':<br />
                        <span style="margin-left:12px;font-weight:bold;">' . $item['offer_company_name'] . '</span><br />' .
                    $language['offer_request:trucks'] . '<br />';

            $trucks = explode(';', $item['offer_trucks']);
            foreach ($trucks as $id) {
                $stmt = $mysql->prepare($sql['truck_lesserdetails']);
                $stmt->bind_params($lang, $id);
                if ($stmt->execute()) {
                    $truckdetails = $stmt->fetch_all();
                    $result .= '<span style="margin-left:12px;"><strong>' . $truckdetails[0]['truck_saxon-id'] . '</strong> ' .
                            $truckdetails[0]['truck_make'] . ' ' .
                            $truckdetails[0]['truck_model'] . ' ' .
                            '<span style="color:#666">' . $truckdetails[0]['truck_type'] . '</span> ' .
                            '<span style="color:#009">' . $truckdetails[0]['truck_cost'] . ' &euro;</span></span><br />';
                }
            }

            $result .= "<td style=\"padding:3px;width:120px;text-align:center;\">" . $item['offer_date-added'] . "</td>";
            $result .= "<td style=\"padding:3px;width:120px;text-align:center;\">" . $item['offer_date-last-edited'] . "</td>";

            $result .= '</td>' .
                    '<td style="width:120px;padding:3px;" id="offerrequest_' . $item['offer_id'] . '_status">
                        ' . $language['offer_request:status'][$item['offer_status']] .
                    (($item['offer_status'] == OfferState_New) ? "" : '<br /><br />
                        ' . $language['clerk'] . ':<br />' . $item['offer_clerkname']) . '</td>' .
                    '<td style="width:150px;padding:3px;" id="offerrequest_' . $item['offer_id'] . '_menu">
                        ' . get_offerrequest_menu($item['offer_clerk-id'], $item['offer_status'], $item['offer_id']) . '
                     </td>' .
                    '<td style="width:50px;">
                        <a href="sys/delete_offer_request.php?offerid=' . $item['offer_id'] . '">Törlés</a>
                     </td>';
            $result .= '</tr>';
        }
        $result .="</table>";
    }
    else
        $result = $language['offer_request:nothingfound'];

    return $result;
}

function offerrequest_take($offerid, $clerkid) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['offer_request:take']);
    $stmt->bind_params($offerid, $clerkid);

    if ($stmt->execute())
        return true;
    else
        return false;
}

function get_offerrequests_byuser($uid) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['get_offer_request:user']);
    $stmt->bind_params($uid);

    if ($stmt->execute()) {

        $result = $stmt->fetch_all();
        if ($stmt->num_rows() == 0)
            $result = array();
        else {
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]['trucks'] = "";
                $trucks = explode(';', $result[$i]['offer_trucks']);
                foreach ($trucks as $id) {
                    $stmt = $mysql->prepare($sql['truck_lesserdetails']);
                    $stmt->bind_params($lang, $id);
                    if ($stmt->execute()) {
                        $truckdetails = $stmt->fetch_all();
                        $result[$i]['trucks'] .= '<span style="margin-left:12px;"><strong>' . $truckdetails[0]['truck_saxon-id'] . '</strong> ' .
                                $truckdetails[0]['truck_make'] . ' ' .
                                $truckdetails[0]['truck_model'] . ' ' .
                                '<span style="color:#666">' . $truckdetails[0]['truck_type'] . '</span> ' .
                                '<span style="color:#009">' . $truckdetails[0]['truck_cost'] . ' &euro;</span></span><br />';
                    }
                }
            }
        }
        return $result;
    }
    else
        return $result;
}

function get_offer_request($id) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['get_offer_request:id']);
    $stmt->bind_params($id);
    $ret_val = array();
    if ($stmt->execute()) {
        if ($stmt->num_rows() != 1)
            return 0;

        else {
            $result = $stmt->fetch_row();
            $ret_val['offer_data'] = $result;

            if ($ret_val['offer_data']['offer_trucks'] != "") {
                $trucks = trim(str_replace(";", ",", $result['offer_trucks']), ',');
                if ($trucks[strlen($trucks) - 1] == ",")
                    $trucks = substr($trucks, 0, strlen($trucks) - 1);
                $trucks = str_replace(",,", ",", $trucks);
            }
            else
                $trucks = "''";

            if (is_array($trucks) || $trucks == "Array")
                $trucks = "''";

            $stmt = $mysql->prepare($sql['get_trucks_in_offer_request']);
            $stmt->bind_params($lang, $trucks, $id);
            if ($stmt->execute()) {
                //      exit($trucks);
                if ($stmt->num_rows() > 0)
                    $ret_val['trucks'] = $stmt->fetch_all();
                else
                    $ret_val['trucks'] = array();

                $userid = $result['offer_user-id'];
                $stmt = $mysql->prepare($sql['get_user_data']);
                $stmt->bind_params($userid);
                $mysql->execute($sql['setutf']);
                if ($stmt->execute()) {
                    $ret_val['userdata'] = $stmt->fetch_row();
                    $clerkid = $result['offer_clerk-id'];
                    $stmt = $mysql->prepare($sql['get_user_data']);
                    $stmt->bind_params($clerkid);
                    if ($stmt->execute()) {
                        $ret_val['clerkdata'] = $stmt->fetch_row();
                        for ($i = 0; $i < count($ret_val['trucks']); $i++) {
                            $stmt = $mysql->prepare($sql['get_offer_copied_images_by_truck']);
                            //exit($ret_val['trucks'][$i]['offer_truck_id']);
                            $truckid = $ret_val['trucks'][$i]['offer_truck_id'];
                            
                            //exit($truckid);
                            
                            $stmt->bind_params($id, $truckid);
                            
                            if ($stmt->execute()) {
                                $ret_val['trucks'][$i]['images'] = $stmt->fetch_all();
                            }
                        }
                        
                        return $ret_val;
                    }
                    ;
                }
                
                // }
                /* else
                  {
                  return 2;
                  } */
            } else {
                return 1;
            }
        }
    } else {
        return 1;
    }
}

function get_offer_trucks($id) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['get_offer_trucks']);
    $stmt->bind_params($id);
    $ret_val = array();
    if ($stmt->execute()) {
        $result = $stmt->fetch_row();
        return $result['offer_trucks'];
    }
    else
        return 0;
}

function generate_offer_request_truck_list($list) {
    $result = "";

    if (count($list) == 0)
        return "";

    $result = "Saxon-szám / Gyártó és típus:<br />" .
            "<select id=\"truck_select\" onchange=\"load_truck_info();\" style=\"width:180px;\">";

    foreach ($list as $item) {
        $value = $item['offer_truck_saxon-id'] != "" ? $item['offer_truck_saxon-id'] : $item['offer_truck_make'] . " " . $item['offer_truck_model'];
        $result.="<option value=\"" . $item['offer_truck_id'] . "\">" . $value . "</option>";
    }
    // exit($result);
    return $result . "</select>";
}

function copy_trucks_offer($offer_id, $trucks) {
    global $sql;
    global $lang;
    global $language;
    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['get_offer_copied_trucks']);
    $stmt->bind_params($offer_id);

    if ($stmt->execute()) {
        $truck_list = explode(";", $trucks);
        $copied = $stmt->fetch_all();
        $ready = array();
        $tocopy = array();
        foreach ($copied as $item) {
            $ready[] = $item['offer_truck_id'];
        }
        foreach ($truck_list as $truck) {
            if (!in_array($truck, $ready) && $truck != "") {
                $tocopy[] = $truck;
            }
        }
        $truck_list = count($tocopy) == 0 ? "''" : implode(",", $tocopy);
        if ($truck_list[strlen($truck_list) - 1] == ",")
            $truck_list = substr($truck_list, 0, strlen($truck_list) - 1);
        $stmt = $mysql->prepare($sql['copy_truck_to_offer']);
        $stmt->bind_params($offer_id, $truck_list);
        if ($stmt->execute()) {
            $stmt = $mysql->prepare($sql['get_images_by_truck']);
            $ids = $trucks != "" ? trim(str_replace(",,", ",", str_replace(";", ",", $trucks)),',') : "''";
            
            $stmt->bind_params($ids);
            if ($stmt->execute()) {
                $images = $stmt->fetch_all();
                $img_list = array();
                foreach ($images as $image) {
                    $img_list[] = $image['image_unique-id'];
                }
                $stmt = $mysql->prepare($sql['get_offer_copied_images']);
                $stmt->bind_params($offer_id);
                if ($stmt->execute()) {
                    $copied = $stmt->fetch_all();
                    $copy_list = array();
                    $tocopy = array();
                    foreach ($copied as $copy) {
                        $copy_list[] = $copy['offer_image_unique_id'];
                    }
                    foreach ($img_list as $img) {
                        if (!in_array($img, $copy_list) && $img != "")
                            $tocopy[] = $img;
                    }
                    $stmt = $mysql->prepare($sql['copy_images_to_offer']);
                    $stmt->bind_params($offer_id, $ids, count($tocopy) > 0 ? implode(",", $tocopy) : "''");
                    if ($stmt->execute()) {
                        // exit($stmt->binded_sql);
                        copy_truck_images(implode(",", $img_list), $offer_id);
                        return 1;
                    }
                    else
                        return 0;
                }
                else
                    return 0;
            }
            else
                return 0;
        }
        else {
            return 0;
        }
    } else {
        return 0;
    }
}

function copy_truck_images($imgs, $offerid) {
    global $sql;
    global $lang;
    global $language;

    // exit($imgs);

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['get_images_to_copy']);
    $stmt->bind_params($imgs == "" ? "''" : $imgs);

    if ($stmt->execute()) {
        if ($stmt->num_rows() > 0) {
            $path = realpath(".") . "/";

            $result = $stmt->fetch_all();
            if (!file_exists($path . "img/trucks_copy/" . $offerid . "/")) {
                mkdir($path . "img/trucks_copy/" . $offerid, 0777);
                chmod($path . "img/trucks_copy/" . $offerid . "/", 0777);
            }
            else
                @chmod($path . "img/trucks_copy/" . $offerid . "/", 0777);

            foreach ($result as $img) {
                $filename = $img['image_filename'];
                if ($filename != "") {
                    /* if(!file_exists("img/trucks/".$filename))
                      $filename = strtolower($filename);
                      print($filename); */
                    if (!file_exists($path . "img/trucks_copy/" . $offerid . "/" . $filename)) {
                        if (file_exists($path . "img/trucks/" . $filename)) {
                            $res = copy($path . "img/trucks/" . $filename, "img/trucks_copy/" . $offerid . "/" . $filename);
                        }
                    }
                    $max = str_replace(".jpg", "_max.jpg", $filename);
                    if (file_exists($path . "img/trucks/" . $max) && !file_exists($path . "img/trucks_copy/" . $offerid . "/" . $max))
                        $res = copy($path . "img/trucks/" . $max, $path . "img/trucks_copy/" . $offerid . "/" . $max);
                }
                /* if($img['image_filename'] != "")
                  {
                  if(!file_exists("img/trucks/".$offerid."/".$img['image_filename']))
                  $filename = strtolower($img['image_filename']);
                  else
                  $filename = $img['image_filename'];
                  if(!file_exists("img/trucks_copy/".$offerid."/".$img['image_filename']))
                  {
                  if(file_exists("img/trucks/".$offerid."/".$filename))
                  $res = copy("img/trucks/".$filename, "img/trucks_copy/".$offerid."/".$filename);
                  }
                  $max = str_replace(".jpg","_max.jpg", $filename);
                  if(file_exists("img/trucks/".$max))
                  $res = copy("img/trucks/".$max, "img/trucks_copy/".$offerid."/".$max);
                  } */
            }
            // exit();
            return 1;
        }
    }
    else {
        return 0;
    }
}

function get_truck_mod_info($offer_id, $truck_id) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['offer_requests_edit:truck_mod']);
    $stmt->bind_params($offer_id, $truck_id, $lang);

    if ($stmt->execute()) {
        $result = $stmt->fetch_row();
        return $result;
    } else {
        return 0;
    }
}

function update_copied_truck_info() {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);
    if (isset($_REQUEST['make_mod'])) {
        $stmt = $mysql->prepare($sql['offer_requests_edit:update_truck2']);
        $stmt->bind_params($_REQUEST['maxheight'], $_REQUEST['price'], $_REQUEST['extras'], $_REQUEST['drivetrain'], $_REQUEST['offerid'], $_REQUEST['truckid'], $_REQUEST['usedhours'], $_REQUEST['warranty'], $_REQUEST['arrival'], str_replace('\\\\', '\\', $_REQUEST['truck_comment']), $_REQUEST['model'], $_REQUEST['maxload'], $_REQUEST['status'], $_REQUEST['poweredwheel'], $_REQUEST['steeredwheel'], $_REQUEST['engine'], $_REQUEST['vtsz'], $_REQUEST['fakeimage'], $_REQUEST['make_mod'], $_REQUEST['fuel_mod'], $_REQUEST['type_mod'], $_REQUEST['year_mod'], $_REQUEST['serial_mod'], $_REQUEST['weight_mod']);
    } else {
        $stmt = $mysql->prepare($sql['offer_requests_edit:update_truck']);
        $stmt->bind_params($_REQUEST['maxheight'], $_REQUEST['price'], $_REQUEST['extras'], $_REQUEST['drivetrain'], $_REQUEST['offerid'], $_REQUEST['truckid'], $_REQUEST['usedhours'], $_REQUEST['warranty'], $_REQUEST['arrival'], str_replace('\\\\', '\\', $_REQUEST['truck_comment']), $_REQUEST['model'], $_REQUEST['maxload'], $_REQUEST['status'], $_REQUEST['poweredwheel'], $_REQUEST['steeredwheel'], $_REQUEST['engine'], $_REQUEST['vtsz'], $_REQUEST['fakeimage']);
    }

//  exit($_REQUEST['enabled'] ."d". $_REQUEST['disabled']);
    //print_r($stmt);


    if ($stmt->execute()) {
        //  exit($stmt->binded_sql);
        $stmt = $mysql->prepare($sql['set_copied_images_enabled']);
        $stmt->bind_params($_REQUEST['enabled'] == "" ? "''" : $_REQUEST['enabled']);
        if ($stmt->execute()) {
            $stmt = $mysql->prepare($sql['set_copied_images_disabled']);
            $stmt->bind_params($_REQUEST['disabled'] == "" ? "''" : $_REQUEST['disabled']);
            if ($stmt->execute()) {
                $mysql->execute($sql['setutf']);
                $stmt = $mysql->prepare($sql['update_offer_request_comment']);

                $stmt->bind_params($_REQUEST['offerid'], str_replace('\\\\', '\\', $_REQUEST['offer_comment']));

                if ($stmt->execute()) {
                    // exit($_REQUEST['offer_comment']);
                    return 1;
                }
                else
                    return 0;
            }
            else
                return 0;
        }
        else
            return 0;
    }
    else {
        return 0;
    }
}

function get_offer_request_images($tid, $oid) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['get_offer_copied_images_by_truck']);
    $stmt->bind_params($oid, $tid);
    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        // print_r($result);exit($stmt->binded_sql);
        return $result;
    }
    else
        return array();
}

function close_offer_request($offerid) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['set_offer_state']);
    $stmt->bind_params(OfferState_Done, $offerid);
    if ($stmt->execute()) {
        $stmt = $mysql->prepare($sql['set_offer_closed_date']);
        if ($stmt->execute()) {
            return 1;
        }
        else
            return 0;
    }
    else
        return 0;
}

function approve_offer_request($offerid) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['set_offer_state']);
    $stmt->bind_params(OfferState_Approved, $offerid);
    if ($stmt->execute()) {
        return 1;
    }
    else
        return 0;
}

function update_offerrequest_options($payment, $euro, $lifetime, $reserve, $language, $offerid, $sig, $delivery, $pdf) {
    global $sql;
    global $lang;
    //global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['update_offer_request_options']);
    $stmt->bind_params($offerid, $payment, $reserve, $euro, $lifetime, $language, $sig, $delivery, $pdf);
    //echo $stmt->last_query();
    if ($stmt->execute()) {
        //if (!isset($_SESSION['pdf_ell'])) $_SESSION['pdf_ell']=1;
        return 1;
    }
    else
        return 0;
}


function update_method($insert_id, $insert_name) {
    global $sql;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);
    if ((int)$insert_id>0 and strlen(trim($insert_name))>0 ){
        $stmt = $mysql->prepare($sql['update_method']);
        $stmt->bind_params($insert_id, $insert_name);
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

function get_method_id($id) {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['get_method_id']);
    $stmt->bind_params($id);

    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result[0];
    }
    else return 0;
}
function get_method_min_id() {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['get_method_min_id']);

    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result[0];
    }
    else return 0;
}



function get_text_method($name) {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['get_text_method']);
    $stmt->bind_params($name);

    if ($stmt->execute()) {
        //echo $stmt->last_query();
        $result = $stmt->fetch_all();
        return $result[0];
    }
    else return 0;
}


function get_inserttext_full() {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['get_inserttext_full']);

    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result;
    }
    else return 0;
}

function insert_method($insert_name) {
    global $sql;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);
    if (strlen(trim($insert_name))>0){
        
        $stmt = $mysql->prepare($sql['insert_method']);
        $stmt->bind_params($insert_name);
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
//////////////////////////
function update_delivery($insert_id, $insert_name) {
    global $sql;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);
    if ((int)$insert_id>0 and strlen(trim($insert_name))>0 ){
        $stmt = $mysql->prepare($sql['update_delivery']);
        $stmt->bind_params($insert_id, $insert_name);
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

function get_delivery_id($id) {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['get_delivery_id']);
    $stmt->bind_params($id);

    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result[0];
    }
    else return 0;
}

function get_delivery_min_id() {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['get_delivery_min_id']);

    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result[0];
    }
    else return 0;
}

function get_text_delivery($name) {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['get_text_delivery']);
    $stmt->bind_params($name);

    if ($stmt->execute()) {
        //echo $stmt->last_query();
        $result = $stmt->fetch_all();
        return $result[0];
    }
    else return 0;
}



function insert_delivery($insert_name) {
    global $sql;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);
    if (strlen(trim($insert_name))>0){
        
        $stmt = $mysql->prepare($sql['insert_delivery']);
        $stmt->bind_params($insert_name);
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





function get_offer_useremail($offerid) {
    global $sql;

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = $mysql->prepare($sql['get_offer_useremail']);
    $stmt->bind_params($offerid);
    
    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        return $result[0];
    }
    else return 0;
}


function generate_payment_list($selected) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['payments']);
    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        $ret_val = "<select name=\"payment\" id=\"payment\" ONCHANGE='param_make(\"payment\", \"edittext2\", \"newtext2\");'>";
        //$ret_val.="<option>Válasszon</option>";
        foreach ($result as $item) {
            $sel = $selected == $item['ID'] ? "selected" : "";
            $ret_val .= "<option " . $sel . " value=\"" . $item['ID'] . "\">" . $item['Name'] . "</option>";
        }
        $ret_val .= "</select>";
        return $ret_val;
    }
    else
        return 0;
}
function generate_deliverymethod_list($selected) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $stmt = $mysql->prepare($sql['deliverymethods']);
    if ($stmt->execute()) {
        $result = $stmt->fetch_all();
        $ret_val = "<select name=\"deliverymethod\" id=\"deliverymethod\" ONCHANGE=\"param_make('deliverymethod', 'edittext3', 'newtext3');\">";
        //$ret_val.="<option>Válasszon</option>";
        foreach ($result as $item) {
            $sel = $selected == $item['ID'] ? "selected" : "";
            $ret_val .= "<option " . $sel . " value=\"" . $item['ID'] . "\">" . $item['Name'] . "</option>";
        }
        $ret_val .= "</select>";
        return $ret_val;
    }
    else
        return 0;
}


/*
function generate_deliverymethod_list($selecteditem) {
    global $lang;
    global $language;

    $ret_val = "<select name=\"deliverymethod\">";
    foreach ($language['deliverymethods'] as $key => $value) {
        $selected = (($selecteditem == $key) ? "selected" : "");
        $ret_val .= "<option " . $selected . " value=\"" . $key . "\">" . $value . "</option>";
    }
    $ret_val .= "</select>";
    return $ret_val;
}
*/
function delete_request($id) {
    global $sql;
    global $lang;
    global $language;

    $mysql = get_connection();
    $result = array();
    $mysql->execute($sql['setutf']);

    $path = realpath('..');
    $img = $path . "/img/trucks_copy/" . $id . "/";
    if (file_exists($img)) {
        //destroy_dir("/img/trucks_copy/".$id."/", $path);
        //TODO
    } else {
        //exit('neee');
    }

    $stmt = $mysql->prepare($sql['delete_offer_request1']);

    $stmt->bind_params($id);

    $stmt->execute();

    $stmt = $mysql->prepare($sql['delete_offer_request2']);

    $stmt->bind_params($id);

    $stmt->execute();

    $stmt = $mysql->prepare($sql['delete_offer_request3']);

    $stmt->bind_params($id);

    $stmt->execute();
}

?>