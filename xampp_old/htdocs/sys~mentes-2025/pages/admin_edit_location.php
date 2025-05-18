<?php

if(!loggedin() || !isauth()) {
	redirect_in_site("?page=$default_page&lang=$lang");
} else {
	ob_start();
		function depSelect($cur) {
			global $depotList;
			$opt = '';
			foreach($depotList as $dep => $name) {
				$opt .= '<option value="'.($dep).'"'.(($dep==$cur)?('SELECTED'):('')).'>'.($name).'</option>';
			}
			return $opt;
		}
		$mysql = get_connection();
		$mysql->execute($sql['setutf']);

		$infoTtext = '';
		if(isSet($_POST['save']) AND $_POST['save']) {
			if(isSet($_POST['loc-remove']) AND is_array($_POST['loc-remove']) AND count($_POST['loc-remove'])) {
				foreach($_POST['loc-remove'] AS $item) {
					$mysql->execute('DELETE FROM `truck_location` WHERE `id`="'.((int)$item).'"');
				}
			}
			if(isSet($_POST['loc-depot']) AND is_array($_POST['loc-depot']) AND count($_POST['loc-depot'])) {
				foreach($_POST['loc-depot'] AS $id => $depot) {
					$mysql->execute('
						UPDATE `truck_location`
						SET
							`depot`="'.((int)$_POST['loc-depot'][$id]).'",
							`subdepot`="'.((int)$_POST['loc-subdepot'][$id]).'",
							`value`="'.(addslashes($_POST['loc-value'][$id])).'",
							`code`="'.(addslashes($_POST['loc-code'][$id])).'"
						WHERE `id`="'.((int)$id).'"
					');
				}
			}
			if(isSet($_POST['new-depot']) AND is_array($_POST['new-depot']) AND count($_POST['new-depot'])) {
				foreach($_POST['new-depot'] AS $id => $depot) {
					$mysql->execute('
						INSERT INTO `truck_location`
							( `depot`, `subdepot`, `value`, `code` )
						VALUES
							(
								"'.((int)$_POST['new-depot'][$id]).'",
								"'.((int)$_POST['new-subdepot'][$id]).'",
								"'.(addslashes($_POST['new-value'][$id])).'",
								"'.(addslashes($_POST['new-code'][$id])).'"
							)
					');
				}
			}
			$infoTtext = '<p style="margin:0.5em;padding:0;font-size:28px;font-weight:bold;">Adatok frissítve!<p>';
		}


		echo'
			<p style="font-size: 32px; padding: 0 0 0 0; margin: 0 0 0 0">RAKTÁR SZERKESZTÉSE</p>
			<br /><br />
			<a href="?page=admin">vissza</a>
			<br/>
			<style>
				button.remove{display:none;text-align:center;margin:auto;color:#d00;background:none;border:none;font-weight:bold;cursor:pointer;}
				input[readonly] { cursor: not-allowed; }
				select[readonly] { cursor: not-allowed; }
				select[readonly] option { visibility: hidden; }
				select[readonly] option:checked { visibility: visible; }
				tr:focus-within, tr:hover{ background-color:rgba(0,0,0,0.15); }
				tr:focus-within button.remove,
				tr:hover button.remove{display:block;}
				select[disabled] { color: #000; background-color: #FFF; opacity: 1; border-color: #777; cursor: not-allowed; }
			</style>
			'.($infoTtext).'
			<form action="" accept-charset="UTF-8" method="post" style="margin-bottom:280px;" id="loc-form">
				<input type="hidden" name="save" value="1" />
  			<table id="table1" cellpadding="5" cellspacing="0" border="0">';
  	$max = 10;
		$depotList = Array();
		$stmt = $mysql->prepare('
			SELECT *
			FROM `truck_location`
			WHERE `subdepot`="0"
				AND `code`!=""
			ORDER BY `depot` ASC, `code` ASC
		');
		if($stmt->execute()) {
			foreach($stmt->fetch_all() AS $dep) {
				$depotList[$dep['depot']] = $dep['value'];
			}
			$stmt = $mysql->prepare('
				SELECT *
				FROM `truck_location`
				WHERE `subdepot`>"0"
					AND `code`!=""
				ORDER BY `depot` ASC, `code` ASC
			');
			if($stmt->execute()) {
				$typelist = $stmt->fetch_all();

				echo '<tr> <th>Depot</th> <th>SubDepot</th> <th>Name</th> <th>Code</th> <th>Töröl</th> </tr>';

				foreach($typelist as $loc) {
					if($max<$loc['subdepot']) { $max = $loc['subdepot']; }
					echo'
						<tr id="loc-'.($loc['id']).'">
							<td><select id="loc-depot-'.($loc['id']).'" name="loc-depot['.($loc['id']).']" onclick="return enableEditDep(\'loc-depot-'.($loc['id']).'\');" readonly>'.(depSelect($loc['depot'])).'</select></td>
							<td><input style="width:55px;text-align:right;" type="number" id="loc-subdepot-'.($loc['id']).'" name="loc-subdepot['.($loc['id']).']" value="'.($loc['subdepot']).'" onclick="return enableEditID(\'loc-subdepot-'.($loc['id']).'\');" readonly /></td>
							<td><input style="width:200px;" type="text" id="loc-value-'.($loc['id']).'" name="loc-value['.($loc['id']).']" value="'.($loc['value']).'" placeholder="pl. Bemutatóterem" maxlength="40" required /></td>
							<td><input style="width:90px;" type="text" id="loc-code-'.($loc['id']).'" name="loc-code['.($loc['id']).']" value="'.($loc['code']).'" placeholder="pl. V1 BET" maxlength="16" required /></td>
							<td><button type="button" onclick="return removeLoc('.($loc['id']).')" class="remove">✕</button></td>
						</tr>';
				}
			}
		}

		echo'
  			</table>
  			<br />
  			<div style="visibility:hidden" id="count">'.($max+1).'</div>
  			<a href="#count" onClick="return addRow()">új raktár</a><br />
  			<br />
  			<input type="submit" value="Mentés" />
			</form>
			<script type="text/javascript">
				function addRow() {
					var id = document.getElementById("count").innerHTML;
					document.getElementById("table1").innerHTML += `
						<tr id="new-${id}">
							<td><select name="new-depot[${id}]">'.(depSelect(0)).'</select></td>
							<td><input style="width:55px;text-align:right;" type="number" id="new-subdepot-${id}" name="new-subdepot[${id}]" value="${id}" placeholder="999" onclick="return enableEditID(\'new-subdepot-${id}\');" readonly /></td>
							<td><input style="width:200px;" type="text" id="new-value-${id}" name="new-value[${id}]" value="" placeholder="pl. Bemutatóterem" maxlength="40" required /></td>
							<td><input style="width:90px;" type="text" id="new-code-${id}" name="new-code[${id}]" value="" placeholder="pl. V1 BET" maxlength="16" required /></td>
							<td><button type="button" onclick="return removeRow(${id})" class="remove">✕</button></td>
						</tr>
					`;
					document.getElementById("count").innerHTML = (parseInt(id)+1).toString();
					document.getElementById("new-value-"+id).focus();
					return false;
				}
				function removeLoc(n) {
					if(confirm("Biztos törli!?")) {
						jQuery("#loc-form").append(`<input type="hidden" name="loc-remove[${n}]" value="${n}" />`);
						jQuery("#loc-"+n).remove();
					}
					return false;
				}
				function removeRow(n) {
					if(confirm("Biztos törli!?")) {
						jQuery("#new-"+n).remove();
					}
					return false;
				}
				function enableEditDep(a) {
					var o = jQuery("#"+a);
					if(confirm("Biztos szerkeszteni akarja!?\nEz alapján kapcsolja össze a terméket a telep hellyel!")) {
						o.removeAttr("onclick");
						o.removeAttr("readonly");
						o.focus();
						return true;
					}
					return false;
				}
				function enableEditID(a) {
					var o = jQuery("#"+a);
					if(confirm("Biztos szerkeszteni akarja!?\nA SubDepot azonosítónak egyedinek kell lennie!\nEz alapján kapcsolja össze a terméket a raktár hellyel!")) {
						o.removeAttr("onclick");
						o.removeAttr("readonly");
						o.focus();
					}
					return false;
				}
			</script>';


		$main_content = ob_get_contents();
	ob_end_clean();

	include("sys/tpl/main.tpl");
}
?>