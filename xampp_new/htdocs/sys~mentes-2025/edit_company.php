<?php
  include_once("common.php");
  
  if(isauth())
  {
    $res = -1;
    if(isset($_REQUEST['comp_id']))
    {
      $res = edit_company();
      $_REQUEST['cid'] = $_REQUEST['comp_id'];
    }
    if(isset($_REQUEST['cid']))
    {
      $text = "";
      if($res >=0)
      {
        switch($res)
        {
          case 0:
            $text = "A szerkesztés sikertelen.";
            break;
          case 1:
            $text = "A szerkesztés sikeres.";
            break;  
        }
      }
      $data = get_company_by_id($_REQUEST['cid']);
      $template = new Template();
      $variables = array (
                     "COMPANY_NAME" => $data['company_name'],
                     "COMPANY_CITY" => $data['company_city'],
                     "COMPANY_ZIP" => $data['company_zip'],
                     "COMPANY_ADDRE" => $data['company_address'],
                     "COMPANY_PHONE" => $data['company_phone'],
                     "COMPANY_FAX" => $data['company_fax'],
                     "COMPANY_EMAIL" => $data['company_email'],
                     "COMPANY_ID" => $data['company_id'],
                     "SUCCES" => $text
                   );
      
      $template->assign_var_array($variables);
      $main_content = $template->compile("lang/hun/edit_company");
      
      echo($main_content);
    }
  }
?>