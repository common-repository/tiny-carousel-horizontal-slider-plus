function _tchsp_submit()
{
	if(document.tchsp_form.img_title.value == "")
	{
		alert(tchsp_image_adminscripts.tchsp_img_title)
		document.tchsp_form.img_title.focus();
		return false;
	}
	else if(document.tchsp_form.img_imageurl.value == "")
	{
		alert(tchsp_image_adminscripts.tchsp_img_imageurl)
		document.tchsp_form.img_imageurl.focus();
		return false;
	}
	else if(document.tchsp_form.img_gal_id.value == "")
	{
		alert(tchsp_image_adminscripts.tchsp_img_gal_id)
		document.tchsp_form.img_gal_id.focus();
		return false;
	}
}

function _tchsp_delete(id)
{
	if(confirm(tchsp_image_adminscripts.tchsp_img_delete))
	{
		document.frm_tchsp_display.action="admin.php?page=tchsp-image-details&ac=del&did="+id;
		document.frm_tchsp_display.submit();
	}
}	

function _tchsp_redirect()
{
	window.location = "admin.php?page=tchsp-image-details";
}

function _tchsp_help()
{
	window.open("http://www.gopiplus.com/work/2014/06/06/tiny-carousel-horizontal-slider-plus-wordpress-plugin/");
}

function _tchsp_checkall(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}

function _tchsp_gal_redirect()
{
	window.location = "admin.php?page=tchsp-gallery-details";
}

function _tchsp_gal_delete(id)
{
	if(confirm(tchsp_gallery_adminscripts.tchsp_gal_delete))
	{
		document.frm_tchsp_display.action="admin.php?page=tchsp-gallery-details&ac=del&did="+id;
		document.frm_tchsp_display.submit();
	}
}

function _tchsp_gal_submit()
{
	if(document.tchsp_form.gal_title.value == "")
	{
		alert(tchsp_gallery_adminscripts.tchsp_gal_title)
		document.tchsp_form.gal_title.focus();
		return false;
	}
	else if(document.tchsp_form.gal_width.value == "")
	{
		alert(tchsp_gallery_adminscripts.tchsp_gal_width)
		document.tchsp_form.gal_width.focus();
		return false;
	}
	else if(isNaN(document.tchsp_form.gal_width.value))
	{
		alert(tchsp_gallery_adminscripts.tchsp_gal_widthnum)
		document.tchsp_form.gal_width.focus();
		return false;
	}
	else if(document.tchsp_form.gal_height.value == "")
	{
		alert(tchsp_gallery_adminscripts.tchsp_gal_height)
		document.tchsp_form.gal_height.focus();
		return false;
	}
	else if(isNaN(document.tchsp_form.gal_height.value))
	{
		alert(tchsp_gallery_adminscripts.tchsp_gal_heightnum)
		document.tchsp_form.gal_height.focus();
		return false;
	}
	else if(document.tchsp_form.gal_intervaltime.value == "")
	{
		alert(tchsp_gallery_adminscripts.tchsp_gal_intervaltime)
		document.tchsp_form.gal_intervaltime.focus();
		return false;
	}
	else if(isNaN(document.tchsp_form.gal_intervaltime.value))
	{
		alert(tchsp_gallery_adminscripts.tchsp_gal_intervaltimenum)
		document.tchsp_form.gal_intervaltime.focus();
		return false;
	}
	else if(document.tchsp_form.gal_animation.value == "")
	{
		alert(tchsp_gallery_adminscripts.tchsp_gal_animation)
		document.tchsp_form.gal_animation.focus();
		return false;
	}
	else if(isNaN(document.tchsp_form.gal_animation.value))
	{
		alert(tchsp_gallery_adminscripts.tchsp_gal_animationnum)
		document.tchsp_form.gal_animation.focus();
		return false;
	}
}