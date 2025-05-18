<?php
include_once("common.php");

$truck = get_truck_details(addslashes($_REQUEST['truckid']));
$truck = $truck[0];

if(isSet($_REQUEST['print'])) {
header('Content-type: text/html; charset=utf-8');
print('
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=6.0, user-scalable=0" />
		<meta name="robots" content="noindex, nofollow" />
		<style>
			@page {
				size: 210mm 297mm;
				margin: 3mm 3mm 3mm 3mm;
				margin: 0mm;
			}
			* { margin-top: 0px; border: none; outline: none; }
			html, body { padding: 0px; margin: 0px; '.((isSet($_REQUEST['web'])?('width: 210mm;'):('width: 100%;'))).' position: relative; font-size: 16px; font-size: 4mm; font-family: Arial; line-height: normal; color: #000; background-color: #FFF; }
			p { margin: 0px; padding: 0px; line-height: normal; }
			th, td { padding: 0px; vertical-align: top; }
			#page { position: relative; width: 100%; height: auto; margin: 0px; padding: 0px; border: none; outline: none; font-size: 1em; }
			#leftCell { padding: 3mm 3mm; padding-left: 8mm; }
			#rightCell { width: 46%; padding: 3mm 3mm; padding-right: 7mm; }
			#header { width: 100%; min-height: 22mm; }
			#code { width: 29mm; height: 29mm; display: inline-block; vertical-align: middle; }
			#SaxonID { font-size: 16.5mm; color: #fc0800; font-weight: bold; vertical-align: middle; display: inline-block; top: 1mm; position: relative; left: 1mm; }
			h3 { display: block; position: relative; font-size: 1.17em; font-weight: bold; margin: 0px; line-height: 1.17em; margin-bottom: 5mm; }
			h3 > small { display: block; position: relative; font-size: smaller; font-weight: normal; }

			#data { position: relative; width: 100%; height: auto; margin: 0px; padding: 0px; border: none; outline: none; font-size: 0.9em; }
			#data th { padding: 1mm; font-weight: normal; text-align: left; width: 44mm; }
			#data td { padding: 1mm; font-weight: normal; text-align: left; }
			#price th, #price td { font-size: 1.75em; line-height: 1.75em; color: #fc0800; font-weight: bold; }

			#images { width: 100%; font-size: 0px; }
			#images th { width: 100%; padding: 1mm; text-align: center; vertical-align middle; }
			#images td { width: 33%; padding: 1mm; text-align: center; vertical-align middle; }
			#images img { width: 100%; }
		</style>
	</head>
	<body>
		<table id="page" cellspacing="0" cellpadding="0" border="0">
			<thead><tr><th colspan="2"><img src="https://'.($_SERVER['HTTP_HOST']).'/img/flyer/flyer_header_' . $lang . '.jpg" id="header" /></th></tr></thead>
			<tbody>
				<tr>
					<td id="leftCell">
						<p style="margin-bottom: 5mm;">
							<img src="https://'.($_SERVER['HTTP_HOST']).'/newqr/?text='.urlencode('https://'.($_SERVER['HTTP_HOST']).'/sys/aktualis_ajax_truck_details.php?lang=hun&id='.($truck['truck_id']).'#'.($truck['truck_saxon-id'])).'" id="code" />
							<span id="SaxonID">'.($truck['truck_saxon-id']).'</span>
						</p>
						<h3>
							'.($truck['truck_type']).'
							<small>'.($truck['truck_make'] . ' ' . $truck['truck_model']).'</small>
						</h3>
						<table id="data" cellspacing="0" cellpadding="0" border="0">
							<tbody>
								<tr> <th>'.($language['truck-details_type']).':</th> <td>'.($truck['truck_type']).'</td> </tr>
								<tr> <th>'.($language['truck-details_function']).':</th> <td>'.($truck['truck_function']).'</td> </tr>
								<tr> <th>'.($language['truck-details_status']).':</th> <td>'.($truck['truck_status']).'</td> </tr>
								<tr> <th>'.($language['truck-details_fuel']).':</th> <td>'.($truck['truck_fuel']).'</td> </tr>
								<tr> <th>'.($language['truck-details_max-load']).':</th> <td>'.($truck['truck_max-load']).' kg</td> </tr>
								<tr> <th>'.($language['truck-details_max-height']).':</th> <td>'.($truck['truck_max-height']).'</td> </tr>
								<tr> <th>'.($language['truck-details_powered-wheel']).':</th> <td>'.($truck['truck_powered-wheel']).'</td> </tr>
								<tr> <th>'.($language['truck-details_steered-wheel']).':</th> <td>'.($truck['truck_steered-wheel']).'</td> </tr>
								<tr> <th>'.($language['truck-details_engine']).':</th> <td>'.($truck['truck_engine']).'</td> </tr>
								<tr> <th>'.($language['truck-details_drivetrain']).':</th> <td>'.($truck['truck_drivetrain']).'</td> </tr>
								<tr> <th>'.($language['truck-details_hours-used']).':</th> <td>'.($truck['truck_hours-used']).'</td> </tr>
								<tr> <th>'.($language['truck-details_year']).':</th> <td>'.($truck['truck_year']).'</td> </tr>
								<tr> <th>'.($language['truck-details_serial']).':</th> <td>'.($truck['truck_serial']).'</td> </tr>
								<tr> <th>'.($language['truck-details_weight']).':</th> <td>'.($truck['truck_weight']).'</td> </tr>
								<tr> <th>'.($language['truck-details_forks']).':</th> <td>'.($truck['truck_forks']).'</td> </tr>
								<tr> <th>'.($language['truck-details_full-height']).':</th> <td>'.($truck['truck_full-height']).'</td> </tr>
								<tr> <th>'.($language['truck-details_cabin-height']).':</th> <td>'.($truck['truck_cabin-height']).'</td> </tr>
								<tr> <th>'.($language['truck-details_length']).':</th> <td>'.($truck['truck_length']).'</td> </tr>
								<tr> <th>'.($language['truck-details_width']).':</th> <td>'.($truck['truck_width']).'</td> </tr>
								<tr> <th>'.($language['truck-details_lifting-column-height']).':</th> <td>'.($truck['truck_lifting-column-height']).'</td> </tr>
								<tr> <th>'.($language['truck-details_extras']).':</th> <td>'.($truck['truck_extras']).'</td> </tr>
								<tr> <th>'.($language['truck-details_warranty']).':</th> <td>'.($truck['truck_warranty']).'</td> </tr>
								<tr> <th>'.($language['truck-details_expected-arrival']).':</th> <td>'.($truck['truck_expected-arrival']).'</td> </tr>
								<tr> <th>'.($language['truck-details_location']).':</th> <td>'.($truck['truck_location']).'</td> </tr>
								<tr id="price"> <th>'.($language['truck-details_cost']).':</th> <td>'.($truck['truck_cost']).' EUR'.($language['truck-details_cost-VAT']).'</td> </tr>
								<tr> <th>'.($language['truck-details_comment']).':</th> <td>'.($truck['truck_desc']).'</td> </tr>
							</tbody>
						</table>
					</td>
					<td width="40%" id="rightCell">
						<table id="images" cellspacing="0" cellpadding="0" border="0">');
$x = 3;
$n = 0;
$c = get_image_count($_REQUEST['truckid']);
$defaultimg = get_truck_default_image($_REQUEST['truckid']);
if(is_file("../img/trucks/" . $defaultimg)) {
	if(is_file("../img/trucks/" . str_replace('.jpg','_max.jpg',$defaultimg))) { $defaultimg = str_replace('.jpg','_max.jpg',$defaultimg); }
	print('<thead><tr><th colspan="'.($x).'"><img src="https://'.($_SERVER['HTTP_HOST']).'/img/trucks/'.($defaultimg).'" /></th></tr></thead>');
}
print('<tbody><tr>');
for($i = 0; $i < $c; $i++) {
	$img = get_truck_image($truck['truck_id'], $i);
	if($img != $defaultimg) {
		if(is_file('../img/trucks/' . $img)) {
			$n++;
			// if(is_file("../img/trucks/" . str_replace('.jpg','_max.jpg',$img))) { $img = str_replace('.jpg','_max.jpg',$img); }
			print('<td><img src="https://'.($_SERVER['HTTP_HOST']).'/img/trucks/'.($img).'" /></td>');
			if(!($n%$x)) { print('</tr><tr>'); }
		}
	}
}
print('
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
	</body>
</html>
');
exit();
} else {
	$data = file_get_contents('https://web.xls.hu/pdf.php?name='.($truck['truck_saxon-id']).'&url='.urlencode('https://'.($_SERVER['HTTP_HOST']).'/sys/aktualis_truckdetails_createpdf.v1.php?truckid='.($_REQUEST['truckid']).'&print=1').'&B=3&L=3&R=3&T=3&W=210&H=297');
	header('Content-Type: application/pdf');
	header('Content-Length: '.strlen($data));
	header('Content-Disposition: inline; filename="'.(urlencode($truck['truck_saxon-id'])).'.pdf"');
	header('Cache-Control: private, max-age=0, must-revalidate');
	header('Pragma: public');
	ini_set('zlib.output_compression','0');
	print $data;
}
?>