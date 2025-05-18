<?php

global $mode;

$mode =  $_REQUEST['mode'];

switch ($mode){
  case 'beszer':
       $mode_label = 'BESZERZÉS';
       break;
  case 'eladas':
       $mode_label = 'ELADÁS';
       break;
  case 'rakmoz':
       $mode_label = 'RAKTÁRI MOZGATÁS';
       break;
}

//csak az első betöltésnél fut
if (isset($_REQUEST['edit_truck']) && $_REQUEST['edit_truck'] == "1") {
    $show_basket = false;
}
$filterlist = get_filter_list("make");
//unction get_filtered_list($saxon_id, $make, $model, $fuel, $max_load, $status, $cost, $location, $offset, $maxshow, $type, $ispart = 0)
if(!isset($_REQUEST['__ispart'])){
    //$_REQUEST['__ispart'] = 0;
}

if (isset($_REQUEST['saxonsearch']) && is_string($_REQUEST['saxonsearch']) && $_REQUEST['saxonsearch'] != "") {
    // exit($_REQUEST['saxonsearch']);
    $_REQUEST['__saxonid'] = search_saxonid($_REQUEST['saxonsearch']);
}

$list = get_filtered_list($_REQUEST['__akcios'], $_REQUEST['__saxonid'], $_REQUEST['__make'], "", $_REQUEST['__fuel'], $_REQUEST['__maxload'], $_REQUEST['__status'], "", "", ((is_numeric($_REQUEST['__offset']) AND $_REQUEST['__offset']>0)?($_REQUEST['__offset']):(0)), $itemsperpage, $_REQUEST['__type'],$_REQUEST['__ispart'],$_REQUEST['function'],$_REQUEST['__terstatus']);
$links = generate_page_links($list[0], $itemsperpage, ((is_numeric($_REQUEST['__offset']) AND $_REQUEST['__offset']>0)?($_REQUEST['__offset']):(0)));
if (loggedin()) {
    $json_data = str_replace('"', "\\'", json_encode($list[4]));
    $body_onload_functions = "init_drag_and_drop('" . $json_data . "')";
    if (isset($_REQUEST['auto_spec_offer']) || isset($_REQUEST['offer_request']) || isset($_REQUEST['flyer_page']))
        $body_onload_functions .= "; start_offer_request()";
}
$sellist = "";
foreach ($filterlist as $filteritem) {
    if (isset($filteritem['ID'])){
        $sellist .= "<option value=\"" . $filteritem['ID'] . "\">" . $filteritem['value'] . "</option>";
    }
    else{
        $sellist .="";
    }
}

$simplesellist = get_simple_search();

//    echo '<script>get_list();</script>';


if (loggedin())
    $basketlinks = '<a href="#" onclick="start_offer_request();" style="margin-left:10px">' . $language['aktualis_menu-offer-request'] . '</a>' .
            '<a href="#__HELP__" class="highslide" style="margin-left:10px" onclick="return hs.htmlExpand(this, {contentId: \'__HELP__\', align: \'center\', width:500});" border="0">' . $language['aktualis_menu-help'] . '</a>';
//'<a href="#" onclick="change_search_mode();" style="margin:10px;">'.$language['searchmode'].'</a>';
else
    $basketlinks = '<a href="#pleaselogin" class="highslide" style="margin-left:10px" onclick="return hs.htmlExpand(this, {contentId: \'pleaselogin\', align: \'center\', width:400});" border="0">' . $language['aktualis_menu-offer-request'] . '</a>' .
            '<a href="#__HELP__" class="highslide" style="margin-left:10px" onclick="return hs.htmlExpand(this, {contentId: \'__HELP__\', align: \'center\', width:500});" border="0">' . $language['aktualis_menu-help'] . '</a>';
//'<a href="#" onclick="change_search_mode();" style="margin:10px;">'.$language['searchmode'].'</a>';

$template = new Template();
$variables = array(
    "FILTERTITLE" => $language['aktualis-FilterTitle'],
    "INVERTLINK" => $language['aktualis-InvertLink'],
    "ADDFILTERLINK" => $language['aktualis-AddFilterLink'],
    "FILTERMENU" => '<a href="#" onclick="show_all();">' . $language['aktualis-showall'] . '</a> ',
    "LISTHINT" => $language['aktualis-ListHint'],
    "FILTERHINT" => $language['aktualis-FilterHint'],
    "SELLIST" => $sellist,
    "LIST" => "<div class=\"page_links\" id=\"page_links_up\">" . $links[0] . "</div>" . $list[3] . "<div class=\"page_links\" id=\"page_links_down\">" . $links[0] . "</div>",
    "ACTIVEFILTER" => "make",
    "GOLINK" => $language['aktualis-showall'],
    "BASKETLINKS" => $basketlinks,
    "__HELP__" => "<div style=\"margin: 10px 10px 20px 10px\"><span style=\"font-size:14px; font-weight:bold\">" . $language['aktualis_helptext_header'] . "</span><hr /><br />" . $language['aktualis_helptext'] . "</div>",
    "PLEASELOGIN" => "<div style=\"margin: 10px 10px 20px 10px\"><span style=\"font-size:14px; font-weight:bold\">" . $language['userman_pleaselogin_aktualis_header'] . "</span><hr /><br />" . $language['userman_pleaselogin_aktualis'] . "</div>",
    "NOTHINGFOUND" => $language['aktualis-nothingfound'],
    "BASKETEMPTY" => $language['aktualis-basketempty'],
    "BASKETCLASS" => (isset($_SESSION['basket']) && (count($_SESSION['basket']) > 0)) ? "dBasket" : "dBasketHidden",
    "BASKET" => list_basket(),
    "BASKETFOOTER" => list_basket_footer(),
    "SHOW_BASKET" => $show_basket,
    "OFFER_REQUEST" => isset($_REQUEST['offer_request']) && isauth() ? $_REQUEST['offer_request'] : "",
    "AUTO_SPEC_OFFER" => isset($_REQUEST['auto_spec_offer']) && isauth() ? $_REQUEST['auto_spec_offer'] : "",
    "FLYER_PAGE" => isset($_REQUEST['flyer_page']) && isauth() ? $_REQUEST['flyer_page'] : "",
    "ADDTOBASKET" => $language['aktualis_basket:add'],
    "INBASKET" => $language['aktualis_basket:in'],
    "SIMPLESELLIST" => $simplesellist,
    "PART0" => $language['aktualis:ispart'][0]['value'],
    "PART1" => $language['aktualis:ispart'][1]['value'],
    "PART2" => $language['aktualis:ispart'][2]['value'],
    "PART3" => $language['aktualis:ispart'][3]['value'],
    "PART4" => $language['aktualis:ispart'][4]['value'],
    "PART5" => $language['aktualis:ispart'][5]['value'],
    "PART6" => $language['aktualis:ispart'][6]['value'],
    "PART7" => $language['aktualis:ispart'][7]['value'],
    "PART8" => $language['aktualis:ispart'][8]['value'],
    "PART9" => $language['aktualis:ispart'][9]['value'],
    "PART10" => $language['aktualis:ispart'][10]['value'],
    "PART11" => $language['aktualis:ispart'][11]['value'],
    "PART12" => $language['aktualis:ispart'][12]['value'],
    "PART13" => $language['aktualis:ispart'][13]['value'],
    "PART14" => $language['aktualis:ispart'][14]['value'],
    "PART15" => $language['aktualis:ispart'][15]['value'],
    "PART16" => $language['aktualis:ispart'][16]['value'],
    "PART17" => $language['aktualis:ispart'][17]['value'],
    "PART18" => $language['aktualis:ispart'][18]['value'],
    "PART19" => $language['aktualis:ispart'][19]['value'],
    "SEARCHMODE" => $language['searchmode'],
    "MODE" => $mode,
    "MODE_LABEL" => $mode_label
);

$nums = explode('|',str_replace("||","|",preg_replace("/[^0-9|]/", '', strip_tags($links[0]))));
$max = end($nums);

// $variables["LIST"] = $list[3];
if(isauth()) { $variables["LIST"] = $list[3]; }

$template->assign_var_array($variables);

if (!isset($_REQUEST['ajax']) || $_REQUEST['ajax'] != 1) {
    $main_content = "<div id=\"aktualis_data\" style=\"width:100%; text-align:left; margin:0px 20px 20px 20px;\">" . $template->compile("sys/lang/" . $lang . "/aktualis") . "</div>";

    include("sys/tpl/main.tpl");
    if(isauth()) { echo'<script>jQuery(document).scroll(function() { aktualLoadScroll(); });</script>'; }
} else {
    echo $template->compile("sys/lang/" . $lang . "/aktualis");
}
if(isauth()) { echo'<script>jQuery("#filtered_list").attr("max",'.($max).');</script>'; }
?>

<script>
  get_list();
</script>'

