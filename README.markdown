# Nice Urls, Simple CMS

Provides a simple Content management system that provides pages with nice urls, such as
  - http://www.domain.com/homepage
  - http://www.domain.com/about

## Installation

  - `cd /var/www/ && git clone git://github.com/ziaix/nus.git`
  - Point the DocumentRoot to the nus-cms directory
  - Add lines to ./sites/sites.ini for each site you want to run
    $sitename = "$pattern"
    sitename = "/site\.co\.uk/"
  - Edit the theme in sites/sitename/theme/, and add pages to sites/sitename/pages/
    
