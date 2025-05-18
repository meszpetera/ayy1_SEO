if($('1234rf'))
  $($('1234rf').value).className = "dIconSelected";

if($('saxon-id'))
{
  disableSelection($('saxon-id'));
  disableSelection($('make'));
  disableSelection($('model'));
  disableSelection($('fuel'));
  disableSelection($('max-load'));
  disableSelection($('status'));
  disableSelection($('location'));
  disableSelection($('cost'));

  disableSelection($('BasketMenu'));
  disableSelection($('BasketContainer'));
}

function init_drag_and_drop(data)
{
  Droppables.remove($('Basket'));
  Droppables.add('Basket', {onDrop : Droppable_OnDrop});
  Droppables.remove($('BasketMenu'));
  Droppables.add('BasketMenu', {onDrop : Droppable_OnDrop});
  
  var ids = data.evalJSON();
  
   draggables.length = ids.length;
  for(i = 0;i < ids.length;i++)
  {
    disableSelection($(ids[i]));
    draggables[i] = new Draggable(ids[i],
    {revert:true, scroll: window});
  }
}

var search_mode = 'simple';