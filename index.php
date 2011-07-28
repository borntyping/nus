<?php
/*
		Nice Urls, Simple CMS
		(c) Samuel Clements 2010
		http://github.com/ziaix/nus

		v2.0.1
*/

define('DEFAULT_PAGE','index');
define('SITES_CONFIG','sites/sites.ini');

define('SITES_DIR','./sites/');
define('DEFAULT_SITE','default/');

define('ERRORPAGE','error404');

/* Classes */

class cms
{
	var $directory;
	var $filetypes;
	var $page;
	
	function __construct()
	{
		$this->filetypes = array('php','html','txt','md','markdown');
	}
	
	function match_site()
	{
		$site = $_SERVER['SERVER_NAME'];
		$sites = parse_ini_file(SITES_CONFIG); //, true);
		foreach ($sites as $directory => $pattern)
		{
			if(preg_match($pattern,$site))
			{
				$this->directory = SITES_DIR.$directory;
				return;
			}
		}
		$this->directory = SITES_DIR.DEFAULT_SITE;
		return;
	}
	
	function get_page_name()
	{
		if ( !isset($_GET['page']) or in_array($_GET['page'], array('','index.html')) )
		{
			$name = DEFAULT_PAGE;
		}
		else
		{
			$name = $_GET['page'];
		}
		return rtrim(clean($name),'/');
	}
	
	function find_page($name,$directory,$filetypes)
	{
		$path = "{$directory}{$name}";
		
		foreach ($filetypes as $ext)
		{
			$p = "$path.$ext";
			if( file_exists($p) )
			{
				return array($p, $ext);
			}
		}
		
		if ( $name == ERRORPAGE )
		{
			header("HTTP/1.0 404 Not Found");
			die("Page not found!");
			return;
		}
		else
		{
			return $this->find_page(ERRORPAGE,$directory,$filetypes);
		}
	}
	
	function create_pages()
	{
		define('PAGES_DIR', "{$this->directory}/pages/");
		define('THEME_DIR', "{$this->directory}/theme/");
		$this->page = $this->find_page($this->get_page_name(),PAGES_DIR,$this->filetypes);
		$this->theme = $this->find_page('theme',THEME_DIR,$this->filetypes);
	}
	
	function render_page()
	{
		$path = $this->page[0];
		$type = $this->page[1];
		switch ($type)
		{
			case 'php':
				include($path);
				break;
			case 'md':
			case 'markdown':
				include_once "markdown.php";
				print Markdown(file_get_contents($path));
				break;
			case 'html':
			default:
				print file_get_contents($path);
				break;
		}
	}
}

/* Functions */
function clean($str)
{
	$str = filter_var($str, FILTER_SANITIZE_STRING);
	$str = filter_var($str, FILTER_SANITIZE_SPECIAL_CHARS);
	$str = str_replace(array('..',';'),'',$str);
	return $str;
}

$nus = new cms();
$nus->match_site();
$nus->create_pages();

include($nus->theme[0]);
