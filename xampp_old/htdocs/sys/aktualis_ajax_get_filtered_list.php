<?php

include_once("common.php");

//$saxon_id = $_REQUEST['saxonid'];
$akcios = $_REQUEST['akcios'];
$make = $_REQUEST['make'];
$function = $_REQUEST['function'];
$type = $_REQUEST['type'];
$model = "";
$fuel = $_REQUEST['fuel'];
$max_load = $_REQUEST['maxload'];
$status = $_REQUEST['status'];
$terstatus = $_REQUEST['terstatus'];
$cost = $_REQUEST['cost'];
$location = $_REQUEST['location'];
$ispart = isset($_REQUEST['ispart']) && $_REQUEST['ispart'] != "" ? $_REQUEST['ispart'] : 0;
$mode = $_REQUEST['mode'];

// echo 'Mode: '.$mode;

$maxshow = $itemsperpage;

$offset = $_REQUEST['offset'];
if ($offset == "")
    $offset = 0;  //preg_match kell ide is majd


if (isset($_REQUEST['saxonsearch']) && is_string($_REQUEST['saxonsearch']) && $_REQUEST['saxonsearch'] != "") {
    // exit($_REQUEST['saxonsearch']);
    if ($_REQUEST['saxonsearch']=='_-____'){}
    else{
        $saxon_id = search_saxonid($_REQUEST['saxonsearch']);
    }
}
if ($offset == 18) {
    $maxshow = 2;
}

$list = get_filtered_list($akcios, $saxon_id, $make, $model, $fuel, $max_load, $status, $cost, $location, $offset, $maxshow, $type, $ispart, $function, $terstatus);
//print_r($list);
//die();
$pages = floor(($list[0] / $maxshow) + 1);
$links = generate_page_links($list[0], $maxshow, $offset);
if ($list != 0) {
    $data = array(
        "top_menu" => "<div class=\"page_links\" id=\"page_links_up\">" . $links[0] . "</div>",
        "bottom_menu" => "<div class=\"page_links\" id=\"page_links_down\">" . $links[0] . "</div>",
        "main_data" => $list[3],
        "max_show" => $list[1],
        "from" => $list[2],
        "ids" => $list[4]
    );
		
		if(isauth()) {
            $nums = explode('|',str_replace("||","|",preg_replace("/[^0-9|]/", '', strip_tags($links[0]))));
            $max = end($nums);
			$data["top_menu"] = '<script>jQuery("#filtered_list").attr("max",'.($max).');</script>';
			$data["bottom_menu"] = "";
		}
    //  print_r( $data['ids']);
    if ($offset == 18) {
        print_r($data);
    }
    echo json_encode($data);
    //echo "<div class=\"page_links\" id=\"page_links_up\">".$links[0]."</div>@<div class=\"page_links\" id=\"page_links_down\">".$links[0]."</div>";
    // echo "<div id=\"filteredcount\" class=\"dFilteredCount\">". $list[0]. " " .$language['aktualis-count'] ."</div>";
    //  echo ;
} else {
    print("ERROR: Failed to get count of results.");
}
?>