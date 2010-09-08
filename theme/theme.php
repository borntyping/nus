<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>
		<?php
			if(isset($page->meta['title'])) :
				echo $page->meta['title'];
			else :
				echo $page->name;
			endif;
		?>
	</title>
	<link rel="stylesheet" href="<?php echo $theme; ?>styles.css" />
</head>
<body>
	<?php echo "<h1>".$page->name."</h1>"; ?>
	<?php echo $page->contents; ?>
</body>
</html>