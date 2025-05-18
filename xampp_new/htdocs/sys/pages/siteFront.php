<?php
//search
    $manuf = '<option value="">' . $language['truck-details_manufacturer'] . '</option>';
    $m = get_filter_list('make');
    foreach ($m as $item)
        $manuf .= '<option value="' . $item['ID'] . '">' . $item['value'] . '</option>';

    $maxload = '<option value="">' . $language['truck-details_max-load'] . '</option>';
    $m = get_filter_list('max-load');
    foreach ($m as $item)
        $maxload .= '<option value="' . $item['ID'] . '">' . $item['value'] . '</option>';

    $fuel = '<option value="">' . $language['truck-details_fuel'] . '</option>';
    $m = get_filter_list('fuel');
    foreach ($m as $item)
        $fuel .= '<option value="' . $item['ID'] . '">' . $item['value'] . '</option>';

    $type = '<option value="">' . $language['truck-details_type'] . '</option>';
    $m = get_filter_list('type');
    foreach ($m as $item)
        $type .= '<option value="' . $item['ID'] . '">' . $item['value'] . '</option>';

    $status = '<option value="">' . $language['truck-details_status'] . '</option>';
    $m = get_filter_list('status');
    foreach ($m as $item)
        $status .= '<option value="' . $item['ID'] . '">' . $item['value'] . '</option>';


    $httphost = $_SERVER['HTTP_HOST'];
    $_SERVER['HTTP_HOST'] = "saxonrt.hu";
//weekly featured
    $truck_id = getCurrentDailyOffer();
    $img = "https://".($_SERVER['HTTP_HOST'])."/img/trucks/" . get_truck_default_image($truck_id);
 // @TODO a fitImageIntoRect getimagesize-ol http-n keresztul letoltott jpgre! Ez nagyon lusta es szervergyilkos megoldas!
    $featured = fitImageIntoRect($img, 414, 207);
/*    list($width, $height, $type, $attr) = getimagesize($img);

    $ratio1 = 414/$width;
    $ratio2 = 207/$height;

    $ratio = ($ratio1 > $ratio2) ? $ratio2 : $ratio1;

    $newWidth = $width * $ratio;
    $newHeight = $height * $ratio;
  */
    $truck = get_truck_details($truck_id);

//staff featured

    $featured_trucks = getFeatured();

    $so1_img = "https://".($_SERVER['HTTP_HOST'])."/img/trucks/" . get_truck_default_image($featured_trucks[0]);
    $so1 = fitImageIntoRect($img, 136, 200);
    $so1t = get_truck_details($featured_trucks[0]);
    $so2_img = "https://".($_SERVER['HTTP_HOST'])."/img/trucks/" . get_truck_default_image($featured_trucks[1]);
    $so2 = fitImageIntoRect($img, 136, 200);
    $so2t = get_truck_details($featured_trucks[1]);
    $so3_img = "https://".($_SERVER['HTTP_HOST'])."/img/trucks/" . get_truck_default_image($featured_trucks[2]);
    $so3 = fitImageIntoRect($img, 136, 200);
    $so3t = get_truck_details($featured_trucks[2]);
    $so4_img = "https://".($_SERVER['HTTP_HOST'])."/img/trucks/" . get_truck_default_image($featured_trucks[3]);
    $so4 = fitImageIntoRect($img, 136, 200);
    $so4t = get_truck_details($featured_trucks[3]);


//autospec
/*    $aso = print_r(getAutoSpecOfferTrucks(), true);

   if ((strtotime(date('Y-m-d'))-strtotime(getAutoSpecOfferLastDate()))/(24*60*60) > 30)
    //it has been more than 30 days since we generated a pdf, so make one now
    {
        //setAutoSpecOfferLastDate();



    }
    else
    //there shall be a pdf already, use that one
    {

    }
*/

//3 random promo

    $rp = getRandomPromo();

    $rp0_img = "https://".($_SERVER['HTTP_HOST'])."/img/trucks/" . get_truck_default_image($rp[0]);
    $rp0 = fitImageIntoRect($rp0_img, 156, 120);
    $rp1_img = "https://".($_SERVER['HTTP_HOST'])."/img/trucks/" . get_truck_default_image($rp[1]);
    $rp1 = fitImageIntoRect($rp1_img, 156, 120);
    $rp2_img = "https://".($_SERVER['HTTP_HOST'])."/img/trucks/" . get_truck_default_image($rp[2]);
    $rp2 = fitImageIntoRect($rp2_img, 156, 120);

    $_SERVER['HTTP_HOST'] = $httphost;

    $template = new Template();
    $variables = array ("SAXONID" => $language['truck-details_saxon-id'],
                        "MAKE" => $language['truck-details_manufacturer'],
                        "MAX_LOAD" => $language['truck-details_max-load'],
                        "FUEL" => $language['truck-details_fuel'],
                        "MANUFACTURER_LIST" => $manuf,
                        "FUEL_LIST" => $fuel,
                        "MAX_LOAD_LIST" => $maxload,
                        "TYPE" => $language['truck-details_type'],
                        "TYPE_LIST" => $type,
                        "STATUS" => $language['truck-details_status'],
                        "STATUS_LIST" => $status,
                        "ws_id" => $truck_id,
                        "daily_offer_image" => $img,
                        "daily_offer_image_width" => $featured['width'],
                        "daily_offer_image_height" => $featured['height'],
                        "daily_offer_make" => $truck[0]['truck_make'],
                        "daily_offer_model" => $truck[0]['truck_model'],
                        "daily_offer_saxon-id" => $truck[0]['truck_saxon-id'],
                        "daily_offer_price" => $truck[0]['truck_cost'],
                        "daily_offer_price_2" => $truck[0]['truck_cost']*0.8,
                        "daily_offer_type" => $truck[0]['truck_type'],
                        "daily_offer_fuel" => $truck[0]['truck_fuel'],
                        "daily_offer_max-load" => $truck[0]['truck_max-load'],
                        "daily_offer_max-height" => $truck[0]['truck_max-height'],
                        "daily_offer_status" => $truck[0]['truck_status'],
                        "rp0_id" => $rp[0],
                        "rp0_img" => $rp0_img,
                        "rp0_w" => $rp0['width'],
                        "rp0_h" => $rp0['height'],
                        "rp1_id" => $rp[1],
                        "rp1_img" => $rp1_img,
                        "rp1_w" => $rp1['width'],
                        "rp1_h" => $rp1['height'],
                        "rp2_id" => $rp[2],
                        "rp2_img" => $rp2_img,
                        "rp2_w" => $rp2['width'],
                        "rp2_h" => $rp2['height'],
                        "so1_id" => $featured_trucks[0],
                        "so1_img" => $so1_img,
                        "so1_w" => $so1['width'],
                        "so1_h" => $so1['height'],
                        "so1_saxon-id" => $so1t[0]['truck_saxon-id'],
                        "so1_name" => $so1t[0]['truck_make'] . ' ' . $so1t[0]['truck_model'],
                        "so1_price" => $so1t[0]['truck_special-offer-price'] . ' &euro;',
                        "so2_id" => $featured_trucks[1],
                        "so2_img" => $so2_img,
                        "so2_w" => $so2['width'],
                        "so2_h" => $so2['height'],
                        "so2_saxon-id" => $so2t[0]['truck_saxon-id'],
                        "so2_name" => $so2t[0]['truck_make'] . ' ' . $so2t[0]['truck_model'],
                        "so2_price" => $so2t[0]['truck_special-offer-price'] . ' &euro;',
                        "so3_id" => $featured_trucks[2],
                        "so3_img" => $so3_img,
                        "so3_w" => $so3['width'],
                        "so3_h" => $so3['height'],
                        "so3_saxon-id" => $so3t[0]['truck_saxon-id'],
                        "so3_name" => $so3t[0]['truck_make'] . ' ' . $so3t[0]['truck_model'],
                        "so3_price" => $so3t[0]['truck_special-offer-price'] . ' &euro;',
                        "so4_id" => $featured_trucks[3],
                        "so4_img" => $so4_img,
                        "so4_w" => $so4['width'],
                        "so4_h" => $so4['height'],
                        "so4_saxon-id" => $so4t[0]['truck_saxon-id'],
                        "so4_name" => $so4t[0]['truck_make'] . ' ' . $so4t[0]['truck_model'],
                        "so4_price" => $so4t[0]['truck_special-offer-price'] . ' &euro;'
                        );

    $body_onload_functions .= 'start_moments();';

    $template->assign_var_array($variables);
    $main_content = $template->compile("sys/lang/" . $lang . "/siteFront");

    include("sys/tpl/main.tpl");
?>