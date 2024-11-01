<?php
/*
Plugin Name: Tiny Carousel Horizontal Slider Plus
Plugin URI: http://www.gopiplus.com/work/2014/06/06/tiny-carousel-horizontal-slider-plus-wordpress-plugin/
Description: This is Jquery based image horizontal slider plugin, it is using tiny carousel light weight jquery script to the slideshow.
Version: 3.2
Author: Gopi Ramasamy
Donate link: http://www.gopiplus.com/work/2014/06/06/tiny-carousel-horizontal-slider-plus-wordpress-plugin/
Author URI: http://www.gopiplus.com/work/2014/06/06/tiny-carousel-horizontal-slider-plus-wordpress-plugin/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: tiny-carousel
Domain Path: /languages
*/

/*  
Copyright 2021 Tiny Carousel Horizontal Slider Plus (www.gopiplus.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Restrict direct file access
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

// Plugin starter
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'tiny-carousel-stater.php');

// WordPress hook & Plugin actions
add_action('admin_menu', array( 'tchsp_cls_registerhook', 'tchsp_adminmenu' ));
register_activation_hook(TCHSP_FILE, array( 'tchsp_cls_registerhook', 'tchsp_activation' ));
register_deactivation_hook(TCHSP_FILE, array( 'tchsp_cls_registerhook', 'tchsp_deactivation' ));
add_shortcode( 'tchsp', 'tchsp_shortcode' );
add_action('wp_enqueue_scripts', 'tchsp_add_javascript_files');
add_action( 'admin_enqueue_scripts', array( 'tchsp_cls_registerhook', 'tchsp_load_adminscripts' ) );

// For localization
function tchsp_textdomain() 
{
	  load_plugin_textdomain( 'tiny-carousel' , false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'tchsp_textdomain');
?>