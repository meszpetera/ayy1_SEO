function save_changes()
{
  var sel = document.getElementById("truck_select");
  var selected = sel.options[sel.selectedIndex].value;
  var url = "sys/aktualis_ajax_update_truck_offer_request.php?offerid=" + $('actual_request').value + "&truckid=" + selected;
  url += "&price=" + $('price_mod').value + "&maxheight=" + $('maxheight_mod').value + "&extras=" + $('extras_mod').value + "&drivetrain=" + $('drivetrain_mod').value + "&usedhours=" + $('usedhours_mod').value;
  url += "&model=" + $('model_mod').value + "&maxload=" + $('maxload_mod').value + "&status=" + $('status_mod').value;
  url += "&poweredwheel=" + $('poweredwheel_mod').value + "&steeredwheel=" + $('steeredwheel_mod').value + "&engine=" + $('engine_mod').value;
  url += "&warranty=" + $('warranty_mod').value + "&arrival=" + $('arrival_mod').value;
  url += "&vtsz=" + $('vtsz').value + "&fakeimage=" + $('fake_image').value;
  if ($('make_mod') != null)
  {
	  url += "&make_mod=" + $('make_mod').value + "&fuel_mod=" + $('fuel_mod').value;
	  url += "&type_mod=" + $('type_mod').value + "&year_mod=" + $('year_mod').value;
	  url += "&serial_mod=" + $('serial_mod').value + "&weight_mod=" + $('weight_mod').value;
  }
  url += "&truck_comment=" + $('truck_comment').value.replace(/\n/g, '\\n') + "&offer_comment=" + $('offer_comment').value.replace(/\n/g, '\\n');
//  url += "&truck_comment=" + $('truck_comment').value.replace(/\n/g, '\\n').replace(/\+/g, "%2B") + "&offer_comment=" + $('offer_comment').value.replace(/\n/g, '\\n');
//  alert(url);
  url = url.replace(/\+/g, "%2B");
//  alert(url);

  var checkboxes = $('image_list').getElementsByTagName("input");
  var enabled = "";
  var disabled = "";
  for ( var i = 0; i < checkboxes.length; i ++ ) {
    if(checkboxes.item(i).type="checkbox")
	{
	  var id = checkboxes.item(i).id.substring(checkboxes.item(i).id.indexOf('_') + 1);
	  if(checkboxes.item(i).checked)
	  {
	    enabled != "" ? enabled += "," + id : enabled += id;
	  }
	  else
	  {
	    disabled != "" ? disabled += "," + id : disabled += id;
	  }
	}
  }
  url += "&enabled="+enabled+"&disabled="+disabled;
  new Ajax.Request(url, {
    method: 'post',
    onSuccess: function(transport) 
      {
        alert(transport.responseText);
        load_truck_info();
      }
    });
}

function load_truck_info()
{
  var sel = document.getElementById("truck_select");
  var selected = sel.options[sel.selectedIndex].value;
  var url = "sys/aktualis_ajax_get_truck_offer_request.php?offerid=" + $('actual_request').value + "&truckid=" + selected;
  new Ajax.Request(url, {
    method: 'post',
    onSuccess: function(transport) 
      {
      //  alert(transport.responseText);
        $('offer_data').innerHTML = transport.responseText;
      }
    });
}

function add_trucks_from_basket()
{
  if($('offer_request').value != "")
  {
    url = "sys/aktualis_ajax_add_offer_request.php?add=" + $('offer_request').value;
    new Ajax.Request(url, {
        method: 'post',
        onSuccess: function(transport) 
        {
            window.location = "?page=offer_requests_edit&lang=hun&tmp=1&request=" + $('offer_request').value;
        }
    });  
  }
  else if($('auto_spec_offer').value != "")
  {
    url = "sys/aktualis_ajax_add_auto_spec_offer.php";
    new Ajax.Request(url, {
        method: 'post',
        onSuccess: function(transport) 
        {
            window.location = "?page=admin_edit_auto_spec_offer&lang=hun";
        }
    });  
  }
  else
    return false;  
     
}

function set_offer_done(id)
{
  if(id == null)
  {
    var url = "sys/offer_send_ajax_close_request.php?offerid=" + $('actual_request').value;
  }
  else
  {
    var url = "sys/offer_send_ajax_close_request.php?offerid=" + id;  
    //alert(url);
  }
  //alert(url);
	new Ajax.Request(url, {
	method: 'post',
	onSuccess: function(transport) 
	  {
     // alert(transport.responseText);
		  window.location.reload();
	  }
	});
  return false;
}

function remove_saxon_id()
{
  alert('lol');
  
  var sel = document.getElementById("truck_select");
  var selected = sel.options[sel.selectedIndex].value;
  var url = "sys/ajax_offer_remove_saxon_id.php?offerid=" + $('actual_request').value + "&truckid=" + selected;
  alert(url);
  new Ajax.Request(url, {
    method: 'post',
    onSuccess: function(transport) 
      {
        alert('lmao');
        alert(transport.responseText);
        load_truck_info();
      }
    });
}
