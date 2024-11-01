<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class tchsp_cls_dbquery
{
	public static function tchsp_image_details_count($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$result = 0;
		if($id > 0)
		{
			$sSql = $wpdb->prepare("SELECT COUNT(*) AS `count` FROM `".$prefix."tinycarousel_image` WHERE `img_id` = %d", array($id));
		}
		else
		{
			$sSql = "SELECT COUNT(*) AS `count` FROM `".$prefix."tinycarousel_image`";
		}
		$result = $wpdb->get_var($sSql);
		return $result;
	}
	
	public static function tchsp_image_details_select($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$arrRes = array();
		if($id > 0)
		{
			$sSql = $wpdb->prepare("SELECT * FROM `".$prefix."tinycarousel_image` where img_id = %d", array($id));
		}
		else
		{
			$sSql = "SELECT * FROM `".$prefix."tinycarousel_image` order by img_id desc";
		}
		$arrRes = $wpdb->get_results($sSql, ARRAY_A);
		return $arrRes;
	}
	
	public static function tchsp_image_details_load($id = 0, $random = "NO")
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$arrRes = array();
		$sSql = "SELECT * FROM `".$prefix."tinycarousel_image`";
		if($id > 0)
		{
			if($random == "YES")
			{
				$sSql = $wpdb->prepare("SELECT * FROM `".$prefix."tinycarousel_image` where img_gal_id = %d and img_display = 'YES' ORDER BY rand()", array($id));
			}
			else
			{
				$sSql = $wpdb->prepare("SELECT * FROM `".$prefix."tinycarousel_image` where img_gal_id = %d and img_display = 'YES'", array($id));
			}
		}
		$arrRes = $wpdb->get_results($sSql, ARRAY_A);
		return $arrRes;
	}
	
	public static function tchsp_image_details_delete($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("DELETE FROM `".$prefix."tinycarousel_image` WHERE `img_id` = %d LIMIT 1", $id);
		$wpdb->query($sSql);
		return true;
	}
	
	public static function tchsp_image_details_act($data = array(), $action = "ins")
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		if($action == "ins")
		{
			$sql = $wpdb->prepare("INSERT INTO `".$prefix."tinycarousel_image` 
			(`img_title`, `img_imageurl`, `img_link`, `img_linktarget`, `img_display`, `img_gal_id`)
			VALUES(%s, %s, %s, %s, %s, %s)", 
			array($data["img_title"], $data["img_imageurl"], $data["img_link"], $data["img_linktarget"], $data["img_display"], $data["img_gal_id"]) );
			$wpdb->query($sql);
			return "sus";
		}
		elseif($action == "ups")
		{
			$sql = $wpdb->prepare("UPDATE `".$prefix."tinycarousel_image` SET `img_title` = %s, `img_imageurl` = %s, `img_link` = %s, `img_linktarget` = %s, `img_display` = %s,
			 `img_gal_id` = %d WHERE img_id = %d LIMIT 1", array($data["img_title"], $data["img_imageurl"], $data["img_link"], $data["img_linktarget"], $data["img_display"], 
			 $data["img_gal_id"], $data["img_id"]) );
			$wpdb->query($sql);
			return "sus";
		}
		else
		{
			return "err";
		}
	}
	
	public static function tchsp_image_details_default()
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		
		$result = tchsp_cls_dbquery::tchsp_gallery_details_count(0);
		if ($result == 0)
		{
			$sql = $wpdb->prepare("INSERT INTO `".$prefix."tinycarousel_gallery` (`gal_title`, `gal_width`,`gal_height`) 
			VALUES (%s, %d, %d)", array("Default Gallery", 100, 75));
			$wpdb->query($sql);
		}
		
		$result = tchsp_cls_dbquery::tchsp_image_details_count(0);
		if ($result == 0)
		{
			$img_title1 = "Tiny Carousel Horizontal Slider Plus Image 1";
			$img_title2 = "Tiny Carousel Horizontal Slider Plus Image 2";
			$img_title3 = "Tiny Carousel Horizontal Slider Plus Image 3";
			$img_title4 = "Tiny Carousel Horizontal Slider Plus Image 4";
			$img_imageurl1 = TCHSP_URL . "images/Sing_1.jpg";
			$img_imageurl2 = TCHSP_URL . "images/Sing_2.jpg";
			$img_imageurl3 = TCHSP_URL . "images/Sing_3.jpg";
			$img_imageurl4 = TCHSP_URL . "images/Sing_4.jpg";
			//$img_imageurl5 = TCHSP_URL . "images/Sing_5.jpg";
			//$img_imageurl6 = TCHSP_URL . "images/Sing_6.jpg";
			$sql = $wpdb->prepare("INSERT INTO `".$prefix."tinycarousel_image` (`img_title`, `img_imageurl`,`img_gal_id`) 
			VALUES (%s, %s, %d)", array($img_title1, $img_imageurl1, "1"));
			$wpdb->query($sql);
			$sql = $wpdb->prepare("INSERT INTO `".$prefix."tinycarousel_image` (`img_title`, `img_imageurl`,`img_gal_id`) 
			VALUES (%s, %s, %d)", array($img_title2, $img_imageurl2, "1"));
			$wpdb->query($sql);
			$sql = $wpdb->prepare("INSERT INTO `".$prefix."tinycarousel_image` (`img_title`, `img_imageurl`,`img_gal_id`) 
			VALUES (%s, %s, %d)", array($img_title3, $img_imageurl3, "1"));
			$wpdb->query($sql);
			$sql = $wpdb->prepare("INSERT INTO `".$prefix."tinycarousel_image` (`img_title`, `img_imageurl`,`img_gal_id`) 
			VALUES (%s, %s, %d)", array($img_title4, $img_imageurl4, "1"));
			$wpdb->query($sql);
			//$sql = $wpdb->prepare("INSERT INTO `".$prefix."tinycarousel_image` (`img_title`, `img_imageurl`,`img_gal_id`) 
			//VALUES (%s, %s, %d)", array($img_title, $img_imageurl5, "1"));
			//$wpdb->query($sql);
			//$sql = $wpdb->prepare("INSERT INTO `".$prefix."tinycarousel_image` (`img_title`, `img_imageurl`,`img_gal_id`) 
			//VALUES (%s, %s, %d)", array($img_title, $img_imageurl6, "1"));
			//$wpdb->query($sql);
		}
		return true;
	}
	
	public static function tchsp_gallery_details_count($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$result = 0;
		if($id > 0)
		{
			$sSql = $wpdb->prepare("SELECT COUNT(*) AS `count` FROM `".$prefix."tinycarousel_gallery` WHERE `gal_id` = %d", array($id));
		}
		else
		{
			$sSql = "SELECT COUNT(*) AS `count` FROM `".$prefix."tinycarousel_gallery`";
		}
		$result = $wpdb->get_var($sSql);
		return $result;
	}
	
	public static function tchsp_gallery_details_select($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$arrRes = array();
		if($id > 0)
		{
			$sSql = $wpdb->prepare("SELECT * FROM `".$prefix."tinycarousel_gallery` where gal_id = %d", array($id));
		}
		else
		{
			$sSql = "SELECT * FROM `".$prefix."tinycarousel_gallery` order by gal_id desc";
		}
		$arrRes = $wpdb->get_results($sSql, ARRAY_A);
		return $arrRes;
	}
	
	public static function tchsp_gallery_details_delete($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("DELETE FROM `".$prefix."tinycarousel_gallery` WHERE `gal_id` = %d LIMIT 1", $id);
		$wpdb->query($sSql);
		return true;
	}
	
	public static function tchsp_gallery_details_act($data = array(), $action = "ins")
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		if($action == "ins")
		{
			$sql = $wpdb->prepare("INSERT INTO `".$prefix."tinycarousel_gallery` 
			(`gal_title`, `gal_width`, `gal_height`, `gal_controls`, `gal_autointerval`, `gal_intervaltime`, `gal_animation`, `gal_random`)
			VALUES(%s, %s, %s, %s, %s, %s, %s, %s)", array($data["gal_title"], $data["gal_width"], $data["gal_height"], 
			$data["gal_controls"], $data["gal_autointerval"], $data["gal_intervaltime"], $data["gal_animation"], $data["gal_random"]) );
			$wpdb->query($sql);
			return "sus";
		}
		elseif($action == "ups")
		{
			$sql = $wpdb->prepare("UPDATE `".$prefix."tinycarousel_gallery` SET `gal_title` = %s, `gal_width` = %s, `gal_height` = %s, `gal_controls` = %s,
			 `gal_autointerval` = %s, `gal_intervaltime` = %s, `gal_animation` = %s, `gal_random` = %s WHERE gal_id = %d LIMIT 1", array($data["gal_title"], 
			 $data["gal_width"], $data["gal_height"], $data["gal_controls"], $data["gal_autointerval"], $data["gal_intervaltime"], $data["gal_animation"],
			 $data["gal_random"], $data["gal_id"]) );
			$wpdb->query($sql);
			return "sus";
		}
		else
		{
			return "err";
		}
	}
}
?>