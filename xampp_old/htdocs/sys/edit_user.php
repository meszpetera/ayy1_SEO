<?php
  include_once("common.php");
  
  if(isauth())
  {
    $res = -1;
    if(isset($_REQUEST['set']))
    {
      $res = update_user_a($_REQUEST['uid']);
    }
    if(isset($_REQUEST['uid']))
    {
      $text = "";
      if($res >=0)
      {
        switch($res)
        {
          case 0:
            print('<span style="margin-bottom: 12px; font-weight:bold; font-size:14px;">Az ügyintézõ szerkesztése sanos <strong>nem sikerült</strong>.</span><br />A folytatáshoz zárja be ezt az űrlapot, majd próbálja újra.<br />');
            break;
          case 1:
            print('<span style="margin-bottom: 12px; font-weight:bold; font-size:14px;">Az ügyintézõ szerkesztése sikerült.</span><br />A folytatáshoz zárja be ezt az űrlapot.<br />');
            break;  
        }
      }
      else
      {
        $data = get_user_by_id($_REQUEST['uid']);
        $template = new Template();
        $variables = array (
                   "FULLNAME" => $data['users_realname'],
                   "ROLE" => $data['users_role'],
                   "USERID" => $data['users_id'],
                   "EMAIL" => $data['users_email'],
                   "PHONE" => $data['users_phone'],
                   "FAX" => $data['users_fax'],
                   "LOGOUT" => $language['logout'],
                   "TITLE" => $language['usercp']['title'],
                   "PERSONAL" => $language['usercp']['personal'],
                   "TRACE" => $language['usercp']['trace'],
                   "REQUESTLIST" => $list,
                   "TEXT" => $text,
                   "ERROR" => $language["usercp"]["error"][$_REQUEST['error']]
                   );
        
        $template->assign_var_array($variables);
        $main_content = $template->compile("lang/hun/edit_user");
        echo($main_content);
      }
    }
  }
?>