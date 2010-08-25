# Nice Urls, Simple CMS

Provides a simple Content managment system that provides pages with simple urls, such as
	http://www.domain.com/homepage
	http://www.domain.com/about

Activate by putting in the top level directory, and setting the server to redirect all pages to index.php

### Apache
	RewriteEngine on
	RewriteCond %{REQUEST_URI} !(^/index\.php|\..*$)$
	RewriteRule ^(.*) /index.php?page=$1 [L]

## Basic Structure

1. index.php opened from any url
2. Init vars
	- From .ini file
	- From included file
3. Init functions
	- From file
4. Get pagename
5. Try and find page in /pages/ dir
	-	Loop though dir using each allowed ext
	-	If mo file found
		+	Send 404 headers
		+	Find 404 page in theme
		+	If no 404 page in theme
			*	Use default 404.php
	-	Set page and ext
6. Start theme
7. Look at page ext to decide how to echo it
	-	echp_php(), echo_html(), echo_txt etc.
8. Echo page
9. End theme
10. End script