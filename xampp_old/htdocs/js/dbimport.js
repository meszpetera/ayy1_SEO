var ret = "";

function step(row)
{
  var url = "dbimport.php?row=" + row;
  new Ajax.Request(url, {
    method: 'get',
    asynchronous: false,
    onSuccess: function(transport)
      {
        ret = transport.responseText;
      }
    });
}

function importDB()
{
  var log = document.getElementById("log");
  log.innerHTML = 'Import started...';
  var progressbar = document.getElementById("progressbar"); 
  
  for (i = 0; i < 1370; i++)
  {
    step(i);
    if (ret != '') 
      log.innerHTML = ret + '<br />' + log.innerHTML;
    
    progressbar.innerHTML = '<div style="background-color:#9f9; width:' + 400*(i+1)/1365 + 'px;">&nbsp;</div>';
  }
  log.innerHTML = 'Importing finished.<br />' + log.innerHTML;
}