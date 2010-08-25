<?php
	// Site index
	
	function getpage() {
		// Gets the name of the requested page
		$page = $_GET["page"];
		return $page;
	}
	
	function grab_gets() {
		// Gets the $_GET values directly though the url, for use with includes
		$gets = $_SERVER["REQUEST_URI"];
		
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
		return $gets_final;
	}
	
	$page = getpage();
	
	if ($page == ""|$page == "/") {
		$page = "home";
	} else {
		$bad  = array("..","@","<",">",";");
		$page = str_replace($bad,"",$page);
	}
	
	if (!file_exists("pages/".$page.".php") && !file_exists("pages/".$page.".html")) :	
		// header("HTTP/1.0 404 Not Found");
		// header("Location: http://borntyping.co.uk/404?search=$page");
	elseif (file_exists("pages/${page}.php")) :
		$ext = "php";
	endif;
	
	// Echo theme
	
	echo "<b>".$page."</b><br>";
	echo $_SERVER["REQUEST_URI"]."<br>".$_SERVER["QUERY_STRING"]."<br>".$_SERVER["SCRIPT_NAME"]."<br><br>";
	include("pages/${page}.${ext}");
?>