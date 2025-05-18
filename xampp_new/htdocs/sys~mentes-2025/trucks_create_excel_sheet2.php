<?php
ini_set("include_path", "./");
set_time_limit(9999);
/* DEBUG * /
error_reporting(E_ALL & ~E_NOTICE ^ E_DEPRECATED & ~E_STRICT);
ini_set('error_reporting', E_ALL & ~E_NOTICE ^ E_DEPRECATED & ~E_STRICT);
ini_set("display_errors", 1);
/* ***** */
// include("Spreadsheet/Excel/Writer.php");
include("common.php");

include("/home/www.saxonrt.eu/Excel/PHPExcel.php");
ini_set("include_path", "/home/www.saxonrt.eu");

global $language, $sql;

function out_excel($s) {
	// $s = iconv('UTF-8','ISO-8859-2//TRANSLIT', $s);
	// $s = utf8_decode($s);
	return $s;
}

$cellSize = Array(7,32,20,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24,24);
$collName = Array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

$sql['excel_get-trucks_2'] = "SELECT
  		`trucks`.*,
      (SELECT value FROM truck_make_[0] WHERE truck_make_[0].ID = trucks.truck_make) AS truck_make_sub,
      (SELECT value FROM truck_type_[0] WHERE truck_type_[0].ID = trucks.truck_type) AS truck_type_sub,
      (SELECT value FROM truck_functions_[0] WHERE truck_functions_[0].ID = trucks.truck_function) AS truck_function_sub,
      (SELECT value FROM truck_fuel_[0] WHERE truck_fuel_[0].ID = trucks.truck_fuel) AS truck_fuel_sub,
      (SELECT value FROM truck_status_[0] WHERE truck_status_[0].ID = trucks.truck_status) AS truck_status_sub,
      CONCAT_WS(' ', (SELECT value FROM truck_location WHERE truck_location.depot = trucks.truck_depot AND truck_location.subdepot = 0), (SELECT value FROM truck_location WHERE truck_location.depot = trucks.truck_depot AND truck_location.subdepot = trucks.`truck_sub-depot` AND truck_location.subdepot != '0')) AS truck_location,
			(
				SELECT value
				FROM truck_location
				WHERE truck_location.depot = trucks.truck_depot
					AND truck_location.subdepot = 0
			) AS `truck_location_1`,
			(
				SELECT value
				FROM truck_location
				WHERE truck_location.depot = trucks.truck_depot
					AND truck_location.subdepot = trucks.`truck_sub-depot`
					AND truck_location.subdepot != '0'
			) AS truck_location_2
    FROM `trucks`
    WHERE `truck_type` = {1}  AND `truck_state` = 'A'
    ORDER BY
    IF( `truck_ispart` =  0 , 0 , 1 ),
    IF( `truck_ispart` =  2 , 0 , 1 ),
    IF( `truck_ispart` =  5 , 0 , 1 ),
    IF( `truck_ispart` =  7 , 0 , 1 ),
    IF( `truck_ispart` =  3 , 0 , 1 ),
    IF( `truck_ispart` =  4 , 0 , 1 ),
    IF( `truck_ispart` =  8 , 0 , 1 ),
    IF( `truck_ispart` = 19 , 0 , 1 ),
    IF( `truck_ispart` = 18 , 0 , 1 ),
    IF( `truck_ispart` = 10 , 0 , 1 ),
    IF( `truck_ispart` =  9 , 0 , 1 ),
    IF( `truck_ispart` =  6 , 0 , 1 ),
    IF( `truck_ispart` = 14 , 0 , 1 ),
    IF( `truck_ispart` = 17 , 0 , 1 ),
    IF( `truck_ispart` = 12 , 0 , 1 ),
    IF( `truck_ispart` = 16 , 0 , 1 ),
    IF( `truck_ispart` = 13 , 0 , 1 ),
    IF( `truck_ispart` = 15 , 0 , 1 ),
    IF( `truck_ispart` = 11 , 0 , 1 ),
    `truck_make`, `truck_fuel`, `truck_max-load`, `truck_saxon-id`";


  $sql['excel_get-trucks_2pub'] = "SELECT
  		`trucks`.*,
      (SELECT value FROM truck_make_[0] WHERE truck_make_[0].ID = trucks.truck_make) AS truck_make_sub,
      (SELECT value FROM truck_type_[0] WHERE truck_type_[0].ID = trucks.truck_type) AS truck_type_sub,
      (SELECT value FROM truck_functions_[0] WHERE truck_functions_[0].ID = trucks.truck_function) AS truck_function_sub,
      (SELECT value FROM truck_fuel_[0] WHERE truck_fuel_[0].ID = trucks.truck_fuel) AS truck_fuel_sub,
      (SELECT value FROM truck_status_[0] WHERE truck_status_[0].ID = trucks.truck_status) AS truck_status_sub,
      CONCAT_WS(' ', (SELECT value FROM truck_location WHERE truck_location.depot = trucks.truck_depot AND truck_location.subdepot = 0), (SELECT value FROM truck_location WHERE truck_location.depot = trucks.truck_depot AND truck_location.subdepot = trucks.`truck_sub-depot` AND truck_location.subdepot != '0')) AS truck_location,
			(
				SELECT value
				FROM truck_location
				WHERE truck_location.depot = trucks.truck_depot
					AND truck_location.subdepot = 0
			) AS `truck_location_1`,
			(
				SELECT value
				FROM truck_location
				WHERE truck_location.depot = trucks.truck_depot
					AND truck_location.subdepot = trucks.`truck_sub-depot`
					AND truck_location.subdepot != '0'
			) AS truck_location_2
    FROM `trucks`
    WHERE truck_public = {3} AND `truck_type` = {1} AND `truck_state` = 'A'
    ORDER BY
    IF( `truck_ispart` =  0 , 0 , 1 ),
    IF( `truck_ispart` =  2 , 0 , 1 ),
    IF( `truck_ispart` =  5 , 0 , 1 ),
    IF( `truck_ispart` =  7 , 0 , 1 ),
    IF( `truck_ispart` =  3 , 0 , 1 ),
    IF( `truck_ispart` =  4 , 0 , 1 ),
    IF( `truck_ispart` =  8 , 0 , 1 ),
    IF( `truck_ispart` = 19 , 0 , 1 ),
    IF( `truck_ispart` = 18 , 0 , 1 ),
    IF( `truck_ispart` = 10 , 0 , 1 ),
    IF( `truck_ispart` =  9 , 0 , 1 ),
    IF( `truck_ispart` =  6 , 0 , 1 ),
    IF( `truck_ispart` = 14 , 0 , 1 ),
    IF( `truck_ispart` = 17 , 0 , 1 ),
    IF( `truck_ispart` = 12 , 0 , 1 ),
    IF( `truck_ispart` = 16 , 0 , 1 ),
    IF( `truck_ispart` = 13 , 0 , 1 ),
    IF( `truck_ispart` = 15 , 0 , 1 ),
    IF( `truck_ispart` = 11 , 0 , 1 ),
    `truck_make`, `truck_fuel`, `truck_max-load`, `truck_saxon-id`";


$format_header = Array(
	'font' => Array(
		'bold'  =>  true,
		'size'  =>  8,
		'name'  =>  'Arial'
	)
);

$format_body = Array(
	'font' => Array(
		'bold'  =>  false,
		'size'  =>  8,
		'name'  =>  'Arial'
	)
);

$format_body_url = Array(
	'font' => Array(
		'bold'  =>  false,
		'size'  =>  8,
		'name'  =>  'Arial',
		'color' => array('rgb' => '015692')
	)
);

$cellUnit = 1;
$ExportName = 'saxon';
$row = 1;
$objPHPExcel = new PHPExcel();
PHPExcel_Calculation::getInstance($objPHPExcel)->clearCalculationCache();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Saxon Zrt. PARTS");
$objPHPExcel->getDefaultStyle()->applyFromArray($format_body);

if (isset($_REQUEST['kategoria'])) {

		$publikus=$_REQUEST['publikus'];

		if (isset($_REQUEST['lang']) and $_REQUEST['lang'] == "hun") {
				$lang = "hun";
		} else {
				$lang = "eng";
		}


		$price = isset($_REQUEST['showprice']) && $_REQUEST['showprice'] == '1' ? true : false;
		$showcomment = isset($_REQUEST['showcomment']) && $_REQUEST['showcomment'] == '1' ? true : false;
		$celltomerge = $price ? 11 : 10;

		if ($_REQUEST['partsonly'] == 1)
				$ExportName = 'saxon_parts';
		else if ($_REQUEST['trucksonly'] == 1)
				$ExportName = 'saxon_trucks';
		else
				$ExportName = 'saxon_trucks_and_parts';

		//Az excel file akkor is elkészül, ha itt meg állítom die()-al.

		if ($_REQUEST['kategoria'] == 'a' or $_REQUEST['kategoria'] == 'b' or $_REQUEST['kategoria'] == 'c') {
				$item = 0;
				$kategoria = $_REQUEST['kategoria'];

				$cell = 0;
				
				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Saxonszám'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Fajta'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Gyartmány'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Tipus'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Funkció'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Különleges tulajdonság'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Felszereltség'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Megjegyzés'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Üzemmód'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Teherbírás'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Emelő magasság'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Első kerék'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Hátsó kerék'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Motor'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Akkumulátor'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Villák'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Tárolás'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Tárolás'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Mező'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Mező'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				if($price) $objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				if($price) $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Eladási ár'));
				if($price) $objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				if($price) $objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				if($price) $cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Eladó neve'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Bizonylatszám'));
				$cell++;

				if($price) $objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				if($price) $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Vételi ár'));
				if($price) $objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				if($price) $objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				if($price) $cell++;


				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Category'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;



				$mysql = get_connection();
				$mysql->execute($sql['setutf']);

				if ($kategoria == 'a') {
						$stmt = $mysql->prepare($sql['excel_get-sum']);

						//$stmt->bind_params($lang, '0');
						$stmt->bind_params($lang);
				}

				if ($kategoria == 'b') {
						$stmt = $mysql->prepare($sql['excel_get-sum-b']);

						//$stmt->bind_params($lang, '0');
						$stmt->bind_params($lang, 0, 2, 3, 5);
				}

				if ($kategoria == 'c') {
						$stmt = $mysql->prepare($sql['excel_get-sum-c']);

						//$stmt->bind_params($lang, '0');
						$stmt->bind_params($lang, 1, 4, 6);
				}

				if ($stmt->execute()) {
						$row = 2;
						$result = $stmt->fetch_all();
						$lastIspart = '#';
						for ($i = 0; $i < count($result); $i++) {
								$CategList = false;
								//publikus rész is hozzávéve
								if ($publikus=='x'){
										$stmt = $mysql->prepare($sql['excel_get-trucks_2']);
										$stmt->bind_params($lang, $result[$i]['ID'], $result[$i]['ispart']);
								}
								else{
										$stmt = $mysql->prepare($sql['excel_get-trucks_2pub']);
										$stmt->bind_params($lang, $result[$i]['ID'], $result[$i]['ispart'], $publikus);
								}
								if ($stmt->execute()) {
									$trucks = $stmt->fetch_all();
									if(count($trucks)>0 AND isSet($trucks[0]['truck_id'])) { $CategList = true; } else { $CategList = false; }
									if($CategList) {
										foreach ($trucks as $truck) {
											$item++; $cell = 0;
												if ($truck['truck_saxon-id'] != '') {
														$link = 'https://saxonrt.hu/sys/aktualis_ajax_truck_details.php?lang=' . $_REQUEST['lang'] . '&id=' . $truck['truck_id'];
														$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_saxon-id']));
														$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
														$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->getHyperlink()->setUrl($link);
														$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_body_url);
												}
												$cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_type_sub'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_make_sub'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_model'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_function_sub'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_short-comment'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_extras'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_desc'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_fuel_sub'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_max-load'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_max-height'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_steered-wheel'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_powered-wheel'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_engine'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel(str_replace(Array("\r\n","\r","\n")," ",$truck['truck_public-desc']))); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_forks'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_location_1'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_location_2'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_loc_x'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_loc_y'])); $cell++;
												if($price) { $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_cost'])); $cell++; }
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_seller_name'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_seller_invoicenum'])); $cell++;
												if($price) { $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_seller_price'])); $cell++; }
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($language['aktualis:ispart'][$truck['truck_ispart']]['value'])); $cell++;
												$row++;
										}
									}
								}
						}
				}
		}
		else {

				$lang = $_REQUEST['lang'];
				$kategoria = (int) $_REQUEST['kategoria'];

				$cell = 0;
				
				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Saxonszám'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Fajta'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Gyartmány'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Tipus'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Funkció'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Különleges tulajdonság'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Felszereltség'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Megjegyzés'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Üzemmód'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Teherbírás'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Emelő magasság'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Első kerék'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Hátsó kerék'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Motor'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Akkumulátor'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Villák'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Tárolás'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Tárolás'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Mező'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Mező'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				if($price) $objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				if($price) $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Eladási ár'));
				if($price) $objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				if($price) $objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				if($price) $cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Eladó neve'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Bizonylatszám'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				if($price) $objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				if($price) $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Vételi ár'));
				if($price) $objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				if($price) $objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				if($price) $cell++;


				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Category'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;


				$mysql = get_connection();
				$mysql->execute($sql['setutf']);

				$stmt = $mysql->prepare($sql['excel_get-types_2']);
				$stmt->bind_params($lang, $kategoria);

				if ($stmt->execute()) {
						$row = 2;
						$result = $stmt->fetch_all();

						for ($i = 0; $i < count($result); $i++) {
								
								if ($publikus=='x'){
										$stmt = $mysql->prepare($sql['excel_get-trucks_2']);
										$stmt->bind_params($lang, $result[$i]['ID'], $kategoria);
								}else{
										$stmt = $mysql->prepare($sql['excel_get-trucks_2pub']);
										$stmt->bind_params($lang, $result[$i]['ID'], $kategoria, $publikus);
								}
								if ($stmt->execute()) {
										$trucks = $stmt->fetch_all();
										foreach ($trucks as $truck) {
												$cell = 0;
												if ($truck['truck_saxon-id'] != '') {
														$link = 'https://saxonrt.hu/sys/aktualis_ajax_truck_details.php?lang=' . $_REQUEST['lang'] . '&id=' . $truck['truck_id'];
														$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_saxon-id']));
														$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
														$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->getHyperlink()->setUrl($link);
														$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_body_url);
												}
												$cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_type_sub'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_make_sub'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_model'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_function_sub'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_short-comment'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_extras'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_desc'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_fuel_sub'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_max-load'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_max-height'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_steered-wheel'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_powered-wheel'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_engine'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel(str_replace(Array("\r\n","\r","\n")," ",$truck['truck_public-desc']))); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_forks'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_location_1'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_location_2'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_loc_x'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_loc_y'])); $cell++;
												if($price) { $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_cost'])); $cell++; }
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_seller_name'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_seller_invoicenum'])); $cell++;
												if($price) { $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_seller_price'])); $cell++; }
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($language['aktualis:ispart'][$truck['truck_ispart']]['value'])); $cell++;
												$row++;
										}
								}
						}
				}
		}

} else {
		$price = isset($_REQUEST['showprice']) && $_REQUEST['showprice'] == '1' ? true : false;
		$showcomment = isset($_REQUEST['showcomment']) && $_REQUEST['showcomment'] == '1' ? true : false;
		$celltomerge = $price ? 11 : 10;

		if ($_REQUEST['partsonly'] == 1)
				$ExportName = 'saxon_parts';
		else if ($_REQUEST['trucksonly'] == 1)
				$ExportName = 'saxon_trucks';
		else
				$ExportName = 'saxon_trucks_and_parts';

		//trucks
		if ($_REQUEST['partsonly'] != 1) {

				$cell = 0;
				
				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Saxonszám'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Fajta'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Gyartmány'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Tipus'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Funkció'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Különleges tulajdonság'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Felszereltség'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Megjegyzés'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Üzemmód'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Teherbírás'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Emelő magasság'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Első kerék'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Hátsó kerék'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Motor'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Akkumulátor'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Villák'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Tárolás'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Tárolás'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Mező'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Mező'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				if($price) $objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				if($price) $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Eladási ár'));
				if($price) $objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				if($price) $objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				if($price) $cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Eladó neve'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Bizonylatszám'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				if($price) $objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				if($price) $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Vételi ár'));
				if($price) $objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				if($price) $objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				if($price) $cell++;


				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Category'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

		}


		$mysql = get_connection();
		$mysql->execute($sql['setutf']);

		$stmt = $mysql->prepare($sql['excel_get-types_2']);
		$stmt->bind_params('eng', '0');

		if ($stmt->execute()) {
				$row = 2;
				$result = $stmt->fetch_all();

				for ($i = 0; $i < count($result); $i++) {

						$stmt = $mysql->prepare($sql['excel_get-trucks_2']);
						$stmt->bind_params('eng', $result[$i]['ID'], '0');
						if ($stmt->execute()) {
								$trucks = $stmt->fetch_all();
								foreach ($trucks as $truck) {
										$cell = 0;
										if ($truck['truck_saxon-id'] != '') {
												$link = 'https://saxonrt.hu/sys/aktualis_ajax_truck_details.php?lang=' . $_REQUEST['lang'] . '&id=' . $truck['truck_id'];
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_saxon-id']));
												$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
												$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->getHyperlink()->setUrl($link);
												$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_body_url);
										}
										$cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_type_sub'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_make_sub'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_model'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_function_sub'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_short-comment'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_extras'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_desc'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_fuel_sub'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_max-load'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_max-height'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_steered-wheel'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_powered-wheel'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_engine'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel(str_replace(Array("\r\n","\r","\n")," ",$truck['truck_public-desc']))); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_forks'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_location_1'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_location_2'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_loc_x'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_loc_y'])); $cell++;
										if($price) { $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_cost'])); $cell++; }
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_seller_name'])); $cell++;
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_seller_invoicenum'])); $cell++;
										if($price) { $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_seller_price'])); $cell++; }
										$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($language['aktualis:ispart'][$truck['truck_ispart']]['value'])); $cell++;
										$row++;
								}
						}
				}
		}
		//}

		if ($_REQUEST['trucksonly'] != 1) {

				$cell = 0;
				
				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Saxonszám'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Fajta'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Gyartmány'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Tipus'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Funkció'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Különleges tulajdonság'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Felszereltség'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Megjegyzés'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Üzemmód'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Teherbírás'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Emelő magasság'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Első kerék'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Hátsó kerék'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Motor'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Akkumulátor'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Villák'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Tárolás'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Tárolás'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Mező'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Mező'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				if($price) $objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				if($price) $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Eladási ár'));
				if($price) $objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				if($price) $objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				if($price) $cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Eladó neve'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Bizonylatszám'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				if($price) $objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				if($price) $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Vételi ár'));
				if($price) $objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				if($price) $objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				if($price) $cell++;


				$objPHPExcel->getActiveSheet()->getColumnDimension($collName[$cell])->setWidth($cellSize[$cell]*$cellUnit);
				$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row,  out_excel('Category'));
				$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_header);
				$cell++;

				$mysql = get_connection();
				$mysql->execute($sql['setutf']);

				$stmt = $mysql->prepare($sql['excel_get-types_2']);
				$stmt->bind_params('eng', '1');

				if ($stmt->execute()) {
						$row = 2;
						$result = $stmt->fetch_all();

						for ($i = 0; $i < count($result); $i++) {

								$stmt = $mysql->prepare($sql['excel_get-trucks_2']);
								$stmt->bind_params('eng', $result[$i]['ID'], '1');
								if ($stmt->execute()) {
										$trucks = $stmt->fetch_all();
										foreach ($trucks as $truck) {
												$cell = 0;
												if ($truck['truck_saxon-id'] != '') {
														$link = 'https://saxonrt.hu/sys/aktualis_ajax_truck_details.php?lang=' . $_REQUEST['lang'] . '&id=' . $truck['truck_id'];
														$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_saxon-id']));
														$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
														$objPHPExcel->getActiveSheet()->getCell($collName[$cell].$row)->getHyperlink()->setUrl($link);
														$objPHPExcel->getActiveSheet()->getStyle($collName[$cell].$row)->applyFromArray($format_body_url);
												}
												$cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_type_sub'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_make_sub'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_model'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_function_sub'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_short-comment'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_extras'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_desc'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_fuel_sub'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_max-load'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_max-height'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_steered-wheel'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_powered-wheel'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_engine'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel(str_replace(Array("\r\n","\r","\n")," ",$truck['truck_public-desc']))); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_forks'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_location_1'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_location_2'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_loc_x'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_loc_y'])); $cell++;
												if($price) { $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_cost'])); $cell++; }
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_seller_name'])); $cell++;
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_seller_invoicenum'])); $cell++;
												if($price) { $objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($truck['truck_seller_price'])); $cell++; }
												$objPHPExcel->getActiveSheet()->setCellValue($collName[$cell].$row, out_excel($language['aktualis:ispart'][$truck['truck_ispart']]['value'])); $cell++;
												$row++;
										}
								}
						}
				}
		}

}

$file = '/home/www.saxonrt.eu/tmp/'.time().'.'.(($_ENV['TYPE']==1)?('xls'):('xlsx'));
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:Z1');
$objPHPExcel->setActiveSheetIndex(0);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, (($_ENV['TYPE']==1)?('Excel5'):('Excel2007')));
$objWriter->setPreCalculateFormulas(true);
$objWriter->save($file);
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.($ExportName).'.'.(($_ENV['TYPE']==1)?('xls'):('xlsx')));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
print file_get_contents($file);
unlink($file);
exit();

?>