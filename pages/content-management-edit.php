<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';

// First check if ID exist with requested ID
$sSql = $wpdb->prepare(
	"SELECT COUNT(*) AS `count` FROM ".WP_FANCYIMGSHOW_TABLE."
	WHERE `FancyImg_id` = %d",
	array($did)
);
$result = '0';
$result = $wpdb->get_var($sSql);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist', 'fancy-image-show'); ?></strong></p></div><?php
}
else
{
	$FancyImg_errors = array();
	$FancyImg_success = '';
	$FancyImg_error_found = FALSE;
	
	$sSql = $wpdb->prepare("
		SELECT *
		FROM `".WP_FANCYIMGSHOW_TABLE."`
		WHERE `FancyImg_id` = %d
		LIMIT 1
		",
		array($did)
	);
	$data = array();
	$data = $wpdb->get_row($sSql, ARRAY_A);
	
	// Preset the form fields
	$form = array(
		'FancyImg_Gallery' => $data['FancyImg_Gallery'],
		'FancyImg_Width' => $data['FancyImg_Width'],
		'FancyImg_Height' => $data['FancyImg_Height'],
		'FancyImg_Effect' => $data['FancyImg_Effect'],
		'FancyImg_delay' => $data['FancyImg_delay'],
		'FancyImg_Strips' => $data['FancyImg_Strips'],
		'FancyImg_StripDelay' => $data['FancyImg_StripDelay'],
		'FancyImg_Random' => $data['FancyImg_Random'],
		'FancyImg_Extra1' => $data['FancyImg_Extra1']
	);
}
// Form submitted, check the data
if (isset($_POST['FancyImg_form_submit']) && $_POST['FancyImg_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('FancyImg_form_edit');
	
	$form['FancyImg_Gallery'] = isset($_POST['FancyImg_Gallery']) ? $_POST['FancyImg_Gallery'] : '';
	if ($form['FancyImg_Gallery'] == '')
	{
		$FancyImg_errors[] = __('Please select the gallery.', 'fancy-image-show');
		$FancyImg_error_found = TRUE;
	}

	$form['FancyImg_Width'] = isset($_POST['FancyImg_Width']) ? $_POST['FancyImg_Width'] : '';
	if ($form['FancyImg_Width'] == '')
	{
		$FancyImg_errors[] = __('Please enter the width.', 'fancy-image-show');
		$FancyImg_error_found = TRUE;
	}
	
	$form['FancyImg_Height'] = isset($_POST['FancyImg_Height']) ? $_POST['FancyImg_Height'] : '';
	if ($form['FancyImg_Height'] == '')
	{
		$FancyImg_errors[] = __('Please enter the height.', 'fancy-image-show');
		$FancyImg_error_found = TRUE;
	}
	
	$form['FancyImg_Effect'] = isset($_POST['FancyImg_Effect']) ? $_POST['FancyImg_Effect'] : '';
	$form['FancyImg_delay'] = isset($_POST['FancyImg_delay']) ? $_POST['FancyImg_delay'] : '';
	$form['FancyImg_Strips'] = isset($_POST['FancyImg_Strips']) ? $_POST['FancyImg_Strips'] : '';
	$form['FancyImg_StripDelay'] = isset($_POST['FancyImg_StripDelay']) ? $_POST['FancyImg_StripDelay'] : '';
	$form['FancyImg_Random'] = isset($_POST['FancyImg_Random']) ? $_POST['FancyImg_Random'] : '';
	$form['FancyImg_Extra1'] = isset($_POST['FancyImg_Extra1']) ? $_POST['FancyImg_Extra1'] : '';

	//	No errors found, we can add this Group to the table
	if ($FancyImg_error_found == FALSE)
	{	
		$sSql = $wpdb->prepare(
				"UPDATE `".WP_FANCYIMGSHOW_TABLE."`
				SET `FancyImg_Gallery` = %s,
				`FancyImg_Width` = %s,
				`FancyImg_Height` = %s,
				`FancyImg_Effect` = %s,
				`FancyImg_delay` = %s,
				`FancyImg_Strips` = %s,
				`FancyImg_StripDelay` = %s,
				`FancyImg_Random` = %s,
				`FancyImg_Extra1` = %s
				WHERE FancyImg_id = %d
				LIMIT 1",
				array($form['FancyImg_Gallery'], $form['FancyImg_Width'], $form['FancyImg_Height'], $form['FancyImg_Effect'], 
							$form['FancyImg_delay'], $form['FancyImg_Strips'], $form['FancyImg_StripDelay'], $form['FancyImg_Random'], $form['FancyImg_Extra1'], $did)
			);
		$wpdb->query($sSql);
		
		$FancyImg_success = 'Details was successfully updated.';
	}
}

if ($FancyImg_error_found == TRUE && isset($FancyImg_errors[0]) == TRUE)
{
?>
  <div class="error fade">
    <p><strong><?php echo $FancyImg_errors[0]; ?></strong></p>
  </div>
  <?php
}
if ($FancyImg_error_found == FALSE && strlen($FancyImg_success) > 0)
{
?>
  <div class="updated fade">
    <p><strong><?php echo $FancyImg_success; ?> 
	<a href="<?php echo WP_FancyImg_ADMIN_URL; ?>"><?php _e('Click here to view the details', 'fancy-image-show'); ?></a></strong></p>
  </div>
  <?php
}
?>
<script language="JavaScript" src="<?php echo WP_FancyImg_PLUGIN_URL; ?>/pages/setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e('Fancy Image Show', 'fancy-image-show'); ?></h2>
	<form name="FancyImg_form" method="post" action="#" onsubmit="return FancyImg_submit()"  >
      <h3><?php _e('Update details', 'fancy-image-show'); ?></h3>
	  
	  	<label for="tag-image"><?php _e('Select gallery name', 'fancy-image-show'); ?></label>
		<select name="FancyImg_Gallery" id="FancyImg_Gallery">
			<option value='GALLERY1' <?php if($form['FancyImg_Gallery'] == 'GALLERY1') { echo "selected='selected'" ; } ?>>GALLERY1</option>
			<option value='GALLERY2' <?php if($form['FancyImg_Gallery'] == 'GALLERY2') { echo "selected='selected'" ; } ?>>GALLERY2</option>
			<option value='GALLERY3' <?php if($form['FancyImg_Gallery'] == 'GALLERY3') { echo "selected='selected'" ; } ?>>GALLERY3</option>
			<option value='GALLERY4' <?php if($form['FancyImg_Gallery'] == 'GALLERY4') { echo "selected='selected'" ; } ?>>GALLERY4</option>
			<option value='GALLERY5' <?php if($form['FancyImg_Gallery'] == 'GALLERY5') { echo "selected='selected'" ; } ?>>GALLERY5</option>
			<option value='GALLERY6' <?php if($form['FancyImg_Gallery'] == 'GALLERY6') { echo "selected='selected'" ; } ?>>GALLERY6</option>
			<option value='GALLERY7' <?php if($form['FancyImg_Gallery'] == 'GALLERY7') { echo "selected='selected'" ; } ?>>GALLERY7</option>
			<option value='GALLERY8' <?php if($form['FancyImg_Gallery'] == 'GALLERY8') { echo "selected='selected'" ; } ?>>GALLERY8</option>
			<option value='GALLERY9' <?php if($form['FancyImg_Gallery'] == 'GALLERY9') { echo "selected='selected'" ; } ?>>GALLERY9</option>
			<option value='GALLERY10' <?php if($form['FancyImg_Gallery'] == 'GALLERY10') { echo "selected='selected'" ; } ?>>GALLERY10</option>
			<option value='GALLERY11' <?php if($form['FancyImg_Gallery'] == 'GALLERY11') { echo "selected='selected'" ; } ?>>GALLERY11</option>
			<option value='GALLERY12' <?php if($form['FancyImg_Gallery'] == 'GALLERY12') { echo "selected='selected'" ; } ?>>GALLERY12</option>
			<option value='GALLERY13' <?php if($form['FancyImg_Gallery'] == 'GALLERY13') { echo "selected='selected'" ; } ?>>GALLERY13</option>
			<option value='GALLERY14' <?php if($form['FancyImg_Gallery'] == 'GALLERY14') { echo "selected='selected'" ; } ?>>GALLERY14</option>
			<option value='GALLERY15' <?php if($form['FancyImg_Gallery'] == 'GALLERY15') { echo "selected='selected'" ; } ?>>GALLERY15</option>
			<option value='GALLERY16' <?php if($form['FancyImg_Gallery'] == 'GALLERY16') { echo "selected='selected'" ; } ?>>GALLERY16</option>
			<option value='GALLERY17' <?php if($form['FancyImg_Gallery'] == 'GALLERY17') { echo "selected='selected'" ; } ?>>GALLERY17</option>
			<option value='GALLERY18' <?php if($form['FancyImg_Gallery'] == 'GALLERY18') { echo "selected='selected'" ; } ?>>GALLERY18</option>
			<option value='GALLERY19' <?php if($form['FancyImg_Gallery'] == 'GALLERY19') { echo "selected='selected'" ; } ?>>GALLERY19</option>
			<option value='GALLERY20' <?php if($form['FancyImg_Gallery'] == 'GALLERY20') { echo "selected='selected'" ; } ?>>GALLERY20</option>
		</select>
		<p><?php _e('Please select your gallery name.', 'fancy-image-show'); ?></p>
		
		<label for="tag-select-gallery-group"><?php _e('Gallery width', 'fancy-image-show'); ?></label>
		<input name="FancyImg_Width" type="text" id="FancyImg_Width" value="<?php echo $form['FancyImg_Width']; ?>" maxlength="3" />
		<p><?php _e('Please enter your gallery width.', 'fancy-image-show'); ?> (Ex: 250)</p>
		
		<label for="tag-select-gallery-group"><?php _e('Gallery height', 'fancy-image-show'); ?></label>
		<input name="FancyImg_Height" type="text" id="FancyImg_Height" value="<?php echo $form['FancyImg_Height']; ?>" maxlength="3" />
		<p><?php _e('Please enter your gallery height.', 'fancy-image-show'); ?> (Ex: 200)</p>
	  
	  	<label for="tag-select-gallery-group"><?php _e('Gallery effect', 'fancy-image-show'); ?></label>
		<select name="FancyImg_Effect" id="FancyImg_Effect">
			<option value='zipper' <?php if($form['FancyImg_Effect'] == 'zipper') { echo "selected='selected'" ; } ?>>zipper</option>
			<option value='wave' <?php if($form['FancyImg_Effect'] == 'wave') { echo "selected='selected'" ; } ?>>wave</option>
			<option value='curtain' <?php if($form['FancyImg_Effect'] == 'curtain') { echo "selected='selected'" ; } ?>>curtain</option>
			<option value='fountain top' <?php if($form['FancyImg_Effect'] == 'fountain top') { echo "selected='selected'" ; } ?>>fountain top</option>
			<option value='random top' <?php if($form['FancyImg_Effect'] == 'random top') { echo "selected='selected'" ; } ?>>random top</option>
		</select>
		<p><?php _e('Please enter your gallery effect', 'fancy-image-show'); ?></p>
		
		<label for="tag-select-gallery-group"><?php _e('Effect delay', 'fancy-image-show'); ?></label>
		<input name="FancyImg_delay" type="text" id="FancyImg_delay" value="<?php echo $form['FancyImg_delay']; ?>" maxlength="4" />
		<p><?php _e('Please enter your gallery effects delay.', 'fancy-image-show'); ?> (Ex : 3000)</p>
		
		<label for="tag-select-gallery-group"><?php _e('Random display', 'fancy-image-show'); ?></label>
		<select name="FancyImg_Random" id="FancyImg_Random">
			<option value='YES' <?php if($form['FancyImg_Random'] == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($form['FancyImg_Random'] == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p><?php _e('Please select Yes, If you like to show the images in random order.', 'fancy-image-show'); ?></p>
		
		<label for="tag-select-gallery-group"><?php _e('Strip delay', 'fancy-image-show'); ?></label>
		<input name="FancyImg_StripDelay" type="text" id="FancyImg_StripDelay" value="<?php echo $form['FancyImg_StripDelay']; ?>" maxlength="3" />
		<p><?php _e('Please enter your gallery strip delay.', 'fancy-image-show'); ?> (Ex: 12)</p>
		
		<label for="tag-select-gallery-group"><?php _e('Enter strip', 'fancy-image-show'); ?></label>
		<input name="FancyImg_Strips" type="text" id="FancyImg_Strips" value="<?php echo $form['FancyImg_Strips']; ?>" maxlength="3" /> 
		<p><?php _e('Please enter your gallery strip.', 'fancy-image-show'); ?> (Ex: 30)</p>
		
		<label for="tag-select-gallery-group"><?php _e('Image folder location', 'fancy-image-show'); ?></label>
		<input name="FancyImg_Extra1" type="text" id="FancyImg_Extra1" value="<?php echo $form['FancyImg_Extra1']; ?>" size="120" maxlength="1024" />
		<p>(Ex : wp-content/plugins/fancy-image-show/gallery1/)</p>
	  
      <input name="FancyImg_id" id="FancyImg_id" type="hidden" value="">
      <input type="hidden" name="FancyImg_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Update Details', 'fancy-image-show'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="FancyImg_redirect()" value="<?php _e('Cancel', 'fancy-image-show'); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="FancyImg_help()" value="<?php _e('Help', 'fancy-image-show'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('FancyImg_form_edit'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'fancy-image-show'); ?>
	<a target="_blank" href="<?php echo WP_FancyImg_FAV; ?>"><?php _e('click here', 'fancy-image-show'); ?></a>
</p>
</div>