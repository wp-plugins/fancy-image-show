<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_FancyImg_display']) && $_POST['frm_FancyImg_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	
	$FancyImg_success = '';
	$FancyImg_success_msg = FALSE;
	
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
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('FancyImg_form_show');
			
			//	Delete selected record from the table
			$sSql = $wpdb->prepare("DELETE FROM `".WP_FANCYIMGSHOW_TABLE."`
					WHERE `FancyImg_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);
			
			//	Set success message
			$FancyImg_success_msg = TRUE;
			$FancyImg_success = __('Selected record was successfully deleted.', 'fancy-image-show');
		}
	}
	
	if ($FancyImg_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $FancyImg_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e('Fancy Image Show', 'fancy-image-show'); ?>
	<a class="add-new-h2" href="<?php echo WP_FancyImg_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'fancy-image-show'); ?></a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".WP_FANCYIMGSHOW_TABLE."` order by FancyImg_id desc";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo WP_FancyImg_PLUGIN_URL; ?>/pages/setting.js"></script>
		<form name="frm_FancyImg_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="FancyImg_group_item[]" /></th>
			<th scope="col"><?php _e('Short Code', 'fancy-image-show'); ?></th>
			<th scope="col"><?php _e('Image Location', 'fancy-image-show'); ?></th>
            <th scope="col"><?php _e('Effect', 'fancy-image-show'); ?></th>
			<th scope="col"><?php _e('Width', 'fancy-image-show'); ?></th>
			<th scope="col"><?php _e('Height', 'fancy-image-show'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="FancyImg_group_item[]" /></th>
			<th scope="col"><?php _e('Short Code', 'fancy-image-show'); ?></th>
			<th scope="col"><?php _e('Image Location', 'fancy-image-show'); ?></th>
            <th scope="col"><?php _e('Effect', 'fancy-image-show'); ?></th>
			<th scope="col"><?php _e('Width', 'fancy-image-show'); ?></th>
			<th scope="col"><?php _e('Height', 'fancy-image-show'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td align="left"><input type="checkbox" value="<?php echo $data['FancyImg_id']; ?>" name="FancyImg_group_item[]"></th>
						<td>[fancy-img-show gallery="<?php echo $data['FancyImg_Gallery']; ?>"]
						<div class="row-actions">
						<span class="edit"><a title="Edit" href="<?php echo WP_FancyImg_ADMIN_URL; ?>&amp;ac=edit&amp;did=<?php echo $data['FancyImg_id']; ?>"><?php _e('Edit', 'fancy-image-show'); ?></a> | </span>
						<span class="trash"><a onClick="javascript:FancyImg_delete('<?php echo $data['FancyImg_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'fancy-image-show'); ?></a></span> 
						</div>
						</td>
						<td><?php echo $data['FancyImg_Extra1']; ?></td>
						<td><?php echo $data['FancyImg_Effect']; ?></td>
						<td><?php echo $data['FancyImg_Width']; ?></td>
						<td><?php echo $data['FancyImg_Height']; ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="6" align="center"><?php _e('No records available.', 'fancy-image-show'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('FancyImg_form_show'); ?>
		<input type="hidden" name="frm_FancyImg_display" value="yes"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo WP_FancyImg_ADMIN_URL; ?>&amp;ac=add"><?php _e('Add New', 'fancy-image-show'); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo WP_FancyImg_FAV; ?>"><?php _e('Help', 'fancy-image-show'); ?></a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	<h3><?php _e('Plugin configuration option', 'fancy-image-show'); ?></h3>
	<ol>
		<li><?php _e('Drag and drop the widget.', 'fancy-image-show'); ?></li>
		<li><?php _e('Add the plugin in the posts or pages using short code.', 'fancy-image-show'); ?></li>
		<li><?php _e('Add directly in to the theme using PHP code.', 'fancy-image-show'); ?></li>
	</ol>
	<p class="description">
		<?php _e('Check official website for more information', 'fancy-image-show'); ?>
		<a target="_blank" href="<?php echo WP_FancyImg_FAV; ?>"><?php _e('click here', 'fancy-image-show'); ?></a>
	</p>
	</div>
</div>