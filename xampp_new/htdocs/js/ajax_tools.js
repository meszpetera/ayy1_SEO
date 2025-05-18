

function process_bottom_textscroll(){}

function user_editor_change_row(id, color)
{
  var s = document.getElementById(id);
  if(s != null)
  {
   // alert(color);
    s.style.backgroundColor = color;
  }
}

function disableSelection(element) 
{   
   if(element)
   {
     element.onselectstart = function() {
         return false;
     };
     element.unselectable = "on";
     element.style.MozUserSelect = "none";
     element.style.cursor = "default";
   }
}

function getElementsByClass(searchClass,node,tag) {
	var classElements = new Array();
	if ( node == null )
		node = document;
	if ( tag == null )
		tag = '*';
	var els = node.getElementsByTagName(tag);
	var elsLen = els.length;
	var pattern = new RegExp("(^|\\\\s)"+searchClass+"(\\\\s|$)");
	for (i = 0, j = 0; i < elsLen; i++) {
		if ( pattern.test(els[i].className) ) {
			classElements[j] = els[i];
			j++;
		}
	}
	return classElements;
}

function check_login()
{
  var url = "sys/login_check_ajax.php";
  new Ajax.Request(url, {
    method: 'get',
    onSuccess: function(transport) 
      {
        if(transport.responseText != loggedin)
        {
          window.location.reload();
        }
      }
  });
  setTimeout("check_login()",120000);
}

function show_hide(id)
{
  var element = document.getElementById(id);
  if(element)
  {
    element.style.display = (element.style.display == "none" || element.style.display == "") ? "block" : "none";
  }
  return false;
}

function save_ispart_reload()
{
  var truckid = document.getElementById("hiddenid").value;
  
  dropdownIndex = document.getElementById('ispart_combo').selectedIndex;
  var ispart = document.getElementById('ispart_combo')[dropdownIndex].value;
  var url = "sys/save_only_truckispart.php?only_ispart=1&truckid="+truckid+"&ispart="+ispart;
  new Ajax.Request(url, {
    method: 'get',
    onSuccess: function(transport) 
      {
          //alert(transport.responseText);
          window.location.reload();
      }
  });
}

function ispart_reload()
{
  dropdownIndex = document.getElementById('ispart_combo').selectedIndex;
  var ispart = document.getElementById('ispart_combo')[dropdownIndex].value;
  
  var url = "sys/aktualis_ajax_filterlist.php?ispart="+ispart+"&field=type";
  
   new Ajax.Request(url, {
    method: 'get',
    onSuccess: function(transport) 
      {
          //alert(transport.responseText);
          var select = document.getElementById("truck_type_IE_Hack");
          select.innerHTML = "<select style=\"width:220px;\" size=\"1\" name=\"type\">"+transport.responseText+"</select>";
          var url = "sys/aktualis_ajax_filterlist.php?ispart="+ispart+"&field=make";
          new Ajax.Request(url, {
            method: 'get',
            onSuccess: function(transport) 
            {
              select = document.getElementById("truck_make_IE_Hack");
              select.innerHTML = "<select style=\"width:220px;\" size=\"1\" name=\"type\">"+transport.responseText+"</select>";
            }});
      }
  });
}