<?php
/*
		Nice Urls, Simple CMS
		(c) Samuel Clements 2010
		http://github.com/ziaix/nus

		v1.2.0
*/

define("CONFIG_FILE_NAME","config.ini");

/* Init */

function clean($str)
{
	$str = filter_var($str, FILTER_SANITIZE_STRING);
	$str = filter_var($str, FILTER_SANITIZE_SPECIAL_CHARS);
	$str = str_replace(array("..",";"),"",$str);
	return $str;
}

class page
{
	var $name;
	var $meta;
	var $contents;
	var $filetypes;

	function __construct($filetypes)
	{
		$this->filetypes = $filetypes;
		$this->meta = array();
	}

	function find_page($errorpage)
	{
		/* Get name */
		if (!isset($_GET["page"]) or in_array($_GET["page"],array("","/","/index.html")))
		{
			$name = DEFAULT_PAGE;
			//$name = explode('.',$name);
			//$name = $name[1];
		}
		else
		{
			$name = clean($_GET["page"]);
			$name = rtrim($name,"/");
		}

		/* Find file */
		foreach ($this->filetypes as $filetype => $permission)
		{
			$pagename = "/${name}.${filetype}";
			if (file_exists(DIR_PAGES.$pagename))
			{
				$name = $pagename;
				$found = TRUE;
				break;
			}
		}

		if (!isset($found))
		{
			if ($name == $errorpage)
			{
				header("HTTP/1.0 404 Not Found");
				die("Page not found!");
			}
			else
			{
				header("HTTP/1.0 404 Not Found");
				$name = "/${errorpage}";
			}
		}
		$this->name = $name;
	}

	function get_contents()
	{
		$extension = explode('.',$this->name);
		$extension = $extension[1];
		$permission = $this->filetypes["${extension}"];
		$page = DIR_PAGES.$this->name;

		ob_start();
		switch ($permission)
		{
			case 0:
				include($page);
				break;
			case 1:
				echo file_get_contents($page);
				break;
			case 2:
				echo '<pre>'.htmlentities(file_get_contents($page)).'<pre>';
				break;
		}
		$this->contents = ob_get_contents();
		ob_end_clean();
	}

	function get_meta($meta, $default) {
		if(isset($this->meta[$meta]))
		{
			return $this->meta[$meta];
		} else {
			return $default;
		}
	}
}

/* Execute */

$config = parse_ini_file(CONFIG_FILE_NAME, true);
if(isset($config['theme'])) { $config['theme'] = "/".$config['theme']; }
define("DIR_THEME",$config['directorys']['theme'].$config['theme'].'/');
define("DIR_PAGES",$config['directorys']['pages']);
define("DEFAULT_PAGE",$config['pages']['default']);

$page = new page($config['filetypes']);
$page->find_page($config['pages']['errorpage']);
$page->get_contents($config['filetypes']);

include DIR_THEME.'theme.php';

?>
