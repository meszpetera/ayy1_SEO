<?php

function isauth()
{
  if($_SESSION['users_type'] == 255 || $_SESSION['users_type'] == 128)
    return true;
  else
    return false;  
}

function ismain()
{
  if($_SESSION['users_type'] == 255)
    return true;
  else
    return false;  
}

function iscustomer()
{
  if($_SESSION['users_type'] == 0)
    return true;
  else
    return false;  
}

function loggedin()
{
  if(isset($_SESSION['users_id']))
  {
    return true;
  }
  return false;
}

function check_email($email)
{
  if (preg_match('/\\b[._+A-Z0-9]+@[A-Z0-9.-]+\\.[A-Z]{2,4}\\b/i', $email))
  {
    return true;
  } 
  else 
  {
    return false;
  }
}

function check_password($psw)
{
  return ((strlen($psw) < 8) ? false : true);
}

/**
* 1: minden ok
* 2: nem megfelelő formátum
* 3: db hiba
* 4: már van
*/

function check_username($usrname)
{
  global $sql;
  if (preg_match('/[a-zA-Z]+[a-zA-Z0-9]*/i', $usrname)) 
  {
    $mysql = get_connection();
    $stmt = $mysql->prepare($sql['get_user_by_name']);
    $stmt->bind_params($usrname);
    if($stmt->execute())
    {
      if($stmt->num_rows() > 0)
      {
        return 4;
      }
      else
        return 1;
    }
    else
    {
      return 3;
    }
  } 
  else 
  {
    return 2;
  }
}

function check_phone($phone)
{
  if (preg_match('/\\+[\\d]{2,3} [\\d]{4,}/', $phone)) 
  {
	  return true;
  } 
  else 
  {
  	return false;
  }
}

function refresh_session_data($newpass = -1)
{
  global $sql, $lang, $language;
   $mysql = get_connection();
    
    $mysql->execute($sql['setutf']);
    
    $stmt = $mysql->prepare($sql['login']);
    $pass = $newpass == -1 ? $_SESSION['users_pass'] : $newpass;
    $stmt->bind_params($_SESSION['users_login'], $pass);
    if($stmt->execute())
    {
      $result = $stmt->fetch_all();
      if($stmt->num_rows() != 0)
      {
        foreach($result[0] as $key => $value)
        {
          $_SESSION[$key] = $value;
        }
        return 1;
      }
      else
        return 0;
    }
}

function update_user_a($id)
{
  global $sql, $lang, $language;

          $mysql = get_connection();

          $mysql->execute($sql['setutf']);

          $stmt = $mysql->prepare($sql['update_user3']);
          $pass = "as";
          $stmt->bind_params($pass, $_REQUEST['email'], $_REQUEST['phone'], $_REQUEST['fax'], $id, $_REQUEST['realname'], $_REQUEST['role']);
          if($stmt->execute())
          {
            //refresh_session_data($pass);
            return 1;
          }
          else
          {
            return 0;
          }
}

function update_user()
{
  global $sql, $lang, $language;
  if($_REQUEST['email'] != "" && check_email($_REQUEST['email']))
  {
    if($_REQUEST['phone'] != "" && check_phone($_REQUEST['phone']))
    {
      if($_REQUEST['fax'] != "" && !check_phone($_REQUEST['fax']))
      {
        return Update_BadFax;
      }
      else
      {
        if($_REQUEST['pass'] == $_REQUEST['passre'] && md5($_REQUEST['oldpass']) == $_SESSION['users_pass'])
        {
          $mysql = get_connection();

          $mysql->execute($sql['setutf']);

          $stmt = $mysql->prepare($sql['update_user']);
          $pass = $_REQUEST['pass'] != "" ? md5($_REQUEST['pass']) : $_SESSION['users_pass'];
          $stmt->bind_params($pass, $_REQUEST['email'], $_REQUEST['phone'], $_REQUEST['fax'], $_SESSION['users_id']);
          if($stmt->execute())
          {
            refresh_session_data($pass);
            return Update_Success;
          }
          else
          {
            return Update_Failed;
          }
        }
        else
        {
          return Update_BadPassword;
        }
      }
    }
    else
    {
      return Update_BadPhone;
    }
  }
  else
  {
    return Update_BadEmail;
  }
}

function check_reg_data($email, $username, $password, $phone)
{
  if (check_email($email))
  {
    $ret = check_username($username);
    
    if (($ret == 1) || (isauth() || $username == ''))
    {
      if (check_password($password))
      {
        if (check_phone($phone))
        {
          return Register_Success;
        }
        else
          return Register_PhoneInvalid;
      }
      else
        return Register_PasswordTooShort;
    }
    else if ($ret == 2)
      return Register_InvalidUserName;
    else if ($ret == 3)
      return Register_DBError;
    else if ($ret == 4)
      return Register_UserNameTaken;
  }
  else
    return Register_BadEmail;  
}

function get_reg_data($comp)
{
  if(!isset($_REQUEST['password']) || $_REQUEST['password'] == "")
    return Register_NoPassword;
  if($_REQUEST['password'] != $_REQUEST['password_re'])
    return Register_PasswordsDifferent;
  $pass = $_REQUEST['password'];
  $result['pass'] = md5($pass);
  if(!isset($_REQUEST['username']) || $_REQUEST['username'] == "")
  {
    if (!isauth())
      return Register_NoUserName;
  }

  if (isauth())
    //if a saxon user registers someone, generate the username automatically.
    $user = str_replace(array(" ", "á", "é", "ó", "ö", "ő", "ú", "ü", "ű", "Á", "É", "Ó", "Ö", "Ő", "Ú", "Ü", "Ű"), 
                        array("",  "a", "e", "o", "o", "o", "u", "u", "u", "A", "E", "O", "O", "O", "U", "U", "U"), 
                        $_REQUEST['realname']) . microtime();
  else
    $user = $_REQUEST['username'];
    
  $result['user'] = $user;
  
  if(!isset($_REQUEST['realname']) || $_REQUEST['realname'] == "")
    return Register_NoRealName;
  $real = $_REQUEST['realname']; 
  $result['real'] = $real;
  
  $result['role'] = $_REQUEST['role'];  
  
  if(!isset($_REQUEST['phone']) || $_REQUEST['phone'] == "")
    return Register_NoPhone;
  $phone = $_REQUEST['phone'];  
  $result['phone'] = $phone;
  if(!isset($_REQUEST['email']) || $_REQUEST['email'] == "")
    return Register_NoEmail;
  $email = $_REQUEST['email'];  
  $result['email'] = $email;
  $data = check_reg_data($email, $user, $pass, $phone);
  if($data != Register_Success)
    return $data;
  $result['fax'] = $_REQUEST['fax'];
  if(!$comp)
  {
    if(!isset($_REQUEST['company_name']) || $_REQUEST['company_name'] == "")
      return Register_NoCompany;
    $comp = $_REQUEST['company_name'] . "<br />\n";  
    if(!isset($_REQUEST['company_address']) || $_REQUEST['company_address'] == "")
      return Register_NoConnectData;
    $comp .= $_REQUEST['company_address'] . "<br />\n";  
    if(!isset($_REQUEST['company_zip']) || $_REQUEST['company_zip'] == "")
      return Register_NoConnectData;
    $comp .= $_REQUEST['company_zip'] . "<br />\n";  
    if(!isset($_REQUEST['company_phone']) || $_REQUEST['company_phone'] == "")
      return Register_NoPhone;
    $comp .= $_REQUEST['company_phone'] . "<br />\n";    
    if(!isset($_REQUEST['company_email']) || $_REQUEST['company_email'] == "")
      return Register_NoEmail;    
    $comp .= $_REQUEST['company_email'] . "<br />\n";    
    $result['company_temp'] = $comp;
  }
  else
  {
    $result['company'] = $_REQUEST['company_select'];
  }
  return $result;
}

function register($company = false)
{
  global $sql, $lang, $language;
  
  if(!loggedin() || isauth())
  {
    $data = get_reg_data($company);
   // print_r($data);
   // exit();
    if(is_array($data))
    {
      $mysql = get_connection();
      
      $mysql->execute($sql['setutf']);
      
      if(!$company)
      {
        $stmt = $mysql->prepare($sql['add_user']);
        $stmt->bind_params($data['user'], $data['pass'], $data['real'], $data['email'], $data['phone'], $data['fax'], $data['company_temp']);
      }
      else
      {
        $stmt = $mysql->prepare($sql['add_user_company']);
        $stmt->bind_params($data['user'], $data['pass'], $data['real'], $data['email'], $data['phone'], $data['fax'], $data['company'], $data['role']);      
       // exit("faszom");
      }
      if($stmt->execute())
      {
        return Register_Success;
      }
      else
        return Register_Failed;
    }
    else
      return $data;
  }
  else
    return Register_Failed;
}

/**
* return values:
*   - 0 : rossz név vagy jelszó
*   - 1 : minden ok
*   - (-1) : már bejelentkezett
*   - 2 : szar a db
*/
function login($username, $userpass)
{
  global $sql, $lang, $language;
  
  if(!loggedin())
  {
    $mysql = get_connection();
    
    $mysql->execute($sql['setutf']);
    
    $stmt = $mysql->prepare($sql['login']);
    $stmt->bind_params($username, md5($userpass));
    if($stmt->execute())
    {
      $result = $stmt->fetch_all();
      if($stmt->num_rows() != 0)
      {
        foreach($result[0] as $key => $value)
        {
          $_SESSION[$key] = $value;
        }
        return 1;
      }
      else
        return 0;
    }
    else
      return 2;
  }
  else
    return -1;
}

function logout()
{
  session_destroy();
	session_unset();
}

function get_company_list()
{
  global $sql, $lang, $language;
 
  $mysql = get_connection();
  
  $mysql->execute($sql['setutf']);
  
  $stmt = $mysql->prepare($sql['get_companies']);
  if($stmt->execute())
  {
    $result = $stmt->fetch_all();

    return $result;
  }
  else
    return 0;
}

function get_users_by_company($id)
{
  global $sql, $lang, $language;
 
  $mysql = get_connection();
  
  $mysql->execute($sql['setutf']);
  
  $stmt = $mysql->prepare($sql['get_user_by_company']);
  $stmt->bind_params($id);
  if($stmt->execute() && $stmt->num_rows() > 0)
  {
	  return $stmt->fetch_all();
  }
  return array();
}

function get_all_companies_and_users()
{
  global $sql, $lang, $language;
 
  $mysql = get_connection();
  
  $mysql->execute($sql['setutf']);
  
  $stmt = $mysql->prepare($sql['get_companies']);
  $result = array();
  if($stmt->execute())
  {
    $data = $stmt->fetch_all();
    for($i = 0;$i<count($data);$i++)
    {      
      $users = get_users_by_company($data[$i]['company_id']);
     // return $users;
      if(count($users) > 0)
      {
        $data[$i]['userlist'] = $users;
        array_push($result, $data[$i]);
      }
    }
  }

  return $result;  
}
/* If inline is set, displays only name and address. */ 
function get_companies($searchString = null)
{
  global $sql, $lang, $language, $inline;
 
  $mysql = get_connection();
  
  $mysql->execute($sql['setutf']);
  if ($searchString == null)
	$stmt = $mysql->prepare($sql['get_companies']);
  else
  {
	$stmt = $mysql->prepare($sql['get_companiesSearch']);
    $stmt->bind_params($searchString);
  }
  
  if($stmt->execute())
  {
   // return $stmt->num_rows();
    $data = $stmt->fetch_all();
    if($stmt->num_rows() > 0)
    {
      $result = "<table style=\"width:100%;border-collapse:collapse\">";
      $result.= "<tr style=\"border-bottom:2px solid #000;\">";
      if (!isset($inline))
      {
        $result .= "<td style=\"width:130px;\">Név</td>";
        $result .= "<td style=\"width:130px;\">Telefon</td>";
        $result .= "<td style=\"width:130px;\">Fax</td>";
        $result .= "<td style=\"width:130px;\">E-mail</td>";
        $result .= "<td style=\"width:130px;\">Cím</td>";
      }
      else
      {
        $result .= "<td style=\"width:260px;\">Név</td>";
        $result .= "<td style=\"width:260px;\">Cím</td>";
      }
      $result.= "</tr>";
      for($i = 0;$i<count($data);$i++)
      {
        $color = ($i % 2) ? 'background-color:#88bbb3;' : 'background-color:#77a096;';
        
        if (isset($inline))
          $color .= "font-family:segoe ui,tahoma,verdana; font-size:12px;";
        
        $result .= "<tr style=\"$color\">";
        if (!isset($inline))
        {
          $result .= "<td>".$data[$i]['company_name']."</td>";
          $result .= "<td>".$data[$i]['company_phone']."</td>";
          $result .= "<td>".$data[$i]['company_fax']."</td>";
          $result .= "<td><a href=\"mailto:".$data[$i]['company_email']."\">".$data[$i]['company_email']."</a></td>";
                      
          $result .= "<td>".$data[$i]['company_zip'].
					 (($data[$i]['company_city'] == "") ? " " : " " . $data[$i]['company_city'] . ", ").
					 $data[$i]['company_address']."</td>";
        }
        else
        {
          $result .= "<td><a href=\"sys/offerwizard_setcompany.php?id=" . $data[$i]['company_id'] . "\">".$data[$i]['company_name']."</a></td>";
          $result .= "<td>".$data[$i]['company_zip'].
					 (($data[$i]['company_city'] == "") ? " " : " " . $data[$i]['company_city'] . ", ").
					 $data[$i]['company_address']."</td>";
        }
        if (isauth())
        {
          if (isset($inline))
            $result .= "<td style=\"border-left:solid 2px; padding-left:3px; width:30px;\"><a href=\"#\" onClick=\"InvokeBlocking_Reload('sys/delete_company.php?cid=".$data[$i]['company_id']."')\">Törlés</a></td>";
          else
            $result .= "<td style=\"border-left:solid 2px; padding-left:3px; width:30px;\"><a href=\"sys/delete_company.php?cid=".$data[$i]['company_id']."&inline\">Törlés</a></td>";
          
          $result .= "<td style=\"width:50px;\"><a href=\"sys/edit_company.php?cid=".$data[$i]['company_id']."\" class=\"highslide\" onclick=\"return hs.htmlExpand(this, {objectType: 'iframe', width: 300, height: 400, preserveContent: false }, {onClosed: function(){window.location.reload();}});\">Szerkeszt</a></td>";
        }
        else
        {
          $result .= "<td style=\"border-left:solid 2px; padding-left:3px; width:50px;\"><a href=\"sys/edit_company.php?cid=".$data[$i]['company_id']."\" class=\"highslide\" onclick=\"return hs.htmlExpand(this, {objectType: 'iframe', width: 300, height: 400, preserveContent: false }, {onClosed: function(){window.location.reload();}});\">Szerkeszt</a></td>";
        }
      //  $result .= "<td><input type=\"button\" value=\"".$language['admin:edit_company']."\"/></td>";
       // $result .= "<td><input type=\"button\" value=\"".$language['admin:delete_company']."\"/></td>";
        $result .= "</tr>";
      }
      $result .= "</table>";
      return $result;
    }
    else
      return 0;
  }
  else
    return 0;
}

function add_company()
{
  global $sql, $lang, $language;
  if(isset($_REQUEST['sent']) && isauth())
  {
    $mysql = get_connection();
  
    $mysql->execute($sql['setutf']);
  
    $stmt = $mysql->prepare($sql['add_company']);
 
    $stmt->bind_params(mb_strtoupper($_REQUEST['company_name']), $_REQUEST['company_country'],  mb_strtoupper($_REQUEST['company_city']), 
                       mb_strtoupper($_REQUEST['company_adr']), mb_strtoupper($_REQUEST['company_zip']), $_REQUEST['company_phone'], 
                       $_REQUEST['company_fax'], mb_strtolower($_REQUEST['company_mail']));
    if($stmt->execute())
    {
      return 1;
    }
    else
      return 0;
  }
}

function edit_company()
{
  global $sql, $lang, $language;
  
  $data = get_company_by_id($_REQUEST['comp_id']);
  if(count($data) == 0)
    return 0;
  
  $id = $_REQUEST['comp_id'];
  $name = $_REQUEST['comp_name'] != "" ? $_REQUEST['comp_name'] : $data['company_name'];
  $address = $_REQUEST['comp_addr'] != "" ? $_REQUEST['comp_addr'] : $data['company_address'];
  $zip = $_REQUEST['comp_zip'] != "" ? $_REQUEST['comp_zip'] : $data['company_zip'];
  $city = $_REQUEST['comp_city'] != "" ? $_REQUEST['comp_city'] : $data['company_city'];
  $phone = $_REQUEST['comp_phone'] != "" ? $_REQUEST['comp_phone'] : $data['company_phone'];
  $fax = $_REQUEST['comp_fax'] != "" ? $_REQUEST['comp_fax'] : $data['company_fax'];
  $email = $_REQUEST['comp_mail'] != "" ? $_REQUEST['comp_mail'] : $data['company_email'];
  
  $mysql = get_connection();
  
  $mysql->execute($sql['setutf']);
  
  $stmt = $mysql->prepare($sql['edit_company']);
  $stmt->bind_params($id,$name, $address, $zip, $phone,$fax,$email,$city);
  if($stmt->execute())
  {
    return 1;
  }
  
  return 0;
}

function delete_company($id)
{
  global $sql, $lang, $language;
  
  $mysql = get_connection();
  
  $mysql->execute($sql['setutf']);
  
  $stmt = $mysql->prepare($sql['delete_company']);
  $stmt->bind_params($id);
  $stmt->execute();
}

function get_unassigned_users()
{
   global $sql, $lang, $language;
  if(isauth())
  {
    $mysql = get_connection();
  
    $mysql->execute($sql['setutf']);
  
    $stmt = $mysql->prepare($sql['get_unassigned_user_data']);
    if($stmt->execute())
    {
      $data = $stmt->fetch_all();
      if($stmt->num_rows() == 0)
        $data = array();
      //print_r($data);
      //exit();
      //exit($stmt->num_rows());
      return $data;
    }
    else
      return 0;
  }
}

function get_user_by_id($id)
{
  global $sql, $lang, $language;
  $mysql = get_connection();
  
  $mysql->execute($sql['setutf']);

  $stmt = $mysql->prepare($sql['getuser']);
  $stmt->bind_params($id);
  if($stmt->execute())
  {
    $arr = $stmt->fetch_all();
    return $arr[0];
  }
}

function get_company_by_id($id)
{
  global $sql, $lang, $language;
  $mysql = get_connection();
  
  $mysql->execute($sql['setutf']);

  $stmt = $mysql->prepare($sql['get_company_by_id']);
  $stmt->bind_params($id);
  if($stmt->execute())
  {
    $arr = $stmt->fetch_all();
    return $arr[0];
  }
}

function assign_user_to_company($userid, $companyid)
{
  global $sql, $lang, $language;
  if(isauth())
  {
    $mysql = get_connection();
  //  exit("stuff");
    $mysql->execute($sql['setutf']);
  
    $stmt = $mysql->prepare($sql['assign_user']);
    $stmt->bind_params($userid, $companyid);
    if($stmt->execute())
    {

      return 1;
    }
    else
      return 0;
  }
}

function get_all_users_assigned()
{
  global $sql, $lang, $language;
  if(isauth())
  {
    $mysql = get_connection();
  
    $mysql->execute($sql['setutf']);
  
    $stmt = $mysql->prepare($sql['get_all_users_assigned']);
    if($stmt->execute())
    {
      return $stmt->fetch_all();
    }
    else
      return 0;
  }
}

function get_company_select()
{
  $companies = get_company_list();
  $company_list ="<select id=\"company_select\" name=\"company_select\" style=\"width:200px;\">";
  $count = 0;
  $sel = isset($_REQUEST['companyid']) ? $_REQUEST['companyid'] : 0;
  foreach($companies as $company)
  {
    $selected = ($company['company_id'] == $sel) ? 'selected="selected" ' : "";
    $company_list .= "<option value=\"".$company['company_id']."\" $selected>".$company['company_name']."</option>";
    $count ++;
  }
  $company_list .= "</select>";
  
  return $company_list;
}  

function fix_phone_number($phoneNumber, $countryID)
{
    global $sql;
    if ($phoneNumber[0] == '+')
    {
        return $phoneNumber;
    }
    else
    {
        $mysql = get_connection();
        $mysql->execute($sql['setutf']);
        $stmt = $mysql->prepare($sql['countries:query_country']);
        $stmt->bind_params($countryID);
        if($stmt->execute())
        {
            $arr = $stmt->fetch_all();
            return $arr[0]['country_phone-prefix'] . ' ' . $phoneNumber;
        }   
    }
}

function GetCountry($countryID)
{
    global $sql;
    if ($phoneNumber[0] == '+')
    {
        return $phoneNumber;
    }
    else
    {
        $mysql = get_connection();
        $mysql->execute($sql['setutf']);
        $stmt = $mysql->prepare($sql['countries:query_country']);
        $stmt->bind_params($countryID);
        if($stmt->execute())
        {
            $arr = $stmt->fetch_all();
            return $arr;
        }   
    }
}
?>