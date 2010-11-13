<?php
/*
		Nice Urls, Simple CMS
		(c) Samuel Clements 2010
		http://github.com/ziaix/nus
		
		-----
		
		./index.php
		Gets the page and theme
*/

// Settings
define("THEMEDIR","themes");
define("APPDIR","app");

// Start app
// Import libary and locate theme files
require_once(APPDIR.'/lib.php');
$app = new app(APPDIR);
$app->get_theme();

// Find the page name, and find the page file
// Will look for 404 page if no page is found
$page = new page($app->config);
$page->find_page_name();
$page->find_page();

// Get GET vars from url and place them into $_GET
$_GET = $page->find_gets();

// Get the page output
// Uses the setting types defined in config.ini
ob_start();
switch ($page->setting)
{
	case 0:
		// Include as php
		include($page->path);
		break;
	case 1:
		// Print file, don't run php
		echo file_get_contents($page->path);
		break;
	case 2:
		// Print file as code, escape html
		if ($config['nus']['codeblocks']) { echo '<div class="nus-code-block"><pre>'; }
		echo htmlentities(file_get_contents($page->path));
		if ($config['nus']['codeblocks'])	{ echo '</pre></div>'; }
		break;
}
$page->contents = ob_get_contents();
ob_end_clean();

// Include theme
// Theme file should print $page->contents where wanted
include $app->theme;

// Exit
?>
