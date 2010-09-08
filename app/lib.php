<?php

if (!function_exists('fb')) {
	function fb ($text,$label,$type){
		$msg = $label.": ".$text;
		error_log($msg);
	}
}

function clean($str) {
	$str = filter_var($str, 513);
	$str = filter_var($str, 515);
	$str = str_replace(array("..",";"),"",$str);
	return $str;
}

class page {
	// Holds the page information
	
	// Config info
	var $default_page;
	var $filetypes;
	var $not_found_page;
	
	// Page info
	var $name;
	var $ext;
	var $setting;
	var $found;
	var $dir;
	var $theme_dir;
	
	// Page contents
	var $meta;
	var $contents;
	
	// On new page()
	function __construct($config) {
		// Get useful config values
		$this->default_page = $config['pages']['default'];
		$this->filetypes = $config['filetypes'];
		$this->dir = $config['dir']['pages'];
		$this->not_found_page = $config['pages']['not_found'];
		$this->url = $config['dir']['nus'];
		
		$this->found = FALSE;
	}

	// Finds the name of the requested page
	function find_page($override = FALSE) {
		if($override == FALSE) :
			if(isset($_GET["page"])) :
				$name = $_GET["page"];
			else :
				$name = $_SERVER["REQUEST_URI"];
				$name = explode('?',$name,2);
				$name = $name[0];
				$name = str_replace($this->url,"",$name);
			endif;
			$name = clean($name);
			if ($name == ""|$name == "/") :
				$name = $this->default_page;
				fb("No page was given","Used default page",'info');
			endif;
			$this->name = $name;
		else :
			$this->name = $override;
		endif;
		
		// Cycle filetypes to find page
		foreach ($this->filetypes as $filetype => $set) :
			if (file_exists($this->dir.$this->name.".".$filetype)) :
				$this->ext = $filetype;
				$this->setting = $set;
				$this->found = TRUE;
				break;
			endif;
		endforeach;
		
		// Deal with 404 errors
		if ($this->found == FALSE) :
			// Oh noes! There is no 404 page!
			if ($this->name == $this->not_found_page) :
				fb("404 page not found in ".$this->dir.". Reverted to failsafe.php","Warning",'error');
				header("HTTP/1.0 404 Not Found");
				$this->dir = "app/";
				$this->name = "failsafe";
				$this->ext = "php";
				$this->setting = 0;
				$this->found = TRUE;
			else :
				header("HTTP/1.0 404 Not Found");
				$this->find_page("404");
			endif;
		endif;
	}
	
	function get_page_path() {
		return $this->dir.$this->name.".".$this->ext;
	}
		
	var $gets;

	function find_gets() {
		// Gets the $_GET values directly though the url, for use with includes
		$gets = $_SERVER["REQUEST_URI"];
		$gets = clean($gets);
		$gets = explode('?',$gets,2);
		if(isset($gets[1]) == FALSE) :
			// Return empty array if there are no gets
			$this->gets = array();
		else :
			$gets = $gets[1];
			$gets = explode('&#38',$gets);
			foreach ($gets as &$get) :
				$line = explode("=",$get);
				$one = $line[0];
				if(!isset($line[1]))
					$line[1] = TRUE;
				$two = $line[1];
				$gets_final[$one] = $two;
				unset($line);
			endforeach;
			$this->gets = $gets_final;
			unset($gets_final);
		endif;
		fb($this->gets, "Gets", "Info");
		return $this->gets;
	}
}