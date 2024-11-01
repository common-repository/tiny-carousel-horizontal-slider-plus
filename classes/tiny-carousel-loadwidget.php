<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class tchsp_cls_widget
{
	public static function tchsp_shortcode_int($arr)
	{
		if ( ! is_array( $arr ) )
		{
			return '';
		}
		
		$imageli = "";
		$tch = "";
		$id = isset($arr['id']) ? $arr['id'] : '0';
		$data = array();
		$data = tchsp_cls_dbquery::tchsp_gallery_details_select($id);
		if( count($data) > 0 )
		{
			$form_gallery = array(
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
			$gal_width = $form_gallery["gal_width"];
			$gal_height = $form_gallery["gal_height"];
			$gal_controls = $form_gallery["gal_controls"];
			$gal_autointerval = $form_gallery["gal_autointerval"];
			$gal_intervaltime = $form_gallery["gal_intervaltime"];
			$gal_animation = $form_gallery["gal_animation"];
			$gal_width1 = $gal_width + 4;
			$gal_height1 = $gal_height + 4;
			
			$image = tchsp_cls_dbquery::tchsp_image_details_load($form_gallery["gal_id"], $form_gallery["gal_random"]);
			if( count($image) > 0 )
			{
				foreach ($image as $img)
				{					
					$imageli = $imageli . '<li>';
						$imageli = $imageli . '<a href="'. $img['img_link'] .'" target="_target">';
							$imageli = $imageli . '<img alt="'. $img['img_title'] .'" src="'. $img['img_imageurl'] .'" />';
						$imageli = $imageli . '</a>';
					$imageli = $imageli . '</li>';
				}
				
				if($imageli <> "")
				{
					$tch = $tch . "<style type='text/css' media='screen'>
					#tchsp { height: 1%; overflow:hidden; position: relative; padding: 0 50px 10px;   }
					#tchsp .viewport { height: ".$gal_height1."px; overflow: hidden; position: relative; }
					#tchsp .buttons { background: #C01313; border-radius: 35px; display: block; position: absolute;
					top: 40%; left: 0; width: 35px; height: 35px; color: #fff; font-weight: bold; text-align: center; line-height: 35px; text-decoration: none;
					font-size: 22px; }
					#tchsp .next { right: 0; left: auto;top: 40%; }
					#tchsp .buttons:hover{ color: #C01313;background: #fff; }
					#tchsp .disable { visibility: hidden; }
					#tchsp .overview { list-style: none; position: absolute; padding: 0; margin: 0; width: ".$gal_width1."px; left: 0 top: 0; }
					#tchsp .overview li{ float: left; margin: 0 20px 0 0; padding: 1px; height: ".$gal_height."px; border: 1px solid #dcdcdc; width: ".$gal_width."px;}
					</style>";
				
					$tch = $tch . '<div id="tchsp">';
						$tch = $tch . '<a class="buttons prev" href="#">&#60;</a>';
						$tch = $tch . '<div class="viewport">';
							$tch = $tch . '<ul class="overview">';
								$tch = $tch . $imageli;
							$tch = $tch . '</ul>';
						$tch = $tch . '</div>';
						$tch = $tch . '<a class="buttons next" href="#">&#62;</a>';
					$tch = $tch . '</div>';
					
					$tch = $tch . '<script type="text/javascript">';
					$tch = $tch . 'jQuery(document).ready(function(){';
						$tch = $tch . "jQuery('#tchsp').tinycarousel({ buttons: ".$gal_controls.", interval: ".$gal_autointerval.", intervalTime: ".$gal_intervaltime.", animationTime: ".$gal_animation." });";
					$tch = $tch . '});';
					$tch = $tch . '</script>';
				}
			}
		}
		else
		{
			$tch = __('Please check your short code. Gallery does not exists for this Id.', TCHSP_TDOMAIN);
		}
		return $tch;
	}	
}

function tchsp_shortcode( $atts ) 
{
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	//[tchsp id="1"]
	$id = isset($atts['id']) ? $atts['id'] : '0';
	
	$arr = array();
	$arr["id"] 	= $id;
	return tchsp_cls_widget::tchsp_shortcode_int($arr);
}

function tchsp($id = 0)
{
	$arr = array();
	$arr["id"] 	= $id;
	echo tchsp_cls_widget::tchsp_shortcode_int($arr);
}
?>