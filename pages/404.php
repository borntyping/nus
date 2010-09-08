<?php

// Page meta
$page->meta['title'] = "404: Page not found";

// 404: Page not found
$page->find_gets();
echo "<b>404: Page Not Found</b>";
if(isset($page->gets['search']))
	echo '<br>You searched for <a href="/'.$page->gets['search'].'">'.$page->gets['search'].'</a>';