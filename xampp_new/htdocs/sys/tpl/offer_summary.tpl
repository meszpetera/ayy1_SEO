<div id="OfferSummary">
  <script type="text/javascript">
    var prev_reqs = <?php echo count($prev_reqs); ?>
  </script>
  <input type="button" value="<?php echo $language['aktualis_offersummary:back'] ?>" onclick="back_to_shop();" /><br />
  <div class="dOfferSummaryHeader">
    <?php
	 // if(!isauth())
	 // {
	    echo $language['aktualis_offersummary:header']
     // }
	?>
  </div>
  <div style="margin-left:60px;">
    <?php
    $c = count($basket);
    $cost = 0;
    ?>
    <?php if ($c > 0) {?>
    <table style="width:741px;padding:0px;border-collapse: collapse;margin-bottom:40px;">
    <?php
    for ($i = 0; $i < $c; $i++)
    {
      $color = (($i % 2) ? 'background-color:#88bbb3;' : 'background-color:#77a096;');
      echo "<tr style=\"$color\" class=\"Rows\">";
      echo "<td class=\"dIDColumn\">".($i + 1)."</td>";
      echo "<td class=\"dInfoColumn\"><strong>" . $basket[$i]['saxon-id'] . "</strong><br />" .
           $basket[$i]['make'] . ' ' . $basket[$i]['model'] . '<br />' .
          $basket[$i]['type']."</td>";
      echo "<td class=\"dPriceColumn\">".$basket[$i]['cost'] . "</td>";
      echo "</tr>";
      $cost += $basket[$i]['cost-int'];
    }
    ?>
      <tr style="border-top:2px solid #000;" class="Rows">
         <td colspan="2" style="padding-left:20px;border-top:2px solid #000;"><strong><?php echo $language['aktualis_offersummary:sum'] ?></strong></td>
         <td style="border-top:2px solid #000;" ><?php echo $cost . ' &euro;'?></td>
      </tr>
    </table>
    <?php } ?>

  <?php if(count($prev_reqs) > 0) {?>
  <a href="#" onclick="show_hide('prev_reqs');"><?php echo $language['aktualis_offersummary:prevrequests']; ?></a>
  <div id="prev_reqs">
  <table class="dPrevReqsTable">
  <?php } ?>

  <?php
  for($i = 0;$i < count($prev_reqs); $i++)
  {
    $color = (($i % 2) ? 'background-color:#88bbb3;' : 'background-color:#77a096;');
    echo "<tr style=\"$color\">";

    echo "<td style=\"padding:3px;\"><input name=\"prev_req_radio\" type=\"radio\" id=\"offer_".$prev_reqs[$i]['offer_id']."\" onclick=\"select_addto($(this).id);\"/></td>".
         "<td>".$prev_reqs[$i]['trucks']."</td>".
         "<td>".$prev_reqs[$i]['offer_date-added']."</td>".
         "<td>".(($prev_reqs[$i]['offer_date-added'] != $prev_reqs[$i]['offer_date-last-edited']) ? $prev_reqs[$i]['offer_date-last-edited'] : "") ."</td>";


    echo "</tr>";
    if($i == (count($prev_reqs) -1))
      echo "</table></div>";
  }
  ?>
  <?php
    if(isauth())
    {
      echo "<div style=\"margin-bottom: 10px;\">"	;
     /* echo "<select id=\"user\" style=\"width:200px;\">";
      $users = get_all_users_assigned();
      foreach($users as $user)
      {
        echo "<option value=\"".$user['users_id']."\">".$user['users_realname']."</option>";
      }
      echo "</select></div>";*/
      echo "Cég neve:<br /><select id=\"comp\" style=\"width:400px;\" onchange=\"refresh_company_user_list();\">";
      $comps = get_all_companies_and_users();
	    //print_r($comps);
      $i = 0;
      foreach($comps as $comp)
      {
        if ($i == 0)
          $companyid = $comp['company_id'];
        echo "<option value=\"".$comp['company_id']."\" ".($i==0 ? "selected" : "").">".$comp['company_name']."</option>";
        $i++;
      }
      echo '</select>';
      echo '<span style="padding-left:10px;"><a href="https://'.($_SERVER['HTTP_HOST']).'/?page=companies&lang=hun">cég hozzáadása</a></span><br />';
  ?>
      Ügyintézõ:<br />
      <div id="user_IEHack">
      <select id="user" style="width:400px;">
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
      <span style="padding-left:10px;"><a href="https://'.($_SERVER['HTTP_HOST']).'/?page=reg&companyid=<?php echo $companyid; ?>&lang=hun">ügyintézõ hozzáadása</a></span><br />
      </div>
  <?php
      echo "</div>";
    }
  ?>
  <div>
    <label for="comment"><?php echo $language['aktualis_offersummary:comment'];?></label>
    <textarea id="requestcomment" name="comment" style="width:741px;height:100px;"></textarea>
  </div>
  <div class="dOfferSummaryFooter"><?php echo $language['aktualis_offersummary:footer']?></div>
  <input type="button" value="<?php echo $language['aktualis_offersummary:finalize']?>" onclick="finalize_offer_request();" />
  <!--<a href="?page=aktualis&lang=<?php echo $lang ?>" onclick="back_to_shop();return false;"><?php echo $language['aktualis_offersummary:back'] ?></a>-->
</div>
