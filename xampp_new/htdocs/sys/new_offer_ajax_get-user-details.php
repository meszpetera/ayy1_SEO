<?php
  include_once("common.php");


  if (isauth())
  {
    $user = get_user_by_id($_REQUEST['uid']);
    
    $result = 'Név: ' . $user['users_realname'] . '<br />' .
              'Beosztás: ' . $user['users_role'] . '<br />' .
              'Email: ' . $user['users_email'] . '<br />' .
              'Tel: ' . $user['users_phone'] . '<br />' .
              'Fax: ' . $user['users_fax'] . '<br />' .
              '<input type="button" value="Ügyintézõ szerkesztése" onclick="hs.htmlExpand($(\'edit_user\'), {objectType: \'iframe\', align: \'center\', width: 600, height: 480}, {onClosed: function(){window.location.reload();}});"/>' . 
              '<a id="edit_user" style="display:none" href="sys/edit_user.php?uid=' . $user['users_id'] . '&lang=hun" ></a>';
    print($result);

  }
?>