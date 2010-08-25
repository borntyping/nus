# Nice Urls, Simple CMS

Provides a simple Content managment system that provides pages with simple urls, such as
	http://www.domain.com/homepage
	http://www.domain.com/about

Activate by putting in the top level directory, and setting the server to redirect all pages to index.php

## Redirection

### Apache
Use the included .htaccess, or put something to this effect into the existing .htaccess or server .conf files

	RewriteEngine on
	RewriteCond %{REQUEST_URI} !(^/index\.php|\..*$)$
	RewriteRule ^(.*) /index.php?page=$1 [L]

## Basic Structure

1. index.php opened from any url on the site/dir
2. Init vars
	- From .ini file
	- From included file
3. Init functions
	- From file
4. Get $pagename
5. Try and find requested page in /pages/ directory
	-	Loop though dir using each allowed ext
	-	If no file found
		+	Send 404 headers
		+	Find 404 page in theme, set $page to the 404 page
		+	If no 404 page in theme, use a default 404.php
	-	Set $page and $ext
6. Start theme
7. Look at page $ext to decide how to echo it
	-	echp_php(), echo_html(), echo_txt() etc.
8. Echo $page using function
9. End theme
10. End script