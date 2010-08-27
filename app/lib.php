<?php

function clean($str) {
	$str = filter_var($str, 513);
	$str = filter_var($str, 515);
	$str = str_replace(array("..",";"),"",$str);
	return $str;
}

class page {
	var $name;

	function find_name($default_name) {
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
			$name = $default_name;
		endif;
		$this->name = $name;
		fb($this->name, 'Page name found');
	}
	
	var $page;
	var $ext;
	var $setting;
	var $found;

	function find_page($filetypes,$pages_directory) {
		$this->found = FALSE;
		foreach ($filetypes as $filetype => $set) :
			if (file_exists($pages_directory.$this->name.".".$filetype)) :
				$this->ext = $filetype;
				$this->setting = $set;
				$this->found = TRUE;
				break;
			endif;
		endforeach;
		unset($filetypes);
		unset($filetype);
		unset($set);
		fb($this->ext, 'Ext found');
		fb($this->setting, 'Setting found');
		fb($this->found, 'Page found');
	}
	
	// ----------
		
	var $get;
		function find_gets() {
			// Gets the $_GET values directly though the url, for use with includes
			$gets = $_SERVER["REQUEST_URI"];	
			$gets = clean($gets);
			$gets = explode('?',$gets,2);
			if(!isset($gets[1])) :
				return array();
			endif;
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
		}
		
		function get_gets() {
			return $this->gets;
		}
}