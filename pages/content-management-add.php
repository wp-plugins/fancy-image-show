<div class="wrap">
<?php
$FancyImg_errors = array();
$FancyImg_success = '';
$FancyImg_error_found = FALSE;

// Preset the form fields
$form = array(
	'FancyImg_Gallery' => '',
	'FancyImg_Width' => '',
	'FancyImg_Height' => '',
	'FancyImg_Effect' => '',
	'FancyImg_delay' => '',
	'FancyImg_Strips' => '',
	'FancyImg_StripDelay' => '',
	'FancyImg_Random' => '',
	'FancyImg_Extra1' => ''
);

// Form submitted, check the data
if (isset($_POST['FancyImg_form_submit']) && $_POST['FancyImg_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('FancyImg_form_add');
	
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
		$sql = $wpdb->prepare(
			"INSERT INTO ".WP_FANCYIMGSHOW_TABLE."
			(FancyImg_Gallery, FancyImg_Width, FancyImg_Height, FancyImg_Effect, FancyImg_delay, FancyImg_Strips, FancyImg_StripDelay, FancyImg_Random, FancyImg_Extra1)
			VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s)",
			array($form['FancyImg_Gallery'], $form['FancyImg_Width'], $form['FancyImg_Height'], $form['FancyImg_Effect'], $form['FancyImg_delay'], 
						$form['FancyImg_Strips'], $form['FancyImg_StripDelay'], $form['FancyImg_Random'], $form['FancyImg_Extra1'])
		);
		$wpdb->query($sql);
		
		$FancyImg_success = __('New details was successfully added.', 'fancy-image-show');
		
		// Reset the form fields
		$form = array(
			'FancyImg_Gallery' => '',
			'FancyImg_Width' => '',
			'FancyImg_Height' => '',
			'FancyImg_Effect' => '',
			'FancyImg_delay' => '',
			'FancyImg_Strips' => '',
			'FancyImg_StripDelay' => '',
			'FancyImg_Random' => '',
			'FancyImg_Extra1' => ''
		);
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
      <h3><?php _e('Add details', 'fancy-image-show'); ?></h3>
      
		<label for="tag-image"><?php _e('Select gallery name', 'fancy-image-show'); ?></label>
		<select name="FancyImg_Gallery" id="FancyImg_Gallery">
			<option value='GALLERY1'>GALLERY1</option>
			<option value='GALLERY2'>GALLERY2</option>
			<option value='GALLERY3'>GALLERY3</option>
			<option value='GALLERY4'>GALLERY4</option>
			<option value='GALLERY5'>GALLERY5</option>
			<option value='GALLERY6'>GALLERY6</option>
			<option value='GALLERY7'>GALLERY7</option>
			<option value='GALLERY8'>GALLERY8</option>
			<option value='GALLERY9'>GALLERY9</option>
			<option value='GALLERY10'>GALLERY10</option>
			<option value='GALLERY11'>GALLERY11</option>
			<option value='GALLERY12'>GALLERY12</option>
			<option value='GALLERY13'>GALLERY13</option>
			<option value='GALLERY14'>GALLERY14</option>
			<option value='GALLERY15'>GALLERY15</option>
			<option value='GALLERY16'>GALLERY16</option>
			<option value='GALLERY17'>GALLERY17</option>
			<option value='GALLERY18'>GALLERY18</option>
			<option value='GALLERY19'>GALLERY19</option>
			<option value='GALLERY20'>GALLERY20</option>
		</select>
		<p><?php _e('Please select your gallery name.', 'fancy-image-show'); ?></p>
		
		<label for="tag-select-gallery-group"><?php _e('Gallery width', 'fancy-image-show'); ?></label>
		<input name="FancyImg_Width" type="text" id="FancyImg_Width" value="" maxlength="3" />
		<p><?php _e('Please enter your gallery width.', 'fancy-image-show'); ?> (Ex: 250)</p>
		
		<label for="tag-select-gallery-group"><?php _e('Gallery height', 'fancy-image-show'); ?></label>
		<input name="FancyImg_Height" type="text" id="FancyImg_Height" value="" maxlength="3" />
		<p><?php _e('Please enter your gallery height.', 'fancy-image-show'); ?> (Ex: 200)</p>
	  
	  	<label for="tag-select-gallery-group"><?php _e('Gallery effect', 'fancy-image-show'); ?></label>
		<select name="FancyImg_Effect" id="FancyImg_Effect">
			<option value='zipper'>zipper</option>
			<option value='wave'>wave</option>
			<option value='curtain'>curtain</option>
			<option value='fountain top'>fountain top</option>
			<option value='random top'>random top</option>
		</select>
		<p><?php _e('Please enter your gallery effect', 'fancy-image-show'); ?></p>
		
		<label for="tag-select-gallery-group"><?php _e('Effect delay', 'fancy-image-show'); ?></label>
		<input name="FancyImg_delay" type="text" id="FancyImg_delay" value="3000" maxlength="4" />
		<p><?php _e('Please enter your gallery effects delay.', 'fancy-image-show'); ?> (Ex : 3000)</p>
		
		<label for="tag-select-gallery-group"><?php _e('Random display', 'fancy-image-show'); ?></label>
		<select name="FancyImg_Random" id="FancyImg_Random">
			<option value='YES'>YES</option>
			<option value='NO'>NO</option>
		</select>
		<p><?php _e('Please select Yes, If you like to show the images in random order.', 'fancy-image-show'); ?></p>
		
		<label for="tag-select-gallery-group"><?php _e('Strip delay', 'fancy-image-show'); ?></label>
		<input name="FancyImg_StripDelay" type="text" id="FancyImg_StripDelay" value="12" maxlength="3" />
		<p><?php _e('Please enter your gallery strip delay.', 'fancy-image-show'); ?> (Ex: 12)</p>
		
		<label for="tag-select-gallery-group"><?php _e('Enter strip', 'fancy-image-show'); ?></label>
		<input name="FancyImg_Strips" type="text" id="FancyImg_Strips" value="30" maxlength="3" /> 
		<p><?php _e('Please enter your gallery strip.', 'fancy-image-show'); ?> (Ex: 30)</p>
		
		<label for="tag-select-gallery-group"><?php _e('Image folder location', 'fancy-image-show'); ?></label>
		<input name="FancyImg_Extra1" type="text" id="FancyImg_Extra1" value="" size="120" maxlength="1024" />
		<p>(Ex : wp-content/plugins/fancy-image-show/gallery1/)</p>
	  
      <input name="FancyImg_id" id="FancyImg_id" type="hidden" value="">
      <input type="hidden" name="FancyImg_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Insert Details', 'fancy-image-show'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="FancyImg_redirect()" value="<?php _e('Cancel', 'fancy-image-show'); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="FancyImg_help()" value="<?php _e('Help', 'fancy-image-show'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('FancyImg_form_add'); ?>
    </form>
</div>
<p class="description">
	<?php _e('Check official website for more information', 'fancy-image-show'); ?>
	<a target="_blank" href="<?php echo WP_FancyImg_FAV; ?>"><?php _e('click here', 'fancy-image-show'); ?></a>
</p>
</div>