<style>
a.truck_edit_img {
	position: relative;
    display: inline-block;
}

a.truck_edit_img::before {
	content: attr(label);
    display: block;
    position: absolute;
    left: -30px;
    top: 105px;
    width: 380px;
    height: auto;
    padding: 0px 0px;
    text-align: center;
    transform: rotate(-35deg);
    color: #FFF;
    font-size: 20px;
    border-radius: 20px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    background-color: rgba(255, 0, 0, 0.5);
    text-align: center;
    line-height: 1.5em;
    box-shadow: 0px 0px 2px #000000;
}

</style>

<?php

if (!loggedin() && !isauth()) {
    redirect_in_site("?page=$default_page&amp;lang=$lang");
} else {
    print(" ");
    flush();
    
    $mode =  $_REQUEST['mode'];
    $editable = ismain();

    if ($mode==''){
       $enabled = false;}
    else{
       $enabled = true;
    } 

  
    switch ($mode){
      case 'beszer':
           $blokk3 = 'block'; 
           $blokk4 = 'none'; 
           $blokk5 = 'none'; 
           $mode_label = ' - BESZERZÉS';
           break;
      case 'eladas':
           $blokk3 = 'none'; 
           $blokk4 = 'block'; 
           $blokk5 = 'none'; 
           $mode_label = ' - ELADÁS';
           break;
      case 'rakmoz':
           $blokk3 = 'none'; 
           $blokk4 = 'none'; 
           $blokk5 = 'block'; 
           $mode_label = ' - RAKTÁRI MOZGATÁS';
           break;
    }


    if (isset($_REQUEST['truckid'])) {

        $template = new Template();

        $mysql = get_connection();
        $mysql->execute($sql['setutf']);

        $stmt = $mysql->prepare($sql['truck_details']);
        $stmt->bind_params("hun", $_REQUEST['truckid']);
        if ($stmt->execute()) {
            $truck = $stmt->fetch_all();
            //$isp = $truck[0]['truck_ispart'] == 0 ? 0 : 1;
            $isp = $truck[0]['truck_ispart'];
            $curChar = strtoupper(substr($truck[0]['truck_saxon-id'], 0,1));
            //exit($isp);
				    $ispart = "";
				    foreach($language['aktualis:ispart-sort'] AS $val) {
				    	$ispChars = explode(',',strtoupper($language['aktualis:ispart'][$val]['chars']));
				    	if(in_array($curChar, $ispChars)) {
				    		$ispart .= "<option value=\"".($language['aktualis:ispart'][$val]['ID'])."\" " . ($isp === $language['aktualis:ispart'][$val]['ID'] ? "selected" : "") . " >".($language['aktualis:ispart'][$val]['value'])."</option>";
				    	}
				    }
            /** /
            $ispart = "<option value=\"0\" " . ($isp == 0 ? "selected" : "") . ">".($language['aktualis:ispart'][0]['value'])."</option>" .
                      "<option value=\"1\" " . ($isp == 1 ? "selected" : "") . ">".($language['aktualis:ispart'][1]['value'])."</option>" .
                      "<option value=\"2\" " . ($isp == 2 ? "selected" : "") . ">".($language['aktualis:ispart'][2]['value'])."</option>" .
                      "<option value=\"3\" " . ($isp == 3 ? "selected" : "") . ">".($language['aktualis:ispart'][3]['value'])."</option>" .
                      "<option value=\"4\" " . ($isp == 4 ? "selected" : "") . ">".($language['aktualis:ispart'][4]['value'])."</option>" .
                      "<option value=\"5\" " . ($isp == 5 ? "selected" : "") . ">".($language['aktualis:ispart'][5]['value'])."</option>" .
                      "<option value=\"6\" " . ($isp == 6 ? "selected" : "") . ">".($language['aktualis:ispart'][6]['value'])."</option>" .
                      "<option value=\"7\" " . ($isp == 7 ? "selected" : "") . ">".($language['aktualis:ispart'][7]['value'])."</option>" .
                      "<option value=\"8\" " . ($isp == 8 ? "selected" : "") . ">".($language['aktualis:ispart'][8]['value'])."</option>" .
                      "<option value=\"9\" " . ($isp == 9 ? "selected" : "") . ">".($language['aktualis:ispart'][9]['value'])."</option>" .
                      "<option value=\"10\" " . ($isp == 10 ? "selected" : "") . ">".($language['aktualis:ispart'][10]['value'])."</option>" .
                      "<option value=\"11\" " . ($isp == 11 ? "selected" : "") . ">".($language['aktualis:ispart'][11]['value'])."</option>" .
                      "<option value=\"12\" " . ($isp == 12 ? "selected" : "") . ">".($language['aktualis:ispart'][12]['value'])."</option>" .
                      "<option value=\"13\" " . ($isp == 13 ? "selected" : "") . ">".($language['aktualis:ispart'][13]['value'])."</option>" .
                      "<option value=\"14\" " . ($isp == 14 ? "selected" : "") . ">".($language['aktualis:ispart'][14]['value'])."</option>" .
                      "<option value=\"15\" " . ($isp == 15 ? "selected" : "") . ">".($language['aktualis:ispart'][15]['value'])."</option>" .
                      "<option value=\"16\" " . ($isp == 16 ? "selected" : "") . ">".($language['aktualis:ispart'][16]['value'])."</option>" .
                      "<option value=\"17\" " . ($isp == 17 ? "selected" : "") . ">".($language['aktualis:ispart'][17]['value'])."</option>" .
                      "<option value=\"18\" " . ($isp == 18 ? "selected" : "") . ">".($language['aktualis:ispart'][18]['value'])."</option>" .
                      "<option value=\"19\" " . ($isp == 19 ? "selected" : "") . ">".($language['aktualis:ispart'][19]['value'])."</option>";
						/**/
            //exit($truck['truck_ispart']);

            $make = '';
            $make_a = get_filter_list('make');
            foreach ($make_a as $item)
                $make .= '<option value="' . $item['ID'] . (($item['value'] == $truck[0]['truck_make']) ? '" selected>' : '">') . $item['value'] . '</option>';

            $functions = '';
            $functions_a = get_filter_list('function', $isp);
            //print_r($functions_a);
            foreach ($functions_a as $item)
                $functions .= '<option value="' . $item['ID'] . (($item['value'] == $truck[0]['truck_function']) ? '" selected>' : '">') . $item['value'] . '</option>';


            $type = "";
            // $type_a = get_filter_list('type', $isp);
						$type_a = get_filter_list('type', 'all');
						$typeFirst = '';
            foreach ($type_a as $item) {
							if(strstr(strtolower($item['value']),'n/a')) {
								$typeFirst .= '<option class="ispart-' . $item['ispart'] . '" value="' . $item['ID'] . '" '.(($item['ID'] == $truck[0]['truck_type_id'] AND $truck[0]['truck_ispart'] == $item['ispart']) ? ('selected') : (
							($item['ispart']==$isp)?('style="display:block;"'):('')
							)).' >' . $item['value'] . '</option>';
							} else {
								$type .= '<option class="ispart-' . $item['ispart'] . '" value="' . $item['ID'] . '" '.(($item['ID'] == $truck[0]['truck_type_id'] AND $truck[0]['truck_ispart'] == $item['ispart']) ? ('selected') : (
							($item['ispart']==$isp)?('style="display:block;"'):('')
							)).' >' . $item['value'] . '</option>';
              //  $type .= '<option value="' . $item['ID'] . (($item['value'] == $truck[0]['truck_type']) ? '" selected>' : '">') . $item['value'] . '</option>';
							}
						}
						$type = $typeFirst . $type;

            $fuel = "";
            $fuel_a = get_filter_list('fuel');
            foreach ($fuel_a as $item)
                $fuel .= '<option value="' . $item['ID'] . (($item['value'] == $truck[0]['truck_fuel']) ? '" selected>' : '">') . $item['value'] . '</option>';

            $status = "";
            $status_a = get_filter_list('status');
            foreach ($status_a as $item)
                $status .= '<option value="' . $item['ID'] . (($item['value'] == $truck[0]['truck_status']) ? '" selected>' : '">') . $item['value'] . '</option>';

            $maxheight = "";
            $maxheight_a = get_filter_list('max-height');
            foreach ($maxheight_a as $item)
                $maxheight .= '<option value="' . $item['value'] . (($item['value'] == $truck[0]['truck_max-height']) ? '" selected>' : '">') . $item['value'] . '</option>';

            $tilt = ($enabled ? '' : ' disabled');

            $location = "";
            $curlocation = "";
            $location_a = get_filter_list('location');
            foreach ($location_a as $item) {
            	$locids = explode('/',$item['ID']);
            	$locid = (int)$locids[1];
            	if($locid==0 OR $locid>49) {
              	$location .= '<option value="' . $item['ID'] . (($item['value'] == $truck[0]['truck_location']) ? '" selected>' : '"'.$tilt.'>') . $item['value'] . '</option>';
            	}
              if($item['value'] == $truck[0]['truck_location']) {
              	$curlocation = $item['value'];
              }
            }
            $public = "";
            $public_a = get_filter_list('public');
            foreach ($public_a as $item) {
                $public .= '<option value="' . $item['ID'] . '" ' . ((intval($item['ID']) == intval($truck[0]['truck_public'])) ? 'selected' : '' ) . '>' . $item['value'] . '</option> ';
                //(($item['value'] == $truck[0]['truck_public']) ? '" selected>' : '">') . $item['value'] . '</option>';
            }

            $pro = $truck[0]['truck_product_status'];
        		$prodstat = "<option value=\"0\" " . ($pro == 0 ? "selected" : $tilt) .">Raktáron levő</option>" .
        							  "<option value=\"1\" " . ($pro == 1 ? "selected" : $tilt) .">Előrendelt</option>" .
        							  "<option value=\"2\" " . ($pro == 2 ? "selected" : $tilt) .">Bérbeadva</option>" .
        							  "<option value=\"3\" " . ($pro == 3 ? "selected" : $tilt) .">Foglalt-Eladás alatt</option>" .
        							  "<option value=\"4\" " . ($pro == 4 ? "selected" : $tilt) .">Eladva</option>" .
        							  "<option value=\"5\" " . ($pro == 5 ? "selected" : $tilt) .">Bizományban</option>" .
        							  "<option value=\"6\" " . ($pro == 6 ? "selected" : $tilt) .">Elbontva</option>";
            $truck_product_status = $pro;
            
            /*echo 'Harmadik kör 1: ',$truck[0]['truck_product_status'],'<br>';
            echo 'Harmadik kör 2: ',$truck_prodstat,'<br>';
            echo 'Harmadik kör 3: ',$truck_product_status,'<br>';*/
            
        }
        else
            $error = "nincs ilyen számú targonca";

        if (isset($_REQUEST['error']))
            $error = $language['truckman_add']['error'][$_REQUEST['error']];

        //képek listázása
        $stmt = $mysql->prepare($sql['truck_getimages']);
        $stmt->bind_params($_REQUEST['truckid']);
        if ($stmt->execute()) {
            $result = $stmt->fetch_all();

            if ($stmt->num_rows() > 0) {
                $list = '<table>';
                foreach ($result as $image) {
                    $list .= '<tr><td style="width:320px">';
                    if (!is_file('img/trucks/' . $image['image_filename'])){
                        $list .= '<img src="../img/trucks/truck_notfound.jpg"/>' .
                                '</td><td style="width:320px">A kép nem található a szerveren!<br />';
                    }else{
                        $list .= '<a href="img/trucks/' . preg_replace("/\./", '_max.', $image['image_filename'], 1) . '" class="truck_edit_img"'. (($image['image_illustration'])?('label="'.$image['image_illustration']):('')) .'" target="_blank">
						<img src="img/trucks/' . $image['image_filename'] . '" style="width:320px; height:240px"/>
						</a></td><td style="width:320px">' . $image['image_filename'] . '<br />';
                    }

                    if ($image['image_id'] != $truck[0]['truck_default-image']){
                        $list .= '  <a href="sys/truckman_setdefaultimage.php?truckid=' . $_REQUEST['truckid'] . '&amp;imageid=' . $image['image_id'] . '&amp;returnto=truckeditor">kép kiválasztása alapértelmezettként</a><br />';
                    }else{
                        $list .= 'ez az alapértelmezett kép<br />';
                    }

                    $list .= '<br />
                    	<form action="sys/truckman_setimage_labels.php?truckid=' . $_REQUEST['truckid'] . '&imageuniqueid=' . $image['image_unique-id'] . '" method="post" style="margin:0px;padding:0px;display:block;">
                    		<div>
                    			Címke:
                    			<input type="text" name="illustration" value="' . (($image['image_illustration'])?($image['image_illustration']):('')) . '" placeholder="" />
                    			<button type="submit">»</button>
                    		</div>
                    	</form>';

/*
                    if ($image['image_illustration'] == 0) {
                        $list .= '<br />  <a href="sys/truckman_setimage_labels.php?illustration=1&notworking=' . $image['image_notworking'] . '&truckid=' . $_REQUEST['truckid'] . '&imageuniqueid=' . $image['image_unique-id'] . '">Címke hozzáadása: illusztráció</a><br />';
                    } else {
                        $list .= '<br />  <a href="sys/truckman_setimage_labels.php?illustration=0&notworking=' . $image['image_notworking'] . '&truckid=' . $_REQUEST['truckid'] . '&imageuniqueid=' . $image['image_unique-id'] . '">Címke eltávolítása: illusztráció</a><br />';
                    }

                    if ($image['image_notworking'] == 0) {
                        $list .= '<br />  <a href="sys/truckman_setimage_labels.php?illustration=' . $image['image_illustration'] . '&notworking=1&truckid=' . $_REQUEST['truckid'] . '&imageuniqueid=' . $image['image_unique-id'] . '">Címke hozzáadása: Nem működik</a><br />';
                    } else {
                        $list .= '<br />  <a href="sys/truckman_setimage_labels.php?illustration=' . $image['image_illustration'] . '&notworking=0&truckid=' . $_REQUEST['truckid'] . '&imageuniqueid=' . $image['image_unique-id'] . '">Címke eltávolítása:Nem működik</a><br />';
                    }
*/

                    $list .= '<br />  <a href="sys/truckman_promo_image.php?truckid=' . $_REQUEST['truckid'] . '&amp;imagename='.((is_file('img/trucks/'.preg_replace("/\./", '_max.', $image['image_filename'], 1)))?(preg_replace("/\./", '_max.', $image['image_filename'], 1)):($image['image_filename'])).'#dTextScrollBottom" target="_blank">kép elkészült munkáinkhoz</a><br />';
                    $list .= '<br />  <a href="sys/truckman_deleteimage.php?truckid=' . $_REQUEST['truckid'] . '&amp;imageid=' . $image['image_id'] . '&amp;returnto=truckeditor">kép törlése</a><br />';
                    $list .= '</td></tr>';
                }
                $list .= '</table>';
            }
            else
                $list = 'Ehhez a targoncához még nincs kép feltöltve.';
        }
        else
            $list = 'Hiba történt a képek listázásakor.';
				
				$pdf = '/pdf/'.($truck[0]['truck_saxon-id']).'.pdf';
				
				$truck_curpdf = '';
				if(is_file(DOCUMENT_ROOT.$pdf)) {
					$truck_curpdf .= '<span style="display:inline-block;position:absolute;">';
					$truck_curpdf .= '<a href="'.($pdf).'" target="_blank">'.($truck[0]['truck_saxon-id']).'.pdf</a><br/>';
					$truck_curpdf .= '<input type="checkbox" id="delPDF" name="delpdf" value="1" /> <label for="delPDF">[Töröl]</label>';
					$truck_curpdf .= '</span>';
				}

    $prodStatDispl = 'display:'.(($truck[0]['truck_product_status']==2)?('block'):('none')).';';
        $variables = array(
            "TRUCKID" => $_REQUEST['truckid'],
            "RETADDR" => isset($_REQUEST['retaddr']) ? "&amp;retaddr=" . $_REQUEST['retaddr'] : "",
            "PAGEID" => isset($_REQUEST['pageid']) ? "&amp;pageid=" . $_REQUEST['pageid'] : "",
            "SAXONID" => $truck[0]['truck_saxon-id'],
            "TRUCK_MAKE" => $make,
            "TRUCK_FUNCTION" => $functions,
            "TRUCK_MODEL" => $truck[0]['truck_model'],
            "TRUCK_TYPE" => $type,
            "TRUCK_FUEL" => $fuel,
            "TRUCK_MAX-LOAD" => $truck[0]['truck_max-load'],
            "TRUCK_MAX-HEIGHT" => $maxheight,
            "TRUCK_STATUS" => $status,
            "TRUCK_FULL-HEIGHT" => $truck[0]['truck_full-height'],
            "TRUCK_CABIN-HEIGHT" => $truck[0]['truck_cabin-height'],
            "TRUCK_LENGTH" => $truck[0]['truck_length'],
            "TRUCK_WIDTH" => $truck[0]['truck_width'],
            "TRUCK_LIFTING-COLUMN-HEIGHT" => $truck[0]['truck_lifting-column-height'],
            "TRUCK_COST" => $truck[0]['truck_cost'],
            "TRUCK_RESELLER_PRICE" => $truck[0]['truck_reseller_price'],
            "TRUCK_SALE_PRICE" => (special_offer_active($truck[0]) ? "Akciós ár: " . $truck[0]['truck_special-offer-price'] . " " : ""),
            "TRUCK_PUBLIC-DESC" => $truck[0]['truck_desc'],
            "TRUCK_INTERNAL-DESC" => $truck[0]['truck_internal-desc'],
            "TRUCK_SHORT-DESC" => $truck[0]['truck_short-comment'],
            "TRUCK_LOCATION" => $location,
            "TRUCK_CUR_LOCATION" => $curlocation,
            "TRUCK_POWERED-WHEEL" => $truck[0]['truck_powered-wheel'],
            "TRUCK_STEERED-WHEEL" => $truck[0]['truck_steered-wheel'],
            "TRUCK_ENGINE" => $truck[0]['truck_engine'],
            "TRUCK_DRIVETRAIN" => $truck[0]['truck_drivetrain'],
            "TRUCK_HOURS-USED" => $truck[0]['truck_hours-used'],
            "TRUCK_YEAR" => $truck[0]['truck_year'],
            "TRUCK_SERIAL" => $truck[0]['truck_serial'],
            "TRUCK_WEIGHT" => $truck[0]['truck_weight'],
            "TRUCK_FORKS" => $truck[0]['truck_forks'],
            "TRUCK_EXTRAS" => $truck[0]['truck_extras'],
            "TRUCK_WARRANTY" => $truck[0]['truck_warranty'],
            "TRUCK_ARRIVAL" => $truck[0]['truck_expected-arrival'],
            "TRUCK_ISPART" => $ispart,
            "TRUCK_PUBLIC" => $public,
            "TRUCK_SELLER_NAME" => $truck[0]['truck_seller_name'],
            "TRUCK_SELLER_PRICE" => $truck[0]['truck_seller_price'],
            "TRUCK_SELLER_DATE" => $truck[0]['truck_seller_date'],
            "TRUCK_SELLER_INVOICENUM" => $truck[0]['truck_seller_invoicenum'],
            "TRUCK_BUYER_NAME" => $truck[0]['truck_buyer_name'],
            "TRUCK_BUYER_PRICE" => $truck[0]['truck_buyer_price'],
            "TRUCK_BUYER_DATE" => $truck[0]['truck_buyer_date'],
            "TRUCK_BUYER_INVOICENUM" => $truck[0]['truck_buyer_invoicenum'],
            "TRUCK_LOC_X" => $truck[0]['truck_loc_x'],
            "TRUCK_LOC_Y" => $truck[0]['truck_loc_y'],
            "TRUCK_PRODSTAT" => $prodstat,
            "TRUCK_PRODSTAT_EXT" => $truck[0]['truck_product_status_ext'],
            "TRUCK_PRODSTAT_EXT_DISP" => $prodStatDispl,
            "ERROR" => $error,
            "ERRORCOLOR" => ($_REQUEST['error'] == "-1") ? "0f0" : "f00",
            "IMAGES" => $list,
            "UNEDITABLE" => $editable ? "" : "disabled",
            "ENABLED" => $enabled ? "" : "readonly",
            "DISACOLOR" => $enabled ? "" : "color:gray;",
            "RESERVED" => (reserve_active($truck[0]) ? "foglalt" : ""),
            "LASTIMAGE" => $truck[0]['truck_imagecount'],
            "FILTER" => 'function'.$truck[0]['truck_ispart'],
            "TRUCK_CURPDF" => $truck_curpdf,
            "BLOKK3" => $blokk3,
            "BLOKK4" => $blokk4,
            "BLOKK5" => $blokk5,
            "MODE" => $mode,
            "MODE_LABEL" =>$mode_label
        );

        $template->assign_var_array($variables);

        $main_content = $template->compile("sys/lang/hun/truckman_editform");  //WARNING: Language hardcoded, no other languages needed
        include("sys/tpl/main.tpl");
    }
    else {
        $template = new Template();

        $mysql = get_connection();
        $mysql->execute($sql['setutf']);

        if (isset($_REQUEST['sortby'])) {
            if ($_REQUEST['sortby'] == "make")
                $sort = "`truck_make`";
            else if ($_REQUEST['sortby'] == "model")
                $sort = "`truck_model`";
            else if ($_REQUEST['sortby'] == "datedesc")
                $sort = "`truck_date` DESC";
            else if ($_REQUEST['sortby'] == "saxonid")
                $sort = "`truck_saxon-id`";
        }
        else
            $sort = "`truck_saxon-id`";

        $filter = 0; //trucks
        //if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "parts") {
        if (isset($_REQUEST['filter']) ) {
            // $filter = substr($_REQUEST['filter'], -1);
             $filter = substr($_REQUEST['filter'],8);
        }
        $filterstring = '';
        if (isset($_REQUEST['filter_saxonid']) && ($_REQUEST['filter_saxonid'] != ''))
            $filterstring .= ' AND `truck_saxon-id` LIKE \'' . $_REQUEST['filter_saxonid'] . '%\'';

        if (isset($_REQUEST['filter_make']) && ($_REQUEST['filter_make'] != ''))
            $filterstring .= ' AND `truck_make` = ' . $_REQUEST['filter_make'];

        if (isset($_REQUEST['is_public']) && ($_REQUEST['is_public'] != ''))
            $filterstring .= ' AND `truck_public` = ' . $_REQUEST['is_public'];

        $stmt = $mysql->prepare($sql['truckman_edit:get_list']);
				
				if($filter == 'a' or $filter == 'b' or $filter == 'c') {
					$filters = Array(0);
					if($filter == 'b') { $filters = Array(0, 2, 3, 5); }
					if($filter == 'c') { $filters = Array(1, 4, 6); }
					$stmt->bind_params($sort, ' AND ( `truck_ispart` = "'.join('" OR `truck_ispart` = "',$filters).'" ) '. $filterstring);
				} else if($filter == 'v') {
					$stmt->bind_params($sort, ' AND `truck_saxon-id` LIKE "v-%" '. $filterstring);
				} else {
					$stmt->bind_params($sort, ' AND `truck_ispart` = "'.$filter.'" '. $filterstring);
				}

        //$start_time = microtime(true);
        if ($stmt->execute()) {
            //$end_time = microtime(true);
            $trucks = $stmt->fetch_all();
            //$end_time2 = microtime(true);

            if( $trucks[0] !== FALSE ){
            $today = getdate();
            $today = $today['year'] . '-' . $today['mon'] . '-' . $today['mday'];
            $strtotime_today = strtotime($today);
            $strtotime20090301 = strtotime('2009-03-01');

            $list_full = '<table>';
            $i = 0;

            foreach ($trucks as $truck) {
                $list = "";
                if ($i % 30 == 0)
                    $list .= '<tr style="background-color:#fff; font-weight:bold">' .
                            '<td style="width:80px" align="center">kép..</td>' .
                            '<td style="width:80px">' . $language['truckman_edit:saxon-id'] . '</td>' .
                            '<td style="width:340px">' . $language['truckman_edit:make_and_model'] . '</td>' .
                            '<td style="width:30px">ár</td>' .
                            '<td >V.Ár</td>' .
                            '<td style="width:80px">Utolsó módosítás</td>' .
                            '<td style="width:20px">' . $language['truckman_edit:public'] . '</td>' .
                            '<td style="width:48px">' . $language['truckman_edit:hints'] . '</td>' .
                            '<td style="width:100px">' . $language['truckman_edit:actions'] . '</td>' .
                            '</tr>';

                $bgcolor = (($i % 2 == 1) ? '#77a096' : '#88BBB3');

                $msg = "";

                if ((!is_file('img/trucks/' . ($truck['truck_image']))) || ($truck['truck_imagecount'] == 0))
                    $msg = '<img src="img/image_missing.png" alt="nincs kép" title="nincs kép"/>';
                else
                    $msg .= '<img src="img/spacer.png" />';

                //n/a
                if ($truck['truck_make'] == "n/a" ||
                        $truck['truck_type'] == -1 ||
                        $truck['truck_fuel'] == -1 ||
                        $truck['truck_depot'] == 0) {
                    $msg .= '<img src="img/image_incomplete.png" alt="hiányzó adatok" title="hiányzó adatok"/>';
                }
                else
                    $msg .= '<img src="img/spacer.png" />';


                //foglalt-e : átmeneti foglalás
                if ((strtotime($truck['truck_reserve-start']) < $strtotime_today) && ($strtotime_today < strtotime($truck['truck_reserve-end'])) && ($truck['truck_reserved'] == '1'))
                    $msg .= '<img src="img/emblem-readonly.png" alt="Foglalt" title="Foglalt"/>';
                else
                    $msg .= '<img src="img/spacer.png" />';

                //módosított-e
                if (strtotime($truck['truck_date']) < $strtotime20090301)
                    $datemodified = $language['truckman_edit:notedited'];
                else
                    $datemodified = $truck['truck_date'];


                if ($truck['truck_state'] == 'B')
                //foglalt-e : folytonos foglalás
                    $msg .= '<img src="img/emblem-readonly.png" />';

                $list .= '<tr style="background-color:' . $bgcolor . '">' .
                        '<td  align="center"><a href="img/trucks/' . $truck['truck_image'] . '" onclick="return hs.htmlExpand(this, {align: \'center\', objectType: \'iframe\', width: 340, height: 520});"><img src="img/trucks/' . get_truck_thumbnail($truck['truck_image']) . '" width="80" height="60"/></a></td>' .
                        '<td >' . $truck['truck_saxon-id'] . '</td>' .
                        '<td >' . $truck['truck_make'] . ' ' . $truck['truck_model'] . '</td>' .
                        '<td >' . (special_offer_active($truck) ? '<span style="text-decoration: line-through;">' . $truck['truck_cost'] . '</span> <span style="color:#f00;font-weight:bold;margin-left:10px">' . $truck['truck_special-offer-price'] . '</span><br />' : $truck['truck_cost']) . '</td>' .
                        '<td >' .  $truck['truck_reseller_price'] . '</td>' .
                        '<td >' . $datemodified . '</td>' .
                        '<td align="center"><input type="checkbox" class="public" id="id_' . $truck['truck_id'] . '" ' . ((intval($truck['truck_public']) == 1) ? 'checked="checked"' : '' ) . '/></td>' .
                        '<td><a name="truck_' . $truck['truck_id'] . '" />' . $msg . '</td>' .
                        '<td align="center">' .
                        '<a href="?page=truckman_edit&amp;lang=hun&amp;truckid=' . $truck['truck_id'] . '" target="blank" style="margin-right:10px">' . $language['truckman_edit:edit'] . '</a>' .
                        //'<a href="?page=truckman_imageeditor&amp;lang=hun&amp;truckid=' . $truck['truck_id'] . '" style="margin-right:10px">' . $language['truckman_edit:imageeditor'] . '</a>' .
                        /* '<a href="sys/aktualis_truckdetails_createpdf.php?truckid=' . $truck['truck_id'] . '" style="margin-right:10px">Adatlap</a>' . */
                        /* '<a href="sys/sticker_createpdf_single.php?truckid=' . $truck['truck_id'] . '" style="margin-right:10px">cimke</a>' . */
                        //             '<a href="sys/set_truck_state.php?id=' .$truck['truck_id'].'" style="margin-right:10px">Eladva?</a>'.
                        '</td></tr>' . "\r\n";
                $i++;
                $list_full .= $list;
            }
            $list_full .= "</table>";

            }/*!==FALSE*/ else{
                $list_full = 'Nincs találat!';
            }
        }

        $make = "";
        $makearray = get_filter_list('make', $filter);
        foreach ($makearray as $makerow)
            $make .= '<option value="' . $makerow['ID'] . '">' . $makerow['value'] . '</option>';
				$_filterName = Array();
				$_filterName['b'] = 'Minden gép';
				$_filterName['v'] = 'Minden gép';
				// $_filterName['c'] = 'Minden részegység';
				$_filterName['0'] = $language['aktualis:ispart'][0]['value'];
				$_filterName['1'] = $language['aktualis:ispart'][1]['value'];
				$_filterName['2'] = $language['aktualis:ispart'][2]['value'];
				$_filterName['3'] = $language['aktualis:ispart'][3]['value'];
				$_filterName['4'] = $language['aktualis:ispart'][4]['value'];
				$_filterName['5'] = $language['aktualis:ispart'][5]['value'];
				$_filterName['6'] = $language['aktualis:ispart'][6]['value'];
				$_filterName['7'] = $language['aktualis:ispart'][7]['value'];
				$_filterName['8'] = $language['aktualis:ispart'][8]['value'];
				$_filterName['9'] = $language['aktualis:ispart'][9]['value'];
				$_filterName['10'] = $language['aktualis:ispart'][10]['value'];
				$_filterName['11'] = $language['aktualis:ispart'][11]['value'];
				$_filterName['12'] = $language['aktualis:ispart'][12]['value'];
				$_filterName['13'] = $language['aktualis:ispart'][13]['value'];
				$_filterName['14'] = $language['aktualis:ispart'][14]['value'];
				$_filterName['15'] = $language['aktualis:ispart'][15]['value'];
				$_filterName['16'] = $language['aktualis:ispart'][16]['value'];
				$_filterName['17'] = $language['aktualis:ispart'][17]['value'];
				$_filterName['18'] = $language['aktualis:ispart'][18]['value'];
				$_filterName['19'] = $language['aktualis:ispart'][19]['value'];
        //$end_time3 = microtime(true);

				$SORT = isset($_REQUEST['sortby']) ? $_REQUEST['sortby'] : "saxonid";
        $ispartFunctions = "";
        foreach($language['aktualis:ispart-sort'] AS $val) {
        	$ispartFunctions .= "<a href=\"?page=truckman_edit&amp;lang=hun&amp;sortby={$SORT}&amp;filter=function".($language['aktualis:ispart'][$val]['ID'])."\">".($language['aktualis:ispart'][$val]['value'])."</a><br />";
    		}

        $variables = array(
            "LIST" => $list_full,
            "ERROR" => $error,
            "FILTERING" => $_filterName[$filter],
            "SORT" => isset($_REQUEST['sortby']) ? $_REQUEST['sortby'] : "saxonid",
            "FILTER" => $filter == 0 ? 0 : $filter,
            "MAKE" => $make,
            "ispartFunctions" => $ispartFunctions
        );

        $template->assign_var_array($variables);



        $main_content = $template->compile("sys/lang/hun/truckman_edit.tpl");  //WARNING: Language hardcoded, no other languages needed
        //$main_content =  $main_content . $template->compile("sys/lang/" . $lang . "/aktualis");
//$end_time4 = microtime(true);
        include("sys/tpl/main.tpl");
        
        //$end_time5 = microtime(true);
    }
}
/*  print("***Execution times***" .
  "\n***MySQL Query time: " . ($end_time - $start_time) .
  "***\n***MySQL fetch time: " . ($end_time2 - $end_time) .
  "***\n***Table generation time: " . ($end_time3 - $end_time2) .
  "***\n***Template compilation time: " . ($end_time4 - $end_time3) .
  "***\n***Sending time: " . ($end_time5 - $end_time4) . "***");
 */
?>

<script>

function ellenor(p1)
{
	var hibastr='';
  var mode = p1;
  
  switch (mode){
    case 'beszer':
          if (getObj('seller_name')=='')		                                        { hibastr += "Az eladó neve nem lehet üres!\n"; }
          if (getObj('seller_price')=='' || getObj('seller_price')==0)		          { hibastr += "A vételi ár nem lehet nulla!\n"; }
          if (getObj('seller_date')==''  || getObj('seller_date')=='0000-00-00')		{ hibastr += "A vétel dátuma helytelen!\n"; }
          if (getObj('seller_invoicenum')=='')		                                  { hibastr += "A számla száma nem lehet üres!\n"; }
          break;
    case 'eladas':
          if (getObj('buyer_name')=='')		                                        { hibastr += "A vevő neve nem lehet üres!\n"; }
          if (getObj('buyer_price')=='' || getObj('buyer_price')==0)		          { hibastr += "Az eladási ár nem lehet nulla!\n"; }
          if (getObj('buyer_date')==''  || getObj('buyer_date')=='0000-00-00')		{ hibastr += "Az eladás dátuma helytelen!\n"; }
          if (getObj('buyer_invoicenum')=='')		                                  { hibastr += "A számla száma nem lehet üres!\n"; }
          break;

   default:
          return true;
  } 
  
	if (hibastr=='') { return true; } else { alert(hibastr); document.getElementById("arrival").focus(); return false; } 
}

function getObj(p2){ 
	return document.getElementById(p2).value; 
} 
</script>
