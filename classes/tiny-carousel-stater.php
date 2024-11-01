<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
$tchsp_plugin_name = 'tiny-carousel-horizontal-slider-plus';
$tchspl_current_folder = dirname(dirname(__FILE__));
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if(!defined('TCHSP_TDOMAIN')) define('TCHSP_TDOMAIN', "tiny-carousel");
if(!defined('TCHSP_PLUGIN_NAME')) define('TCHSP_PLUGIN_NAME', $tchsp_plugin_name);
if(!defined('TCHSP_PLUGIN_DISPLAY')) define('TCHSP_PLUGIN_DISPLAY', "Tiny Carousel Horizontal Slider Plus");
if(!defined('TCHSP_DIR')) define('TCHSP_DIR', $tchspl_current_folder.DS);
if(!defined('TCHSP_URL')) define('TCHSP_URL',plugins_url().'/'.strtolower('tiny-carousel-horizontal-slider-plus').'/');
define('TCHSP_FILE',TCHSP_DIR.'tiny-carousel-horizontal-slider-plus.php');
if(!defined('TCHSP_FAV')) define('TCHSP_FAV', 'http://www.gopiplus.com/work/2014/06/06/tiny-carousel-horizontal-slider-plus-wordpress-plugin/');
if(!defined('TCHSP_ADMINURL')) define('TCHSP_ADMINURL', site_url() . '/wp-admin/admin.php?page=tchsp-image-details');
if(!defined('TCHSP_ADMINURL1')) define('TCHSP_ADMINURL1', site_url() . '/wp-admin/admin.php?page=tchsp-gallery-details');
define('TCHSP_OFFICIAL', 'Check official website for more information <a target="_blank" href="'.TCHSP_FAV.'">click here</a>');
require_once(TCHSP_DIR.'classes'.DIRECTORY_SEPARATOR.'tiny-carousel-register.php');
require_once(TCHSP_DIR.'classes'.DIRECTORY_SEPARATOR.'tiny-carousel-intermediate.php');
require_once(TCHSP_DIR.'classes'.DIRECTORY_SEPARATOR.'tiny-carousel-query.php');
require_once(TCHSP_DIR.'classes'.DIRECTORY_SEPARATOR.'tiny-carousel-loadwidget.php');
?>