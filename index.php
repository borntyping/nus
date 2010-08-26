<?php
// Site index

//include("app/settings.php");
$default_page = "home";
$filetypes = array(
	// Include
	"php"  => 0,
	// Echo
	"html" => 1,
	"htm"  => 1,
	// Print as code
	"txt"  => 2,
	"ini"  => 2
);

include("app/functions.php");

$page = getpage();

// Find page

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