<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'tiny-carousel-image-show-nonce' ) )  { die('<p>Security check failed.</p>'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_tchsp_display']) && $_POST['frm_tchsp_display'] == 'yes')
{
	$did = isset($_GET['did']) ? sanitize_text_field($_GET['did']) : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$tchsp_success = '';
	$tchsp_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$result = tchsp_cls_dbquery::tchsp_image_details_count($did);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'tiny-carousel'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('tchsp_form_show');
			
			//	Delete selected record from the table
			tchsp_cls_dbquery::tchsp_image_details_delete($did);
			
			//	Set success message
			$tchsp_success_msg = TRUE;
			$tchsp_success = __('Selected record was successfully deleted.', 'tiny-carousel');
		}
	}
	
	if ($tchsp_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $tchsp_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e(TCHSP_PLUGIN_DISPLAY, 'tiny-carousel'); ?></h2>
    <h3><?php _e('Image Details', 'tiny-carousel'); ?></h3>
	<div class="tool-box">
	<?php
		$myData = array();
		$myData = tchsp_cls_dbquery::tchsp_image_details_select(0);
		?>
		<form name="frm_tchsp_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
			<th class="check-column" scope="col" style="padding: 8px 2px;">
			<input type="checkbox" name="tchsp_checkall" id="tchsp_checkall" onClick="_tchsp_checkall('frm_tchsp_display', 'chk_delete[]', this.checked);" /></th>
            <th scope="col"><?php _e('Image Title', 'tiny-carousel'); ?></th>
			<th scope="col"><?php _e('Image URL', 'tiny-carousel'); ?></th>
			<th scope="col"><?php _e('Link', 'tiny-carousel'); ?></th>
			<th scope="col"><?php _e('Link Target', 'tiny-carousel'); ?></th>
			<th scope="col"><?php _e('Display', 'tiny-carousel'); ?></th>
			<th scope="col"><?php _e('Gallery Title', 'tiny-carousel'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
			<th class="check-column" scope="col" style="padding: 8px 2px;">
			<input type="checkbox" name="tchsp_checkall" id="tchsp_checkall" onClick="_tchsp_checkall('frm_tchsp_display', 'chk_delete[]', this.checked);" /></th>
            <th scope="col"><?php _e('Image Title', 'tiny-carousel'); ?></th>
			<th scope="col"><?php _e('Image URL', 'tiny-carousel'); ?></th>
			<th scope="col"><?php _e('Link', 'tiny-carousel'); ?></th>
			<th scope="col"><?php _e('Link Target', 'tiny-carousel'); ?></th>
			<th scope="col"><?php _e('Display', 'tiny-carousel'); ?></th>
			<th scope="col"><?php _e('Gallery Title', 'tiny-carousel'); ?></th>
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
						<td align="left"><input name="chk_delete[]" id="chk_delete[]" type="checkbox" value="<?php echo $data['img_id'] ?>" /></td>
						<td><?php echo stripslashes($data['img_title']); ?>
						<div class="row-actions">
						<span class="edit">
						<a title="Edit" href="<?php echo TCHSP_ADMINURL; ?>&ac=edit&amp;did=<?php echo $data['img_id']; ?>"><?php _e('Edit', 'tiny-carousel'); ?></a> | </span>
						<span class="trash">
						<a onClick="javascript:_tchsp_delete('<?php echo $data['img_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'tiny-carousel'); ?></a>
						</span> 
						</div>
						</td>
						<td><a href="<?php echo $data['img_imageurl']; ?>" target="_blank"><img src="<?php echo TCHSP_URL; ?>inc/image-icon.png" /></a></td>
						<td><a href="<?php echo $data['img_link']; ?>" target="_blank"><img src="<?php echo TCHSP_URL; ?>inc/linkicon.gif" /></a></td>
						<td>
						<?php  
						if($data['img_linktarget'] == "_blank")
						{
							echo "Open New Window";
						}
						else
						{
							echo "Open Same Window";
						}						
						?>
						</td>
						<td><?php echo $data['img_display']; ?></td>
						<td>
						<?php
						$galleryData = array();
						$galleryData = tchsp_cls_dbquery::tchsp_gallery_details_select($data['img_gal_id']);
						if(count($galleryData) > 0 )
						{
							foreach ($galleryData as $data)
							{
								echo $data['gal_title'];
							}
						}
						?>					
						</td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="7" align="center"><?php _e('No records available.', 'tiny-carousel'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('tchsp_form_show'); ?>
		<input type="hidden" name="frm_tchsp_display" value="yes"/>
		<?php $nonce = wp_create_nonce( 'tiny-carousel-image-show-nonce' ); ?>
	  <input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo $nonce; ?>"/>
      </form>	
	  <div class="tablenav bottom">
	  	<a href="<?php echo TCHSP_ADMINURL; ?>&amp;ac=add"><input class="button action" type="button" value="<?php _e('Add New', 'tiny-carousel'); ?>" /></a>
	  	<a target="_blank" href="<?php echo TCHSP_FAV; ?>"><input class="button action" type="button" value="<?php _e('Help', 'tiny-carousel'); ?>" /></a>
		<a target="_blank" href="<?php echo TCHSP_FAV; ?>"><input class="button button-primary" type="button" value="<?php _e('Short Code', 'tiny-carousel'); ?>" /></a>
	  </div>
	<h3><?php _e('Plugin configuration option', 'tiny-carousel'); ?></h3>
	<ol>
		<li><?php _e('Add plugin in the posts or pages using short code.', 'tiny-carousel'); ?></li>
		<li><?php _e('Add directly in to theme using PHP code.', 'tiny-carousel'); ?></li>
	</ol>
	<p class="description"><?php echo TCHSP_OFFICIAL; ?></p>
	</div>
</div>