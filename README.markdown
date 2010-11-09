# Nice Urls, Simple CMS

Provides a simple Content managment system that provides pages with nice urls, such as
	http://www.domain.com/homepage
	http://www.domain.com/about

Activate by putting in the top level directory, and setting the server to redirect all pages to index.php

## Redirection

### Apache
Use the included .htaccess, or put something to this effect into the existing .htaccess or server .conf files

	ErrorDocument 404 /index.php

This redirects all pages to nus, unless they exist as a file on the server.

## Basic Structure

1. Visting a page opens NUS at index.php 
2. Get settings from config.ini
3. Get classes from lib.php
4. Find $page->name
5. Find requested page in directory
	-	Loop though pages directory trying each allowed ext until one is found
	-	If no file is found
		+ Restart finding page with for a 404 page
		+	If the 404 page has not been found, die()
	-	Set $page, $ext and $setting
6. Use $page->setting to decide how to echo the page
7. Echo page into output buffer
8. Echo theme, inserting page into it.
