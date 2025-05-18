var speed = 2000;

function change_to_next()
{
  var iddiv = document.getElementById("promo_id");
  var image = document.getElementById("promo_image");
  var link = document.getElementById("promo_link");
  if(iddiv && image && link)
  {
    var url = "sys/promo_ajax.php?id="+iddiv.value;
  //  alert(url);
    new Ajax.Request(url, {
    method: 'get',
    onSuccess: function(transport) 
      {
        var data = transport.responseText.split(';');
        image.src = data[0];
        link.href = data[1];
        iddiv.value=data[2];
      }
    });
  }
  if(speed > 0)
  {
    setTimeout("change_to_next()", speed);
  }
}