var filters = new Object();
filters['saxon-id'] = "";
filters['akcios'] = "";
filters['make'] = "";
filters['type'] = "";
filters['fuel'] = "";
filters['max-load'] = "";
filters['status'] = "";
filters['location'] = "";
filters['cost'] = "";

var offset = 0;
var actual_page = 1;
var prev_reqs = 0;
var selected_prev_id = "";
var is_part_global = '+';

Array.prototype.remove = function(from, to) {
    var rest = this.slice((to || from) + 1 || this.length);
    this.length = from < 0 ? this.length + from : from;
    return this.push.apply(this, rest);
};

draggables = new Array();

function remove_draggable(id)
{
    // alert(id);
    var index = -1;
    for(var i = 0;i<draggables.length;i++)
    {
        if(draggables[i]['element'].id == id)
        {
            index = i;
            break;
        }
    }
    // alert(index);
    if(index >= 0)
    {
        draggables[index].destroy();
        draggables.remove(index);
    }  
}

function selected_filters(select)
{
    var selectedArray = new Array();
    var selObj = document.getElementById(select);
    var i;
    var count = 0;
    for (i=0; i<selObj.options.length; i++) {
        if (selObj.options[i].selected) {
            selectedArray[count] = selObj.options[i].innerHTML;
            count++;
        }
    }
    return selectedArray;
}

function selected_filter_values(select)
{
    var selectedArray = new Array();
    var selObj = document.getElementById(select);
    var i;
    var count = 0;
    for (i=0; i<selObj.options.length; i++) {
        if (selObj.options[i].selected) {
            selectedArray[count] = selObj.options[i].value;
            count++;
        }
    }
    return selectedArray;
}

function add_selected_filters()
{
    var active = document.getElementById("1234rf");
    var test = document.getElementById(active.value + "filter");
    var filtercat = document.getElementById(active.value + "filter");
    selected = selected_filters("selMake");
    selected_val = selected_filter_values("selMake");
    if(!test && selected.length)
    {
        var list = document.getElementById("FilterList");
        list.appendChild(Builder.node('div', {
            className: 'dFilterCat', 
            id: active.value + 'filter'
        }));
        var filtercat = document.getElementById(active.value + "filter");
        var name = document.getElementById(active.value);
        filtercat.innerHTML = name.title;
    }
    for (i=0;i<selected.length;i++)
    {
        if(selected[i] != "" && filters[active.value].indexOf(selected_val[i]+";") < 0)
        {
            var item = Builder.node('div',{
                className: 'dFilter', 
                id:active.value+"fil"+selected_val[i]
            },selected[i]);
            var imageid = active.value+"fil"+selected_val[i]+"img";
            item.appendChild(Builder.node('img',{
                className: 'imgRemove', 
                src:'img/aktualis/remove.gif', 
                id:imageid, 
                onclick:'remove_filter(\''+item.id+'\');', 
                onmousemove:'change_image(\''+imageid+'\',\'img/aktualis/remove_h.gif\');', 
                onmouseout:'change_image(\''+imageid+'\',\'img/aktualis/remove.gif\');', 
                style:"cursor:pointer;cursor:hand;"
            }));
            //item.appendChild(Builder.node('span'{className:''},'or'));
            filtercat.appendChild(item);
            filters[active.value] += selected_val[i] + ";";
        }
    }
    filters_changed(1);
}

function remove_filter(filter)
{
    var remove = document.getElementById(filter);
    var parent = remove.id.substr(0,remove.id.indexOf('fil'));
    var value = remove.id.substr(remove.id.indexOf('fil')+3,remove.id.length);
    var parentobj = document.getElementById(parent+ 'filter');
    parentobj.removeChild(remove);
    filters[parent] = filters[parent].substr(0,filters[parent].indexOf(value)) + filters[parent].substr(filters[parent].indexOf(value) + value.length+1,filters[parent].length);
    var childCount = parentobj.getElementsByTagName('div').length;
    if(childCount == 0)
    {
        var main = document.getElementById('FilterList');
        main.removeChild(parentobj);
        filters[parent] = "";
    }
    filters_changed(1);
}

function load_filter_list(field)
{
    var listdiv = document.getElementById("IEHack-FilterOptionsList"); 
    if(listdiv)
    {
        var url = "sys/aktualis_ajax_filterlist.php?field=" + field + "&lang=" + language + "&ispart="+is_part_global;
        new Ajax.Request(url, {
            method: 'get',
            onSuccess: function(transport) 
            {
                listdiv.innerHTML = '<select size="8" id="selMake" class="selList" multiple="multiple" ondblclick="add_selected_filters();">' + transport.responseText + '</select>';
                var active = document.getElementById("1234rf");
                var icon1 = document.getElementById(active.value);
                var icon2 = document.getElementById(field);
                /*icon1.src = "img/aktualis/"+active.value+".gif";
        icon2.src = "img/aktualis/"+field+"_h.gif";*/
                icon1.className = "dIcon";
                icon2.className = "dIconSelected";
                active.value = field;
            }
        });
    }
}

function load_simple_filter_list(field)
{
    var listdiv = document.getElementById("IEHack-"+field+"_s"); 
    if(listdiv)
    {
        var url = "sys/aktualis_ajax_filterlist.php?field=" + field + "&lang=" + language +"&ispart="+is_part_global+"&issimple=1";
        // alert(url);
        new Ajax.Request(url, {
            method: 'get',
            onSuccess: function(transport) 
            {
                var active = document.getElementById(field+"_s");
                var width = active.style.width;
                listdiv.innerHTML = '<select onchange="filters_changed(1)" id="'+field+'_s" style="margin:5px;margin-top:0px;margin-bottom:0px;px;width:'+width+'">' + transport.responseText + '</select>';
            }
        });
    }
}

function ispart_changed(to)
{
    if(search_mode == 'simple')
    {
        dropdownIndex = document.getElementById('ispart_s').selectedIndex;
        var ispart = document.getElementById('ispart_s')[dropdownIndex].value;
        is_part_global = ispart;
        //alert(is_part_global);
        load_simple_filter_list("type");
        load_simple_filter_list("function");
        //load_simple_filter_list("make");
        //load_simple_filter_list("saxon-id");
        load_simple_filter_list("akcios");
        
        /*
        if (language == 'eng')
        {
            if (ispart == 1)
                document.getElementById('Hack-make_s').innerHTML = 'Function';
            else
                document.getElementById('Hack-make_s').innerHTML = 'Manufacturer';
        }
      */  
    }
    if(search_mode == 'advanced')
    {
         //alert(to);
         for (index = 0; index < 7; ++index) {
            var sel0 = document.getElementById("s"+index);
            sel0.style.backgroundColor="";
         }
         var sel = document.getElementById("s"+to);
         sel.style.backgroundColor="#ffcc01";
         //sel.className = "dIconSelected";
        is_part_global = to;
        var active = document.getElementById("1234rf");
        load_filter_list(active.value);
        clear_all();
    }
    filters_changed(1);
  
    return false;
}

function show_all()
{
    filters['saxon-id'] = "";
    filters['make'] = "";
    filters['model'] = "";
    filters['fuel'] = "";
    filters['max-load'] = "";
    filters['status'] = "";
    filters['location'] = "";
    filters['cost'] = "";
    var main = document.getElementById('FilterList');
    main.innerHTML = "";
    offset = 0;
    get_list();
}

function change_image(img, pic)
{
    var image = document.getElementById(img); 
    //alert(pic);
    image.src = pic;
}

function change_back(div, pic)
{
    var image = document.getElementById(div); 
    if(image)
        image.style.backgroundImage = 'url('+pic+')';
}

function invert_selection()
{
    var selectedArray = new Array();
    var selObj = document.getElementById("selMake");
    var i;
    for (i=0; i<selObj.options.length; i++) {
        if (selObj.options[i].selected) {
            selObj.options[i].selected = false;
        }
        else
            selObj.options[i].selected = true;
    }
}

function Droppable_OnDrop(element)
{    
    var url = "sys/aktualis_ajax_add_truck_to_basket.php?id=";
    url += element.id.split("_")[1];
    new Ajax.Request(url, {
        method: 'get',
        onSuccess: function(transport) 
        {
            var ret = transport.responseText;
        
            if (ret == "1") //successfully added to basket
            {
                var p = element.parentNode;

                for(var i = 0; i < p.childNodes.length; i++)
                {
                    if (p.childNodes[i] == element)
                    {
                        if (i == p.childNodes.length -1)
                        {
                            p.removeChild(element);
                            //element.className = "dListItemAdded";
                            var e = document.createElement('div');
                            e.className = "dListItemAdded";
                            p.appendChild(e);    
                            //alert('2');
                            e.innerHTML = element.innerHTML;
                            e.id = element.id;
                

                            alert('1');
                            var lol = e.getElementsByTagName('a');
                            //lol.style = "display:none";
                            alert(lol.parentNode.innerHTML);
                
                            break;
                        }
                        else
                        {
                            p.removeChild(element);
                            var e = document.createElement('div');
                            e.className = "dListItemAdded";
                            p.insertBefore(e, p.childNodes[i]);
                            //alert('2');
                            e.innerHTML = element.innerHTML;
                            e.id = element.id;                
                
                            //  alert('1');
                            var lol = e.getElementsByClassName('truck_to_basket');
                            lol[0].style.display = "none";
                            var f = e.getElementsByClassName('truck_in_basket');
                            f[0].style.display = "block";
                            //alert(lol.parentNode.innerHTML);
                            break;
                        }
                    }           
                }
                var basketitem0 = $('basketitem0');
                if (basketitem0 == null)
                {
                    url = "sys/aktualis_ajax_show_basket.php";
                    new Ajax.Request(url, {
                        method: 'get',
                        onSuccess: function(transport) 
                        {
                            var basket = $('Basket');
                            basket.innerHTML = transport.responseText;
                        }
                    });
                    /*                var request1="";
                //alert($('offer_request').value);                
                
            if($('offer_request').value != "")
              request1 = $('offer_request').value;
            if($('auto_spec_offer').value != "")
              request2 = $('auto_spec_offer').value;
              
            url = "sys/aktualis_ajax_basket_get_footer_menu.php" + (request1 != "" ? ("?offer_request="+request1) : "")
                 + (request2 != "" ? ("?offer_request="+request2) : "");*/
                    url = "sys/aktualis_ajax_basket_get_footer_menu.php?" + 
                    (($('offer_request').value != "") ? ("&offer_request=" + $('offer_request').value) : "") + 
                    (($('auto_spec_offer').value != "") ? ("&auto_spec_offer=" + $('auto_spec_offer').value) : "") + 
                    (($('flyer_page').value != "") ? ("&flyer_page=" + $('flyer_page').value) : "");
                         
                 
                    if($('flyer_page').value != "")
                        url += "?flyer_page=" + $('flyer_page').value;
                    // alert(url);
                    new Ajax.Request(url, {
                        method: 'get',
                        onSuccess: function(transport) 
                        {
                            var basketmenu = $('BasketMenu');
                            basketmenu.innerHTML = transport.responseText;
                        }
                    });              
                }
                else
                {
                    url = "sys/aktualis_ajax_basket_get_last_item.php";
                    new Ajax.Request(url, {
                        method: 'get',
                        onSuccess: function(transport) 
                        {
                            var basket = $('Basket');
                            basket.innerHTML += transport.responseText;
                        }
                    });
                }
            }
            else if (ret == "-1") //already in basket
            {
                alert("DEBUG: truck already in basket");
            }
        }
    });
    return false;
}

function get_list()
{
    // Droppables.remove($('Basket'));
    // Droppables.add('Basket', {onDrop : Droppable_OnDrop});
    // Droppables.remove($('BasketMenu'));
    // Droppables.add('BasketMenu', {onDrop : Droppable_OnDrop});
		
		var mode = document.getElementById("mode").value;
    var saxonsearch = document.getElementById('saxonsearch').value;
    var listdiv = document.getElementById("filtered_list");
    if(listdiv)
    {
    		if(document.getElementById('ispart_s')) {
    	  var ispartIndex = document.getElementById('ispart_s').selectedIndex;
    		var ispart = document.getElementById('ispart_s')[ispartIndex].value;
    		} else {
    			var ispart = is_part_global;
    		}
        listdiv.innerHTML = "<img src=\"img/loading.gif\" style=\"width: 32px; height: 32px; margin-left: 414px;\" />";
        var url = "sys/aktualis_ajax_get_filtered_list.php?offset=" + offset;
        url += "&make="+filters['make'];
        url += "&fuel="+filters['fuel'];
        //url += "&saxonid="+filters['saxon-id'];
        url += "&akcios="+filters['akcios'];
        url += "&type="+filters['type'];
        url += "&maxload="+filters['max-load'];
        url += "&status="+filters['status'];
        url += "&location="+filters['location'];
        url += "&cost="+filters['cost'];
        url += "&lang="+language;
        url += "&mode="+mode;
        url += "&saxonsearch="+saxonsearch;
        url += "&ispart="+ispart+"&xxx";
				
				for(var n = 0; n <= 6; n++) {
					if(jQuery("#terstatus_"+n).is(":checked")) {
						url += "&terstatus[]="+n;
					}
				}
				
        //alert(url);
        new Ajax.Request(url, {
            method: 'get',
            onSuccess: function(transport) 
            {
								aktualOffset = 1;
                for(i = 0;i<draggables.length;i++)
                {
                    draggables[i].destroy();
                }
                //alert(transport.responseText);
                var data = transport.responseText.evalJSON();
                if (data['main_data'] != "")
                {
                		jQuery("#filtered_list").html(data['top_menu'] + data['main_data'] + data['bottom_menu']);
                    // listdiv.innerHTML = data['top_menu'] + data['main_data'] + data['bottom_menu'];          
                    var nothingfound = document.getElementById("nothingfound");
                    nothingfound.style.display = "none";
                }
                else
                {
                		jQuery("#filtered_list").html("");
                    // listdiv.innerHTML = "";
                    var nothingfound = document.getElementById("nothingfound");
                    nothingfound.style.display = "inline";
                }
                // alert(data['ids']);
                //ids = data['ids'].split(".");
                draggables.length = data['ids'].length;
                for(i = 0;i < data['ids'].length;i++)
                {
                    disableSelection($(data['ids'][i]));
                    draggables[i] = new Draggable(data['ids'][i],
                    {
                        revert:true, 
                        scroll: window
                    });
                }
            }
        });
    }
}

function get_simple_list()
{
    // Droppables.remove($('Basket'));
    // Droppables.add('Basket', {onDrop : Droppable_OnDrop});
    // Droppables.remove($('BasketMenu'));
    // Droppables.add('BasketMenu', {onDrop : Droppable_OnDrop});
    var dropdownIndex = document.getElementById('make_s').selectedIndex;
    var make = document.getElementById('make_s')[dropdownIndex].value;
    
    var dropdownIndex = document.getElementById('function_s').selectedIndex;
    var functions = document.getElementById('function_s')[dropdownIndex].value;
    
    //dropdownIndex = document.getElementById('saxon-id_s').selectedIndex;
    //var saxon = document.getElementById('saxon-id_s')[dropdownIndex].value;

    dropdownIndex = document.getElementById('akcios_s').selectedIndex;
    var akcios = document.getElementById('akcios_s')[dropdownIndex].value;

   
   
// dropdownIndex = document.getElementById('model_s').selectedIndex;
    // var model = document.getElementById('model_s')[dropdownIndex].value;
    dropdownIndex = document.getElementById('fuel_s').selectedIndex;
    var fuel = document.getElementById('fuel_s')[dropdownIndex].value;
    dropdownIndex = document.getElementById('status_s').selectedIndex;
    var status = document.getElementById('status_s')[dropdownIndex].value;
    dropdownIndex = document.getElementById('type_s').selectedIndex;
    var type = document.getElementById('type_s')[dropdownIndex].value;
    dropdownIndex = document.getElementById('location_s').selectedIndex;
    var location = document.getElementById('location_s')[dropdownIndex].value;
    // dropdownIndex = document.getElementById('max-load_s').selectedIndex;
    // var maxl = document.getElementById('max-load_s')[dropdownIndex].value;
    var maxl = document.getElementById('max-load_s').value;
    // dropdownIndex = document.getElementById('max-height_s').selectedIndex;
    // var maxh = document.getElementById('max-height_s')[dropdownIndex].value;

    // dropdownIndex = document.getElementById('cost_s').selectedIndex;
    // var cost = document.getElementById('cost_s')[dropdownIndex].value;
    var cost = document.getElementById('cost_s').value;
    var saxonsearch = document.getElementById('saxonsearch').value;
    dropdownIndex = document.getElementById('ispart_s').selectedIndex;
    var ispart = document.getElementById('ispart_s')[dropdownIndex].value;
		var mode = document.getElementById("mode").value;
    
    //alert(language +' ' + ispart );
    /*
    if( ispart=='1' ){
        document.getElementById('Hack-make_s').innerHTML = ( (language=='hun')?'FunkciĂł':'Function' );
    }else{
        document.getElementById('Hack-make_s').innerHTML = ((language=='hun')?'GyĂˇrtĂł':'Manufacturer')  ;
    }
    */
    
    
    
    
    
    var listdiv = document.getElementById("filtered_list");
    if(listdiv)
    {
        listdiv.innerHTML = "<img src=\"img/loading.gif\" style=\"width: 32px; height: 32px; margin-left: 414px;\" />";
        var url = "sys/aktualis_ajax_get_filtered_list.php?offset=" + offset;
        url += "&make="+make;
        url += "&function="+functions;
        url += "&fuel="+fuel;
        //url += "&saxonid="+saxon;
        url += "&akcios="+akcios;
        url += "&type="+type;
        url += "&maxload="+maxl;
        url += "&status="+status;
        url += "&location="+location;
        url += "&cost="+cost;
        url += "&lang="+language;
        // alert(saxonsearch);
        url += "&saxonsearch="+saxonsearch;
        url += "&ispart="+ispart;
        url += "&mode="+mode;
				
				for(var n = 0; n <= 5; n++) {
					if(jQuery("#terstatus_"+n).is(":checked")) {
						url += "&terstatus[]="+n;
					}
				}
    
        //alert(url);
    
        new Ajax.Request(url, {
            method: 'get',
            onSuccess: function(transport) 
            {
								aktualOffset = 1;
                for(i = 0;i<draggables.length;i++)
                {
                    draggables[i].destroy();
                }
                // alert(transport.responseText);
                var data = transport.responseText.evalJSON();
                if (data['main_data'] != "")
                {
                		jQuery("#filtered_list").html(data['top_menu'] + data['main_data'] + data['bottom_menu']);
                    // listdiv.innerHTML = data['top_menu'] + data['main_data'] + data['bottom_menu'];          
                    var nothingfound = document.getElementById("nothingfound");
                    nothingfound.style.display = "none";
                }
                else
                {
                		jQuery("#filtered_list").html("");
                    // listdiv.innerHTML = "";
                    var nothingfound = document.getElementById("nothingfound");
                    nothingfound.style.display = "inline";
                }
        
                // alert(data['ids']);
                //ids = data['ids'].split(".");
                draggables.length = data['ids'].length;
                for(i = 0;i < data['ids'].length;i++)
                {
                    disableSelection($(data['ids'][i]));
                    draggables[i] = new Draggable(data['ids'][i],
                    {
                        revert:true, 
                        scroll: window
                    });
                }
            }
        });
    }
}


function remove_truck_from_basket(id)
{
    var url = "sys/aktualis_ajax_remove_truck_from_basket.php?id=" + id;
    new Ajax.Request(url, {
        method: 'get',
        onSuccess: function(transport) 
        {
            var element = document.getElementById('listitem_'+id);
            if(element)
            {
                //element.style.backgroundImage = "url(../img/aktualis/listitem.gif)"; 
                element.className = "dListItem";
                var lol = element.getElementsByClassName('truck_to_basket');
                lol[0].style.display = "block";
                var f = element.getElementsByClassName('truck_in_basket');
                f[0].style.display = "none";
                //    element.onmouseover = new Function("change_back('listitem_"+id+"','img/aktualis/listitem_h.gif')");
                //   element.onmouseout = new Function("change_back('listitem_"+id+"','img/aktualis/listitem.gif')");
                //draggables.length++
                /*alert(draggables.length);*/
                disableSelection(element);
            // draggables.push(new Draggable('listitem_'+id,
            //  {revert:true, scroll: window}));
            /* alert(draggables.length);*/
            }
            //  get_list();
            var basket = $('Basket');
            var basketitem = $('basketitem' + id);
            basket.removeChild(basketitem);
        
            if (basket.childElements().length == 0)
            {
                url = "sys/aktualis_ajax_show_basket.php";
                new Ajax.Request(url, {
                    method: 'get',
                    onSuccess: function(transport) 
                    {
                        var basket = $('Basket');
                        basket.innerHTML = transport.responseText;
                    }
                });
                /*            if($('offer_request').value != "")
              request = $('offer_request').value;
            url = "sys/aktualis_ajax_basket_get_footer_menu.php" + (request != "" ? ("?offer_request="+request) : "");
                 */
                url = "sys/aktualis_ajax_basket_get_footer_menu.php?" + 
                (($('offer_request').value != "") ? ("&offer_request=" + $('offer_request').value) : "") + 
                (($('auto_spec_offer').value != "") ? ("&auto_spec_offer=" + $('auto_spec_offer').value) : "") + 
                (($('flyer_page').value != "") ? ("&flyer_page=" + $('flyer_page').value) : "");
            
                //rem by FARM @ 09-05-27            url = "sys/aktualis_ajax_basket_get_footer_menu.php";
                new Ajax.Request(url, {
                    method: 'get',
                    onSuccess: function(transport) 
                    {
                        var basketmenu = $('BasketMenu');
                        basketmenu.innerHTML = transport.responseText;
                    }
                });            
            }
        }
    });        
}

var filter_timer;


function doMask(){
/*    
    var str = document.getElementById('saxonsearch').value;
    //alert(str);
    if( str.length == 1 ){
        //alert('1');
        if( !str.toUpperCase().match(/^[A-Z]+$/) ){
            document.getElementById('saxonsearch').value = '';
        }else{
        //document.getElementById('saxonsearch').value = str.toUpperCase() + '-';
        }
    }else if( str.length >= 2 && str.length <= 5 ){
        //alert('2');
        if(str.substring(1, 2)!='-' ){
            var str = document.getElementById('saxonsearch').value = str.toUpperCase().substring(0,1)+'-'+str.substring(1);
        }
        if(! /^\d+$/.test( str.substring(str.length-1,str.length) ) ){
            document.getElementById('saxonsearch').value = str.substring(0, str.length-1);
            //alert(str.substring(0, str.length-1));
            return false;
        }
    }else if( str.length > 6 ){
        //alert('3');
        document.getElementById('saxonsearch').value = str.substring(0, 6);
        return false;
    }
    
    
 */   
}



function filters_changed(init)
{
    if(init == '1')
    {
        if(filter_timer){
            clearTimeout(filter_timer);
        }
        filter_timer = setTimeout("filters_changed('0')",500);
    } else {
        offset = 0;
        if(search_mode == "advanced") {
            get_list();
        } else {
            // get_list();
            get_simple_list();	
        }    
    }  
}

function start_offer_request()
{
    var basket = document.getElementById("BasketContainer");
    basket.className = "dBasket";
  
    url = "sys/aktualis_ajax_show_basket.php";
    new Ajax.Request(url, {
        method: 'get',
        onSuccess: function(transport) 
        {
            var basket = $('Basket');
            basket.innerHTML = transport.responseText;
        }
    });  

    /*  var param = get_url_parameter('offer_request');
  url = "sys/aktualis_ajax_basket_get_footer_menu.php" + (param == '' ? '' : '?offer_request=' + param);
  var param = get_url_parameter('auto_spec_offer');
  if (param = '1')
    url = "sys/aktualis_ajax_basket_get_footer_menu.php" + (param == '' ? '' : '?auto_spec_offer=' + param);
     */
    url = "sys/aktualis_ajax_basket_get_footer_menu.php?" + 
    (($('offer_request').value != "") ? ("&offer_request=" + $('offer_request').value) : "") + 
    (($('auto_spec_offer').value != "") ? ("&auto_spec_offer=" + $('auto_spec_offer').value) : "") + 
    (($('flyer_page').value != "") ? ("&flyer_page=" + $('flyer_page').value) : "");

    
    //  alert(url);
    new Ajax.Request(url, {
        method: 'get',
        onSuccess: function(transport) 
        {
            var basketmenu = $('BasketMenu');
            basketmenu.innerHTML = transport.responseText;
        }
    });
}

function get_url_parameter(name)
{
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( window.location.href );
    if( results == null )
        return "";
    else
        return results[1];
}


function load_from_offset(from, id)
{
    offset = from;
    /*remove_link('up_page_'+id);
  remove_link('down_page_'+id);*/
    if(search_mode=="advanced")
        get_list();
    else
        get_simple_list();  
}

function remove_link(id)
{
    var a = document.getElementById(id);
    if(a)
    {
        //alert(a);
        var text = a.innerHTML;
        var onclick = a.onclick;
        //var item = Builder.node('span',{style:'display:inline;', onclick:a.onclick, id:a.id, innerHTML:a.innerHTML});
        a.replace('<span style="display:inline;" onclick="'+onclick+'" id="'+a.id+'">'+text+'</span>');
    // item.appendChild(Builder.node('img',{className: 'imgRemove', src:'img/aktualis/remove.gif', id:imageid, onclick:'remove_filter(\''+item.id+'\');', onmousemove:'change_image(\''+imageid+'\',\'img/aktualis/remove_h.gif\');', onmouseout:'change_image(\''+imageid+'\',\'img/aktualis/remove.gif\');'}));
    }
}

function finalize_offer_request()
{
    var box = document.getElementById("OfferSummary");
    select = $('user');
    var f = document.getElementById('requestcomment');
    // alert(f.value);
    var urladd="comment=" + f.value;
    // alert(urladd);
    if(select)
    {
        urladd += "&userid=" + select[select.selectedIndex].value;
    }
    box.innerHTML = "<img src=\"img/loading.gif\" style=\"width: 32px; height: 32px; margin-left: 414px;\" />";
    if(selected_prev_id == "")
        url = "sys/aktualis_ajax_add_offer_request.php" + "?" + urladd;
    else
    {
        url = "sys/aktualis_ajax_add_offer_request.php?add=" + selected_prev_id.substring(selected_prev_id.indexOf("_") + 1, selected_prev_id.length) +"&comment=" + $('comment').innerHTML + "&" + urladd;
    }
    // alert(url);
    new Ajax.Request(url, {
        method: 'post',
        onSuccess: function(transport) 
        {
            //    alert(transport.responseText);
            if(transport.responseText != "!redir!")
            {
                box.innerHTML = transport.responseText;
            }
            else
            {
                window.location = "http://saxonrt.hu/?page=offer_requests&lang=hun";
            }
        }
    });            
}

function clear_all()
{
    url = "sys/aktualis_ajax_clear_basket.php";
    new Ajax.Request(url, {
        method: 'get',
        onSuccess: function(transport) 
        {
            //var toremove = getElementsByClass('dListItemAdded', $('filtered_list'));
            var list = $('filtered_list');
            var childs = list.childElements();
            for(var i=0;i<childs.length;i++)
            {
                if(childs[i].className == 'dListItemAdded')
                {
                    //  alert(childs[i]);
                    childs[i].className = 'dListItem';
                    var lol = childs[i].getElementsByClassName('truck_to_basket');
                    lol[0].style.display = "block";
                    var f = childs[i].getElementsByClassName('truck_in_basket');
                    f[0].style.display = "none";
                //  childs[i].onmouseover = new Function("change_back('"+childs[i].id+"','img/aktualis/listitem_h.gif')");
                //   childs[i].onmouseout = new Function("change_back('"+childs[i].id+"','img/aktualis/listitem.gif')");
                /*   draggables.push(new Draggable(childs[i].id,
            {revert:true, scroll: window}));*/
                }
            }
            // alert("fuck");
            url = "sys/aktualis_ajax_show_basket.php";
            new Ajax.Request(url, {
                method: 'get',
                onSuccess: function(transport) 
                {
                    var basket = $('Basket');
                    basket.innerHTML = transport.responseText;
                }
            });
            /*        if($('offer_request').value != "")
              request = $('offer_request').value;
            url = "sys/aktualis_ajax_basket_get_footer_menu.php" + (request != "" ? ("?offer_request="+request) : "");
        if($('flyer_page').value != "")
          url += "&flyer_page=" + $('flyer_page').value;
             */

            url = "sys/aktualis_ajax_basket_get_footer_menu.php?" + 
            (($('offer_request').value != "") ? ("&offer_request=" + $('offer_request').value) : "") + 
            (($('auto_spec_offer').value != "") ? ("&auto_spec_offer=" + $('auto_spec_offer').value) : "") + 
            (($('flyer_page').value != "") ? ("&flyer_page=" + $('flyer_page').value) : "");


            //  url = "sys/aktualis_ajax_basket_get_footer_menu.php";
            new Ajax.Request(url, {
                method: 'get',
                onSuccess: function(transport) 
                {
                    var basketmenu = $('BasketMenu');
                    basketmenu.innerHTML = transport.responseText;
                }
            }); 
        }
    });
}

function show_finalize_request()
{
    //var container = $('aktualis_data');
    var url = "sys/aktualis_ajax_offer_finalize.php";
    //$('form1').style.display = "none";
    Effect.toggle('aktualis_data', 'appear',
    {
        afterFinish:function()

        {
            new Ajax.Request(url, {
                method: 'get',
                onSuccess: function(transport) 
                {
                    //alert(transport.responseText);
                    var data = transport.responseText.split("@");
                    //data = .split("@");
                    //debugger;
          
                    prev_reqs = data[0];
                    $('aktualis_data').innerHTML = data[1];
                    // container.appear({ duration: 3.0 });
                    Effect.toggle('aktualis_data', 'appear', {
                        duration: 0.5
                    });
                },
                onFailed :function()
                {
                    Effect.toggle('aktualis_data', 'appear', {
                        duration: 0.5
                    });
                }
            });
        }
    });
//debugger;
/*Effect.toggle('aktualis_data', 'appear', { 
    duration: 0.5,
    afterFinish: function()
    {
      new Ajax.Request(url, {
      method: 'get',
      onSuccess: function(transport) 
        {
          data = transport.responseText.split("@");
          debugger;
          alert(data[0]);
          prev_reqs = data[0];
          container.innerHTML = data[1];
         // container.appear({ duration: 3.0 });
          Effect.toggle('aktualis_data', 'appear', { duration: 0.5 });
        },
      onFailed :function()
        {
          Effect.toggle('aktualis_data', 'appear', { duration: 0.5 });
        }
     });
    }
  });*/
}

function back_to_shop()
{
    var container = $('aktualis_data');
    var url = "?ajax=1&page=aktualis&lang=" + language;
    Effect.toggle('aktualis_data', 'appear', { 
        duration: 0.5,
        afterFinish: function()
        {
            new Ajax.Request(url, {
                method: 'get',
                onSuccess: function(transport) 
                {
                    container.innerHTML = transport.responseText;
                    // container.appear({ duration: 3.0 });
                    Effect.toggle('aktualis_data', 'appear', {
                        duration: 0.5
                    });
                }
            });
        }
    });
}

function select_addto(id)
{
    selected_prev_id = id;
}
function set_special_offer()
{
    alert('L');
}

function change_search_mode()
{
    if(search_mode == 'simple')
    {
        $('advancedsearch').style.display = 'block';
        $('simplesearch').style.display = 'none';
        search_mode = 'advanced';
    }
    else if(search_mode == 'advanced')
    {
        $('advancedsearch').style.display = 'none';
        $('simplesearch').style.display = 'block';
        search_mode = 'simple';
    }
}

function refresh_company_user_list()
{
    var selObj = document.getElementById('comp');
    var i = 0;
    for (i=0; i<selObj.options.length; i++) 
    {
        if (selObj.options[i].selected) 
        {
            break;
        }
    }
    var id = selObj.options[i].value;
    var url = "sys/get_users_by_company.php?companyid="+id;
    var hack = document.getElementById('user_IEHack');
  
    new Ajax.Request(url, {
        method: 'get',
        onSuccess: function(transport) 
        {
            //  alert(transport.responseText);
            var json = transport.responseText.evalJSON();
            var stuff = '<select id="user" style="width:400px;">';
            for(i = 0; i < json.length;i++)
            {
                stuff += '<option value="'+json[i].users_id+'">'+json[i].users_realname+'</option>';
            }
            stuff += "</select>";
            stuff += "<span style=\"padding-left:10px;\"><a href=\"http://saxonrt.hu/?page=reg&companyid=" + id + "&lang=hun\">ĂĽgyintĂ©zĂµ hozzĂˇadĂˇsa</a></span><br />";
            hack.innerHTML = stuff;
        }
    });
}


function aktualLoadNextAjax() {
	var dropdownIndex = document.getElementById('make_s').selectedIndex;
	var make = document.getElementById('make_s')[dropdownIndex].value;
	var dropdownIndex = document.getElementById('function_s').selectedIndex;
	var functions = document.getElementById('function_s')[dropdownIndex].value;
	dropdownIndex = document.getElementById('akcios_s').selectedIndex;
	var akcios = document.getElementById('akcios_s')[dropdownIndex].value;
	dropdownIndex = document.getElementById('fuel_s').selectedIndex;
	var fuel = document.getElementById('fuel_s')[dropdownIndex].value;
	dropdownIndex = document.getElementById('status_s').selectedIndex;
	var status = document.getElementById('status_s')[dropdownIndex].value;
	dropdownIndex = document.getElementById('type_s').selectedIndex;
	var type = document.getElementById('type_s')[dropdownIndex].value;
	dropdownIndex = document.getElementById('location_s').selectedIndex;
	var location = document.getElementById('location_s')[dropdownIndex].value;
	// dropdownIndex = document.getElementById('max-load_s').selectedIndex;
	// var maxl = document.getElementById('max-load_s')[dropdownIndex].value;
  var maxl = document.getElementById('max-load_s').value;
	// dropdownIndex = document.getElementById('cost_s').selectedIndex;
	// var cost = document.getElementById('cost_s')[dropdownIndex].value;
	var cost = document.getElementById('cost_s').value;
	var saxonsearch = document.getElementById('saxonsearch').value;
	dropdownIndex = document.getElementById('ispart_s').selectedIndex;
	var ispart = document.getElementById('ispart_s')[dropdownIndex].value;
	var mode = document.getElementById("mode").value;


	var url = "sys/aktualis_ajax_get_filtered_list.php?offset=" + (aktualOffset * 15);
			url += "&make="+make;
			url += "&function="+functions;
			url += "&fuel="+fuel;
			url += "&akcios="+akcios;
			url += "&type="+type;
			url += "&maxload="+maxl;
			url += "&status="+status;
			url += "&location="+location;
			url += "&cost="+cost;
			url += "&lang="+language;
			url += "&saxonsearch="+saxonsearch;
			url += "&ispart="+ispart;
			url += "&mode="+mode;
			
	for(var n = 0; n <= 5; n++) {
		if(jQuery("#terstatus_"+n).is(":checked")) {
			url += "&terstatus[]="+n;
		}
	}

	new Ajax.Request(url, {
		method: 'get',
		onSuccess: function(transport) {
			for(i=0;i<draggables.length;i++) { draggables[i].destroy(); }
			var data = transport.responseText.evalJSON();
			if (data['main_data'] != "") {
				jQuery('#filtered_list').append(data['main_data']);
				var nothingfound = document.getElementById("nothingfound");
				nothingfound.style.display = "none";
				jQuery('#filtered_list').attr('loading','loaded');
				jQuery('#filtered_list .ajaxloding').remove();
				aktualOffset = aktualOffset + 1;
			}
			
			draggables.length = data['ids'].length;
			for(i = 0;i < data['ids'].length;i++) {
				disableSelection($(data['ids'][i]));
				draggables[i] = new Draggable(data['ids'][i],
				{
					revert: true, 
					scroll: window
				});
			}
		}
	});
}


var aktualOffset = 1;
var aktualOffsetMax = 0;

function aktualLoadScroll() {
	var wh = parseFloat(jQuery(document).height());
	var dh = parseFloat(jQuery('body').outerHeight());
	var x = parseFloat(jQuery(window).scrollTop());
	var b = 900;
	var h = wh - dh;
	var st = h - x;
	var m = parseFloat(jQuery("#filtered_list").attr("max"));
	
	if(st<b && jQuery('#filtered_list').attr('loading')!='loading' && m>aktualOffset) {
		jQuery('#filtered_list').attr('loading','loading');
		var loding = '<div class="ajaxloding" style="text-align:center;"><img src="img/loading.gif" style="width: 32px; height: 32px; margin-left: 414px;" /></div>';
		jQuery('#filtered_list').append(loding);
		aktualLoadNextAjax();
	}
	// jQuery('title').html(st+'/'+h);
}

/*
jQuery(document).scroll(function() {
	aktualLoadScroll();
});
*/