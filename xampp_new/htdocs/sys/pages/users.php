<?php
  if(!loggedin() || !isauth())
  {
    redirect_in_site("?page=$default_page&lang=$lang");
  }
  else
  {    
    $users = get_unassigned_users();
    if(count($users) > 0)
    {
      /*$companies = get_company_list();
      $company_list ="<select>";
      foreach($companies as $company)
      {
        $company_list .= "<option value=\"".$company['company_id']."\">".$company['company_name']."</option>";
      }
      $company_list .= "</select>";*/
      $company_list = get_company_select();
      $data = "<table style=\"width:100%;\">";
      foreach($users as $user)
      {
        $data .="<tr>";
        $data .="<td>".$user['users_realname']."</td>";
        $data .="<td>".$user['users_phone']."</td>";
        $data .="<td style=\"width:150px;\">".$user['users_email']."</td>";
        $data .="<td>".$user['users_fax']."</td>";
        $data .= "<td style=\"width:200px;\">".$user['users_company_temp']."</td>";
        $data .= "<td id=\"user_".$user['users_id']."\">".$company_list."</td>";
        $data .= "<td><input type=\"button\" value=\"Hozzár.\" onclick=\"assign_user('".$user['users_id']."')\" /></td>";
        $data .="</tr>";
      }
      $data .="</table>";
    }
    $users = get_all_users_assigned();
    if(count($users) > 0)
    {
      $rdata = "<table style=\"margin-top:10px;width:100%;border-collapse:collapse;\">";
      $rdata .= "<tr style=\"border-bottom:2px solid #000;\">";
      $rdata .= "<td style=\"width:150px;\">Név</td>";
      $rdata .= "<td style=\"width:150px;\">Telefon</td>";
      $rdata .= "<td style=\"width:150px;\">E-mail</td>";
      $rdata .= "<td style=\"width:150px;\">Fax</td>";
     // $rdata .= "<td style=\"width:150px;\">Cég</td>";
      $rdata .= "</tr>";
      for($i = 0;$i<count($users);$i++)
      {
        $color = ($i % 2) ? '#88bbb3' : '#77a096';
        $rdata .="<tr style=\"background-color:$color;\" id=\"trinusers_id".$users[$i]['users_id']."\" onmouseover=\"user_editor_change_row('"."trinusers_id".$users[$i]['users_id']."', '#ffcc01')\" onmouseout=\"user_editor_change_row('"."trinusers_id".$users[$i]['users_id']."', '".$color."')\">";
        $rdata .="<td>".$users[$i]['users_realname']."</td>";
        $rdata .="<td>".$users[$i]['users_phone']."</td>";
        $rdata .="<td>".$users[$i]['users_email']."</td>";
        $rdata .="<td>".$users[$i]['users_fax']."</td>";
        $rdata .= "<td style=\"width:50px;\"><a href=\"sys/edit_user.php?uid=".$users[$i]['users_id']."\" class=\"highslide\" onclick=\"return hs.htmlExpand(this, {objectType: 'iframe', width: 330, height: 450, preserveContent: false }, {onClosed: function(){window.location.reload();}});\">Szerk.</a></td>";
        //$rdata .= "<td>".$users[$i]['users_company_temp']."</td>";
      //  $rdata .= "<td id=\"user_".$user['users_id']."\">".$company_list."</td>";
      //  $rdata .= "<td><input type=\"button\" value=\"".$language['admin:assign_company']."\" onclick=\"assign_user('".$user['users_id']."')\" /></td>";
        $rdata .="</tr>";
      }
      $rdata .="</table>";
    }
    $template = new Template();
    $variables = array (
                   "DATA" => $data,
                   "USERS" => $rdata
                 );
    
    $template->assign_var_array($variables);
    $main_content = $template->compile("sys/lang/hun/users");  //WARNING: Language hardcoded, no other languages needed
    
    include("sys/tpl/main.tpl");
  }
?>