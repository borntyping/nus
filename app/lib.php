<?php

function clean($str)
{
	$str = filter_var($str, FILTER_SANITIZE_STRING);
	$str = filter_var($str, FILTER_SANITIZE_SPECIAL_CHARS);
	$str = str_replace(array("..",";"),"",$str);
	return $str;
}

class app
{
	var $config;
	var $theme;
	
	function __construct()
	{
		$this->config = parse_ini_file("config.ini", true);
		$this->theme = 'themes/'.$this->config['nus']['theme'];
	}
}

class page
{
	/* Holds the page information */
	
	// Page info
	var $name;
	var $ext;
	var $setting;
	var $found;
	var $path;
	
	var $filetypes;
	var $pagedir;
	
	// Page contents
	var $meta;
	var $contents;
	
	// On new page()
	function __construct($config)
	{
		// Get useful config values
		define("NOTFOUND_PAGE", $config['pages']['notfound']);
		define("DEFAULT_PAGE", $config['pages']['default']);;
		define("URL", $config['nus']['parentdir']);
		$this->pagedir = $config['nus']['pages'];
		$this->filetypes = $config['filetypes'];
		$this->found = FALSE;
		$this->i = 0;
	}

	// Finds the name of the requested page
	function find_page_name($override = FALSE)
	{
		if($override == TRUE)
		{
			$this->name = $override;
		}
		else
		{
			if(isset($_GET["page"]))
			{
				$name = $_GET["page"];
			}
			else
			{
				$name = $_SERVER["REQUEST_URI"];
				$name = explode('?',$name,2);
				$name = $name[0];
				$name = str_replace(URL,"",$name);
			}
		}
		
		if ($name == ""|$name == "/")
		{
			$name = DEFAULT_PAGE;
		}
		$this->name = clean($name);
		return $this->name;
	}

	// Cycle filetypes to find page
	function find_page()
	{
		if(!isset($this->name))
		{
			find_page_name();
		}
		
		foreach ($this->filetypes as $filetype => $set)
		{
			if (file_exists($this->pagedir."/".$this->name.".".$filetype))
			{
				$this->ext = $filetype;
				$this->setting = $set;
				$this->found = TRUE;
				break;
			}
		}
		
		if ($this->found == FALSE)
		{
			// Oh noes! There is no 404 page!
			if ($this->name == NOTFOUND_PAGE)
			{
				header("HTTP/1.0 404 Not Found");
				die("Page not found!");
			}
		}
		
		$this->path = $this->pagedir."/".$this->name.".".$this->ext;
		return $this->path;
	}
}
