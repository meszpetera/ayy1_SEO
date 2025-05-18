<?php /* Készítő: H.Tibor */
header('HTTP/1.0 200 Found',true,200);

$_ENV['SQL'] = @mysqli_connect('localhost','saxonrt','NwzV6Dc');
mysqli_select_db($_ENV['SQL'],'saxonrt');
mysqli_query($_ENV['SQL'],'SET NAMES utf8');
$nw = "\r\n";
$tab = "\t";

/** /
$nw = "";
$tab = "";
/**/

$_ENV['ispart'] = Array();
$_ENV['ispart'][0] = 'Villás targoncák';
$_ENV['ispart'][1] = 'Fődarabok';
$_ENV['ispart'][2] = 'Építőipari és kommunális gépek';
$_ENV['ispart'][3] = 'Kézi emelők';
$_ENV['ispart'][4] = 'Adapterek';
$_ENV['ispart'][5] = 'Vontatók, golfautók, pótkocsik, speciális járművek';
$_ENV['ispart'][6] = 'Kiegészítők';
$_ENV['ispart'][7] = 'Sehová';
$_ENV['ispart'][8] = 'Emelő oszlopok';
$_ENV['ispart'][9] = 'Kerekek, gumik';
$_ENV['ispart'][10] = 'Akkumulátorok';
$_ENV['ispart'][11] = 'Valami';
$_ENV['ispart'][12] = 'Hajtóművek';
$_ENV['ispart'][13] = 'Hajtott hidak';
$_ENV['ispart'][14] = 'Karosszéria elemek';
$_ENV['ispart'][15] = 'Hidraulika elemek';
$_ENV['ispart'][16] = 'Kormányzott hidak';
$_ENV['ispart'][17] = 'Motorok';
$_ENV['ispart'][18] = 'Töltők';
$_ENV['ispart'][19] = 'Villák';

$_ENV['ispart_en'] = Array();
$_ENV['ispart_en'][0] = 'Forklift trucks';
$_ENV['ispart_en'][1] = 'Main parts';
$_ENV['ispart_en'][2] = 'Construction and communal machines';
$_ENV['ispart_en'][3] = 'Handling equipments';
$_ENV['ispart_en'][4] = 'Attachements';
$_ENV['ispart_en'][5] = 'Towing trucks - golf carts - trailers - special machines';
$_ENV['ispart_en'][6] = 'Accessories';
$_ENV['ispart_en'][7] = 'Nowhere';
$_ENV['ispart_en'][8] = 'Lift masts';
$_ENV['ispart_en'][9] = 'Wheels, tires';
$_ENV['ispart_en'][10] = 'Batteries';
$_ENV['ispart_en'][11] = 'Something';
$_ENV['ispart_en'][12] = 'Transmissions';
$_ENV['ispart_en'][13] = 'Driving axles';
$_ENV['ispart_en'][14] = 'Body parts';
$_ENV['ispart_en'][15] = 'Hydraulics';
$_ENV['ispart_en'][16] = 'Steering axles';
$_ENV['ispart_en'][17] = 'Engines';
$_ENV['ispart_en'][18] = 'Chargers';
$_ENV['ispart_en'][19] = 'Forks';

$_ENV['locale'] = Array();
$_ENV['locale'][1000] = 'coming soon';
$_ENV['locale'][400] = 'Felszerelve';
$_ENV['locale'][300] = 'Megszűnt';
$_ENV['locale'][100] = 'Vecsés 1';
$_ENV['locale'][134] = 'Vecsés 1 ÁRÚHÁZ';
$_ENV['locale'][104] = 'Vecsés 1 B.T.';
$_ENV['locale'][103] = 'Vecsés 1 B.T.F.';
$_ENV['locale'][119] = 'Vecsés 1 B.T.P';
$_ENV['locale'][112] = 'Vecsés 1 B.T.R.';
$_ENV['locale'][131] = 'Vecsés 1 B.T.R.P';
$_ENV['locale'][105] = 'Vecsés 1 B.T.U';
$_ENV['locale'][111] = 'Vecsés 1 B.T.U.';
$_ENV['locale'][101] = 'Vecsés 1 H.SZ.T.';
$_ENV['locale'][102] = 'Vecsés 1 Műhely';
$_ENV['locale'][132] = 'Vecsés 1 MŰHELY UDVAR';
$_ENV['locale'][126] = 'Vecsés 1 Parkoló';
$_ENV['locale'][133] = 'Vecsés 1 RAKTÁR';
$_ENV['locale'][123] = 'Vecsés 1 Sátor';
$_ENV['locale'][118] = 'Vecsés 1 SÁTOR UDVAR';
$_ENV['locale'][200] = 'Vecsés 2';
$_ENV['locale'][212] = 'Vecsés 2 BEJÁRÓ';
$_ENV['locale'][213] = 'Vecsés 2 CSARNOK 1.';
$_ENV['locale'][204] = 'Vecsés 2 CSARNOK 2.';
$_ENV['locale'][202] = 'Vecsés 2 ELÖKERT 1.';
$_ENV['locale'][207] = 'Vecsés 2 ELÖKERT 2.';
$_ENV['locale'][205] = 'Vecsés 2 H.SZ.T. 1.';
$_ENV['locale'][203] = 'Vecsés 2 H.SZ.T. 2.';
$_ENV['locale'][208] = 'Vecsés 2 OL. KERT.';
$_ENV['locale'][211] = 'Vecsés 2 OL. KERT. 2.';
$_ENV['locale'][201] = 'Vecsés 2 OL. TÁR.';

function out_xml($s) { return str_replace("&",'&amp;',$s); }

$terCon = mysqli_query($_ENV['SQL'],'
	SELECT
		( SELECT `value` FROM `truck_fuel_hun` WHERE `ID`=`truck_fuel` ) `fuel`,
		( SELECT `value` FROM `truck_fuel_eng` WHERE `ID`=`truck_fuel` ) `fuel_en`,
		( SELECT `value` FROM `truck_make_hun` WHERE `ID`=`truck_make` ) `make`,
		( SELECT `value` FROM `truck_make_eng` WHERE `ID`=`truck_make` ) `make_en`,
		( SELECT `value` FROM `truck_status_hun` WHERE `ID`=`truck_status` ) `status`,
		( SELECT `value` FROM `truck_status_eng` WHERE `ID`=`truck_status` ) `status_en`,
		( SELECT `value` FROM `truck_type_hun` WHERE `ID`=`truck_type` ) `type`,
		( SELECT `value` FROM `truck_type_eng` WHERE `ID`=`truck_type` ) `type_en`,
		( SELECT `value` FROM `truck_functions_hun` WHERE `ID`=`truck_function` ) `function`,
		( SELECT `value` FROM `truck_functions_eng` WHERE `ID`=`truck_function` ) `function_en`,
		`trucks`.*
	FROM `trucks`
	WHERE `truck_state` = "A" AND `truck_public` = 1 AND truck_product_status = 0
		AND ( `truck_saxon-id` LIKE "H-%" OR `truck_saxon-id` LIKE "V-%" OR `truck_saxon-id` LIKE "A-%" OR `truck_saxon-id` LIKE "M-%" )
	ORDER BY `truck_id`
');

if(isSet($_GET['counter'])) { print mysqli_num_rows($terCon); exit(); }

if(isSet($_GET['download'])) {
	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename="export-'.(date('Y-m-d_H.i')).'.xml"');
}

header('Content-type: text/xml; charset=utf-8');
print('<?xml version="1.0" encoding="UTF-8"?>'.$nw);
print('<products>'.$nw);

while($ter = mysqli_fetch_array($terCon)) {
	print($tab.'<item>'.$nw);
		print($tab.$tab.'<id>'.out_xml($ter['truck_id']).'</id>'.$nw);
		print($tab.$tab.'<saxon-id>'.out_xml($ter['truck_saxon-id']).'</saxon-id>'.$nw);
		print($tab.$tab.'<category>'.out_xml($_ENV['ispart_en'][$ter['truck_ispart']]).'</category>'.$nw);
		print($tab.$tab.'<type>'.out_xml($ter['type_en']).'</type>'.$nw);
		print($tab.$tab.'<make>'.out_xml($ter['make_en']).'</make>'.$nw);
		print($tab.$tab.'<function>'.out_xml($ter['function_en']).'</function>'.$nw);
		print($tab.$tab.'<model>'.out_xml($ter['truck_model']).'</model>'.$nw);
		print($tab.$tab.'<fuel>'.out_xml($ter['fuel_en']).'</fuel>'.$nw);
		// print($tab.$tab.'<product-status>'.out_xml($ter['status_en']).'</product-status>'.$nw);
		print($tab.$tab.'<max-load unit="kg.">'.out_xml($ter['truck_max-load']).'</max-load>'.$nw);
		print($tab.$tab.'<max-height unit="mm.">'.out_xml($ter['truck_max-height']).'</max-height>'.$nw);
		print($tab.$tab.'<status>'.out_xml($ter['truck_status']).'</status>'.$nw);
		print($tab.$tab.'<full-height>'.out_xml($ter['truck_full-height']).'</full-height>'.$nw);
		print($tab.$tab.'<cabin-height>'.out_xml($ter['truck_cabin-height']).'</cabin-height>'.$nw);
		print($tab.$tab.'<length>'.out_xml($ter['truck_length']).'</length>'.$nw);
		print($tab.$tab.'<width>'.out_xml($ter['truck_width']).'</width>'.$nw);
		print($tab.$tab.'<lifting-column-height>'.out_xml($ter['truck_lifting-column-height']).'</lifting-column-height>'.$nw);
		//print($tab.$tab.'<comments>'.out_xml($ter['truck_desc']).'</comments>'.$nw);
		print($tab.$tab.'<special-features>'.out_xml($ter['truck_short-comment']).'</special-features>'.$nw);
		print($tab.$tab.'<powered-wheel>'.out_xml($ter['truck_powered-wheel']).'</powered-wheel>'.$nw);
		print($tab.$tab.'<steered-wheel>'.out_xml($ter['truck_steered-wheel']).'</steered-wheel>'.$nw);
		print($tab.$tab.'<engine>'.out_xml($ter['truck_engine']).'</engine>'.$nw);
		print($tab.$tab.'<drivetrain>'.out_xml($ter['truck_drivetrain']).'</drivetrain>'.$nw);
		print($tab.$tab.'<hours-used>'.out_xml($ter['truck_hours-used']).'</hours-used>'.$nw);
		print($tab.$tab.'<year>'.out_xml($ter['truck_year']).'</year>'.$nw);
		//print($tab.$tab.'<serialno>'.out_xml($ter['truck_serial']).'</serialno>'.$nw);
		print($tab.$tab.'<weight>'.out_xml($ter['truck_weight']).'</weight>'.$nw);
		print($tab.$tab.'<forks>'.out_xml($ter['truck_forks']).'</forks>'.$nw);
		print($tab.$tab.'<extras>'.out_xml($ter['truck_extras']).'</extras>'.$nw);
		print($tab.$tab.'<warranty>'.out_xml($ter['truck_warranty']).'</warranty>'.$nw);
		print($tab.$tab.'<expected-arrival>'.out_xml($ter['truck_expected-arrival']).'</expected-arrival>'.$nw);
		print($tab.$tab.'<price unit="EUR">'.out_xml($ter['truck_cost']).'</price>'.$nw);
		print($tab.$tab.'<images>'.$nw);
		$imgurl = 'http://saxonrt.hu/img/trucks/';
		$kepCon = mysqli_query($_ENV['SQL'],'
			SELECT *
			FROM `truck_images` 
			WHERE `image_truck-id` = "'.($ter['truck_id']).'"
			ORDER BY IF(`image_id`="'.($ter['truck_default-image']).'",0,1), `image_id`
		');
		while($kep = mysqli_fetch_array($kepCon)) {
				print($tab.$tab.$tab.'<image>'.($imgurl.str_replace('.jpg','_max.jpg',$kep['image_filename'])).'</image>'.$nw);
		}
		print($tab.$tab.'</images>'.$nw);
	print($tab.'</item>'.$nw);
}
print('</products>');

exit();
?>