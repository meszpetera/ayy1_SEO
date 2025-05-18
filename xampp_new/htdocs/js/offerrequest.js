function offerrequest_take(id)
{
  var menu = document.getElementById("offerrequest_" + id + "_menu"); 
  if(menu)
  {
    if (id % 2 == 0)
      menu.innerHTML = "<img src=\"img/loading_darkbg.gif\" style=\"width: 32px; height: 32px; margin-left: 0px; margin-top: 0px;\" />";
    else
      menu.innerHTML = "<img src=\"img/loading.gif\" style=\"width: 32px; height: 32px; margin-left: 0px; margin-top: 0px;\" />";
    
    var url = "sys/offerrequest_ajax_take.php?id=" + id;
    new Ajax.Request(url, {
    method: 'get',
    onSuccess: function(transport) 
      {
        var data = transport.responseText.split("@");        
        menu.innerHTML = data[0];
        var status = document.getElementById("offerrequest_" + id + "_status"); 
        status.innerHTML = data[1];
      }
    });
  }
}

function offer_request_approve(id)
{
  var menu = document.getElementById("offerrequest_" + id + "_menu"); 
  if(menu)
  {
    if (id % 2 == 0)
      menu.innerHTML = "<img src=\"img/loading_darkbg.gif\" style=\"width: 32px; height: 32px; margin-left: 0px; margin-top: 0px;\" />";
    else
      menu.innerHTML = "<img src=\"img/loading.gif\" style=\"width: 32px; height: 32px; margin-left: 0px; margin-top: 0px;\" />";
    var url = "sys/offer_send_ajax_approve_request.php?offerid=" + id;
    new Ajax.Request(url, {
    method: 'get',
    onSuccess: function(transport) 
      {
    //    alert(transport.responseText);
        var data = transport.responseText.split("@");        
        menu.innerHTML = data[0];
        var status = document.getElementById("offerrequest_" + id + "_status"); 
        status.innerHTML = data[1];
        window.reload();
		//location.reload();
      }
    });
  }
}

