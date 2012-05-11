<?php
/**
 *     Fancy Image Show
 *     Copyright (C) 2012  www.gopiplus.com
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
?>

<div class="wrap">
  <?php
  	global $wpdb;
    $title = __('Fancy Image Show');
    @$mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=fancy-image-show/fancy-image-show.php";
    @$DID=@$_GET["DID"];
    @$AC=@$_GET["AC"];
    @$submittext = "Insert Message";
	if($AC <> "DEL" and trim(@$_POST['FancyImg_Width']) <>"")
    {
			if($_POST['FancyImg_id'] == "" )
			{
					$sql = "insert into ".WP_FANCYIMGSHOW_TABLE.""
					. " set `FancyImg_Gallery` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Gallery']))
					. "', `FancyImg_Width` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Width']))
					. "', `FancyImg_Height` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Height']))
					. "', `FancyImg_Effect` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Effect']))
					. "', `FancyImg_delay` = '" . mysql_real_escape_string(trim($_POST['FancyImg_delay']))
					. "', `FancyImg_Strips` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Strips']))
					. "', `FancyImg_StripDelay` = '" . mysql_real_escape_string(trim($_POST['FancyImg_StripDelay']))
					. "', `FancyImg_Random` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Random']))
					. "', `FancyImg_Extra1` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Extra1']))
					. "'";	
			}
			else
			{
					$sql = "update ".WP_FANCYIMGSHOW_TABLE.""
					. " set `FancyImg_Gallery` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Gallery']))
					. "', `FancyImg_Width` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Width']))
					. "', `FancyImg_Height` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Height']))
					. "', `FancyImg_Effect` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Effect']))
					. "', `FancyImg_delay` = '" . mysql_real_escape_string(trim($_POST['FancyImg_delay']))
					. "', `FancyImg_Strips` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Strips']))
					. "', `FancyImg_StripDelay` = '" . mysql_real_escape_string(trim($_POST['FancyImg_StripDelay']))
					. "', `FancyImg_Random` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Random']))
					. "', `FancyImg_Extra1` = '" . mysql_real_escape_string(trim($_POST['FancyImg_Extra1']))
					. "' where `FancyImg_id` = '" . $_POST['FancyImg_id'] 
					. "'";	
			}
			$wpdb->get_results($sql);
    }
    
    if($AC=="DEL" && $DID > 0)
    {
        $wpdb->get_results("delete from ".WP_FANCYIMGSHOW_TABLE." where FancyImg_id=".$DID);
    }
    
    if($DID<>"" and $AC <> "DEL")
    {
        $data = $wpdb->get_results("select * from ".WP_FANCYIMGSHOW_TABLE." where FancyImg_id=$DID limit 1");
        if ( empty($data) ) 
        {
           echo "<div id='message' class='error'><p>No data available! use below form to create!</p></div>";
           return;
        }
        $data = $data[0];
        if ( !empty($data) ) $FancyImg_id_x = htmlspecialchars(stripslashes($data->FancyImg_id)); 
		if ( !empty($data) ) $FancyImg_Gallery_x = htmlspecialchars(stripslashes($data->FancyImg_Gallery)); 
        if ( !empty($data) ) $FancyImg_Width_x = htmlspecialchars(stripslashes($data->FancyImg_Width));
		if ( !empty($data) ) $FancyImg_Height_x = htmlspecialchars(stripslashes($data->FancyImg_Height));
        if ( !empty($data) ) $FancyImg_Effect_x = htmlspecialchars(stripslashes($data->FancyImg_Effect));
		if ( !empty($data) ) $FancyImg_delay_x = htmlspecialchars(stripslashes($data->FancyImg_delay));
		if ( !empty($data) ) $FancyImg_Strips_x = htmlspecialchars(stripslashes($data->FancyImg_Strips));
		if ( !empty($data) ) $FancyImg_StripDelay_x = htmlspecialchars(stripslashes($data->FancyImg_StripDelay));
		if ( !empty($data) ) $FancyImg_Random_x = htmlspecialchars(stripslashes($data->FancyImg_Random));
		if ( !empty($data) ) $FancyImg_Extra1_x = htmlspecialchars(stripslashes($data->FancyImg_Extra1));
        $submittext = "Update Message";
    }
    ?>
  <h2>Fancy Image Show</h2>
  <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/fancy-image-show/setting.js"></script>
  <form name="FancyImg_form" method="post" action="<?php echo $mainurl; ?>" onsubmit="return FancyImg_submit()"  >
    <table width="100%">
      <tr>
        <td width="28%" align="left" valign="middle">Select Gallery Name:</td>
        <td width="72%" align="left" valign="middle">Enter Gallery Width:</td>
      </tr>
      <tr>
        <td align="left" valign="middle"><select name="FancyImg_Gallery" id="FancyImg_Gallery">
            <option value='GALLERY1' <?php if(@$FancyImg_Gallery_x=='GALLERY1') { echo 'selected' ; } ?>>GALLERY1</option>
            <option value='GALLERY2' <?php if(@$FancyImg_Gallery_x=='GALLERY2') { echo 'selected' ; } ?>>GALLERY2</option>
            <option value='GALLERY3' <?php if(@$FancyImg_Gallery_x=='GALLERY3') { echo 'selected' ; } ?>>GALLERY3</option>
            <option value='GALLERY4' <?php if(@$FancyImg_Gallery_x=='GALLERY4') { echo 'selected' ; } ?>>GALLERY4</option>
            <option value='GALLERY5' <?php if(@$FancyImg_Gallery_x=='GALLERY5') { echo 'selected' ; } ?>>GALLERY5</option>
            <option value='GALLERY6' <?php if(@$FancyImg_Gallery_x=='GALLERY6') { echo 'selected' ; } ?>>GALLERY6</option>
            <option value='GALLERY7' <?php if(@$FancyImg_Gallery_x=='GALLERY7') { echo 'selected' ; } ?>>GALLERY7</option>
            <option value='GALLERY8' <?php if(@$FancyImg_Gallery_x=='GALLERY8') { echo 'selected' ; } ?>>GALLERY8</option>
            <option value='GALLERY9' <?php if(@$FancyImg_Gallery_x=='GALLERY9') { echo 'selected' ; } ?>>GALLERY9</option>
          </select>
        <td align="left" valign="middle"><input name="FancyImg_Width" type="text" id="FancyImg_Width" value="<?php echo @$FancyImg_Width_x; ?>" maxlength="3" /> (Ex: 250)
      </tr>
      <tr>
        <td align="left" valign="middle">Enter Gallery Height:</td>
        <td align="left" valign="middle">Select Gallery Effect:</td>
      </tr>
      <tr>
        <td align="left" valign="middle"><input name="FancyImg_Height" type="text" id="FancyImg_Height" value="<?php echo @$FancyImg_Height_x; ?>" maxlength="3" /> (Ex:200)</td>
        <td align="left" valign="middle"><select name="FancyImg_Effect" id="FancyImg_Effect">
            <option value='zipper' <?php if(@$FancyImg_Effect_x=='zipper') { echo 'selected' ; } ?>>zipper</option>
            <option value='wave' <?php if(@$FancyImg_Effect_x=='wave') { echo 'selected' ; } ?>>wave</option>
            <option value='curtain' <?php if(@$FancyImg_Effect_x=='curtain') { echo 'selected' ; } ?>>curtain</option>
            <option value='fountain top' <?php if(@$FancyImg_Effect_x=='fountain top') { echo 'selected' ; } ?>>fountain top</option>
            <option value='random top' <?php if(@$FancyImg_Effect_x=='random top') { echo 'selected' ; } ?>>random top</option>
          </select></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Enter Effect Delay:</td>
        <td align="left" valign="middle">Random Image Display:</td>
      </tr>
      <tr>
        <td align="left" valign="middle"><input name="FancyImg_delay" type="text" id="FancyImg_delay" value="<?php echo @$FancyImg_delay_x; ?>" maxlength="4" /> (Ex : 3000)</td>
        <td align="left" valign="middle"><select name="FancyImg_Random" id="FancyImg_Random">
            <option value='YES' <?php if(@$FancyImg_Random_x=='YES') { echo 'selected' ; } ?>>YES</option>
            <option value='NO' <?php if(@$FancyImg_Random_x=='NO') { echo 'selected' ; } ?>>NO</option>
          </select></td>
      </tr>
      <tr>
        <td align="left" valign="middle">Enter Strip Delay:</td>
        <td align="left" valign="middle">Enter Strip Delay:</td>
      </tr>
      <tr>
        <td align="left" valign="middle"><input name="FancyImg_StripDelay" type="text" id="FancyImg_StripDelay" value="<?php echo @$FancyImg_StripDelay_x; ?>" maxlength="3" /> (Ex: 12)</td>
        <td align="left" valign="middle"><input name="FancyImg_Strips" type="text" id="FancyImg_Strips" value="<?php echo @$FancyImg_Strips_x; ?>" maxlength="3" /> 
          (Ex: 30)</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">Image Folder Location</td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="middle">
        <input name="FancyImg_Extra1" type="text" id="FancyImg_Extra1" value="<?php echo @$FancyImg_Extra1_x; ?>" size="120" maxlength="1024" />
        <br /> Ex : wp-content/plugins/fancy-image-show/gallery1/
        </td>
      </tr>
      <tr>
        <td height="35" colspan="3" align="left" valign="bottom"><input name="publish" lang="publish" class="button-primary" value="<?php echo @$submittext?>" type="submit" />
          <input name="publish" lang="publish" class="button-primary" onClick="FancyImg_redirect()" value="Cancel" type="button" />
		  <input name="Help" lang="publish" class="button-primary" onclick="FancyImg_help()" value="Help" type="button" /></td>
      </tr>
      <input name="FancyImg_id" id="FancyImg_id" type="hidden" value="<?php echo @$FancyImg_id_x; ?>">
    </table>
  </form>
  <div class="tool-box">
    <?php
	$data = $wpdb->get_results("select * from ".WP_FANCYIMGSHOW_TABLE." order by FancyImg_Gallery,FancyImg_id");
	if ( empty($data) ) 
	{ 
		echo "<div id='message' class='error'>No data available! use below form to create!</div>";
		return;
	}
	?>
    <form name="frm_FancyImg_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th width="8%" align="left" scope="col">Gallery
              </td>
            <th width="8%" scope="col">Effect
              </td>
            <th align="left" scope="col">Image Location
              </td>
            <th width="8%" align="left" scope="col">Action
              </td>
          </tr>
        </thead>
        <?php 
        $i = 0;
        foreach ( $data as $data ) { 
        ?>
        <tbody>
          <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
            <td align="left" valign="middle"><?php echo(stripslashes($data->FancyImg_Gallery)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->FancyImg_Effect)); ?></td>
            <td align="left" valign="middle"><?php echo(stripslashes($data->FancyImg_Extra1)); ?></td>
            <td align="left" valign="middle"><a href="options-general.php?page=fancy-image-show/fancy-image-show.php&DID=<?php echo($data->FancyImg_id); ?>">Edit</a> &nbsp; <a onClick="javascript:FancyImg_delete('<?php echo($data->FancyImg_id); ?>')" href="javascript:void(0);">Delete</a></td>
          </tr>
        </tbody>
        <?php $i = $i+1; } ?>
      </table>
      <br />
	  <strong>Plugin Configuration</strong> <br /><br />
	  	1. Drag and Drop the Widget<br />
		2. Add the gallery in the posts or pages<br />
		3. Add directly in the theme<br /><br />
      Check official website <a href="http://www.gopiplus.com/work/2011/11/06/fancy-image-show-wordpress-plugin/">www.gopiplus.com</a> for live demo and more help. <br />
	  Note: Don't upload your original images into plug-in folder. if you upload the images into plug-in folder, you may lose the images when you update the plug-in to next version.
</form>
  </div>
</div>
