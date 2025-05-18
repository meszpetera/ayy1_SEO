<?php
  include("common.php");
  ?>
  <html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <script type="text/javascript" src="js/image_preload.js"></script>
<script type="text/javascript" src="js/promo.js"></script>
<script type="text/javascript" src="js/ticker.js"></script>
<script type="text/javascript" src="../js/framework/prototype.js"></script>
<script type="text/javascript" src="js/framework/scriptaculous.js"></script>
<script type="text/javascript" src="js/ajax_tools.js"></script>
<script type="text/javascript" src="../js/aktualis.js"></script>
<script type="text/javascript" src="js/aktualis_truckdetails.js"></script>
<script type="text/javascript" src="js/offerrequest.js"></script>
<script type="text/javascript" src="js/flyer.js"></script>
<script type="text/javascript" src="js/ibox/ibox.js"></script>
<script type="text/javascript" src="js/offer_send.js"></script>
<script type="text/javascript" src="js/users.js"></script>
<script type="text/javascript" src="js/highslide/highslide.js"></script>
<script type="text/javascript" src="js/registration.js"></script>
  </head>
  <body>
  <?php

      echo "<div style=\"margin-bottom: 10px;\">"	;
      echo "<select id=\"user\" style=\"width:200px;\">";
      $users = get_all_users_assigned();
      foreach($users as $user)
      {
        echo "<option value=\"".$user['users_id']."\">".$user['users_realname']."</option>";
      }
      echo "</select></div>";
      echo "Cég neve:<br /><select id=\"comp\" style=\"width:200px;\" onchange=\"refresh_company_user_list();\">";
      $comps = get_all_companies_and_users();
	    //print_r($comps);
      $i = 0;
      foreach($comps as $comp)
      {
        echo "<option value=\"".$comp['company_id']."\" ".($i==0 ? "selected" : "").">".$comp['company_name']."</option>";
        $i++;
      }
      echo "</select>";
  ?>
      Ügyintézo:<br />
      <div id="user_IEHack">
      <select id="user" style="width:200px;">
        <?php
        //echo $comps;
       // print_r($comps);
         foreach($comps[0]['userlist'] as $user)
          {
            ?>
              <option value="<?php echo $user['users_id']; ?>"><?php echo $user['users_realname']; ?></option>
            <?php
          }
        ?>
      </select>
      </div>
  <?php
      echo "</div>";    
?>
</body>
</html>