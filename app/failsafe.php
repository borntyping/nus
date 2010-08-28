<?php
$page->find_gets();
echo "<b>404: Page Not Found</b>";
if(isset($page->gets['search']))
	echo '<br>You searched for <a href="/'.$page->gets['search'].'">'.$page->gets['search'].'</a>';
echo '<br><br>Warning: 404 page not found in theme. Reverted to failsafe.php';