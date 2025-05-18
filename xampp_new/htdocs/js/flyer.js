draggables_flyer = new Array();

function add_page(type)
{
  new Ajax.Request('sys/flyer_ajax_newpage.php?pagetype=' + type, { method: 'get' });
}

function remove_page(index)
{
  new Ajax.Request('sys/flyer_ajax_removepage.php?pageid=' + index, { method: 'get' });
}

function Droppable_OnDrop_Flyer(truck, cell)
{
  var truckid = truck.id;
  if (cell.innerHTML != '&nbsp;')  //remove the truck currently in the cell
    remove_truck_from_cell(cell.id.split("_")[1]);

  cell.innerHTML = "<img src=\"img/loading.gif\" style=\"width: 32px; height: 32px;\" />";
  var pageid = document.getElementById('pageid').innerHTML;
  var url = 'sys/flyer_ajax_setcell.php?pageid=' + pageid + '&truckid=' + truck.id + '&cellid=' + cell.id.split("_")[1];
  
  new Ajax.Request(url, {
    method: 'get',
    onSuccess: function(transport) 
      {
        cell.innerHTML = transport.responseText;
        document.getElementById('trucks').removeChild(document.getElementById(truckid));
      }
    });
}

function initialize_trucks()
{
  var trucks = $('trucks').getElementsByTagName('div');
  for(var i = 0; i < trucks.length; i++)
    draggables_flyer.push(new Draggable(trucks[i].id, {revert:true, scroll: window}));
}

function initialize_editor(cellcount)
{
  initialize_trucks();
  
  for (var i = 0; i < cellcount; i++)
    Droppables.add('cell_' + i, {onDrop : Droppable_OnDrop_Flyer});
}

function remove_truck_from_cell(cellid)
{
  var cell = document.getElementById('cell_' + cellid);
  cell.innerHTML = "<img src=\"img/loading.gif\" style=\"width: 32px; height: 32px;\" />";
  var pageid = document.getElementById('pageid').innerHTML;
  var url = 'sys/flyer_ajax_unsetcell.php?pageid=' + pageid + '&cellid=' + cellid;
  
  new Ajax.Request(url, {
    method: 'get',
    asynchronous: false,
    onSuccess: function(transport) 
      {
        document.getElementById('trucks').innerHTML = transport.responseText;
        cell.innerHTML = '&nbsp;' ;
        initialize_trucks();
      }
    });
}

function add_trucks_to_flyer_from_basket()
{
  if($('flyer_page').value != "")
  {
    url = "sys/aktualis_ajax_add_to_flyer.php";
  }
  else
    return false;  
  
  new Ajax.Request(url, {
    method: 'post',
    onSuccess: function(transport) 
      {
        window.location = "?page=flyer_editor_" + $('flyer_page').value.split('_')[1] + "&lang=hun&pageid=" + $('flyer_page').value.split('_')[0];
      }
    });     
}

function set_flyer_name()
{
  var name = document.getElementById('flyer_name');
  if (name)
    new Ajax.Request("sys/flyer_ajax_settitle.php?value=" + name.value, 
      { method: 'get', 
        asynchronous: false
       });  
}

function remove_truck_from_flyer(id)
{
  var url = 'sys/flyer_ajax_removetruck.php?truckid=' + id;
  
  new Ajax.Request(url, {
    method: 'get',
    asynchronous: false,
    onSuccess: function(transport) 
      {
        document.getElementById('trucks').innerHTML = transport.responseText;
        initialize_trucks();
      }
    });
}
