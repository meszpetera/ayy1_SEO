<?php

  if(!loggedin() || !isauth() || !isset($_REQUEST['request']))
  {
    redirect_in_site("?page=rolunk&lang=$lang");
  }
  else
  {  
    /*if ($_SESSION['users_type'] == 255)
    {
      $result = '<strong>targoncák kezelése</strong><br />' . 
                '<a href="?page=truckman_new&lang=hun" style="margin-left:10px">' . $language['admin:truckman_new'] . '</a><br />' . 
                '<a href="?page=truckman_edit&lang=hun" style="margin-left:10px">' . $language['admin:truckman_edit'] . '</a><br /><br />' . 
                '<strong>ajánlatkérések</strong><br />' . 
                '<a href="?page=offer_requests&lang=hun" style="margin-left:10px">' . $language['admin:offer_requests'] . '</a><br />';
    }
    else if ($_SESSION['users_type'] == 128)
    {
      $result = "b";
    }*/
    $offer_data = get_offer_request($_REQUEST['request']);
   // print_r($offer_data); exit();
    
    $trucks = get_offer_trucks($_REQUEST['request']);
    
    $copied = copy_trucks_offer($_REQUEST['request'],$trucks);
    
    $data = get_offer_request($_REQUEST['request']);
    
    
    $close = ($offer_data['offer_data']['offer_status'] != 2) ? "<a href=\"#\" onclick=\"set_offer_done();\"><img src=\"../img/apply.png\" title=\"".$language['offer_request:close']."\" alt=\"".$language['offer_request:close']."\" style=\"border:none;width:32px;height:32px;\"/></a>" : "";
    /*
    $mail = ($offer_data['offer_data']['offer_status'] != 2) ? "
        <a href=\"sys/offerrequest_createpdf.php?offerid=" . $_REQUEST['request'] . "&sendEmail\">
            <img src=\"../img/mail.png\" title=\"Küldés emailben\" alt=\"Küldés emailben\" style=\"border:none;width:32px;height:32px;\"/>
        </a>" : "";
    */
    $view = ($offer_data['offer_data']['offer_status'] != 2) ? "
        <a href=\"sys/offerrequest_createpdf.php?offerid=" . $_REQUEST['request'] . "\">
            <img src=\"../img/pdf.png\" title=\"Megtekintés\" alt=\"Megtekintés\" style=\"border:none;width:32px;height:32px;\"/>
        </a>" : "";
    
    $add_link = '<a href="?page=aktualis&lang=hun&offer_request='. $_REQUEST['request'].'&mode=eladas"><img src="../img/search.png" title="'.$language['offer_request:add'].'" alt="'.$language['offer_request:add'].'" style="border:none;width:32px;height:32px;"/></a>';
    $add_truck = '<a href="?page=truckman_new&lang=hun&offer_request='.$_REQUEST['request'].'" style="margin-left:10px"><img src="../img/edit_add.png" title="'.$language['admin:truckman_new'].'" style="border:none;width:32px;height:32px;" alt="'.$language['admin:truckman_new'].'" /></a>';//<img src="" title="" alt="" style="border:none;width:32p;height:32px;"/>
    
    $options = '<a href="sys/ajax_set_offerreqest_options.php?offerid='.$_REQUEST['request'].'" class="highslide" onclick="return hs.htmlExpand(this, {objectType: \'iframe\', align: \'center\', width: 720, height: 350}, {onClose: function(){window.location.reload();}});" border="0"><img src="../img/advancedsettings.png" title="'.$language['offer_request:options'].'" alt="'.$language['offer_request:options'].'" style="border:none;width:32p;height:32px;"/></a>';

    $mail = ($offer_data['offer_data']['offer_status'] != 2) ? '
        <a href="sys/email_sender_options.php?offerid='.$_REQUEST['request'].'" 
            class="highslide" onclick="return hs.htmlExpand(this, {objectType: \'iframe\', align: \'center\', width: 400, height: 250}, 
            {onClosed: function(){window.location.reload();}});" border="0">
            <img src="../img/mail.png" title="Küldés emailben" alt="Küldés emailben" style="border:none;width:32px;height:32px;"/>
        </a>': "";

    $edittext = '
        <a href="/sys/edit_text.php?tip=0" class="highslide" id="edittext"
            onclick="return hs.htmlExpand(this, {objectType: \'iframe\', align: \'center\', width: 380, 
            height: 240}, {onClose: function(){parent.window.location.reload();}});" border="0">
            Beszúrandó szerkesztés
        </a>';
  /*  
    $newtext = '
        <a href="/sys/edit_text.php?tip=0" class="highslide" id="newtext"
            onclick="return hs.htmlExpand(this, {objectType: \'iframe\', align: \'center\', width: 300, 
            height: 200}, {onClose: function(){window.location.reload();}});" border="0">
            Új szöveg
        </a>';
  */
        $selectoption=  get_inserttext_full();
        $op="";
        foreach ($selectoption as $sel){
           $op.='<option id="'.$sel["insert_name"].'" value="'.$sel["insert_value"].'" />'.$sel["insert_name"].'</option>\n';
        }
     $newtext = '
        <a href="/sys/edit_text.php?tip=1" class="highslide" id="newtext"
            onclick="return hs.htmlExpand(this, {objectType: \'iframe\', align: \'center\', width: 380, 
            height: 240}, {onClose: function(){parent.window.location.reload();}});" border="0">
            Új beszúrás készítés
        </a>';
  
    
        $edit = '
            <input type="button" value="Beszúrandó szerkesztés" 
            onclick="hs.htmlExpand($(\'edittext\'), 
            {objectType: \'iframe\', align: \'center\', width: 380, height: 240}, 
            {onClosed: function(){window.location.reload();}}); "/>' .
                '<a id="edittext" style="display:none" 
                     href="/sys/edit_text.php?tip=0" ></a>';
    
        $insert = '
            <input type="button" value="Új beszúrás készítés" 
            onclick="hs.htmlExpand($(\'newtext\'), 
            {objectType: \'iframe\', align: \'center\', width: 380, height: 240}, 
            {onClosed: function(){window.location.reload();}});"/>' .
                '<a id="newtext" 
                    style="display:none" href="/sys/edit_text.php?tip=1" ></a>';
        $delete = '
            <input type="button" value="Törlés" 
            onclick="hs.htmlExpand($(\'deletetext\'), 
            {objectType: \'iframe\', align: \'center\', width: 380, height: 240}, 
            {onClosed: function(){window.location.reload();}});"/>' .
                '<a id="deletetext" 
                    style="display:none" href="/sys/delete_text.php?tip=1" ></a>';
    
    if(!is_numeric($data) && !(!ismain() && $offer_data['offer_data']['offer_status'] == 2))
    {
      if($copied == 1)
      {
        $template = new Template();
        $variables = array (
                       "DATA" => generate_offer_request_truck_list($data['trucks']),
                       "ACTUAL" => $_REQUEST['request'],
                       "STATE" => $data['offer_data']['offer_status'],
                       "CLOSE" => $data['offer_data']['offer_status'] != 2 ? $close."<br />Lezárás" : "",
                       "ADD" => $data['offer_data']['offer_status'] == 1  || $data['offer_data']['offer_status'] == 2 ? $add_link : "",
                       "ADDTRUCK" => $data['offer_data']['offer_status'] == 1  || $data['offer_data']['offer_status'] == 2 ? $add_truck : "",
                       "OPTIONS" => $options,
                       "OFFER_COMMENT" => $data['offer_data']['offer_comment'],
                       "COMMENTS" => $data['offer_data']['offer_text'] != "" ? $data['offer_data']['offer_text'] : $language['admin:no_comment'],
                       "MAIL" => $mail,
                       "VIEW" => $view,
                       "EDITTEXT" => $edittext,
                       "NEWTEXT" => $newtext,
                       "EDIT" => $edit,
                       "INSERT" => $insert,
                       "DELETE" => $delete,
                       "OP" => $op
                      );
        
        $template->assign_var_array($variables);
        $main_content = $template->compile("sys/lang/hun/offer_requests_edit");  //WARNING: Language hardcoded, no other languages needed
      }
      else
      {
        $main_content = "Hiba történt, kérjük próbálja újra.";
      }
    }
    else if(!ismain() && $offer_data['offer_data']['offer_status'] == 2)
    {
      $main_content = "Az ajánlatkérést már lezárták (".$offer_data['offer_data']['offer_date-closed']."), felülvizsgálat alatt van.";
    }
    else
    {
      $main_content = $language[''][$data];
    }
    
    include("sys/tpl/main.tpl");
  }
?>