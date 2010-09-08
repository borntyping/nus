<!DOCTYPE HTML>
<html lang="en-GB">
<head>
	<title>Razor-Studios - 
		<?php
			if(isset($page->meta['title'])) :
				echo ucwords($page->meta['title']);
			else :
				echo ucwords($page->name);
			endif;
		?>
	</title>
	<meta charset="UTF-8"> 
	<link rel="stylesheet" href="<?php echo $theme; ?>styles.css" media="screen and (min-width: 501px)" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Nobile:regular,italic" />
	<link rel="stylesheet" href="<?php echo $theme; ?>small.css" type="text/css" media="handheld, screen and (max-width: 500px)" />
	<!--[if IE]>
		<link rel="stylesheet" href="<?php echo $theme; ?>ie.css" />
	<![endif]-->
</head>
<body>
<!--[if IE]>
	<div id="iehackbox">
<![endif]-->
<div id="main">
	<a id="header" href="/">
		<h1 id="title">Razor Studios</h1>
	</a>
	<div id="nav">
		<?php
			if($page != "home")
				echo '<a href="/">home</a>';
			if($page != "projects")
				echo '<a href="/projects">projects</a>';
			echo '<a href="http://wiki.razor-studios.co.uk/">wiki</a>';
			if($page != "news")
				echo '<a href="/news">news</a>';
			if($page != "about")
				echo '<a href="/about">about</a>';
			if($page != "staff")
				echo '<a href="/staff">staff</a>';
			echo '<a href="http://forum.razor-studios.co.uk/">forum</a>';
			if($page != "contact")
				echo '<a href="/contact">contact</a>';
		?>
	</div>
	<div id="content">
		<?php echo $page->contents; ?>
	</div>
	<div id="footer">
		Design by <a href="http://borntyping.co.uk/">some guy</a>. <p id="token-att"><a href="http://brsev.deviantart.com/art/Token-128429570">Token icons</a> by <a href="http://brsev.com">brsev</a>.</p> All &copy; 2010.
		<!--[if IE]>
		<br>IE? Really? Go use a <i>real</i> browser; <a href="http://www.mozilla.com/firefox/">Firefox</a>, <a href="http://www.google.com/chrome/">Chrome</a> and <a href="http://www.opera.com/">Opera</a> are some good options.</div>
		<![endif]-->
	</div>
</body>
</html>