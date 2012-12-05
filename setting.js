/**
 *     Fancy Image Show
 *     Copyright (C) 2011 - 2013 www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */	

function FancyImg_submit()
{
	if(document.FancyImg_form.FancyImg_Gallery.value=="")
	{
		alert("Please enter the image path.")
		document.FancyImg_form.FancyImg_Gallery.focus();
		return false;
	}
	else if(document.FancyImg_form.FancyImg_Width.value=="" || isNaN(document.FancyImg_form.FancyImg_Width.value))
	{
		alert("Please enter the gallery width, only number.")
		document.FancyImg_form.FancyImg_Width.focus();
		document.FancyImg_form.FancyImg_Width.select();
		return false;
	}
	else if(document.FancyImg_form.FancyImg_Height.value=="" || isNaN(document.FancyImg_form.FancyImg_Height.value))
	{
		alert("Please enter the gallery height, only number.")
		document.FancyImg_form.FancyImg_Height.focus();
		document.FancyImg_form.FancyImg_Height.select();
		return false;
	}
	else if(document.FancyImg_form.FancyImg_delay.value=="" || isNaN(document.FancyImg_form.FancyImg_delay.value))
	{
		alert("Please enter the gallery effect delay, only number.")
		document.FancyImg_form.FancyImg_delay.focus();
		document.FancyImg_form.FancyImg_delay.select();
		return false;
	}
	else if(document.FancyImg_form.FancyImg_StripDelay.value=="" || isNaN(document.FancyImg_form.FancyImg_StripDelay.value))
	{
		alert("Please enter the strip delay, only number.")
		document.FancyImg_form.FancyImg_StripDelay.focus();
		document.FancyImg_form.FancyImg_StripDelay.select();
		return false;
	}
	else if(document.FancyImg_form.FancyImg_Strips.value=="" || isNaN(document.FancyImg_form.FancyImg_Strips.value))
	{
		alert("Please enter the delay, only number.")
		document.FancyImg_form.FancyImg_Strips.focus();
		document.FancyImg_form.FancyImg_Strips.select();
		return false;
	}
	else if(document.FancyImg_form.FancyImg_Extra1.value=="")
	{
		alert("Please enter the image location, only number.")
		document.FancyImg_form.FancyImg_Extra1.focus();
		return false;
	}
}

function FancyImg_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_FancyImg_display.action="options-general.php?page=fancy-image-show/fancy-image-show.php&AC=DEL&DID="+id;
		document.frm_FancyImg_display.submit();
	}
}	

function FancyImg_redirect()
{
	window.location = "options-general.php?page=fancy-image-show/fancy-image-show.php";
}

function FancyImg_help()
{
	window.open("http://www.gopiplus.com/work/2011/11/06/fancy-image-show-wordpress-plugin/");
}