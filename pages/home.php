<?php
	echo "<br>This is the default homepage";
	$page->find_gets();
	echo "<br>Gets: ";
	print_r($page->gets);
?>