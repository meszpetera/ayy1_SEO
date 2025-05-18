<?php

function remove_accents($string) {
    //return strtr($string,"()!$'?: ,&+-/.???????ĽľŔÁÂĂÄĹĆÇČÉĘËĚÍÎĎĐŃŇÓÔŐÖŘŮÚŰÜÝßŕáâăäĺćçčéęëěíîďđńňóôőöřůúűüý˙","--------------SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
    return str_replace(preg_split('//', "()!$'?: ,&+-/???????ĽľŔÁÂĂÄĹĆÇČÉĘËĚÍÎĎĐŃŇÓÔŐÖŘŮÚŰÜÝßŕáâăäĺćçčéęëěíîďđńňóôőöřůúűüý˙", -1, PREG_SPLIT_NO_EMPTY), preg_split('//', "-------------SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy", -1, PREG_SPLIT_NO_EMPTY), $string);
}

function prepare_str($s) {
    return str_replace("'", "''", $s);
}

/**
 * 1: minden ok
 * 0: nincs saxonid
 * 2: nincs make
 * 3: nincs model
 * 4: nincs type
 * 5: nincs fuel
 * 6: nincs maxload
 * 7: nincs maxheight
 * 8: nincs status
 * 9: nincs price
 * 10: nincs location
 */
function check_truck_data() {
    //  if(!isset($_REQUEST['saxonid']) || $_REQUEST['saxonid'] == "")
//      return 0;
    if (!isset($_REQUEST['make']) || $_REQUEST['make'] == "")
        return 2;
    if (!isset($_REQUEST['model']) || $_REQUEST['model'] == "")
        return 3;
    if (!isset($_REQUEST['type']) || $_REQUEST['type'] == "")
        return 4;
    if (!isset($_REQUEST['fuel']) || $_REQUEST['fuel'] == "")
        return 5;
    if (!isset($_REQUEST['maxload']) || $_REQUEST['maxload'] == "")
        return 6;
    if (!isset($_REQUEST['maxheight']) || $_REQUEST['maxheight'] == "")
        return 7;
    if (!isset($_REQUEST['status']) || $_REQUEST['status'] == "")
        return 8;
    if (!isset($_REQUEST['price']) || $_REQUEST['price'] == "")
        return 9;
    if (!isset($_REQUEST['location']) || $_REQUEST['location'] == "")
        return 10;
    /* if(!isset($_REQUEST['pwheel']) || $_REQUEST['pwheel'] == "")
      return 11;
      if(!isset($_REQUEST['swheel']) || $_REQUEST['swheel'] == "")
      return 12;
      if(!isset($_REQUEST['engine']) || $_REQUEST['engine'] == "")
      return 13;
      if(!isset($_REQUEST['drivetrain']) || $_REQUEST['drivetrain'] == "")
      return 14;
      if(!isset($_REQUEST['hours']) || $_REQUEST['hours'] == "")
      return 15;
      if(!isset($_REQUEST['year']) || $_REQUEST['year'] == "")
      return 16;
      if(!isset($_REQUEST['serial']) || $_REQUEST['serial'] == "")
      return 17;
      if(!isset($_REQUEST['weight']) || $_REQUEST['weight'] == "")
      return 18;
      if(!isset($_REQUEST['warranty']) || $_REQUEST['warranty'] == "")
      return 19;
      if(!isset($_REQUEST['arrival']) || $_REQUEST['arrival'] == "")
      return 20; */
    return 1;
}

function add_truck() {
    global $sql;

    //$ret = check_truck_data();
    $ret = 1;
    if ($ret != 1)
        return $ret;

    $makeid = $_REQUEST['make'];
    $typeid = $_REQUEST['type'];

    $mysql = get_connection();

    $mysql->execute($sql['setutf']);

    if (isset($_REQUEST['type_add']) && $_REQUEST['type_add'] != "") {
        $stmt = $mysql->prepare($sql['truckman_get_type_count']);
        $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart']);
        $stmt->execute();
        $c = $stmt->fetch_all();
        if ($c[0]['count'] == 0) {
            //hun and get id
            $stmt = $mysql->prepare($sql['truckman_add_type']);
            $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart'], "hun");
            $stmt->execute();
            $stmt = $mysql->prepare("SELECT LAST_INSERT_ID() as `id`;");
            $stmt->execute();
            $id = $stmt->fetch_all();
            $typeid = $id[0]['id'];

            //eng
            $stmt = $mysql->prepare($sql['truckman_add_type_id']);
            $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart'], "eng", $typeid);
            $stmt->execute();
            //ger
            $stmt = $mysql->prepare($sql['truckman_add_type_id']);
            $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart'], "ger", $typeid);
            $stmt->execute();
        } else {
            $stmt = $mysql->prepare($sql['truckman_find_type']);
            $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart']);
            $stmt->execute();
            $m = $stmt->fetch_all();
            $typeid = $m[0]['id'];
        }
    }

    if (isset($_REQUEST['make_add']) && $_REQUEST['make_add'] != "") {
        $stmt = $mysql->prepare($sql['truckman_get_make_count']);
        $stmt->bind_params($_REQUEST['make_add']);
        $stmt->execute();
        $c = $stmt->fetch_all();
        if ($c[0]['count'] == 0) {
            $stmt = $mysql->prepare($sql['truckman_add_make']);
            $stmt->bind_params($_REQUEST['make_add']);
            $stmt->execute();
            $stmt = $mysql->prepare("SELECT LAST_INSERT_ID() as `id`;");
            $stmt->execute();
            $id = $stmt->fetch_all();
            $makeid = $id[0]['id'];
        } else {
            $stmt = $mysql->prepare($sql['truckman_find_make']);
            $stmt->bind_params($_REQUEST['make_add']);
            $stmt->execute();
            $m = $stmt->fetch_all();
            $makeid = $m[0]['id'];
        }
    }

    $uid = microtime();

    $loc = explode('/', $_REQUEST['location']);

    $stmt = $mysql->prepare($sql['truckman_add_truck']);

    $stmt->bind_params("", $makeid, $_REQUEST['model'],  $_REQUEST['fuel'],  $_REQUEST['maxload'], $_REQUEST['maxheight'],  $_REQUEST['status'], $typeid, $_REQUEST['price'],
                                    $_REQUEST['pwheel'], $_REQUEST['swheel'], $_REQUEST['engine'], $_REQUEST['drivetrain'], $_REQUEST['hours'],  $_REQUEST['year'], 
                                    $_REQUEST['serial'], $_REQUEST['weight'], $_REQUEST['extras'], $_REQUEST['publicdesc'], $_REQUEST['internaldesc'], $loc[0], $loc[1], 
                                    $_REQUEST['warranty'], $_REQUEST['arrival'], $uid, $_REQUEST['ispart'], $_REQUEST['shortdesc'], $_REQUEST['forks'],
                                    $_REQUEST['seller_name'], $_REQUEST['seller_price'], $_REQUEST['seller_date'], $_REQUEST['seller_invoicenum'],
                                    $_REQUEST['buyer_name'],  $_REQUEST['buyer_price'],  $_REQUEST['buyer_date'],  $_REQUEST['buyer_invoicenum'], $_REQUEST['truck_prodstat'], $_REQUEST['truck_loc_x'], $_REQUEST['truck_loc_y'], $_REQUEST['truck_product_status_ext']);

    if ($stmt->execute()) {
        $mysql->execute($sql['setutf']);

        $stmt = $mysql->prepare($sql['get_truck_by_temp']);

        $stmt->bind_params($uid);

        if ($stmt->execute()) {
            $res = $stmt->fetch_row();
            $res = $res['truck_id'];

            $_SESSION['basket'] = array($res);

            add_offer_request("", $_REQUEST['offer_id']);

            // exit($_REQUEST['offer_id']);
            // copy_trucks_offer($_REQUEST['offer_id'], $res);

            return 1;
        }
    } else {
        return 11;
    }
}


function modify_truck() {
    global $sql;


    //print_r($_REQUEST);

    //$ret = check_truck_data();
    if (isset($ret) && $ret > 1)
        return $ret;

    $loc = explode('/', $_REQUEST['location']);
    if(!$_REQUEST['truck_prodstat']) { $_REQUEST['truck_prodstat'] = $_REQUEST['truck_product_status']; }
    // print('Status: '.$_REQUEST['truck_prodstat']."\r\n\r\n"); print_r($_REQUEST); exit();

    $mysql = get_connection();
    $mysql->execute($sql['setutf']);
    $stmt = "";
    if (ismain()) {

        $typeid = $_REQUEST['type'];
        $makeid = $_REQUEST['make'];
        $functionid = $_REQUEST['function'];

        if (isset($_REQUEST['type_add']) && $_REQUEST['type_add'] != "") {
            $stmt = $mysql->prepare($sql['truckman_get_type_count']);
            $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart']);
            $stmt->execute();
            $c = $stmt->fetch_all();
            if ($c[0]['count'] == 0) {
                //hun and get id
                $stmt = $mysql->prepare($sql['truckman_add_type']);
                $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart'], "hun");
                $stmt->execute();
                $stmt = $mysql->prepare("SELECT LAST_INSERT_ID() as `id`;");
                $stmt->execute();
                $id = $stmt->fetch_all();
                $typeid = $id[0]['id'];

                //eng
                $stmt = $mysql->prepare($sql['truckman_add_type_id']);
                $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart'], "eng", $typeid);
                $stmt->execute();
                //ger
                $stmt = $mysql->prepare($sql['truckman_add_type_id']);
                $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart'], "ger", $typeid);
                $stmt->execute();
            } else {
                $stmt = $mysql->prepare($sql['truckman_find_type']);
                $stmt->bind_params($_REQUEST['type_add'], $_REQUEST['ispart']);
                $stmt->execute();
                $m = $stmt->fetch_all();
                $typeid = $m[0]['id'];
            }
        }

        if (isset($_REQUEST['make_add']) && $_REQUEST['make_add'] != "") {
            $stmt = $mysql->prepare($sql['truckman_get_make_count']);
            $stmt->bind_params($_REQUEST['make_add'], $_REQUEST['ispart']);
            $stmt->execute();
            $c = $stmt->fetch_all();
            if ($c[0]['count'] == 0) {
                $stmt = $mysql->prepare($sql['truckman_add_make']);
                $stmt->bind_params($_REQUEST['make_add'], $_REQUEST['ispart']);
                $stmt->execute();
                $stmt = $mysql->prepare("SELECT LAST_INSERT_ID() as `id`;");
                $stmt->execute();
                $id = $stmt->fetch_all();
                $makeid = $id[0]['id'];
            } else {
                $stmt = $mysql->prepare($sql['truckman_find_make']);
                $stmt->bind_params($_REQUEST['make_add'], $_REQUEST['ispart']);
                $stmt->execute();
                $m = $stmt->fetch_all();
                $makeid = $m[0]['id'];
            }
        }

        if (isset($_REQUEST['maxheight_add']) && $_REQUEST['maxheight_add'] != "")
            $maxheight = $_REQUEST['maxheight_add'];
        else
            $maxheight = $_REQUEST['maxheight'];


        if (isset($_REQUEST['only_ispart']) && $_REQUEST['only_ispart'] == 1) {
            $stmt = $mysql->prepare($sql['truckman_modify_truck_ispart']);
            $stmt->bind_params($_REQUEST['truckid'], $_REQUEST['ispart']);
            $stmt->execute();
            return 1;
        }

        $stmt = $mysql->prepare($sql['truckman_modify_truck']);
        //echo $sql['truckman_modify_truck'];

        $stmt->bind_params(
                addslashes($_REQUEST['truckid']), 
                addslashes($makeid), 
                addslashes($_REQUEST['model']), 
                addslashes($_REQUEST['fuel']), 
                addslashes($_REQUEST['maxload']), 
                addslashes($maxheight), 
                addslashes($_REQUEST['status']),
                
                addslashes($_REQUEST['full-height']),
                addslashes($_REQUEST['cabin-height']),
                addslashes($_REQUEST['length']),
                addslashes($_REQUEST['width']),
                addslashes($_REQUEST['turning-circle']),
                
                addslashes($typeid), 
                addslashes($_REQUEST['price']),
                addslashes($_REQUEST['reseller_price']),
                
                addslashes($_REQUEST['pwheel']), 
                addslashes($_REQUEST['swheel']), 
                addslashes($_REQUEST['engine']), 
                addslashes($_REQUEST['drivetrain']), 
                addslashes($_REQUEST['hours']), 
                addslashes($_REQUEST['year']), 
                addslashes($_REQUEST['serial']), 
                addslashes($_REQUEST['weight']), 
                addslashes($_REQUEST['extras']), 
                addslashes($_REQUEST['publicdesc']), 
                addslashes($_REQUEST['internaldesc']), 
                addslashes($loc[0]), 
                addslashes($loc[1]), 
                addslashes($_REQUEST['warranty']), 
                addslashes($_REQUEST['arrival']), 
                addslashes($_REQUEST['shortdesc']), 
                addslashes($_REQUEST['forks']), 
                addslashes($_REQUEST['truck_public']),
                addslashes($functionid),
                addslashes($_REQUEST['ispart']),
                
                addslashes($_REQUEST['seller_name']),
                addslashes($_REQUEST['seller_price']),
                addslashes($_REQUEST['seller_date']),
                addslashes($_REQUEST['seller_invoicenum']),
                addslashes($_REQUEST['buyer_name']),
                addslashes($_REQUEST['buyer_price']),
                addslashes($_REQUEST['buyer_date']),
                addslashes($_REQUEST['buyer_invoicenum']),
                addslashes((($loc[0]==10 && $loc[1]==0)?(1):((isSet($_REQUEST['truck_product_status']))?($_REQUEST['truck_product_status']):($_REQUEST['truck_prodstat'])))),
                addslashes($_REQUEST['truck_loc_x']),
                addslashes($_REQUEST['truck_loc_y']),
                addslashes($_REQUEST['truck_product_status_ext'])
                );
        //echo '<pre>'.$stmt->last_query().'</pre>';
        //exit();
        // print($_REQUEST['truck_product_status']); exit();
       
    } else {
        $stmt = $mysql->prepare($sql['truckman_modify_truck_base']);

        $stmt->bind_params(addslashes($_REQUEST['truckid']), htmlentities($_REQUEST['internaldesc']));
    }
    
    //if(isSet($_REQUEST['truck_product_status']) AND $_REQUEST['truck_product_status']!=4) { truckman_set_active(addslashes($_REQUEST['truckid']),addslashes($_REQUEST['truck_product_status'])); }

    if ($stmt->execute()) {
        return 1;
    } else {
        return 11;
    }
}

function truck_updated($truckid) {
    global $sql;

    $mysql = get_connection();
    $stmt = $mysql->prepare($sql['truck_updated']);
    $stmt->bind_params($truckid);
    return $stmt->execute();
}

function truckman_set_sold($id) {
    global $sql;

    $mysql = get_connection();
    $stmt = $mysql->prepare($sql['truckman_set_sold']);
    $stmt->bind_params($id);
    return $stmt->execute();
}

function truckman_set_active($id,$st) {
    global $sql;

    $mysql = get_connection();
    $stmt = $mysql->prepare($sql['truckman_set_active']);
    $stmt->bind_params($id);
    $stmt->bind_params($st);
    return $stmt->execute();
}


?>