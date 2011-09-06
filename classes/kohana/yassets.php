<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Yassets extends Assets
{

	public function set($path, $url)
	{
		$info = pathinfo($url);
		if (in_array($info['extension'], array('css', 'js'))
		AND substr($info['filename'], -4) != '.min')
		{
			return parent::set($path, Y::stamp($url));
		}

		/* "//", "http://", "https://", "ftp://", "ftps://" */
		if (preg_match('/^((ht|f)tps?:)?\/\//i', $url))
		{
			return parent::set($path, $url);
		}

		return parent::set($path, Url::site($url));
	}

}
