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
$page = new page($config);
$page->find_page();

// Theme [Page]
ob_start();
switch ($page->setting) :
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
endswitch;
$page->contents = ob_get_contents();
ob_end_clean();

if(isset($config['dir']['theme'])) :
	$theme = $config['dir']['nus'].$config['dir']['theme'].$config['nus']['theme']."/";
else :
	$theme = $config['dir']['nus'].$config['dir']['theme'];
endif;
include $theme."theme.php";