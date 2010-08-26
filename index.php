<?php
// Site index

//include("app/settings.php");
$default_page = "home";
$pages_directory = "pages/";
$nus = array(
	"codeblocks" => TRUE
);
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

$count = 0;
$pagenotfound = TRUE;

foreach ($filetypes as $filetype => $set) :
	$count = $count + 1;
	if (file_exists($pages_directory.$page.".".$filetype)) :
		$page = $pages_directory.$page.".".$filetype;
		$setting = $set;
		$pagenotfound = FALSE;
		break;
	endif;
endforeach;

if ($pagenotfound == TRUE) :
	header("HTTP/1.0 404 Not Found");
	header("Location: http://".$_SERVER['SERVER_NAME']."/404?search=$page");	
endif;

// Echo theme

echo "<b>".$page."</b><br>";

switch ($setting) {
	case 0:
		include($page);
		break;
	case 1:
		echo file_get_contents($page);
		break;
	case 2:
		if ($nus['codeblocks']) { echo '<div class="nus-code-block">'; }
		echo htmlentities(file_get_contents($page));
		if ($nus['codeblocks']) { echo '</div>'; }
		break;
}