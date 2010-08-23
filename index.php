<?php
	// Site index
	
	echo "Hi";
	die();
	
	// Get requested page
	// Url should be formatted as www.domian.com/page?other
	$page = $_SERVER["REQUEST_URI"];
	$page = explode('?',$page,2);
	$page = $page[0];
	$ext = "html";
	
	if ($page == "/") {
		$page = "home";
	} else {
		$bad  = array("..","/");
		$page = str_replace($bad,"",$page);
	}
	
	if (!file_exists("pages/".$page.".php") && !file_exists("pages/".$page.".html")) :	
		header("HTTP/1.0 404 Not Found");
		// header("Location: http://borntyping.co.uk/404?search=$page");
	elseif (file_exists("pages/${page}.php")) :
		$ext = "php";
	endif;
	
	include("theme/header.php");
	include("pages/${page}.${ext}");
	echo "</div>"; // Add this to sidebar.
	include("theme/sidebar.php");
	include("theme/footer.php");
?>