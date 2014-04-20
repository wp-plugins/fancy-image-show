<?php
/*
Plugin Name: Fancy Image Show
Plugin URI: http://www.gopiplus.com/work/2011/11/06/fancy-image-show-wordpress-plugin/
Description: Fancy Image Show WordPress plugin is a simple image rotation plugin. The image rotation happens with five different fancy effects, so it is named fancy image show. 
Author: Gopi Ramasamy
Version: 7.2
Author URI: http://www.gopiplus.com/work/2011/11/06/fancy-image-show-wordpress-plugin/
Donate link: http://www.gopiplus.com/work/2011/11/06/fancy-image-show-wordpress-plugin/
Tags: Fancy, slideshow, Images
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

global $wpdb, $wp_version;
define("WP_FANCYIMGSHOW_TABLE", $wpdb->prefix . "FancyImg_plugin");
define('WP_FancyImg_FAV', 'http://www.gopiplus.com/work/2011/11/06/fancy-image-show-wordpress-plugin/');

if ( ! defined( 'WP_FancyImg_BASENAME' ) )
	define( 'WP_FancyImg_BASENAME', plugin_basename( __FILE__ ) );
	
if ( ! defined( 'WP_FancyImg_PLUGIN_NAME' ) )
	define( 'WP_FancyImg_PLUGIN_NAME', trim( dirname( WP_FancyImg_BASENAME ), '/' ) );
	
if ( ! defined( 'WP_FancyImg_PLUGIN_URL' ) )
	define( 'WP_FancyImg_PLUGIN_URL', WP_PLUGIN_URL . '/' . WP_FancyImg_PLUGIN_NAME );
	
if ( ! defined( 'WP_FancyImg_ADMIN_URL' ) )
	define( 'WP_FancyImg_ADMIN_URL', get_option('siteurl') . '/wp-admin/options-general.php?page=fancy-image-show' );

function FancyImg( $gallery = "GALLERY1" ) 
{
	$arr = array();
	$arr["gallery"] = $gallery;
	echo FancyImg_shortcode($arr);
}

function FancyImgShow() 
{
	global $wpdb;
	$FancyImg_Setting = get_option('FancyImg_Setting');
	$arr = array();
	$arr["gallery"] = $FancyImg_Setting;
	echo FancyImg_shortcode($arr);
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
	add_option('FancyImg_Setting', "GALLERY1");
}

function FancyImg_admin_options() 
{
	//include_once("image-management.php");
	global $wpdb;
	$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
	switch($current_page)
	{
		case 'edit':
			include('pages/content-management-edit.php');
			break;
		case 'add':
			include('pages/content-management-add.php');
			break;
		case 'set':
			include('pages/widget-setting.php');
			break;
		default:
			include('pages/content-management-show.php');
			break;
	}
}

function FancyImg_shortcode( $atts ) 
{
	global $wpdb;
	//[fancy-img-show gallery="GALLERY1"]

	$FancyImgDiv = "";
	
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$scode = $atts['gallery'];
	
	
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
			
			$random = rand(10,100);
	
			$FancyImg = "";
			$FancyImg = $FancyImg."<script>";
			$FancyImg = $FancyImg.'$j(function() {  ';                 	
					$FancyImg = $FancyImg.'$j(document).ready(function(){ ';
					$FancyImg = $FancyImg.'$j("#'.$FancyImg_Gallery.$random.'").FancyImageShow({ ';
					$FancyImg = $FancyImg."width: ".$FancyImg_Width.", ";
					$FancyImg = $FancyImg."height: ".$FancyImg_Height.", ";
					$FancyImg = $FancyImg."effect: '".$FancyImg_Effect."', ";
					$FancyImg = $FancyImg."delay:  ".$FancyImg_delay.", ";
					$FancyImg = $FancyImg."strips:	".$FancyImg_Strips.", ";
					$FancyImg = $FancyImg."stripDelay: ".$FancyImg_StripDelay." }); ";
			$FancyImg = $FancyImg."}); ";        				
					$FancyImg = $FancyImg."}); ";
			$FancyImg = $FancyImg."</script>";
			$FancyImg = $FancyImg.'<div id="'.$FancyImg_Gallery.$random.'">'.$FancyImgDiv.'</div>';
			
		}
		else
		{
			$FancyImg = "Wrong folder location ( " .$FancyImg_Extra1. " ), Pls enter as per example.";
		}
	}
	else
	{
		$FancyImg = "Gallery ( " .$scode. " ) not available";
	}
	return $FancyImg;
}

function FancyImg_deactivation() 
{
	//No action required.
}

function FancyImg_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'jquery');
		wp_enqueue_script( 'fancy-image-show', WP_FancyImg_PLUGIN_URL.'/js/fancy-image-show.js');
	}	
}

function FancyImg_add_to_menu() 
{
	add_options_page(__('Fancy Image Show', 'fancy-image-show'), __('Fancy Image Show', 'fancy-image-show'), 'manage_options', 'fancy-image-show', 'FancyImg_admin_options' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'FancyImg_add_to_menu');
}

function FancyImg_widget($args) 
{
	extract($args);
	if (get_option('FancyImg_Title') <> "")
	{
		echo $before_widget . $before_title;
		echo get_option('FancyImg_Title');
		echo $after_title;
	}
	else
	{
		echo '<div style="height:10px;"></div>';
	}
	FancyImgShow();
	if (get_option('FancyImg_Title') <> "")
	{
		echo $after_widget;
	}
	else
	{
		echo '<div style="height:10px;"></div>';
	}
}

function FancyImg_control() 
{
	$FancyImg_Title = get_option('FancyImg_Title');
	$FancyImg_Setting = get_option('FancyImg_Setting');
	if (isset($_POST['FancyImg_Submit'])) 
	{
		$FancyImg_Title = $_POST['FancyImg_Title'];
		$FancyImg_Setting = $_POST['FancyImg_Setting'];
		update_option('FancyImg_Title', $FancyImg_Title );
		update_option('FancyImg_Setting', $FancyImg_Setting );
	}
	echo '<p>'.__('Widget Title:', 'fancy-image-show').'<br><input  style="width: 200px;" type="text" value="';
	echo $FancyImg_Title . '" name="FancyImg_Title" id="FancyImg_Title" /></p>';
	echo '<p>'.__('Gallery Setting:', 'fancy-image-show').'<br><select name="FancyImg_Setting" id="FancyImg_Setting">';
	?>
	<option value="GALLERY1" <?php if($FancyImg_Setting=='GALLERY1') { echo 'selected' ; } ?>>GALLERY1</option>
	<option value="GALLERY2" <?php if($FancyImg_Setting=='GALLERY2') { echo 'selected' ; } ?>>GALLERY2</option>
	<option value="GALLERY3" <?php if($FancyImg_Setting=='GALLERY3') { echo 'selected' ; } ?>>GALLERY3</option>
	<option value="GALLERY4" <?php if($FancyImg_Setting=='GALLERY4') { echo 'selected' ; } ?>>GALLERY4</option>
	<option value="GALLERY5" <?php if($FancyImg_Setting=='GALLERY5') { echo 'selected' ; } ?>>GALLERY5</option>
	<option value="GALLERY6" <?php if($FancyImg_Setting=='GALLERY6') { echo 'selected' ; } ?>>GALLERY6</option>
	<option value="GALLERY7" <?php if($FancyImg_Setting=='GALLERY7') { echo 'selected' ; } ?>>GALLERY7</option>
	<option value="GALLERY8" <?php if($FancyImg_Setting=='GALLERY8') { echo 'selected' ; } ?>>GALLERY8</option>
	<option value="GALLERY9" <?php if($FancyImg_Setting=='GALLERY9') { echo 'selected' ; } ?>>GALLERY9</option>
	<option value="GALLERY10" <?php if($FancyImg_Setting=='GALLERY10') { echo 'selected' ; } ?>>GALLERY10</option>
	<option value="GALLERY11" <?php if($FancyImg_Setting=='GALLERY11') { echo 'selected' ; } ?>>GALLERY11</option>
	<option value="GALLERY12" <?php if($FancyImg_Setting=='GALLERY12') { echo 'selected' ; } ?>>GALLERY12</option>
	<option value="GALLERY13" <?php if($FancyImg_Setting=='GALLERY13') { echo 'selected' ; } ?>>GALLERY13</option>
	<option value="GALLERY14" <?php if($FancyImg_Setting=='GALLERY14') { echo 'selected' ; } ?>>GALLERY14</option>
	<option value="GALLERY15" <?php if($FancyImg_Setting=='GALLERY15') { echo 'selected' ; } ?>>GALLERY15</option>
	<option value="GALLERY16" <?php if($FancyImg_Setting=='GALLERY16') { echo 'selected' ; } ?>>GALLERY16</option>
	<option value="GALLERY17" <?php if($FancyImg_Setting=='GALLERY17') { echo 'selected' ; } ?>>GALLERY17</option>
	<option value="GALLERY18" <?php if($FancyImg_Setting=='GALLERY18') { echo 'selected' ; } ?>>GALLERY18</option>
	<option value="GALLERY19" <?php if($FancyImg_Setting=='GALLERY19') { echo 'selected' ; } ?>>GALLERY19</option>
	<option value="GALLERY20" <?php if($FancyImg_Setting=='GALLERY20') { echo 'selected' ; } ?>>GALLERY20</option>
	</select>
	<?php
	echo '<input type="hidden" id="FancyImg_Submit" name="FancyImg_Submit" value="1" />';
}

function FancyImg_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget(__('Fancy Image Show', 'fancy-image-show'), __('Fancy Image Show', 'fancy-image-show'), 'FancyImg_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control(__('Fancy Image Show', 'fancy-image-show'), array(__('Fancy Image Show', 'fancy-image-show'), 'widgets'), 'FancyImg_control');
	} 
}

function FancyImg_textdomain() 
{
	  load_plugin_textdomain( 'fancy-image-show', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'FancyImg_textdomain');
add_shortcode( 'fancy-img-show', 'FancyImg_shortcode' );
add_action('wp_enqueue_scripts', 'FancyImg_add_javascript_files');
add_action("plugins_loaded", "FancyImg_init");
register_activation_hook(__FILE__, 'FancyImg_install');
register_deactivation_hook(__FILE__, 'FancyImg_deactivation');
?>