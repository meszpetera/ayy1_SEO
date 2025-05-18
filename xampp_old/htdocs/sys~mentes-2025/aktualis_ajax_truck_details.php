<?php
include_once("common.php"); 

	$id = $_REQUEST['id'];
	
	if ($id != "")  //@TODO preg_match kell
	{
		$truck = get_truck_details($id);
		//$truck = get_truck_details_public($id);
		if($truck[0]['truck_id']>0)
		{
			$t = get_truck_image($truck[0]['truck_id'], $truck[0]['truck_default-image']);
			$label = get_truck_label($truck[0]['truck_id'], $truck[0]['truck_default-image']);
			//print('"' . $t . '"');
			$truck['truck_default-image'] = (($t == "") ? "" : "../img/trucks/" . $t);
	//    $truck['truck_default-image'] = $truck[0]['truck_default-image'] == "" ? "" : "../img/trucks/" . get_truck_image($truck['truck_id'], $truck[0]['truck_default-image']);
			
			$c = get_image_count($truck[0]['truck_id']);
			for ($i = 0; $i < $c; $i++) {
				$truck[0]['images'][$i] = get_truck_image($truck[0]['truck_id'], $i);
				$truck[0]['labels'][$i] = get_truck_label($truck[0]['truck_id'], $i);
			}
			
			
	//    print_r($truck[0]['images']);
			include("tpl/truck_details.tpl");  
		} else { http_response_code(403); print('<title>403 - Megszünt termék!</title>'); }
	} else { http_response_code(404); print('<title>404 - Nemlétező termék!</title>'); }
?> 