<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');
/**
 * TYPOlight Repository :: Class RepositoryBackendTheme
 *
 * NOTE: this file was edited with tabs set to 4.
 * @package Repository
 * @copyright Copyright (C) 2008 by Peter Koch, IBK Software AG
 * @license See accompaning file LICENSE.txt
 */

/**
 * Implements the backend theme
 */
class RepositoryBackendTheme
{
	const themepath = 'system/modules/rep_client/themes/';
	
	/**
	 * Get a theme file.
	 * @param string $file The basename if the file (without extension).
	 * @return string The file path.
	 */
	public static function file($file)
	{
		$theme = $GLOBALS['TL_CONFIG']['backendTheme'];
		if (strlen($theme) && $theme!='default') {
			$f = self::themepath.$theme.'/'.$file;
			if (is_file(TL_ROOT.'/'.$f)) return $f;
		} // if
		return self::themepath.'default/'. $file;
	} // file
	
	/**
	 * Get image url from the theme.
	 * @param string $file The basename if the image (without extension).
	 * @param boolean $png Additional return: True if the file is a png, false for gif.
	 * @return string The image path.
	 */
	public static function image($file, &$png)
	{
		$theme = $GLOBALS['TL_CONFIG']['backendTheme'];
		if (strlen($theme) && $theme!='default') {
			$url = self::themepath.$theme.'/images/';
			if (is_file(TL_ROOT.'/'.$url.$file.'.png')) return $url.$file.'.png';
			if (is_file(TL_ROOT.'/'.$url.$file.'.gif')) { $png = false; return $url.$file.'.gif'; }
		} // if
		$url = self::themepath.'default/images/';
		if (is_file(TL_ROOT.'/'.$url.$file.'.png')) return $url.$file.'.png';
		if (is_file(TL_ROOT.'/'.$url.$file.'.gif')) { $png = false; return $url.$file.'.gif'; }
		return $url.'default.png';
	} // image
	
	/**
	 * Create a 'img' tag from theme icons.
	 * @param string $file The basename if the image (without extension).
	 * @param string $alt The 'alt' text.
	 * @param string $attributes Additional tag attributes.
	 * @return string The html code.
	 */
	public static function createImage($file, $alt='', $attributes='')
	{
		if ($alt=='') $alt = 'icon';
		$png = true;
		$img = self::image($file, $png);
		$size = getimagesize(TL_ROOT.'/'.$img);
		return '<img'.($png ? ' class="pngfix"' : '').' src="'.$img.'" '.$size[3].' alt="'.specialchars($alt).'"'.(strlen($attributes) ? ' '.$attributes : '').' />';
	} // createImage
	
	/**
	 * Create a list button (link button)
	 * @param string $file The basename if the image (without extension).
	 * @param string $link The URL of the link to create.
	 * @param string $text The alt/title text.
	 * @param string $confirm Optional confirmation text before redirecting to the link.
	 * @param boolean $popup Open the target in a new window.
	 * @return string The html code.
	 */
	public function createListButton($file, $link, $text, $confirm='', $popup=false)
	{
		$onclick = '';
		if ($confirm!='') {
			$onclick .= 'if (!confirm(\''.$confirm.'\')) return false; ';
		}
		if ($popup) {
			$onclick .= 'window.open(this.href); return false; ';
		}
		if ($onclick!=''){
			$onclick = ' onclick="' . trim($onclick) . '"';
		}
		return '<a href="'.$link.'" title="'.$text.'"'.$onclick.'>'.$this->createImage($file,$text,'title="'.$text.'"').'</a>';
	} // createListButton

	public function createMainButton($file, $link, $text, $confirm='')
	{
		$onclick = ($confirm=='')
						? ''
						: ' onclick="if (!confirm(\''.$confirm.'\')) return false;"';
		return '<a href="'.$link.'" title="'.$text.'"'.$onclick.'>'.$this->createImage($file,$text,'title="'.$text.'"').' '.$text.'</a>';
	} // createMainButton

} // class RepositoryTheme

?>