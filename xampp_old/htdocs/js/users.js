function assign_user(user)
{
  var selects = $('user_' + user).getElementsByTagName('select');
  var select = selects[0];
  url = "sys/admin_assign_user.php?userid=" + user + "&companyid=" + select.value;
   new Ajax.Request(url, {
    method: 'get',
    onSuccess: function(transport) 
      {
      //  alert("fuck");
        // alert(transport.responseText);
        window.reload();
      }
    });


    
}



function ispComboToSaxonChar(obj) {
	var betu = jQuery(obj).find(':selected').attr('betu');
	betu = betu.split(',');
	jQuery('#ispart_betu').html('');
	for(var a=0; a<betu.length; a++) {
		jQuery('#ispart_betu').append('<option value="'+betu[a]+'">'+betu[a]+'</option>');
	}
	jQuery('.newtypes').attr('class','newtypes ispart-'+jQuery(obj).val());
}
function ispComboToSaxonChar2(obj) {
	jQuery('.newtypes option').removeAttr('style');
	jQuery('.newtypes').attr('class','newtypes ispart-'+jQuery(obj).val());
	jQuery('.newtypes').val("");
}