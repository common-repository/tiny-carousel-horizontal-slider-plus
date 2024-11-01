<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class tchsp_cls_intermediate
{
	public static function tchsp_gallery_details()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(TCHSP_DIR.'page'.DIRECTORY_SEPARATOR.'tiny-carousel-gallery-add.php');
				break;
			case 'edit':
				require_once(TCHSP_DIR.'page'.DIRECTORY_SEPARATOR.'tiny-carousel-gallery-edit.php');
				break;
			default:
				require_once(TCHSP_DIR.'page'.DIRECTORY_SEPARATOR.'tiny-carousel-gallery-show.php');
				break;
		}
	}
	
	public static function tchsp_image_details()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(TCHSP_DIR.'page'.DIRECTORY_SEPARATOR.'tiny-carousel-image-add.php');
				break;
			case 'edit':
				require_once(TCHSP_DIR.'page'.DIRECTORY_SEPARATOR.'tiny-carousel-image-edit.php');
				break;
			default:
				require_once(TCHSP_DIR.'page'.DIRECTORY_SEPARATOR.'tiny-carousel-image-show.php');
				break;
		}
	}
}
?>