<?php
	// Page meta
	$page->meta['title'] = "Home";
?>
This is the default homepage<br>Gets:
<?php
	$page->find_gets();
	print_r($page->gets);
?>