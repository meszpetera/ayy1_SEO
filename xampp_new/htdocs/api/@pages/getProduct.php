<?php /* Készítő: H.Tibor */ if(!$_ENV["SiteStart"]) { header("HTTP/1.0 404 Not Found",true,404); exit(); }

if(isSet($_ENV['REURL'][2]) AND ((int)$_ENV['REURL'][2]>0 OR preg_match("/^[a-z]{1}[-]{1}[0-9]{4,6}$/",in_text($_ENV['REURL'][2])) )) {
	$ProductId = 0;
	$ProducetCode = '';

	if((int)$_ENV['REURL'][2]>0) {
		$ProductId = (int)$_ENV['REURL'][2]>0;
	} else {
		$ProducetCode = strtoupper(in_text($_ENV['REURL'][2]));
	}

	$sql = "
		SELECT
			`truck_id`,
			`truck_saxon-id`,
			`truck_model`,
			`truck_max-load`,
			`truck_max-height`,
			`truck_full-height`,
			`truck_cabin-height`,
			`truck_length`,
			`truck_width`,
			`truck_lifting-column-height`,
			`truck_cost`,
			`truck_reseller_price`,
			`truck_date`,
			`truck_reserved`,
			`truck_reserve-start`,
			`truck_reserve-end`,
			`truck_special-offer-active`,
			`truck_special-offer-start`,
			`truck_special-offer-end`,
			`truck_special-offer-price`,
			`truck_default-image`,
			`truck_desc`,
			`truck_powered-wheel`,
			`truck_steered-wheel`,
			`truck_engine`,
			`truck_drivetrain`,
			`truck_hours-used`,
			`truck_year`,
			`truck_serial`,
			`truck_weight`,
			`truck_extras`,
			`truck_internal-desc`,
			`truck_warranty`,
			`truck_expected-arrival`,
			`truck_ispart`,
			`truck_short-comment`,
			`truck_forks`,
			`truck_public`,
			`truck_seller_name`,
			`truck_seller_price`,
			`truck_seller_date`,
			`truck_seller_invoicenum`,
			`truck_buyer_name`,
			`truck_buyer_price`,
			`truck_buyer_date`,
			`truck_buyer_invoicenum`,
			`truck_product_status`,
			`truck_loc_x`,
			`truck_loc_y`,
			`trucks`.`truck_type` AS `truck_type_id`,
			(
				SELECT `value`
				FROM `truck_make_hun`
				WHERE `truck_make_hun`.`ID` = `trucks`.`truck_make`
				LIMIT 1
			) AS `truck_make`,
			(
				SELECT `value`
				FROM `truck_functions_hun`
				WHERE `truck_functions_hun`.`ID` = `trucks`.`truck_function`
				LIMIT 1
			) AS `truck_function`,
			(
				SELECT `value`
				FROM `truck_fuel_hun`
				WHERE `truck_fuel_hun`.`ID` = `trucks`.`truck_fuel`
				LIMIT 1
			) AS `truck_fuel`,
			(
				SELECT `value`
				FROM `truck_status_hun`
				WHERE `truck_status_hun`.`ID` = `trucks`.`truck_status`
				LIMIT 1
			) AS `truck_status`,
			(
				SELECT `value`
				FROM `truck_type_hun`
				WHERE `truck_type_hun`.`ID` = `trucks`.`truck_type`
				LIMIT 1
			) AS `truck_type`,
			(
				SELECT `image_illustration`
				FROM `truck_images`
				WHERE `truck_images`.`image_truck-id` = `trucks`.`truck_id`
					AND `truck_images`.`image_id` = `trucks`.`truck_default-image`
				LIMIT 1
			) AS `truck_default-image_label`,
			(
				SELECT COUNT(*)
				FROM `truck_images`
				WHERE `truck_images`.`image_truck-id` = `trucks`.`truck_id`
			) AS `truck_imagecount`,
			CONCAT_WS(
				' ',
				(
					SELECT `value`
					FROM `truck_location`
					WHERE `truck_location`.`depot` = `trucks`.`truck_depot`
						AND `truck_location`.`subdepot` = 0
					LIMIT 1
				),
				(
					SELECT `value`
					FROM `truck_location`
					WHERE `truck_location`.`depot` = `trucks`.`truck_depot`
						AND `truck_location`.`subdepot` = `trucks`.`truck_sub-depot`
						AND `truck_location`.`subdepot` != '0'
					LIMIT 1
				)
			) AS `truck_location`
		FROM `trucks`
		WHERE "
			.(
				($ProductId > 0)
				?("`trucks`.`truck_id` = '{$ProductId}'")
				:("`trucks`.`truck_saxon-id` = '{$ProducetCode}'")
			)
		."
		LIMIT 1
	";
	$con = mysqli_query($_ENV['MYSQLI'],$sql);
	if($sor = mysqli_fetch_array($con,MYSQLI_ASSOC)) {
		$_ENV['JSON']['success'] = true;
		$_ENV['JSON']['truck'] = $sor;
	} else {
		$_ENV['JSON']['error'] = 'No product!';
	}
} else if(isSet($_ENV['REURL'][2])) {
	$_ENV['JSON']['error'] = 'Invalied ID!';
} else {
	$_ENV['JSON']['error'] = 'No ID!';
}

?>