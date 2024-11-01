<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'tiny-carousel-gallery-edit-nonce' ) )  { die('<p>Security check failed.</p>'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? sanitize_text_field($_GET['did']) : '0';
if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }

$tchsp_errors = array();
$tchsp_success = '';
$tchsp_error_found = FALSE;
	
// First check if ID exist with requested ID
$result = '0';
$result = tchsp_cls_dbquery::tchsp_gallery_details_count($did);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'tiny-carousel'); ?></strong></p></div><?php
}
else
{
	
	$data = array();
	$data = tchsp_cls_dbquery::tchsp_gallery_details_select($did);
	
	// Preset the form fields
	$form = array(
		'gal_id' => $data[0]['gal_id'],
		'gal_title' => $data[0]['gal_title'],
		'gal_width' => $data[0]['gal_width'],
		'gal_height' => $data[0]['gal_height'],
		'gal_controls' => $data[0]['gal_controls'],
		'gal_autointerval' => $data[0]['gal_autointerval'],
		'gal_intervaltime' => $data[0]['gal_intervaltime'],
		'gal_animation' => $data[0]['gal_animation'],
		'gal_random' => $data[0]['gal_random']
	);
}
// Form submitted, check the data
if (isset($_POST['tchsp_form_submit']) && $_POST['tchsp_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('tchsp_form_edit');
	
	$form['gal_title'] = isset($_POST['gal_title']) ? sanitize_text_field($_POST['gal_title']) : '';
	if ($form['gal_title'] == '')
	{
		$tchsp_errors[] = __('Enter title for your gallery.', 'tiny-carousel');
		$tchsp_error_found = TRUE;
	}
	
	$form['gal_width'] = isset($_POST['gal_width']) ? sanitize_text_field($_POST['gal_width']) : '';
	$returnvalue = tchsp_cls_validation::num_val($form['gal_width']);
	if ($form['gal_width'] == '' || $returnvalue == "invalid")
	{
		$tchsp_errors[] = __('Enter your image width, You should add same width images in this gallery. (Ex: 200)', 'tiny-carousel');
		$tchsp_error_found = TRUE;
	}
	
	$form['gal_height'] = isset($_POST['gal_height']) ? sanitize_text_field($_POST['gal_height']) : '';
	$returnvalue = tchsp_cls_validation::num_val($form['gal_height']);
	if ($form['gal_height'] == '' || $returnvalue == "invalid")
	{
		$tchsp_errors[] = __('Enter your image height, You should add same height images in this gallery. (Ex: 150)', 'tiny-carousel');
		$tchsp_error_found = TRUE;
	}
	
	$form['gal_controls'] = isset($_POST['gal_controls']) ? sanitize_text_field($_POST['gal_controls']) : '';
	$form['gal_controls'] = tchsp_cls_validation::val_tf_default($form['gal_controls']);
	
	$form['gal_autointerval'] = isset($_POST['gal_autointerval']) ? sanitize_text_field($_POST['gal_autointerval']) : '';
	$form['gal_autointerval'] = tchsp_cls_validation::val_tf_default($form['gal_autointerval']);
	
	$form['gal_intervaltime'] = isset($_POST['gal_intervaltime']) ? sanitize_text_field($_POST['gal_intervaltime']) : '';
	if ($form['gal_intervaltime'] == '')
	{
		$tchsp_errors[] = __('Enter auto interval time in millisecond. (Ex: 1500)', 'tiny-carousel');
		$tchsp_error_found = TRUE;
	}
	if(!is_numeric($form['gal_intervaltime'])) { $form['gal_intervaltime'] = 1500; }
	
	$form['gal_animation'] = isset($_POST['gal_animation']) ? sanitize_text_field($_POST['gal_animation']) : '';
	if ($form['gal_animation'] == '')
	{
		$tchsp_errors[] = __('Enter animation duration in millisecond. (Ex: 1000)', 'tiny-carousel');
		$tchsp_error_found = TRUE;
	}
	if(!is_numeric($form['gal_animation'])) { $form['gal_animation'] = 1000; }
	
	$form['gal_random'] = isset($_POST['gal_random']) ? sanitize_text_field($_POST['gal_random']) : '';
	$form['gal_random'] = tchsp_cls_validation::val_yn_default($form['gal_random']);

	//	No errors found, we can add this Group to the table
	if ($tchsp_error_found == FALSE)
	{	
		$action = tchsp_cls_dbquery::tchsp_gallery_details_act($form, "ups");
		if($action == "sus")
		{
			$tchsp_success = __('Details was successfully updated.', 'tiny-carousel');
		}
		elseif($action == "err")
		{
			$tchsp_success = __('Oops unexpected error occurred.', 'tiny-carousel');
			$tchsp_error_found = TRUE;
		}
	}
}

if ($tchsp_error_found == TRUE && isset($tchsp_errors[0]) == TRUE)
{
	?><div class="error fade"><p><strong><?php echo $tchsp_errors[0]; ?></strong></p></div><?php
}
if ($tchsp_error_found == FALSE && strlen($tchsp_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $tchsp_success; ?> 
		<a href="<?php echo TCHSP_ADMINURL1; ?>"><?php _e('Click here', 'tiny-carousel'); ?></a> 
		<?php _e('to view the details', 'tiny-carousel'); ?></strong></p>
	</div>
	<?php
}
?>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e(TCHSP_PLUGIN_DISPLAY, 'tiny-carousel'); ?></h2>
	<form name="tchsp_form" method="post" action="#" onsubmit="return _tchsp_submit()"  >
      <h3><?php _e('Edit Gallery Details', 'tiny-carousel'); ?></h3>
	  
		<label for="tag-a"><?php _e('Gallery title', 'tiny-carousel'); ?></label>
		<input name="gal_title" type="text" id="gal_title" value="<?php echo $form['gal_title']; ?>" size="50" maxlength="255" />
		<p><?php _e('Enter title for your gallery.', 'tiny-carousel'); ?></p>
		
		<label for="tag-a"><?php _e('Width', 'tiny-carousel'); ?></label>
		<input name="gal_width" type="text" id="gal_width" value="<?php echo $form['gal_width']; ?>" maxlength="4" />
		<p><?php _e('Enter your image width, You should add same size (width) images in this gallery. (Ex: 200)', 'tiny-carousel'); ?></p>			
		
		<label for="tag-a"><?php _e('Height', 'tiny-carousel'); ?></label>
		<input name="gal_height" type="text" id="gal_height" value="<?php echo $form['gal_height']; ?>" maxlength="4" />
		<p><?php _e('Enter your image height, You should add same size (height) images in this gallery. (Ex: 150)', 'tiny-carousel'); ?></p>
		
		<label for="tag-a"><?php _e('Controls', 'tiny-carousel'); ?></label>
		<select name="gal_controls" id="gal_controls">
			<option value='true' <?php if($form['gal_controls'] == 'true') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='false' <?php if($form['gal_controls'] == 'false') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p><?php _e('Want to use the Left, Right arrow button in your gallery?', 'tiny-carousel'); ?></p>
		
		<label for="tag-a"><?php _e('Auto interval', 'tiny-carousel'); ?></label>
		<select name="gal_autointerval" id="gal_autointerval">
			<option value='true' <?php if($form['gal_autointerval'] == 'true') { echo "selected='selected'" ; } ?>>True</option>
			<option value='false' <?php if($form['gal_autointerval'] == 'false') { echo "selected='selected'" ; } ?>>False</option>
		</select>
		<p><?php _e('Want to add auto interval to move one image from another?', 'tiny-carousel'); ?></p>
		
		<label for="tag-a"><?php _e('Interval time', 'tiny-carousel'); ?></label>
		<input name="gal_intervaltime" type="text" id="gal_intervaltime" value="<?php echo $form['gal_intervaltime']; ?>" maxlength="4"  />
		<p><?php _e('Enter auto interval time in millisecond. (Ex: 1500)', 'tiny-carousel'); ?></p>
		
		<label for="tag-a"><?php _e('Animation', 'tiny-carousel'); ?></label>
		<input name="gal_animation" type="text" id="gal_animation" value="<?php echo $form['gal_animation']; ?>" maxlength="4" />
		<p><?php _e('Enter animation duration in millisecond. (Ex: 1000)', 'tiny-carousel'); ?></p>
		
		<label for="tag-a"><?php _e('Random display', 'tiny-carousel'); ?></label>
		<select name="gal_random" id="gal_random">
			<option value='YES' <?php if($form['gal_random'] == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($form['gal_random'] == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p><?php _e('Do you want to display images in random order?', 'tiny-carousel'); ?></p>
		  
      <input name="gal_id" id="gal_id" type="hidden" value="<?php echo $form['gal_id']; ?>">
      <input type="hidden" name="tchsp_form_submit" id="tchsp_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Submit', 'tiny-carousel'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_tchsp_gal_redirect()" value="<?php _e('Cancel', 'tiny-carousel'); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_tchsp_help()" value="<?php _e('Help', 'tiny-carousel'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('tchsp_form_edit'); ?>
	  <?php $nonce = wp_create_nonce( 'tiny-carousel-gallery-edit-nonce' ); ?>
	  <input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo $nonce; ?>"/>
    </form>
</div>
<p class="description"><?php echo TCHSP_OFFICIAL; ?></p>
</div>