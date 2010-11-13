<?php
/*
		Nice Urls, Simple CMS
		index.php - gets the page and theme
*/

// Settings
define("THEMEDIR","themes");
define("APPDIR","app");

// Start app
require_once(APPDIR.'/lib.php');
$app = new app(APPDIR);
$app->get_theme();

// Get the page
$page = new page($app->config);
$page->find_page_name();
$page->find_page();
$_GET = $page->find_gets();

// Get the page output
ob_start();
switch ($page->setting)
{
	case 0:
		include($page->path);
		break;
	case 1:
		echo file_get_contents($page->path);
		break;
	case 2:
		if ($config['nus']['codeblocks']) { echo '<div class="nus-code-block"><pre>'; }
		echo htmlentities(file_get_contents($page->path));
		if ($config['nus']['codeblocks'])	{ echo '</pre></div>'; }
		break;
}
$page->contents = ob_get_contents();
ob_end_clean();

// Include theme
include $app->theme;

?>
