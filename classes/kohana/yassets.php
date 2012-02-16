<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Yassets extends Assets
{

	protected $_path;

	public function __construct()
	{
		parent::__construct();

		$config = Kohana::$config->load('yaminify');

		if (($js = Arr::get($config->js, 'dir', NULL)) !== NULL)
		{
			$this->_path['js'] = $js;
		}

		if (($css = Arr::get($config->css, 'dir', NULL)) !== NULL)
		{
			$this->_path['css'] = $css;
		}
	}

	public static function factory()
	{
		return new Yassets;
	}

	protected function _parse_url($url)
	{
		$info = pathinfo($url);

		// path prepending - skip external files
		if ( ! preg_match('/(^((ht|f)tps?:)?\/\/)|(^'.preg_quote(Url::base(), '/').')/iD', $url)
		    AND
		    ($path = Arr::get($this->_path, $info['extension'])) !== NULL)
		{
			$path = rtrim($path, '/').'/';
			$url = $path.$url;
		}

		// stamp local css and js files
		if ( ! preg_match('/(^((ht|f)tps?:)?\/\/)|(^'.preg_quote(Url::base(), '/').')|(\.min\.(js|css)$)/iD', $url) AND class_exists('Yaminify'))
		{
			return Yaminify::stamp($url);
		}

		return parent::_parse_url($url);
	}

}
