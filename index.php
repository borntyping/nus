<?php
	// Site index
	// Should be redirected to by the 404 ErrorDocument
	// $dir = "/nus";
	$getpage_style = 1;
	$testing = 1;
	
	
	function getpage_style_404($dir) {
		// Get requested page
		// Url should be formatted as www.domian.com/page?other
		// Redirect should be though 404, i.e.
		// ErrorDocument 404 /nus/index.php
		$page = $_SERVER["REQUEST_URI"];
		$page = explode('?',$page,2);
		$page = $page[0];
		$page = str_replace($dir, "", $page);
		return $page;
		unset ($page);
	}
	
	function getpage_style_redirect() {
		// Get requested page
		// Url should be formatted as www.domian.com/page?other
		// Redirect should be though server redirects
		echo $_GET["page"];
		$page = $_GET["page"];
		return $page;
		unset ($page);
	}
	
	function grab_gets() {
		$gets = $_SERVER["REQUEST_URI"];
		$gets = explode('?',$gets,2);
		$gets = $gets[1];
		$gets = explode('&',$gets);
		foreach ($gets as &$get) :
			$line = explode("=",$get);
			$one = $line[0];
			$two = $line[1];
			$gets_final[$one] = $two;
			unset($line);
		endforeach;
		return $gets_final;
		unset($gets_final);
	}
	
	echo "<b>".$_GET["page"]."</b><br>";
	$page = $_GET["page"];
	echo $_SERVER["REQUEST_URI"]."<br>".$_SERVER["QUERY_STRING"]."<br>".$_SERVER["SCRIPT_NAME"]."<br><br>";
	// print_r($_SERVER);
	
	$ext = "html";
	
	if ($page == "/") {
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
	
	// include("theme/header.php");
	include("pages/${page}.${ext}");
	// echo "</div>"; // Add this to sidebar.
	// include("theme/sidebar.php");
	// include("theme/footer.php");
?>