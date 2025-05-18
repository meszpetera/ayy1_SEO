<?php
  include_once("common.php");
  
  function generate_offer_options_form($offerid, $text = "")
  {
    $offer = get_offer_request($offerid);
    
        $min_method=  get_method_min_id();
        $min_delivery= get_delivery_min_id();
        
    
         $edit = '
            <input type="button" value="" style="cursor: pointer; width: 16px; height: 16px; background-image: url(\'../img/edit.png\');"
            onclick="hs.htmlExpand($(\'edittext2\'), 
            {objectType: \'iframe\', align: \'center\', width: 380, height: 240}, 
            {onClosed: function(){window.location.reload();}}); "/>' .
                '<a id="edittext2" style="display:none" 
                     href="/sys/edit_method.php?tip=0&param='.$min_method['ID'].'" ></a>';
    
        $insert = '
            <input type="button" value="" style="cursor: pointer; width: 16px; height: 16px; background-image: url(\'../img/new.gif\');"
            onclick=" return hs.htmlExpand($(\'newtext2\'), 
            {objectType: \'iframe\', align: \'center\', width: 380, height: 240}, 
            {onClosed: function(){window.location.reload();}});"/>' .
                '<a id="newtext2" 
                    style="display:none" href="/sys/edit_method.php?tip=1&param='.$min_method['ID'].'" ></a>';
   
         $edit_delivery = '
            <input type="button" value="" style="cursor: pointer; width: 16px; height: 16px; background-image: url(\'../img/edit.png\');"
            onclick="hs.htmlExpand($(\'edittext3\'), 
            {objectType: \'iframe\', align: \'center\', width: 380, height: 240}, 
            {onClosed: function(){window.location.reload();}}); "/>' .
                '<a id="edittext3" style="display:none" 
                     href="/sys/edit_delivery.php?tip=0&param='.$min_delivery['ID'].'" ></a>';
    
        $insert_delivery = '
            <input type="button" value="" style="cursor: pointer; width: 16px; height: 16px; background-image: url(\'../img/new.gif\');"
            onclick=" return hs.htmlExpand($(\'newtext3\'), 
            {objectType: \'iframe\', align: \'center\', width: 380, height: 240}, 
            {onClosed: function(){window.location.reload();}});"/>' .
                '<a id="newtext3" 
                    style="display:none" href="/sys/edit_delivery.php?tip=1&param='.$min_delivery['ID'].'" ></a>';
   
    
    
    $template = new Template();
    $variables = array (
                   "METHOD_SELECT" => generate_payment_list($offer['offer_data']['offer_payment']),
                   "RESERVE" => $offer['offer_data']['offer_reserve'],
                   "EURO" => $offer['offer_data']['offer_euro'],
                   "LIFETIME" => $offer['offer_data']['offer_lifetime'],
                   "OFFERID" => $offer['offer_data']['offer_id'],
                   "SIGNATURE" => "",
                   "DELIVERYMETHOD" => generate_deliverymethod_list($offer['offer_data']['offer_deliverymethod']),
                   "TEXT" => $text,
                   "HUN" => ($offer['offer_data']['offer_lang'] == 'hun' ? 'SELECTED' : ''),
                   "ENG" => ($offer['offer_data']['offer_lang'] == 'eng' ? 'SELECTED' : ''),
                   "SZURT" => ($offer['offer_data']['offer_pdf'] == '0' ? 'SELECTED' : ''),
                   "OSSZES" => ($offer['offer_data']['offer_pdf'] == '1' ? 'SELECTED' : ''),
                   "EDIT"=>$edit,
                   "INSERT"=>$insert,
                   "EDIT_DELIVERY"=>$edit_delivery,
                   "INSERT_DELIVERY"=>$insert_delivery
                   
                 );

    $template->assign_var_array($variables);
    return $template->compile("lang/univ/request_options");
  }
  
  if(isset($_REQUEST['payment']) &&
     isset($_REQUEST['reserve']) &&
     isset($_REQUEST['euro']) &&
     isset($_REQUEST['lifetime']) &&
     isset($_REQUEST['language']) &&
     isset($_REQUEST['offerid'])&&
     isset($_REQUEST['pdf'])&&
     isauth())
  {
	update_offerrequest_options($_REQUEST['payment'], $_REQUEST['euro'], $_REQUEST['lifetime'], $_REQUEST['reserve'], $_REQUEST['language'], $_REQUEST['offerid'], $_REQUEST['signature'], $_REQUEST['deliverymethod'], $_REQUEST['pdf']);
    $offerid = $_REQUEST['offerid'];
    echo generate_offer_options_form($offerid, $language['admin:success']);    
  }
  else
  {
    $offerid = $_REQUEST['offerid'];
    echo generate_offer_options_form($offerid);
  }
?>