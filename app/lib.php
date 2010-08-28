<?php

function clean($str) {
	$str = filter_var($str, 513);
	$str = filter_var($str, 515);
	$str = str_replace(array("..",";"),"",$str);
	return $str;
}

class page {
	var $name;

	function find_name($config) {
		// Finds the name of the requested page
		if(isset($_GET["page"])) :
			$name = $_GET["page"];
		else :
			$name = $_SERVER["REQUEST_URI"];
			$name = explode('?',$name,2);
			$name = $name[0];
		endif;
		$name = clean($name);
		if ($name == ""|$name == "/") :
			$name = $config['pages']['default'];
			fb("Used default page",'info');
		endif;
		$this->name = $name;
	}
	
	var $ext;
	var $setting;
	var $found;
	var $dir;

	function find_page($config) {
		$this->dir = $config['nus']['pages_directory'];
		$this->found = FALSE;
		foreach ($config['filetypes'] as $filetype => $set) :
			if (file_exists($this->dir.$this->name.".".$filetype)) :
				$this->ext = $filetype;
				$this->setting = $set;
				$this->found = TRUE;
				break;
			endif;
		endforeach;
		
		if ($this->found == FALSE && $this->name == $config['pages']['not_found']) :
			$this->dir = "app/";
			$this->name = "failsafe";
			$this->ext = "php";
			$this->setting = 0;
			$this->found = TRUE;
			fb("404 page not found in theme. Reverted to failsafe.php","Warning",'error');
		endif;
		
		unset($filetypes);
		unset($filetype);
		unset($set);
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
		if(!isset($gets[1])) :
			$this->gets = array();
			fb($this->gets, "No gets", "Info");
		else :
			$gets = $gets[1];
			$gets = explode('&',$gets);
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
			fb($this->gets, "Gets", "Info");
		endif;
		return $this->gets;
	}
}