/*function setimage(imageid, truckid)
{
  imgdiv = document.getElementById("imagediv");
  imgdiv.innerHTML = "<img src=\"../img/loading.gif\" style=\"width: 32px; height: 32px; margin-left: 144px; margin-top: 104px;\" />";
  
  var url = "aktualis_ajax_getimagesdiv.php?id=" + imageid + "&truckid=" + truckid;
  new Ajax.Request(url, {
  method: 'get',
  onSuccess: function(transport) 
    {
      imgdiv.innerHTML = transport.responseText;
    }
  });
}*/

function setimage(url, max)
{
  imgdiv = document.getElementById("imagediv");
  if (max != "none")
    imgdiv.innerHTML = '<a href="' + max + '" target="blank"><img src="../img/trucks/' + url + '" style="width: 320px;" /></a>';
  else
    imgdiv.innerHTML = '<img src="../img/trucks/' + url + '" style="width: 320px;" />';
}

function setimagenew(url, max, label)
{
  imgdiv = document.getElementById("imagediv");
  if (max != "none")
    imgdiv.innerHTML = '<a href="' + max + '" ' + ((label)?('label="' + label + '"'):('')) + ' target="blank"><img src="../img/trucks/' + url + '" style="width: 320px;" /></a>';
  else
    imgdiv.innerHTML = '<img src="../img/trucks/' + url + '" style="width: 320px;" />';
}
