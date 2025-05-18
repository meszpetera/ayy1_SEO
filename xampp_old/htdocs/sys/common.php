<?php
  define("OfferState_New", 0);
  define("OfferState_WIP", 1);
  define("OfferState_Done", 2);
  define("OfferState_Changed", 3);
  define("OfferState_Approved", 4);
  define("Register_Success", 0);
  define("Register_PhoneInvalid", 1);
  define("Register_PasswordTooShort", 2);
  define("Register_InvalidUserName", 3);
  define("Register_DBError", 4);
  define("Register_UserNameTaken", 5);
  define("Register_BadEmail", 6);
  define("Register_NoConnectData", 7);  
  define("Register_NoUserName", 8);
  define("Register_NoPassword", 9);
  define("Register_NoRealName", 10);
  define("Register_PasswordsDifferent", 11);
  define("Register_NoPhone", 12);
  define("Register_NoCompany", 13);
  define("Register_Failed", 14);
  define("Register_NoEmail", 15);
  define("Update_Success", 0);
  define("Update_BadPassword", 1);
  define("Update_BadEmail", 2);
  define("Update_DifferentPasswords", 3);
  define("Update_BadPhone", 4);
  define("Update_BadFax", 5);
  define("Update_Failed", 6);


  include_once("_dstart_tools.php");
  include_once("config.php");
  include_once("page_utils.php");
  include_once("lang_utils.php"); 
  include_once("template.php");
  
  session_name('sid');
  session_set_cookie_params(7*24*60*60,'/',$_SERVER['HTTP_HOST']);
  session_start();
  //exit($_REQUEST['lang']);
  if(isset($_REQUEST['lang']) && lang_exists($_REQUEST['lang']))
  {
    $lang = $_REQUEST['lang'];
    $path = dirname(__FILE__) . '/';
    include($path."lang/".$lang."/language.php");
 //   exit($lang);
  }
  else
  {
    $lang = $default_lang;
    $path = dirname(__FILE__) . '/';
    include($path."lang/".$lang."/language.php"); 
  }
  
  include_once("sql_cmd.php"); 
  include_once("db.php"); 
  include_once("db_tools.php"); 
    # commented out logging
    # Logger::log('common.php','Request_start','',Array('_COOKIE'=>$_COOKIE,'_POST'=>$_POST,'_GET'=>$_GET,'_FILES'=>$_FILES,'_SESSION'=>$_SESSION,'_SERVER'=>$_SERVER),19);
  include_once("promo_utils.php"); 
  include_once("aktualis_utils.php"); 
  include_once("user_utils.php"); 
  include_once("offer_utils.php"); 
  include_once("truckman_utils.php"); 
  include_once("offerrequest_utils.php"); 
  include_once("flyer_utils.php"); 
  include_once("special-offer_utils.php"); 
  include_once("siteFront_utils.php"); 
  

  
  $main_menu = generate_menu();
  
/*
  if (loggedin())
  {
    if(isauth())
      $admin = "<a href=\"?page=admin&amp;lang=$lang\">" . $language['userman_admin'] . "</a><br />";
    $user_box = '<div class="dUserBox" id="UserBox">' .
               '<div class="dUserInfo">' . $language['userman_welcome'] . '<span style="font-weight:bold;">' . $_SESSION['users_realname'] . '</span>!<br /><br /><a href="?page=usercp&amp;lang='.$lang.'">' . $language['userman_manage'] . '</a><br />'.$admin.'<a href="sys/logout.php?lang=' . $lang . '">' . $language['userman_logout'] . '</a>' . 
               '</div></div>';
  }
  else
  {
    $user_box = '<div class="dUserBox" id="UserBox">' .
               '<span style="font-weight:bold;"><a href="?page=login&amp;lang='.$lang.'">' . $language['userman_login'] . '</a></span><br /><br /><a href="?page=reg&amp;lang='.$lang.'">' . $language['userman_register'] . '</a><br /><a href="#whyregister" rel="ibox">' . $language['userman_whyregister'] . '</a>' . 
               '</div>';  
  }

*/  

  if (loggedin())
  {
    if(isauth())
      $admin = " <a href=\"?page=admin&amp;lang=$lang\">" . $language['userman_admin'] . "</a> ";
    $user_box_top = $language['userman_welcome'] . '<span style="font-weight:bold;">' . $_SESSION['users_realname'] . '</span>! | '.$admin.' | <a href="sys/logout.php?lang=' . $lang . '">' . $language['userman_logout'] . '</a>';
  }
  else
  {
    $user_box_bottom = '<div class="dUserBox" id="UserBox">' .
               '<span style="font-weight:bold;"><a href="?page=login&amp;lang='.$lang.'">' . $language['userman_login'] . '</a></span><br /><br />' . 
               //'<img src="https://'.($_SERVER['HTTP_HOST']).'/img/flags/hu.png" alt="hun"/>'.
               '</div>';  
  }

  $noscript = "<div class=\"noscript_warning\">".$language['no_javascript']."</div>";
  
  $loggedin = loggedin();
  
  $beta = $language['beta'];
?>
