<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'tiny-carousel-image-edit-nonce' ) )  { die('<p>Security check failed.</p>'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? sanitize_text_field($_GET['did']) : '0';
if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }

// First check if ID exist with requested ID
$result = '0';
$result = tchsp_cls_dbquery::tchsp_image_details_count($did);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'tiny-carousel'); ?></strong></p></div><?php
}
else
{
	$tchsp_errors = array();
	$tchsp_success = '';
	$tchsp_error_found = FALSE;
	
	$data = array();
	$data = tchsp_cls_dbquery::tchsp_image_details_select($did);
	
	// Preset the form fields
	$form = array(
		'img_id' => $data[0]['img_id'],
		'img_title' => $data[0]['img_title'],
		'img_imageurl' => $data[0]['img_imageurl'],
		'img_link' => $data[0]['img_link'],
		'img_linktarget' => $data[0]['img_linktarget'],
		'img_display' => $data[0]['img_display'],
		'img_gal_id' => $data[0]['img_gal_id'],
	);
}
// Form submitted, check the data
if (isset($_POST['tchsp_form_submit']) && $_POST['tchsp_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('tchsp_form_edit');
	
	$form['img_title'] = isset($_POST['img_title']) ? sanitize_text_field($_POST['img_title']) : '';
	if ($form['img_title'] == '')
	{
		$tchsp_errors[] = __('Enter image title.', 'tiny-carousel');
		$tchsp_error_found = TRUE;
	}
	
	$form['img_imageurl'] = isset($_POST['img_imageurl']) ? sanitize_text_field($_POST['img_imageurl']) : '';
	$form['img_imageurl'] = esc_url_raw( $form['img_imageurl'] );
	if ($form['img_imageurl'] == '')
	{
		$tchsp_errors[] = __('Enter tiny-carousel popup url. url must start with either http or https.', 'tiny-carousel');
		$tchsp_error_found = TRUE;
	}

	$form['img_link'] = isset($_POST['img_link']) ? sanitize_text_field($_POST['img_link']) : '';
	$form['img_link'] = esc_url_raw( $form['img_link'] );
	
	$form['img_linktarget'] = isset($_POST['img_linktarget']) ? sanitize_text_field($_POST['img_linktarget']) : '';
	$form['img_linktarget'] = tchsp_cls_validation::target_val_default($form['img_linktarget']);
	
	$form['img_display'] = isset($_POST['img_display']) ? sanitize_text_field($_POST['img_display']) : '';
	$form['img_display'] = tchsp_cls_validation::val_yn_default($form['img_display']);
	
	$form['img_gal_id'] = isset($_POST['img_gal_id']) ? sanitize_text_field($_POST['img_gal_id']) : '';
	$form['img_id'] = isset($_POST['img_id']) ? sanitize_text_field($_POST['img_id']) : '';

	//	No errors found, we can add this Group to the table
	if ($tchsp_error_found == FALSE)
	{	
		$action = tchsp_cls_dbquery::tchsp_image_details_act($form, "ups");
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
		<a href="<?php echo TCHSP_ADMINURL; ?>"><?php _e('Click here', 'tiny-carousel'); ?></a> 
		<?php _e('to view the details', 'tiny-carousel'); ?></strong></p>
	</div>
	<?php
}
?>
<script type="text/javascript">
jQuery(document).ready(function($){
    $('#upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var img_imageurl = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#img_imageurl').val(img_imageurl);
        });
    });
});
</script>
<?php
wp_enqueue_script('jquery'); // jQuery
wp_enqueue_media(); // This will enqueue the Media Uploader script
?>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e(TCHSP_PLUGIN_DISPLAY, 'tiny-carousel'); ?></h2>
	<form name="tchsp_form" method="post" action="#" onsubmit="return _tchsp_submit()"  >
      <h3><?php _e('Edit Image Details', 'tiny-carousel'); ?></h3>
	  
	  	<label for="tag-a"><?php _e('Title', 'tiny-carousel'); ?></label>
		<input name="img_title" type="text" id="img_title" value="<?php echo $form['img_title']; ?>" size="60" maxlength="255" />
		<p><?php _e('Enter image title.', 'tiny-carousel'); ?></p>
		
		<label for="tag-a"><?php _e('Image path (URL)', 'tiny-carousel'); ?></label>
		<input name="img_imageurl" type="text" id="img_imageurl" value="<?php echo $form['img_imageurl']; ?>" size="60" maxlength="1024" />
		<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
		<p><?php _e('Where is the picture located on the internet (ex: http://www.gopiplus.com/work/wp-content/uploads/pluginimages/88x88/1.jpg)', 'tiny-carousel'); ?></p>			
		
		<label for="tag-a"><?php _e('Link', 'tiny-carousel'); ?></label>
		<input name="img_link" type="text" id="img_link" value="<?php echo $form['img_link']; ?>" size="60" maxlength="1024" />
		<p><?php _e('When someone clicks on the picture, where do you want to send them. Link must start with either http or https.', 'tiny-carousel'); ?></p>
		
		<label for="tag-a"><?php _e('Link target', 'tiny-carousel'); ?></label>
		<select name="img_linktarget" id="img_linktarget">
			<option value='_blank' <?php if($form['img_linktarget'] == '_blank') { echo "selected='selected'" ; } ?>>Open New Window</option>
			<option value='_self' <?php if($form['img_linktarget'] == '_self') { echo "selected='selected'" ; } ?>>Open Same Window</option>
		</select>
		<p><?php _e('Target attribute specifies where to open the link.', 'tiny-carousel'); ?></p>
		
		<label for="tag-a"><?php _e('Display', 'tiny-carousel'); ?></label>
		<select name="img_display" id="img_display">
			<option value='YES' <?php if($form['img_display'] == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($form['img_display'] == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p><?php _e('Do you want the picture to show in your galler?', 'tiny-carousel'); ?></p>
		
		<label for="tag-a"><?php _e('Gallery title', 'tiny-carousel'); ?></label>
		<select name="img_gal_id" id="img_gal_id">
			<option value=''>Select</option>
			<?php
			$thisselected = "";
			$galleryData = array();
			$galleryData = tchsp_cls_dbquery::tchsp_gallery_details_select(0);
			if(count($galleryData) > 0 )
			{
				foreach ($galleryData as $data)
				{
					if($form['img_gal_id'] == $data['gal_id']) 
					{ 
						$thisselected = "selected='selected'" ; 
					}
					?><option value='<?php echo $data['gal_id'] ?>' <?php echo $thisselected; ?>><?php echo $data['gal_title'] ?></option><?php
					$thisselected = "";
				}
			}
			?>
		</select>
		<p><?php _e('Select gallery name for this picture.', 'tiny-carousel'); ?></p>
		  
      <input name="img_id" id="img_id" type="hidden" value="<?php echo $form['img_id']; ?>">
      <input type="hidden" name="tchsp_form_submit" id="tchsp_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button add-new-h2" value="<?php _e('Submit', 'tiny-carousel'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button add-new-h2" onclick="_tchsp_redirect()" value="<?php _e('Cancel', 'tiny-carousel'); ?>" type="button" />
        <input name="Help" lang="publish" class="button add-new-h2" onclick="_tchsp_help()" value="<?php _e('Help', 'tiny-carousel'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('tchsp_form_edit'); ?>
	  <?php $nonce = wp_create_nonce( 'tiny-carousel-image-edit-nonce' ); ?>
	  <input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo $nonce; ?>"/>
    </form>
</div>
<p class="description"><?php echo TCHSP_OFFICIAL; ?></p>
</div>