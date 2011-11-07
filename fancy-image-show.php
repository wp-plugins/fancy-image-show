<?php

/*
Plugin Name: Fancy Image Show
Plugin URI: http://www.gopiplus.com/work/2011/11/06/fancy-image-show-wordpress-plugin/
Description: Fancy Image Show WordPress plugin is a simple image rotation plugin. The image rotation happens with five different fancy effects, so it is named fancy image show. 
Author: Gopi.R
Version: 1.0
Author URI: http://www.gopiplus.com/work/
Donate link: http://www.gopiplus.com/work/2011/11/06/fancy-image-show-wordpress-plugin/
Tags: Image, slider, slideshow, description
*/

/**
 *     Fancy Image Show
 *     Copyright (C) 2011  www.gopiplus.com
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

global $wpdb, $wp_version;
define("WP_FANCYIMGSHOW_TABLE", $wpdb->prefix . "FancyImg_plugin");

function FancyImgShow() 
{
	global $wpdb;
	$sSql = "select * from ".WP_FANCYIMGSHOW_TABLE." where 1=1 order by rand() limit 0,1;";
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$FancyImg_Gallery = $data->FancyImg_Gallery;
			$FancyImg_Width = $data->FancyImg_Width;
			$FancyImg_Height = $data->FancyImg_Height;
			$FancyImg_Effect = $data->FancyImg_Effect;
			$FancyImg_delay = $data->FancyImg_delay;
			$FancyImg_Strips = $data->FancyImg_Strips;
			$FancyImg_StripDelay = $data->FancyImg_StripDelay;
			$FancyImg_Random = $data->FancyImg_Random;
			$FancyImg_Extra1 = $data->FancyImg_Extra1;
		}
		//echo $FancyImg_Extra1;
		$siteurl_link = get_option('siteurl') . "/";
		$f_dirHandle = opendir($FancyImg_Extra1);
		$FancyImg = "";
		while ($f_file = readdir($f_dirHandle)) 
		{
			if(!is_dir($f_file) && (strpos($f_file, '.jpg')>0 or strpos($f_file, '.gif')>0)) 
			{
				$FancyImg = $FancyImg ."<img src='".$siteurl_link . $FancyImg_Extra1 . $f_file ."' />";
			}
		}
	}
	?>
    <script>
	$j(function() {                   	
			$j(document).ready(function(){
			$j('#Wh_<?php echo $FancyImg_Gallery ?>').FancyImageShow({ 
			width: 	<?php echo $FancyImg_Width ?>, 
			height: <?php echo $FancyImg_Height ?>, 
			effect: '<?php echo $FancyImg_Effect ?>',
			delay:  <?php echo $FancyImg_delay ?>,
			strips:	<?php echo $FancyImg_Strips ?>,
			stripDelay: <?php echo $FancyImg_StripDelay ?> });
	});        				
			});
	</script> 
    <div id="Wh_<?php echo $FancyImg_Gallery ?>"><?php echo $FancyImg; ?></div>
    <?php
}

function FancyImg_install() 
{
	global $wpdb;
	if($wpdb->get_var("show tables like '". WP_FANCYIMGSHOW_TABLE . "'") != WP_FANCYIMGSHOW_TABLE) 
	{
		$sSql = "CREATE TABLE IF NOT EXISTS `". WP_FANCYIMGSHOW_TABLE . "` (";
		$sSql = $sSql . "`FancyImg_id` INT NOT NULL AUTO_INCREMENT ,";
		$sSql = $sSql . "`FancyImg_Gallery` VARCHAR( 10 ) NOT NULL ,";
		$sSql = $sSql . "`FancyImg_Width` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`FancyImg_Height` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`FancyImg_Effect` VARCHAR( 15 ) NOT NULL ,";
		$sSql = $sSql . "`FancyImg_delay` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`FancyImg_Strips` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`FancyImg_StripDelay` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`FancyImg_Random` VARCHAR( 4 ) NOT NULL ,";
		$sSql = $sSql . "`FancyImg_Extra1` VARCHAR( 1024 ) NOT NULL ,";
		$sSql = $sSql . "`FancyImg_Extra2` VARCHAR( 100 ) NOT NULL ,";
		$sSql = $sSql . "`FancyImg_Date` datetime NOT NULL default '0000-00-00 00:00:00' ,";
		$sSql = $sSql . "PRIMARY KEY ( `FancyImg_id` )";
		$sSql = $sSql . ")";
		$wpdb->query($sSql);
		
		$IsSql = "INSERT INTO `". WP_FANCYIMGSHOW_TABLE . "` (`FancyImg_Gallery`, `FancyImg_Width`, `FancyImg_Height` , `FancyImg_Effect` , `FancyImg_delay` , `FancyImg_Strips` , `FancyImg_StripDelay` , `FancyImg_Random` ,`FancyImg_Extra1` , `FancyImg_Date`)"; 
		
		$sSql = $IsSql . " VALUES ('GALLERY1', '200', '150', 'random top', '2000', '12', '30', 'YES', 'wp-content/plugins/fancy-image-show/gallery1/', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
		$sSql = $IsSql . " VALUES ('GALLERY2', '280', '280', 'zipper', '2000', '12', '30', 'YES', 'wp-content/plugins/fancy-image-show/gallery2/', '0000-00-00 00:00:00');";
		$wpdb->query($sSql);
	}

	add_option('FancyImg_Title', "Fancy Image Show");
}

function FancyImg_admin_options() 
{
	include_once("image-management.php");
}

add_filter('the_content','FancyImg_Show_Filter');

function FancyImg_Show_Filter($content)
{
	return 	preg_replace_callback('/\[FANCY-IMG-SHOW:(.*?)\]/sim','FancyImg_Show_Filter_Callback',$content);
}

function FancyImg_Show_Filter_Callback($matches) 
{
	global $wpdb;
	$scode = $matches[1];
	//[FANCY-IMG-SHOW:GALLERY1]
	$sSql = "select * from ".WP_FANCYIMGSHOW_TABLE." where 1=1 and FancyImg_Gallery='".$scode."' order by rand() limit 0,1;";
	$data = $wpdb->get_results($sSql);
	if ( ! empty($data) ) 
	{
		foreach ( $data as $data ) 
		{
			$FancyImg_Gallery = $data->FancyImg_Gallery;
			$FancyImg_Width = $data->FancyImg_Width;
			$FancyImg_Height = $data->FancyImg_Height;
			$FancyImg_Effect = $data->FancyImg_Effect;
			$FancyImg_delay = $data->FancyImg_delay;
			$FancyImg_Strips = $data->FancyImg_Strips;
			$FancyImg_StripDelay = $data->FancyImg_StripDelay;
			$FancyImg_Random = $data->FancyImg_Random;
			$FancyImg_Extra1 = $data->FancyImg_Extra1;
		}
		//echo $FancyImg_Extra1;
		$siteurl_link = get_option('siteurl') . "/";
		if(is_dir($FancyImg_Extra1))
		{
			$f_dirHandle = opendir($FancyImg_Extra1);
			$FancyImg = "";
			while ($f_file = readdir($f_dirHandle)) 
			{
				if(!is_dir($f_file) && (strpos($f_file, '.jpg')>0 or strpos($f_file, '.gif')>0)) 
				{
					$FancyImgDiv = $FancyImgDiv ."<img src='".$siteurl_link . $FancyImg_Extra1 . $f_file ."' />";
				}
			}
		}
		else
		{
			echo "Wrong folder location, Pls enter as per example.";
		}
	}
 	$FancyImg = "";
    $FancyImg = $FancyImg."<script>";
	$FancyImg = $FancyImg.'$j(function() {  ';                 	
			$FancyImg = $FancyImg.'$j(document).ready(function(){ ';
			$FancyImg = $FancyImg.'$j("#'.$FancyImg_Gallery.'_1").FancyImageShow({ ';
			$FancyImg = $FancyImg."width: ".$FancyImg_Width.", ";
			$FancyImg = $FancyImg."height: ".$FancyImg_Height.", ";
			$FancyImg = $FancyImg."effect: '".$FancyImg_Effect."', ";
			$FancyImg = $FancyImg."delay:  ".$FancyImg_delay.", ";
			$FancyImg = $FancyImg."strips:	".$FancyImg_Strips.", ";
			$FancyImg = $FancyImg."stripDelay: ".$FancyImg_StripDelay." }); ";
	$FancyImg = $FancyImg."}); ";        				
			$FancyImg = $FancyImg."}); ";
	$FancyImg = $FancyImg."</script>";
    $FancyImg = $FancyImg.'<div id="'.$FancyImg_Gallery.'_1">'.$FancyImgDiv.'</div>';
	return $FancyImg;
}

function FancyImg_deactivation() 
{

}


function FancyImg_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'jquery-1.7.min', get_option('siteurl').'/wp-content/plugins/fancy-image-show/js/jquery-1.7.min.js');
		wp_enqueue_script( 'fancy-image-show', get_option('siteurl').'/wp-content/plugins/fancy-image-show/js/fancy-image-show.js');
	}	
}

add_action('init', 'FancyImg_add_javascript_files');

function FancyImg_add_to_menu() 
{
	add_options_page('Fancy Image Show', 'Fancy Image Show', 'manage_options', __FILE__, 'FancyImg_admin_options' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'FancyImg_add_to_menu');
}

function FancyImg_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('FancyImg_Title');
	echo $after_title;
	FancyImgShow();
	echo $after_widget;
}

function FancyImg_control() 
{
	echo 'Fancy Image Show';
}

function FancyImg_init()
{
	if(function_exists('register_sidebar_widget')) 
	{
		register_sidebar_widget('Fancy Image Show', 'FancyImg_widget');
	}
	
	if(function_exists('register_widget_control')) 
	{
		register_widget_control(array('Fancy Image Show', 'widgets'), 'FancyImg_control');
	} 
}

add_action("plugins_loaded", "FancyImg_init");
register_activation_hook(__FILE__, 'FancyImg_install');
register_deactivation_hook(__FILE__, 'FancyImg_deactivation');
?>
