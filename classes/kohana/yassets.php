<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Yassets extends Assets
{

	public static function factory()
	{
		return new Yassets;
	}

	protected function _parse_url($url)
	{
		$info = pathinfo($url);

		if (! preg_match('/(^((ht|f)tps?:)?\/\/)|(\.min\.(js|css)$)/i', $url)
		AND class_exists('Yaminify'))
		{
			return Yaminify::stamp($url);
		}

		return parent::_parse_url($url);
	}

}
