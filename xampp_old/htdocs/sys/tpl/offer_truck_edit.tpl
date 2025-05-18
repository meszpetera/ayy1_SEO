<div style="text-align:center; width:100%"><a href="sys/remove_truck_from_offer.php?truckid=<?php echo $original[0]['truck_id']; ?>&offerid=<?php echo $_REQUEST['offerid'];?>">eltávolítás az ajánlatból</a></div>
<br />
<br />
<table class="truck_info" style="border-collapse:collapse;margin-left:auto;margin-right:auto;width:700px;text-align:center;margin-top:20px;border:1px solid #000;">
<tr style="background:#77a096;border-bottom:1px solid #000;">
    <td style="width:50%;" colspan="2" style="text-align:center;">
      <div style="font-size:20px;">
      <?php 
          if ($mod['offer_truck_saxon-id'] != '')
          {
              echo $mod['offer_truck_saxon-id'] . ' <a href="#" onclick="remove_saxon_id();">Saxon szám eltávolítása</a>';
          }
          else 
          {
              echo 'nem raktári gép';
          }
      ?>
      </div>
    </td>
  </tr>
  <tr style="background:#88bbb3;">
    <td style="width:50%;">
      <div>Ár</div>
      <div><?php echo $original[0]['truck_cost']; ?></div>
    </td>
    <td style="width:50%;">
      <div>Ár (módosított)</div> 
      <input type="text" id="price_mod" value="<?php echo $mod['offer_truck_cost']; ?>" <?php if(trim($mod['offer_truck_cost']) != trim($original[0]['truck_cost'])) { ?> style="background:#BA8787;" <?php } ?> />
    </td>
  </tr>
  <tr style="background:#77a096;">
    <td style="width:50%;"  style="text-align:center;">
      <div>Gyártó</div>
      <div><?php echo $original[0]['truck_make']; ?></div>
    </td>
        <td style="width:50%;"  style="text-align:center;">
      <div>Gyártó</div>
      <!--div><?php echo $original[0]['truck_make']; ?></div>
      <div><?php echo $mod['offer_truck_make']; ?></div-->
	  <?php
	  if ($mod['offer_truck_saxon-id'] == '')
          {
	  ?>
        <select id="make_mod" <?php if(trim($mod['offer_truck_make']) != trim($original[0]['truck_make'])) { ?> style="background:#BA8787;" <?php } ?>>
        <?php 
            $makes = get_filter_list("make");
            foreach ($makes as $make)
                print('<option value="' . $make['ID'] . '"' . (($mod['offer_truck_make'] == $make['value']) ? 'selected' : '') . '>' . $make['value'] . '</option>');
        ?>
        </select>
	  <?php
	      }
		  else
		  {
			echo $original[0]['truck_make'];
	      }
      ?>
    </td>
  </tr>
  <tr style="background:#88bbb3;">
    <td style="width:50%;"  style="text-align:center;">
      <div>Model</div>
      <div><?php echo $original[0]['truck_model']; ?></div>
    </td>
        <td style="width:50%;"  style="text-align:center;">
      <div>Model</div>
      <div>
        <input type="text" id="model_mod" value="<?php echo $mod['offer_truck_model']; ?>" <?php if(trim($mod['offer_truck_model']) != trim($original[0]['truck_model'])) { ?> style="background:#BA8787;" <?php } ?> />
        <!--?php echo $original[0]['truck_model']; ?-->
      </div>
    </td>
  </tr>
  <tr style="background:#77a096;">
    <td style="width:50%;"  style="text-align:center;">
      <div>Üzemmód</div>
      <div><?php echo $original[0]['truck_fuel']; ?></div>
    </td>
        <td style="width:50%;"  style="text-align:center;">
      <div>Üzemmód</div>
      <!--div><?php echo $original[0]['truck_fuel']; ?></div-->
	  <?php
	  if ($mod['offer_truck_saxon-id'] == '')
          {
	  ?>
        <select id="fuel_mod" <?php if(trim($mod['offer_truck_fuel']) != trim($original[0]['truck_fuel'])) { ?> style="background:#BA8787;" <?php } ?>>
        <?php 
            $fuels = get_filter_list("fuel");
            foreach ($fuels as $fuel)
                print('<option value="' . $fuel['ID'] . '"' . (($mod['offer_truck_fuel'] == $fuel['value']) ? 'selected' : '') . '>' . $fuel['value'] . '</option>');
        ?>
        </select>
	  <?php
	      }
		  else
		  {
			echo $original[0]['truck_fuel'];
	      }
      ?>
    </td>
  </tr>
  <tr style="background:#88bbb3;">
    <td style="width:50%;"  style="text-align:center;">
      <div>Maximális terhelés</div>
      <div><?php echo $original[0]['truck_max-load']; ?></div>
    </td>
    <td style="width:50%;"  style="text-align:center;">
      <div>Maximális terhelés</div>
      <div>
        <input type="text" id="maxload_mod" value="<?php echo $mod['offer_truck_max-load']; ?>" <?php if(trim($mod['offer_truck_max-load']) != trim($original[0]['truck_max-load'])) { ?> style="background:#BA8787;" <?php } ?> />

      <!--?php echo $original[0]['truck_max-load']; ?--></div>
    </td>    
  </tr>
  <tr style="background:#77a096;">
    <td style="width:50%;">
      <div>Emelési magasság</div>
      <div><?php echo $original[0]['truck_max-height']; ?></div>
    </td>
    <td style="width:50%;">
      <div>Emelési magasság (módosított)</div> 
      <input type="text" id="maxheight_mod" value="<?php echo $mod['offer_truck_max-height']; ?>" <?php if(trim($mod['offer_truck_max-height']) != trim($original[0]['truck_max-height'])) { ?> style="background:#BA8787;" <?php } ?> />
    </td>
  </tr >
  <tr style="background:#88bbb3;">
    <td style="width:50%;">
      <div>Állapot</div>
      <div><?php echo $original[0]['truck_status']; ?></div>
    </td>
    <td style="width:50%;" >
      <div>Állapot</div>
        <select id="status_mod" <?php if(trim($mod['offer_truck_status']) != trim($original[0]['truck_status'])) { ?> style="background:#BA8787;" <?php } ?>>
        <?php 
            $statuses = get_filter_list("status");
            foreach ($statuses as $status)
                print('<option value="' . $status['ID'] . '"' . (($mod['offer_truck_status'] == $status['value']) ? 'selected' : '') . '>' . $status['value'] . '</option>');
        ?>
        </select>
        <!--input disabled type="text" id="status_mod" value="<?php echo $mod['offer_truck_status']; ?>" <?php if(trim($mod['offer_truck_status']) != trim($original[0]['truck_status'])) { ?> style="background:#BA8787;" <?php } ?> /-->

      <!--?php echo $original[0]['truck_status']; ?--></div>
    </td>    
  </tr>
  <tr style="background:#77a096;">
    <td style="width:50%;">
      <div>Fajta</div>
      <div><?php echo $original[0]['truck_type']; ?></div>
    </td>
    <td style="width:50%;">
      <div>Fajta</div>
      <!--div><?php echo $original[0]['truck_type']; ?></div-->
	  <?php
	  if ($mod['offer_truck_saxon-id'] == '')
          {
	  ?>
        <select id="type_mod" <?php if(trim($mod['offer_truck_type']) != trim($original[0]['truck_type'])) { ?> style="background:#BA8787;" <?php } ?>>
        <?php 
            $types = get_filter_list("alltype");
            foreach ($types as $type)
                print('<option value="' . $type['ID'] . '"' . (($mod['offer_truck_type'] == $type['value']) ? 'selected' : '') . '>' . $type['value'] . '</option>');
        ?>
        </select>
	  <?php
	      }
		  else
		  {
			echo $original[0]['truck_type'];
	      }
      ?>
    </td>    
  </tr>
      <tr style="background:#88bbb3;">
    <td style="width:50%;"   style="text-align:center;">
      <div>Leírás</div>
      <div><?php echo $original[0]['truck_desc']; ?></div>
    </td>
    <td style="width:50%;"   style="text-align:center;">
      <div>Leírás</div>
      <div><?php echo $original[0]['truck_desc']; ?></div>
    </td>    
  </tr>
      <tr style="background:#77a096;">
    <td style="width:50%;"  style="text-align:center;"> 
      <div>Meghajtott kerék</div>
      <div><?php echo $original[0]['truck_powered-wheel']; ?></div>
    </td>
    <td style="width:50%;"  style="text-align:center;"> 
      <div>Meghajtott kerék</div>
      <div>
        <input type="text" id="poweredwheel_mod" value="<?php echo $mod['offer_truck_powered-wheel']; ?>" <?php if(trim($mod['offer_truck_powered-wheel']) != trim($original[0]['truck_powered-wheel'])) { ?> style="background:#BA8787;" <?php } ?> />

      <!--?php echo $original[0]['truck_powered-wheel']; ?--></div>
    </td>    
  </tr>
      <tr style="background:#88bbb3;">
    <td style="width:50%;"   style="text-align:center;">
      <div>Kormányzott kerék</div>
      <div><?php echo $original[0]['truck_steered-wheel']; ?></div>
    </td>
    <td style="width:50%;"   style="text-align:center;">
      <div>Kormányzott kerék</div>
      <div>
        <input type="text" id="steeredwheel_mod" value="<?php echo $mod['offer_truck_steered-wheel']; ?>" <?php if(trim($mod['offer_truck_steered-wheel']) != trim($original[0]['truck_steered-wheel'])) { ?> style="background:#BA8787;" <?php } ?> />

      <!--?php echo $original[0]['truck_steered-wheel']; ?--></div>
    </td>    
  </tr>
      <tr style="background:#77a096;">
    <td style="width:50%;"  style="text-align:center;">
      <div>Motor</div>
      <div><?php echo $original[0]['truck_engine']; ?></div>
    </td>
    <td style="width:50%;"  style="text-align:center;">
      <div>Motor</div>
      <div>
        <input type="text" id="engine_mod" value="<?php echo $mod['offer_truck_engine']; ?>" <?php if(trim($mod['offer_truck_engine']) != trim($original[0]['truck_engine'])) { ?> style="background:#BA8787;" <?php } ?> />

      <!--?php echo $original[0]['truck_engine']; ?--></div>
    </td>    
  </tr>
    <td style="width:50%;">
      <div>Hajtómű</div>
      <div><?php echo $original[0]['truck_drivetrain']; ?></div>
    </td>
    <td style="width:50%;">
      <div>Hajtómű (módosított)</div> 
      <input type="text" id="drivetrain_mod" value="<?php echo $mod['offer_truck_drivetrain']; ?>" <?php if(trim($mod['offer_truck_drivetrain']) != trim($original[0]['truck_drivetrain'])) { ?> style="background:#BA8787;" <?php } ?> />
    </td>
  </tr>
        <tr style="background:#77a096;">
    <td style="width:50%;"  style="text-align:center;">
      <div>Üzemórák</div>
      <div><?php echo $original[0]['truck_hours-used']; ?></div>
    </td>  
    <td style="width:50%;">
      <div>Üzemórák (módosított)</div> 
      <input type="text" id="usedhours_mod" value="<?php echo $mod['offer_truck_hours-used']; ?>" <?php if(trim($mod['offer_truck_hours-used']) != trim($original[0]['truck_hours-used'])) { ?> style="background:#BA8787;" <?php } ?> />
    </td>
  </tr>
        <tr style="background:#88bbb3;">
    <td style="width:50%;">
      <div>Évjárat</div>
      <div><?php echo $original[0]['truck_year']; ?></div>
    </td>
    <td style="width:50%;">
      <div>Évjárat</div>
      <!--div><?php echo $original[0]['truck_year']; ?></div-->
	  <?php
	  if ($mod['offer_truck_saxon-id'] == '')
          {
	  ?>
      <input type="text" id="year_mod" value="<?php echo $mod['offer_truck_year']; ?>" <?php if(trim($mod['offer_truck_year']) != trim($original[0]['truck_year'])) { ?> style="background:#BA8787;" <?php } ?> />
	  <?php
	      }
		  else
		  {
			echo $original[0]['truck_year'];
	      }
      ?>
    </td>    
  </tr>
  <tr style="background:#77a096;">
    <td style="width:50%;"  style="text-align:center;">
      <div>Sorozatszám</div>
      <div><?php echo $original[0]['truck_serial']; ?></div>
    </td>
    <td style="width:50%;"  style="text-align:center;">
      <div>Sorozatszám</div>
      <!--div><?php echo $original[0]['truck_serial']; ?></div-->
	  <?php
	  if ($mod['offer_truck_saxon-id'] == '')
          {
	  ?>
      <input type="text" id="serial_mod" value="<?php echo $mod['offer_truck_serial']; ?>" <?php if(trim($mod['offer_truck_serial']) != trim($original[0]['truck_serial'])) { ?> style="background:#BA8787;" <?php } ?> />
	  <?php
	      }
		  else
		  {
			echo $original[0]['truck_serial'];
	      }
      ?>
    </td>    
  </tr>
  <tr style="background:#88bbb3;">
    <td style="width:50%;"  style="text-align:center;">
      <div>Tömeg</div>
      <div><?php echo $original[0]['truck_weight']; ?></div>
    </td>
    <td style="width:50%;"  style="text-align:center;">
      <div>Tömeg</div>
      <!--div><?php echo $original[0]['truck_weight']; ?></div-->
	  <?php
	  if ($mod['offer_truck_saxon-id'] == '')
          {
	  ?>
      <input type="text" id="weight_mod" value="<?php echo $mod['offer_truck_weight']; ?>" <?php if(trim($mod['offer_truck_weight']) != trim($original[0]['truck_weight'])) { ?> style="background:#BA8787;" <?php } ?> />
	  <?php
	      }
		  else
		  {
			echo $original[0]['truck_weight'];
	      }
      ?>
    </td>    
  </tr>
  <tr style="background:#77a096;">
    <td style="width:50%;">
      <div>Extrák</div>
      <div><?php echo $original[0]['truck_extras']; ?></div>
    </td>
    <td style="width:50%;">
      <div>Extrák (módosított)</div>
      <input type="text" id="extras_mod" value="<?php echo $mod['offer_truck_extras']; ?>" <?php if(strcmp(trim($mod['offer_truck_extras']),trim($original[0]['truck_extras'])) != 0) { ?> style="background:#BA8787;" <?php } ?>/>
    </td>
  </tr>
  <tr style="background:#88bbb3;">
    <td style="width:50%;">
      <div>Garancia</div>
      <div><?php echo $original[0]['truck_warranty']; ?></div>
    </td>
    <td style="width:50%;">
      <div>Garancia (módosított)</div>
      <input type="text" id="warranty_mod" value="<?php echo $mod['offer_truck_warranty']; ?>" <?php if(strcmp(trim($mod['offer_truck_warranty']),trim($original[0]['truck_warranty'])) != 0) { ?> style="background:#BA8787;" <?php } ?>/>
    </td>
  </tr>
  <tr style="background:#77a096;">
    <td style="width:50%;">
      <div>Várható szállítási idő</div>
      <div><?php echo $original[0]['truck_expected-arrival']; ?></div>
    </td>
    <td style="width:50%;">
      <div>Várható szállítási idő (módosított)</div>
      <input type="text" id="arrival_mod" value="<?php echo $mod['offer_truck_expected-arrival']; ?>" <?php if(strcmp(trim($mod['offer_truck_expected-arrival']),trim($original[0]['truck_expected-arrival'])) != 0) { ?> style="background:#BA8787;" <?php } ?>/>
    </td>
  </tr>
  <tr style="background:#88bbb3;">
    <td style="width:50%;">
      <div>&nbsp;</div>
      <div></div>
    </td>
    <td style="width:50%;">
      <div>VTSZ:</div>
      <input type="text" id="vtsz" value="<?php echo $mod['offer_truck_vtsz']; ?>"/>
    </td>
  </tr>
  <tr style="background:#77a096;">
    <td style="width:50%;">
      <div>&nbsp;</div>
      <div>&nbsp;</div>
    </td>
    <td style="width:50%;">
      <div>Kép valódi:</div>
      <select id="fake_image">
        <option value="0" <?php echo $mod['offer_truck_fake-image'] == '1' ? '' : 'selected'; ?>>igen</option>
        <option value="1" <?php echo $mod['offer_truck_fake-image'] == '1' ? 'selected' : ''; ?>>nem, a kép illusztráció</option>
      </select>
    </td>
  </tr>
  <tr style="background:#88bbb3;">
    <td style="width:50%;" colspan="2">
      <div>Kísérőszöveg a targoncához&nbsp; 
      <?php
        $selectoption=  get_inserttext_full();
        foreach ($selectoption as $sel){
            $op.='<option value="'.$sel["insert_value"].'" />'.$sel["insert_name"].'</option>\n';
        }
      ?>
          <select name="insert_text" id="insert_text2" ONCHANGE="HandleChange('insert_text2', 'truck_comment');">
                <option />Válasszon</option>
                <?php echo $op; ?>
          </select>
      </div>
      <textarea id="truck_comment" style="height:70px;width:600px"><?php echo $mod['offer_truck_ocomment']; ?></textarea>
    </td>
  </tr>  
  <tr style="background:#77a096;">
    <td colspan="2" style="vertical-align:middle;text-align:center;" id="image_list">
	  <?php
	    foreach($images as $image)
		{
      if($image['offer_image_filename'] != "")
      {
		  ?>
      <div class="image_holder">
		  <input type="checkbox" id="<?php echo "enabled_".$image['offer_image_main_id']; ?>" <?php echo ($image['offer_image_enabled'] == 1 ? "checked": ""); ?>/>
		  <img src="<?php echo "img/trucks_copy/".$_REQUEST['offerid']."/".$image['offer_image_filename']; ?>" style="border:none;width:200px;height:150px;" />
      </div>
		  <?php
      }
		}
	  ?>
    <div style="clear:both;" /><br />
    Az ajánlatban csak az első 2 engedélyezett kép jelenik meg.
	  <a href="sys/truckman_uploadimage.php?truckid=<?php echo $_REQUEST['truckid']; ?>&lastimage=0&path=img/trucks_copy/<?php echo $_REQUEST['offerid']; ?>/&offerid=<?php echo $_REQUEST['offerid']; ?>" class="highslide" onclick="return hs.htmlExpand(this, {objectType: 'iframe', align: 'center', width: 500, height: 200}, {onClose: function(){load_truck_info();}});" border="0">kép feltöltése</a>
	</td>
  </tr>
</table>
<p style="text-align:center;">
<input type="button" value="Mentés" onclick="save_changes();" />
</p>

<script type="text/javascript">

function HandleChange2(insert, comment) {
alert("aaa");
      var select = document.getElementById(insert);
alert(select.value);
      if(select.value!="Válasszon"){
        //IE support
        if (document.selection) {
            document.getElementById(comment).focus();
            sel = document.selection.createRange();
            sel.text = select.value;
        }
        //MOZILLA and others
        else if (document.getElementById(comment).selectionStart || document.getElementById(comment).selectionStart == '0') {
            var startPos = document.getElementById(comment).selectionStart;
            var endPos = document.getElementById(comment).selectionEnd;
            document.getElementById(comment).value = document.getElementById(comment).value.substring(0, startPos)
                + select.value
                + document.getElementById(comment).value.substring(endPos, document.getElementById(comment).value.length);
        } else {
            document.getElementById(comment).value += select.value;
        }

    }

}
</script>