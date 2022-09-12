<?php
namespace app\components;

use Yii;
//use common\models\Resize;
define('DIR_IMAGE', $_SERVER['DOCUMENT_ROOT'].'/web/userdata/images/');
/**
*	
*	@param filename string
*	@param width 
*	@param height
*	@param type char [default, w, h]
*				default = scale with white space, 
*				w = fill according to width, 
*				h = fill according to height
*	
*/

class Image extends \yii\base\Model
{
	public $image;
	
	public static function resize($filename, $width, $height, $type = "", $watermark = '')
	{
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			$filename = 'nofoto.jpg';
		} 		
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		
		$old_image = $filename;		
		$new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
		
		if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image)))
		{
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;				
				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}		
			}
			
			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Resize (DIR_IMAGE . $old_image);
				$image->resize($width, $height, $type);	
				if($watermark)$image->watermark(new Resize(DIR_IMAGE . 'watermark.png'), 'bottomright');				
				$image->save(DIR_IMAGE . $new_image);				
				
				
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
		}
		return '/userdata/images/'.$new_image;		
	}
}
?>