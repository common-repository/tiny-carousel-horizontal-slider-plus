<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class tchsp_cls_registerhook
{
	public static function tchsp_activation()
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		
		$tchsp_plugin_ver = "1.2";
		$tchsp_plugin_installed = "";
		$tchsp_plugin_installed = get_option("tchsp_plugin_installed");
		if($tchsp_plugin_installed == "")
		{
			add_option('tchsp_plugin_installed', "1.2");
		}
		else
		{
			update_option( "tchsp_plugin_installed", $tchsp_plugin_ver );
		}
		
		// Plugin tables
		$array_tables_to_plugin = array('tinycarousel_gallery' ,'tinycarousel_image');
		$errors = array();
		
		// loading the sql file, load it and separate the queries
		$sql_file = TCHSP_DIR.'sql'.DS.'tiny-carousel-tbl.sql';		
		$prefix = $wpdb->prefix;
        $handle = fopen($sql_file, 'r');
        $query = fread($handle, filesize($sql_file));
        fclose($handle);
        $query=str_replace('CREATE TABLE IF NOT EXISTS `','CREATE TABLE IF NOT EXISTS `'.$prefix, $query);
        $queries=explode('-- SQLQUERY ---', $query);

        // run the queries one by one
        $has_errors = false;
        foreach($queries as $qry)
		{
            $wpdb->query($qry);
        }
		
		// list the tables that haven't been created
        $missingtables=array();
        foreach($array_tables_to_plugin as $table_name)
		{
			if(strtoupper($wpdb->get_var("SHOW TABLES like  '". $prefix.$table_name . "'")) != strtoupper($prefix.$table_name))  
			{
                $missingtables[] = $prefix.$table_name;
            }
        }
		
		// add error in to array variable
        if($missingtables) 
		{
			$errors[] = __('These tables could not be created on installation ' . implode(', ',$missingtables), TCHSP_TDOMAIN);
            $has_errors=true;
        }
		
		// if error call wp_die()
        if($has_errors) 
		{
			wp_die( __( $errors[0] , TCHSP_TDOMAIN ) );
			return false;
		}
		else
		{
			tchsp_cls_dbquery::tchsp_image_details_default();
		}
        return true;
	}
	
	public static function tchsp_deactivation()
	{
		// do not generate any output here
	}
	
	public static function tchsp_adminmenu()
	{
		if (is_admin()) 
		{
			add_menu_page( __( 'Tiny Carousel', TCHSP_TDOMAIN ), 
				__( 'Tiny Carousel', TCHSP_TDOMAIN ), 'admin_dashboard', 'tiny-carousel-horizontal-slider-plus', 'es_admin_option', TCHSP_URL.'inc/menu-icon.png' );
			
			add_submenu_page('tiny-carousel-horizontal-slider-plus', __( 'Gallery Details', TCHSP_TDOMAIN ), 
				__( 'Gallery Details', TCHSP_TDOMAIN ), 'administrator', 'tchsp-gallery-details', array( 'tchsp_cls_intermediate', 'tchsp_gallery_details' ));
			
			add_submenu_page('tiny-carousel-horizontal-slider-plus', __( 'Image Details', TCHSP_TDOMAIN ), 
				__( 'Image Details', TCHSP_TDOMAIN ), 'administrator', 'tchsp-image-details', array( 'tchsp_cls_intermediate', 'tchsp_image_details' ));
		}		
	}
	
	public static function tchsp_load_adminscripts() 
	{
		if( !empty( $_GET['page'] ) ) 
		{
			switch ( $_GET['page'] ) 
			{
				case 'tchsp-gallery-details':
					wp_register_script( 'tchsp-gallery-adminscripts', TCHSP_URL . 'page/setting.js', '', '', true );
					wp_enqueue_script( 'tchsp-gallery-adminscripts' );
					$tchsp_select_params = array(
						'tchsp_gal_title'   		=> __( 'Enter title for your gallery.', 'tchsp-select', 'tiny-carousel' ),
						'tchsp_gal_width'   		=> __( 'Enter your image width, You should add same width images in this gallery. (Ex: 200)', 'tchsp-select', 'tiny-carousel' ),
						'tchsp_gal_widthnum'   		=> __( 'Enter your image width, only number.', 'tchsp-select', 'tiny-carousel' ),
						'tchsp_gal_height'   		=> __( 'Enter your image height, You should add same height images in this gallery. (Ex: 150)', 'tchsp-select', 'tiny-carousel' ),
						'tchsp_gal_heightnum'   	=> __( 'Enter your image height, only number.', 'tchsp-select', 'tiny-carousel' ),
						'tchsp_gal_intervaltime'   	=> __( 'Enter auto interval time in millisecond. (Ex: 1500)', 'tchsp-select', 'tiny-carousel' ),
						'tchsp_gal_intervaltimenum' => __( 'Enter auto interval time in millisecond, only number.', 'tchsp-select', 'tiny-carousel' ),
						'tchsp_gal_animation'   	=> __( 'Enter animation duration in millisecond. (Ex: 1000)', 'tchsp-select', 'tiny-carousel' ),
						'tchsp_gal_animationnum'	=> __( 'Enter animation duration in millisecond, only number.', 'tchsp-select', 'tiny-carousel' ),
						'tchsp_gal_delete'			=> __( 'Do you want to delete this record?', 'tchsp-select', 'tiny-carousel' ),
					);
					wp_localize_script( 'tchsp-gallery-adminscripts', 'tchsp_gallery_adminscripts', $tchsp_select_params );
					break;
					
				case 'tchsp-image-details':
					wp_register_script( 'tchsp-image-adminscripts', TCHSP_URL . 'page/setting.js', '', '', true );
					wp_enqueue_script( 'tchsp-image-adminscripts' );
					$tchsp_select_params = array(
						'tchsp_img_title'   		=> __( 'Enter image title.', 'tchsp-select', 'tiny-carousel' ),
						'tchsp_img_imageurl'   		=> __( 'Enter picture url. url must start with either http or https.', 'tchsp-select', 'tiny-carousel' ),
						'tchsp_img_gal_id'   		=> __( 'Select gallery name for this picture.', 'tchsp-select', 'tiny-carousel' ),
						'tchsp_img_delete'			=> __( 'Do you want to delete this record?', 'tchsp-select', 'tiny-carousel' ),
					);
					wp_localize_script( 'tchsp-image-adminscripts', 'tchsp_image_adminscripts', $tchsp_select_params );
					break;
			}
		}
	}
}

function tchsp_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'jquery.tinycarousel', TCHSP_URL.'inc/jquery.tinycarousel.js');
	}
}

class tchsp_cls_validation
{
	public static function num_val($value)
	{
		$returnvalue = "valid";
		if( !is_numeric($value) ) 
		{ 
			$returnvalue = "invalid";
		}
		return $returnvalue;
	}
	
	public static function target_val_default($value)
	{
		$returnvalue = "_blank";
		if($value == "_blank" || $value == "_self")
		{
			$returnvalue = $value;
		}
		return $returnvalue;
	}
	
	public static function val_yn_chk($value)
	{
		$returnvalue = "valid";
		if($value != "YES" && $value != "NO")
		{
			$returnvalue = "invalid";
		}
		return $returnvalue;
	}
	
	public static function val_yn_default($value)
	{
		$returnvalue = $value;
		if($value != "YES" && $value != "NO")
		{
			$returnvalue = "YES";
		} 
		return $returnvalue;
	}
	
	public static function val_tf_default($value)
	{
		$returnvalue = $value;
		if($value != "true" && $value != "false")
		{
			$returnvalue = "true";
		} 
		return $returnvalue;
	}
}
?>