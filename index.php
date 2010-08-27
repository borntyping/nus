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

require_once('dev/FirePHPCore/fb.php');
require_once('app/lib.php');

$page = new page();
$page->find_name($default_page);
$page->find_page($filetypes,$pages_directory);

if ($page->found == FALSE) :
	header("HTTP/1.0 404 Not Found");
	header("Location: http://".$_SERVER['SERVER_NAME']."/404?search=$page");	
endif;

// Theme [Header]
echo "<b>".$page->name."</b><br>";

// Theme [Page]
switch ($page->setting) {
	case 0:
		include($page->get_page_path());
		break;
	case 1:
		echo file_get_contents($page->get_page_path());
		break;
	case 2:
		if ($nus['codeblocks']) { echo '<div class="nus-code-block">'; }
		echo htmlentities(file_get_contents($page->get_page_path()));
		if ($nus['codeblocks']) { echo '</div>'; }
		break;
}

// Theme [Footer]