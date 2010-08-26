<?php

function clean($str) {
	$str = filter_var($str, 513);
	$str = filter_var($str, 515);
	$str = str_replace(array("..",";"),"",$str);
	return $str;
}

function getpage() {
	// Gets the name of the requested page
	if(isset($_GET["page"])) :
		$page = $_GET["page"];
	else :
		$page = $_SERVER["REQUEST_URI"];
		$page = explode('?',$page,2);
		$page = $page[0];
	endif;
	
	$page = clean($page);
	
	if ($page == ""|$page == "/") :
		$page = $default_page;
	endif;
	
	return $page;
}

function grab_gets() {
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
	return $gets_final;
}