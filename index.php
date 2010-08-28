<?php
/*
		Nice Urls, Simple CMS
		index.php - gets the page and theme
*/

// Get FirePHP module [for testing]
	require_once('dev/FirePHPCore/fb.php');
// Get libary
	require_once('app/lib.php');
// Read settings
	$config = parse_ini_file("app/config.ini", true);

// Get the page
$page = new page();
$page->find_name($config);
$page->find_page($config);

// Deal with 404 errors
if ($page->found == FALSE) :
	// header("HTTP/1.0 404 Not Found");
	// header("Location: http://".$_SERVER['SERVER_NAME']."/".$config['pages']['not_found']."?search=".$page->name);
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
		if ($config['nus']['codeblocks']) { echo '<div class="nus-code-block">'; }
		echo htmlentities(file_get_contents($page->get_page_path()));
		if ($config['nus']['codeblocks']) { echo '</div>'; }
		break;
}

// Theme [Footer]